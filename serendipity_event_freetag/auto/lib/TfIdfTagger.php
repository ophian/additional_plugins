<?php

require_once __DIR__ . '/Stopwords.php';
require_once __DIR__ . '/HtmlText.php';

/**
 * TF-IDF tagger with a noun filter (capitalization heuristic for German),
 * optional bigram support, and fuzzy matching against existing tags.
 *
 * Noun heuristic: In German, nouns are capitalized while verbs/adjectives/
 * filler words (except at the start of a sentence) are not. A word only
 * counts as a tag candidate if it's capitalized AND is NOT the first word
 * of its sentence.
 *
 * Whole words, no fragments: "tokenizing" here means "splitting text at
 * word boundaries into whole words" (the classic NLP term), not "chopping
 * into sub-word pieces" the way LLM tokens work. Bigrams are two whole,
 * sentence-adjacent words glued into one phrase (e.g. "Toolbar Buttons").
 * Output preserves the original spelling/capitalization, not the internal
 * lowercase form used only for counting/matching.
 *
 * TF-IDF itself isn't a probability, just a fixed formula:
 * score = (frequency within this article) x (rarity across all articles).
 *
 * Proper-name filter (only $language='de'): the construction "XYZs Noun"
 * without an article is used in German almost exclusively for proper names
 * ("Karins Mann", "Berlins Innenstadt") - regular nouns almost always form
 * the genitive with an article. A capitalized word ending in "s", directly
 * followed by another capitalized word, is therefore treated as a likely
 * proper name and excluded. CAUTION, trade-off: this also catches real tech
 * product names like "Windows Update" - hence it's toggleable.
 *
 * Language mode: 'de' uses the capitalization heuristic (noun = capitalized,
 * not sentence-initial). 'en' CANNOT rely on this, since in English only
 * proper nouns are capitalized, not regular nouns - instead an extended
 * stopword list (function words + common verbs/adjectives) from StopwordsEn
 * does the filtering.
 *
 * Usage:
 *   $tagger = new TfIdfTagger($allArticleTexts); // corpus for IDF
 *   $suggestions = $tagger->suggest($singleText, $existingTags, 5);
 */
final class TfIdfTagger
{
    /** @var array<int, array<string,int>> Tokenized corpus documents (lowercase key => freq) */
    private array $corpusDocs = [];

    /** @var array<string,int> Number of documents a term appears in */
    private array $docFrequency = [];

    private int $corpusSize = 0;

    private int $minWordLength;

    private bool $useBigrams;

    private bool $nounsOnly;

    private bool $excludeGenitiveNames;

    private bool $mergeLoanwordPlurals;

    private string $language;

    /**
     * @param string[] $corpusTexts            All available article texts (raw, incl. HTML/BBCode)
     * @param bool     $nounsOnly              Only for $language='de': treat capitalized,
     *                                          non-sentence-initial words as candidates
     * @param bool     $excludeGenitiveNames   Only for $language='de': exclude the
     *                                          "XYZs Noun" pattern (likely proper names)
     * @param string   $language               'de' or 'en' - controls the filtering strategy
     * @param bool     $mergeLoanwordPlurals   Only for $language='de': merge tech loanword
     *                                          plurals formed with "+s" (Plugin/Plugins) into
     *                                          one candidate. Off by default - narrower and
     *                                          less battle-tested than the German stopword
     *                                          list itself, so opt in and verify on real
     *                                          articles before relying on it.
     */
    public function __construct(
        array $corpusTexts,
        int $minWordLength = 4,
        bool $useBigrams = true,
        bool $nounsOnly = true,
        bool $excludeGenitiveNames = true,
        string $language = 'de',
        bool $mergeLoanwordPlurals = false
    ) {
        $this->minWordLength = $minWordLength;
        $this->useBigrams = $useBigrams;
        $this->nounsOnly = $nounsOnly;
        $this->excludeGenitiveNames = $excludeGenitiveNames;
        $this->language = $language;
        $this->mergeLoanwordPlurals = $mergeLoanwordPlurals;

        if ($language === 'en') {
            require_once __DIR__ . '/StopwordsEn.php';
        }

        foreach ($corpusTexts as $text) {
            $entries = $this->tokenize($text);
            $keys = array_column($entries, 'key');
            $freq = array_count_values($keys);
            $this->corpusDocs[] = $freq;
            foreach (array_keys($freq) as $term) {
                $this->docFrequency[$term] = ($this->docFrequency[$term] ?? 0) + 1;
            }
        }
        $this->corpusSize = max(count($this->corpusDocs), 1);
    }

    /**
     * @param string   $text          The article text to tag
     * @param string[] $existingTags  Tags already known from the DB (for priority matching)
     * @param int      $limit         Number of suggestions wanted
     * @return array{matched: string[], suggested: array<array{tag:string, score:float}>}
     */
    public function suggest(string $text, array $existingTags = [], int $limit = 5): array
    {
        $entries = $this->tokenize($text);
        $keys = array_column($entries, 'key');
        $termFreq = array_count_values($keys);
        $totalTerms = max(count($keys), 1);

        // Remember the original spelling per lowercase key (first variant seen)
        $displayForms = [];
        foreach ($entries as $entry) {
            if (!isset($displayForms[$entry['key']])) {
                $displayForms[$entry['key']] = $entry['display'];
            }
        }

        // 1. Match existing tags: word boundary at the start (no hit in the
        // middle of a word, e.g. tag "art" inside "start"), deliberately open
        // at the end for inflected forms (tag "Update" also matches
        // "Updates"/"Updated" in the text).
        // Deduplicate case-insensitively: if the tag list itself contains
        // both "sommer" and "Sommer" (e.g. entered inconsistently across
        // articles over the years), keep only one. Deliberately neutral -
        // no attempt to guess which spelling is "more correct" (that's a
        // language-specific judgment call this tool shouldn't make, and
        // tag DB hygiene is a separate housekeeping task anyway). Whichever
        // spelling appears first in $existingTags wins.
        $matched = [];
        $seenLower = [];
        $lowerText = mb_strtolower(HtmlText::toPlainText($text));
        foreach ($existingTags as $tag) {
            $needle = mb_strtolower($tag);
            if ($needle === '' || isset($seenLower[$needle])) {
                continue;
            }
            if (preg_match('/\b' . preg_quote($needle, '/') . '/u', $lowerText)) {
                $matched[] = $tag;
                $seenLower[$needle] = true;
            }
        }

        // 2. Compute TF-IDF for all terms not already matched
        $matchedLower = array_map('mb_strtolower', $matched);
        $scores = [];
        foreach ($termFreq as $key => $freq) {
            if (in_array($key, $matchedLower, true)) {
                continue;
            }
            $tf = $freq / $totalTerms;
            $df = $this->docFrequency[$key] ?? 0;
            // +1 smoothing so unknown terms don't cause division by zero
            $idf = log($this->corpusSize / (1 + $df)) + 1;
            $scores[$key] = $tf * $idf;
        }

        arsort($scores);
        $top = array_slice($scores, 0, $limit, true);

        $suggested = [];
        foreach ($top as $key => $score) {
            // Output the original spelling (e.g. "Toolbar Buttons"), not the lowercase form
            $suggested[] = ['tag' => $displayForms[$key] ?? $key, 'score' => round($score, 4)];
        }

        return ['matched' => array_unique($matched), 'suggested' => $suggested];
    }

    /**
     * Tokenizes text into whole words (>= minWordLength), filtered down to
     * noun candidates (if $nounsOnly), plus optional bigrams from adjacent
     * whole words.
     *
     * @return array<int, array{key:string, display:string}> key = lowercase
     *         (for counting/matching), display = original spelling (output)
     */
    private function tokenize(string $text): array
    {
        $plain = HtmlText::toPlainText($text);

        // Split into sentences to detect "first word of the sentence"
        $sentences = preg_split('/(?<=[.!?])\s+/u', $plain) ?: [$plain];

        $entries = [];
        $isGerman = $this->language !== 'en';

        foreach ($sentences as $sentence) {
            preg_match_all('/[\p{L}][\p{L}\-]*/u', $sentence, $matches);
            $words = $matches[0];

            // Index => ['key' => lowercase, 'display' => original]; raw
            // candidates before the optional genitive/proper-name filter
            $candidatesInSentence = [];

            foreach ($words as $i => $word) {
                $lower = mb_strtolower($word);
                $isStopword = $isGerman
                    ? Stopwords::isStopword($lower)
                    : StopwordsEn::isStopword($lower);

                if (mb_strlen($lower) < $this->minWordLength || $isStopword) {
                    continue;
                }

                // Reject words with more than one dash (e.g. multi-part
                // compound chains, markdown/formatting artifacts) - applies
                // to both languages since it's a data-quality rule, not a
                // grammar one. A single dash is still fine (Toolbar-Buttons).
                if (substr_count($word, '-') > 1) {
                    continue;
                }

                // Reject words ending in a dash - these are truncated
                // fragments from German elliptical compounds ("Schlag- und
                // Suchwörter" -> the regex would otherwise capture "Schlag-"
                // as if it were a complete word). Never a valid standalone
                // word regardless of language.
                if (mb_substr($word, -1) === '-') {
                    continue;
                }

                // Reject words with implausible internal capitalization
                // (e.g. concatenated fragments where separators got lost
                // somewhere upstream, "UsersYourUserNameAppDataRoaming...").
                // Checked PER dash-segment, not across the whole word, so
                // legitimate compounds with an acronym half still work
                // ("Section-IDs": segment "IDs" has 2 caps, fine). A segment
                // that's fully uppercase is exempt (real acronym: "CMS",
                // "HTTPS"); anything else with more than 2 capital letters
                // mixed with lowercase is very likely mangled text, not a
                // real word. Two caps stays allowed for real brand names
                // like "PayPal", "YouTube", "GitHub".
                foreach (explode('-', $word) as $segment) {
                    $capCount = preg_match_all('/\p{Lu}/u', $segment);
                    $isAllCaps = $capCount === mb_strlen($segment);
                    if ($capCount > 2 && !$isAllCaps) {
                        continue 2; // skip the whole word, not just this segment
                    }
                }

                // English: no capitalization heuristic possible (only proper
                // nouns are capitalized, regular nouns aren't) - every
                // non-stopword is a candidate, filtered solely via the
                // extended stopword list. Singularize so "task"/"tasks" and
                // "Apple"/"Apples" are counted as the same candidate instead
                // of splitting their frequency across two separate entries.
                if (!$isGerman || !$this->nounsOnly) {
                    $key = $isGerman ? $lower : $this->singularizeEn($lower);
                    $isCapitalized = mb_substr($word, 0, 1) === mb_strtoupper(mb_substr($word, 0, 1), 'UTF-8');
                    $display = $isCapitalized
                        ? mb_strtoupper(mb_substr($key, 0, 1), 'UTF-8') . mb_substr($key, 1)
                        : $key;
                    $candidatesInSentence[$i] = ['key' => $key, 'display' => $display];
                    continue;
                }

                $isSentenceStart = ($i === 0);
                $isCapitalized = mb_substr($word, 0, 1) === mb_strtoupper(mb_substr($word, 0, 1), 'UTF-8');

                if ($isCapitalized && !$isSentenceStart) {
                    $candidatesInSentence[$i] = ['key' => $lower, 'display' => $word];
                }
            }

            // Proper-name pattern: "XYZs Noun" (genitive without article) ->
            // drop XYZ. Only relevant for German + the noun filter enabled.
            if ($isGerman && $this->nounsOnly && $this->excludeGenitiveNames) {
                $indices = array_keys($candidatesInSentence);
                foreach ($indices as $pos => $idx) {
                    $display = $candidatesInSentence[$idx]['display'];
                    $endsWithS = mb_substr($display, -1) === 's' || mb_substr($display, -1) === 'S';
                    $nextIdx = $indices[$pos + 1] ?? null;
                    $followedByCandidate = $nextIdx !== null && $nextIdx === $idx + 1;

                    if ($endsWithS && $followedByCandidate) {
                        unset($candidatesInSentence[$idx]);
                    }
                }
            }

            // Merge tech loanword plurals ("Plugins" -> "Plugin") into their
            // singular. Runs AFTER the genitive filter above so the two don't
            // interfere: the genitive filter checks the ORIGINAL word ending
            // in "s"; only surviving candidates get singularized afterwards.
            if ($isGerman && $this->nounsOnly && $this->mergeLoanwordPlurals) {
                foreach ($candidatesInSentence as $idx => $candidate) {
                    $singularKey = $this->singularizeLoanwordDe($candidate['key']);
                    if ($singularKey !== $candidate['key']) {
                        $candidatesInSentence[$idx] = [
                            'key' => $singularKey,
                            'display' => mb_strtoupper(mb_substr($singularKey, 0, 1), 'UTF-8') . mb_substr($singularKey, 1),
                        ];
                    }
                }
            }

            foreach ($candidatesInSentence as $candidate) {
                $entries[] = $candidate;
            }

            // Bigrams only from directly adjacent (remaining) candidates in
            // the same sentence; original spelling of both words is preserved
            if ($this->useBigrams) {
                $indices = array_keys($candidatesInSentence);
                foreach ($indices as $pos => $idx) {
                    $nextIdx = $indices[$pos + 1] ?? null;
                    if ($nextIdx !== null && $nextIdx === $idx + 1) {
                        $a = $candidatesInSentence[$idx];
                        $b = $candidatesInSentence[$nextIdx];

                        // Reject bigrams where either word contains a dash
                        // (e.g. "Smarty smarty-fork") regardless of language.
                        if (str_contains($a['key'], '-') || str_contains($b['key'], '-')) {
                            continue;
                        }

                        $entries[] = [
                            'key' => $a['key'] . ' ' . $b['key'],
                            'display' => $a['display'] . ' ' . $b['display'],
                        ];
                    }
                }
            }
        }

        return $entries;
    }

    /**
     * Conservative English singularization used only to group candidate
     * tags for counting/scoring ("task"/"tasks" -> one entry, not two with
     * split frequencies). Deliberately narrow rather than a full stemmer:
     * a wrong stem (e.g. "status" -> "statu") is worse than occasionally
     * missing an irregular plural, so words where blind "-s" stripping is
     * known to break are excluded rather than guessed at.
     */
    private function singularizeEn(string $word): string
    {
        // "-sis" (analysis, crisis, basis, ...) and "-ics" (physics, ethics,
        // ...) pluralize irregularly or are already singular mass nouns -
        // stripping a trailing "s" here would produce a wrong/nonsense stem.
        if (mb_substr($word, -3) === 'sis' || mb_substr($word, -3) === 'ics') {
            return $word;
        }
        // "-us" (status, virus, campus, ...) and "-ss" (class, process, ...)
        // are not simple "+s" plurals either.
        if (mb_substr($word, -2) === 'us' || mb_substr($word, -2) === 'ss') {
            return $word;
        }

        static $invariant = ['series', 'species', 'news', 'means'];
        if (in_array($word, $invariant, true)) {
            return $word;
        }

        // categories -> category, companies -> company
        if (preg_match('/^(.+[^aeiou])ies$/', $word, $m)) {
            return $m[1] . 'y';
        }

        // tasks -> task, guardrails -> guardrail, databases -> database
        if (mb_strlen($word) > $this->minWordLength && mb_substr($word, -1) === 's') {
            return mb_substr($word, 0, -1);
        }

        return $word;
    }

    /**
     * Conservative German loanword-plural merge ("Plugin"/"Plugins" -> one
     * candidate). Deliberately narrow: German plural formation has multiple
     * patterns (+e, +er+umlaut, +en, +s, unchanged) with no single reliable
     * rule, so this ONLY handles the "+s" pattern used by modern tech
     * loanwords, and explicitly excludes common native German words and
     * first names that happen to end in "s" but aren't loanword plurals
     * (Kreis, Preis, Klaus, ...). A wrong merge is worse than no merge, so
     * when in doubt this returns the word unchanged.
     */
    private function singularizeLoanwordDe(string $lower): string
    {
        static $invariant = [
            // Adverbs / conjunctions / prepositions (over 4 chars)
            'abends', 'abseits', 'allerdings', 'andernfalls', 'anders', 'angesichts',
            'beispielsweise', 'bereits', 'besonders', 'bestenfalls', 'damals',
            'demnächst', 'diesseits', 'falls', 'glücklicherweise', 'höchstens',
            'jedenfalls', 'jenseits', 'keineswegs', 'mehrmals', 'meistens', 'mindestens',
            'mittags', 'mittels', 'morgens', 'nachmittags', 'nachts', 'nächstens',
            'oftmals', 'rückwärts', 'schlimmstenfalls', 'seitens', 'seitwärts', 'stets',
            'teils', 'unterwegs', 'vergebens', 'vielerorts', 'vorwärts', 'wenigstens',
            // Nouns ending in "-is"
            'akropolis', 'anis', 'arbeitsverzeichnis', 'basis', 'beweis', 'eis',
            'ergebnis', 'erkenntnis', 'erlebnis', 'firnis', 'gastritis', 'geheimnis',
            'genesis', 'gratis', 'himalayareis', 'iris', 'jasminreis', 'kannabis', 'kreis',
            'kürbis', 'mais', 'memphis', 'praxis', 'preis', 'reis', 'softeis', 'tennis',
            'versäumnis', 'verzeichnis',
            // Nouns ending in "-as"/"-es"/"-hs"/"-ls"/"-ks"/"-ms"/"-ns"/"-os"/"-ps"/"-rs"/
            // Well, actually some placed here might as well be in tech/loanwords section down below...
            'alias', 'amazonas', 'ananas', 'atlas', 'bias', 'chaos', 'cms', 'dachs',
            'diskurs', 'dns', 'chronos', 'dos', 'ethos', 'kokos', 'logos', 'pathos',
            'entries', 'fels', 'fries', 'fuchs', 'gas', 'glas', 'gps', 'hals', 'https',
            'impuls', 'jeans', 'kansas', 'keks', 'kies', 'kirmes', 'konkurs', 'kurs',
            'lachs', 'lesbos', 'mars', 'melos', 'moos', 'ms-dos', 'mythos', 'paradies',
            'peloponnes', 'puls', 'rollmops', 'sms', 'tacheles', 'veritas', 'vers',
            'wuchs',
            // Common first names ( >=4 chars )
            'hans', 'jens', 'klaus', 'lars', 'lukas', 'markus', 'mats', 'matthias',
            'niklas', 'nikolas', 'nikolaus', 'silas', 'thomas', 'tobias',
            // Ancient historian names ( >=4 chars "-as"/"-os"/"-es"/"-is"/ )
            'andreas', 'abraxas', 'achilles', 'alkibiades', 'brasidas', 'costas',
            'elias', 'ilias', 'lisias', 'nikias', 'alexandros', 'alexios', 'ambrosios',
            'apollos', 'christos', 'eros', 'georgios', 'ikaros', 'leandros', 'maximos',
            'menelaos', 'nikos', 'philippos', 'sebastianos', 'thanos', 'ares',
            'aristoteles', 'pericles', 'perikles', 'phileas', 'herakles', 'sokrates',
            'thukydides', 'adonis', 'artemis', 'dennis', 'jannis', 'phyllis',
            // English tech/loanwords, Anglicisms, "Denglish" that stay invariant rather than merge.
            // When falling back to their singular form well, they are NOT in here i.e. Assets -> asset, Smoothies -> Smoothie ...
            'analytics', 'basics', 'cannabis', 'canvas', 'charts', 'darts', 'graphics',
            'handies', 'news', 'parties', 'saas', 'shorts', 'teenies', 'teens', 'trends',
            'windows',
            // Words that are often spelled inconsistently,
            //  das Genus („Art, Gattung, Geschlecht“, Maskulinum, Femininum und Neutrum), der Genuss, Genuß,
            // or that could legitimately go either way depending on context
            //  (e.g. "Nippon Airways" should stay "Airways", not become "Airway")
            'airways', 'gries',
        ];
        if (in_array($lower, $invariant, true)) {
            return $lower;
        }
        // "-us"/"-ss" endings are not "+s" plurals either (
        //      Fokus, Virus, Bonus, Modus, Radius, Tetanus, Fidibus, Tempus, Turnus, Bus, Nachtbus, Nautilus, Christus, Syrakus, ...
        //      Optimismus, Organismus, Orgasmus, Enthusiasmus, Antagonismus, Kaukasus, Marxismus, Sozialismus, Positivismus, ...
        //      Couscous, Hummus, Labskaus, Apfelmus, Magnus, (etc), ...
        //      Laus, Linus, Vilnius, Belarus, Kaktus, Cactus, Caktus, Casus, Knacktus, Knacksus, Knaxus, Genus, Rectus, obliquus, ...
        //      Arijus, Hermeteus, Ikarus, Odysseus, Plinius, Prometheus, Sirius, Telemachus, ...
        //   [ ... I think you get what I mean... You don't get enough sleep when your mind never rests searching these words ... smile. ]
        //      Prozess, Boss, Dress, Press, Spass, Gross, Fuss, Muss, Fluss, Stress, Kompass, Kuss, Business, Class, Bypass, ...)
        // and long vocals with -ß (Spaß, Gruß, Fuß, Floß, Ruß, Süß, ...) aren't catched too! Most of them end with "e" in plural.
        if (mb_substr($lower, -2) === 'us' || mb_substr($lower, -2) === 'ss') {
            return $lower;
        }
        if (mb_strlen($lower) > $this->minWordLength && mb_substr($lower, -1) === 's') {
            return mb_substr($lower, 0, -1);
        }
        return $lower;
    }
}
