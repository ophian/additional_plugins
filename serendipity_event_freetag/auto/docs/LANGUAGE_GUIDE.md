# Building a Language File for the Auto-Tagging Stopword System

*[Deutsche Version: LANGUAGE_GUIDE.de.md](https://github.com/ophian/additional_plugins/blob/master/serendipity_event_freetag/auto/docs/LANGUAGE_GUIDE.de.md)*

This document explains the *principles* behind `Stopwords.php` (German) and
`StopwordsEn.php` (English), so a future contributor can build a stopword
file for a third language (or extend an existing one) without having to
reverse-engineer the reasoning from the code alone. It is not a spec for
`SomeNewLanguage.php` to copy line-by-line - languages differ too much for
that - it's a decision framework: the questions to ask, in order, and the
trade-offs at each one.

## 1. What this system is actually for

The stopword list feeds a TF-IDF<sup>[0]</sup> tagger (`TfIdfTagger.php`) that suggests
tags for blog articles. A word on the list is excluded from *auto-suggested*
new tags. It is **never** excluded from being matched if it's already an
established tag on the blog (`suggest()`'s `matched` logic runs on the raw
article text, completely independent of the stopword list - see §7). That
distinction matters for every decision below: being "wrong" about a stopword
entry is cheap (worst case, one fewer plausible auto-suggestion) because the
author can always tag manually, and because a genuinely useful word that got
excluded is *never* permanently lost - it just never gets suggested
automatically.

## 2. Step 0 - does the language give you a free signal?

Before writing a single word, ask: does this language have an orthographic
or morphological feature that reliably distinguishes topic-bearing words
(nouns) from function/filler words, independent of a word list?

- **German**: yes - all nouns are capitalized, even mid-sentence. This is
  exploited directly in `Stopwords.php` / `TfIdfTagger::tokenize()`: a
  candidate must be capitalized AND not sentence-initial. The stopword list
  itself can then be much smaller, since most non-nouns are already excluded
  by the capitalization rule alone.
- **English**: no - only proper nouns are capitalized, common nouns aren't.
  There is no shortcut; the stopword list has to do all the work, which is
  why `StopwordsEn.php` is roughly 4x larger than the German list for a
  comparable degree of coverage.
- **Other languages**: check for capitalization rules, but also consider
  other signals - e.g. definite articles fused to nouns, case markers,
  or (for languages with a rich agglutinative morphology) whether a
  stemming/lemmatization step is even feasible with hand-written rules, or
  whether it would need a real morphological analyzer (in which case, say so
  explicitly rather than attempting a fragile home-grown approximation).

## 3. Step 1 - function words (closed class)

Every language has a finite set of pronouns, prepositions, conjunctions,
articles, auxiliary/modal verbs, and common discourse connectors. This class
doesn't grow - list it once, thoroughly, and it's largely done. Include:

- Personal, possessive, reflexive, and demonstrative pronouns
- Prepositions and conjunctions
- Auxiliary and modal verbs (in their inflected forms too, unless your
  verb-conjugation system already covers them - see §4)
- Common discourse markers/connectors (however, therefore, unless, ...)
- Quantifiers (many, few, several, ...) - watch for overlap with the
  adjectives list; don't duplicate a quantifier that's also listed as an
  adjective elsewhere (see §9)

**Short/trivial entries**: don't skip 1-2 letter function words just because
they look like they can't possibly matter. They usually won't, in practice,
because a separate `minWordLength` filter already excludes anything shorter
than the configured threshold before the stopword check even runs - but they
cost nothing to list, and they become a real safety net if `minWordLength`
is ever configured lower. Document this reasoning inline (see the note above
`$functionWords` in `StopwordsEn.php`) so nobody "cleans up" what looks like
dead weight without understanding why it's there.

## 4. Step 2 - verb inflection strategy

Decide, for the target language, whether verb inflection is *productive and
rule-based* (a small number of patterns cover the vast majority of verbs) or
*inherently irregular* (German strong verbs, English irregular verbs).

- If regular: write a `conjugate()`-equivalent that derives inflected forms
  from a base-form list, so maintenance only ever means adding a base form
  (see `StopwordsEn.php::conjugate()` for consonant-doubling, e-drop,
  y-to-ies, and third-person -es rules as a worked example).
- Hand-list only genuinely irregular forms in a separate keyed structure
  (`IRREGULAR` in `StopwordsEn.php`). Don't try to make the regular-rule
  engine "smart enough" to also handle irregulars via more special cases -
  that way lies an unmaintainable thicket of edge cases. A flat lookup table
  is more honest and easier to extend.
- **Never guess algorithmically what a general rule-detection heuristic
  can't reliably determine** (e.g. syllable counting to decide consonant
  doubling in English - "happen" and "get" look structurally identical but
  inflect differently). Use a small, curated exception list instead
  (`DOUBLING_VERBS`). A wrong guess here silently produces a malformed word
  form that then never matches anything - worse than not having the rule at
  all, because it's invisible.
- If the target language has regional/historical spelling variants (British
  vs. American English is the worked example here - `NOUN_ADJ_VARIANTS`,
  and the automatic `-ize`/`-ise` derivation in `conjugate()`), decide
  whether the variants can be derived by a pattern (worth automating) or
  need explicit pairing (list them, don't guess).

## 5. Step 3 - adjectives: the real judgment call

This is where most of the actual thinking happens, and where a systematic
test helps more than intuition alone. For every candidate word, ask:

> **Could this word, on its own, ever be the actual subject of an article -
> in *any* plausible content domain, not just the blog you have in front of
> you right now?**

- If no (it only ever *describes* something else - "important", "several",
  "obviously"): safe to exclude.
- If yes, even in a domain-specific way (color/texture/taste words for a
  food blog; "secure"/"remote"/"smart" for a tech blog; genre words like
  "horror" or "classic"; geography, materials, family relations, colors,
  occupations): **do not exclude it**, even if it's grammatically an
  adjective and even if it "feels" generic in isolation. A word's part of
  speech doesn't determine whether it's topical - its actual semantic
  content does.

This system was tuned against a specific set of blogs (recipes, PHP/CMS
tooling) and explicitly stays open to unrelated domains (travel, politics,
astronomy, hobbies, family, ...) that the same blog might cover next month.
When curating a large frequency list (word-frequency exports are a good
source of candidates), don't default to "generic-sounding = exclude" -
apply the test above to *every* word, and when genuinely unsure, leave it
out of the stopword list. A missed auto-suggestion costs nothing; a
suppressed real topic costs a manual step every time it comes up.

## 6. Step 4 - domain-tailoring, not universal completeness

This is not, and should not try to become, a general-purpose NLP stopword
list matching some academic standard. Prioritize completeness for the
words that actually show up as noise in *this* author's real content over
enumerating every theoretically possible word in the language. The long
tail of rare words is, by definition, rare - and TF-IDF's own math already
deprioritizes anything that's genuinely uncommon across the corpus, so a
missing rare word is usually harmless (see §8).

## 7. Step 5 - the safety valve: never break the matched-tag bypass

`TfIdfTagger::suggest()` checks whether any already-established tag appears
in the article text via a direct regex match on the raw text - this runs
independently of, and before, any stopword filtering. This is why it's safe
to be aggressive about excluding a word from auto-suggestions: if the author
already uses that word as a tag, it's found regardless. When implementing a
new language, preserve this separation. Do not fold "is this word
stopword-excluded" logic into the matched-tag check, and do not let a
language-specific tokenizer quirk (e.g. capitalization requirements)
accidentally suppress the matched-tag path.

## 8. Step 6 - malformed-text robustness (language-independent)

Several safety rules apply regardless of language, because they guard
against upstream data problems, not grammar:

- **HTML entity decoding before tag stripping** (`HtmlText::toPlainText()`):
  `strip_tags()` alone leaves literal entity text (`&nbsp;`) behind, which
  then gets mistaken for a real word ("nbsp"). Decode first.
- **Tag-to-space padding, not tag-to-nothing**: naive `strip_tags()` fuses
  adjacent table cells / block content together
  (`<td>A</td><td>B</td>` -> "AB"). Pad every `<`/`>` with a space before
  stripping.
- **Reject words with more than one dash**, and **reject words ending in a
  dash** (fragments from elliptical constructions like German
  "Schlag- und Suchwörter", or malformed markup).
- **Reject implausible internal capitalization**: more than two capital
  letters in a single dash-segment that isn't fully uppercase is very
  likely mangled/concatenated text, not a real word - checked *per
  dash-segment*, not across a whole hyphenated compound, so genuine
  compounds with an acronym half ("Section-IDs") still work. Fully
  uppercase segments are exempt (real acronyms: "CMS", "HTTPS").
- These rules are cheap insurance and language-agnostic - implement them
  once in the tokenizer, not per language file.

## 9. Step 7 - plural/singular handling: conservative by construction

If the target language has productive, low-risk pluralization for a
specific subset of vocabulary (e.g. English "+s" for most nouns; German
"+s" specifically for modern loanwords), a narrow, **opt-in** normalization
step can merge "task"/"tasks" into one candidate instead of splitting their
frequency. Ground rules, learned the hard way in this codebase:

- Never attempt this for a language's *general* pluralization if it has
  multiple productive patterns with no single reliable rule (German native
  plurals: +e, +er+umlaut, +en, +s, or unchanged - there is no shortcut).
  Scope the normalization narrowly (e.g. "only the +s loanword pattern") and
  say so in the code comment.
- Maintain an explicit **invariant/exception list** for words where the
  "obvious" stripping rule would produce a wrong or different real word
  (English: "status" -> "statu" is wrong; "analysis" -> "analysi" is wrong,
  covered by suffix-based guards for `-us`/`-ss`/`-sis`/`-ics`. German:
  "Kreis" -> "Krei" is wrong, "Klaus" -> "Klau" changes a name into an
  unrelated word). A wrong merge is worse than no merge - when genuinely
  unsure, extend the exception list rather than loosening the rule.
- Tie any length-based threshold in the stripping rule to the tagger's
  actual `minWordLength` setting, not a separate hardcoded number - two
  independent magic numbers that happen to start out equal will silently
  diverge the moment either one is tuned.

## 10. Step 8 - evidence over speculation

Add words as they're found to actually cause noise in real test runs
against real content - not by pre-emptively enumerating every word that
theoretically might. A single observed instance is worth adding (cheap);
exhaustively guessing at words nobody has actually seen cause a problem
usually isn't a good use of time, and risks over-broad exclusions from
guessing wrong about a word's topicality (§5). When you *do* have a large
candidate source (e.g. a frequency-annotated word list), cross-check
programmatically against the existing list first (`isStopword()` already
accounts for inflection, plural-stripping, and the `-ly` rule) so you only
have to make judgment calls on genuinely new candidates, not re-litigate
words that are already covered.

## 11. Step 9 - hygiene: alphabetize, dedupe, and let sections retire

- Group entries under `// comment` headers by *semantic* category (function
  words, adjectives, tech-domain verbs, ...), and alphabetize *within* each
  group. This makes "is X already here" a fast visual scan instead of a
  full-text search, and keeps a rough history of how the list grew.
- Periodically re-alphabetize and diff the result against the previous
  version's full word set (not just a line count) to confirm nothing was
  silently lost or duplicated - alphabetizing a large list by hand is
  exactly the kind of mechanical task that should be scripted and verified,
  not eyeballed.
- A section whose only reason to exist was documenting a since-fixed bug
  ("these entries used to be missing because of a wiring bug") should be
  merged into whatever semantic section its words actually belong to once
  the bug is history - keeping it separate forever turns a changelog entry
  into a permanent, confusing category.
- Watch for entries that can *never* structurally satisfy the rule they
  were added to support (e.g. a word added to guard against a "-s ending"
  rule that doesn't actually end in "s") - these are harmless but
  meaningless, and worth removing when noticed, the same way a code review
  would flag dead code.

## 12. Anti-patterns - things not to do

- Don't build a general "smart" heuristic (syllable counting, algorithmic
  stemming) where a small curated exception list would be more reliable and
  easier to reason about.
- Don't exclude a word just because it's grammatically an adjective/adverb -
  exclude it because it has no topical content, which is a semantic
  judgment, not a part-of-speech one.
- Don't let a stopword-list decision block an already-established tag - if
  you ever find yourself routing stopword-exclusion logic into the
  matched-tag path, stop and reconsider the architecture instead.
- Don't keep a "historical" section alive past its narrative usefulness.
- Don't guess at plural/singular stripping without an exception list for
  the words where it would break something.
- Don't skip the diff-and-verify step after a bulk reformatting/sorting
  pass - "it still looks right" is not the same as "nothing was lost".

## 13. Quick checklist for a new language file

1. Does the language give a free morphological signal (like German
   capitalization)? If yes, exploit it in the tokenizer, not just the word
   list.
2. List function words (closed class) exhaustively - pronouns,
   prepositions, conjunctions, auxiliaries, connectors, quantifiers.
3. Decide the verb-inflection strategy: rule-based generator + irregular
   lookup table, or (if inflection is too irregular to rule-generate) a
   flat list of pre-inflected forms.
4. Curate adjectives/descriptive words using the "could this ever be a
   real topic" test from §5 - not a part-of-speech test.
5. Reuse the language-independent robustness rules (HTML decoding, tag
   padding, dash rules, cap-count rule) - implement once, not per language.
6. If pluralization normalization is wanted, scope it narrowly, make it
   opt-in, and build an exception list from the start.
7. Confirm the matched-tag bypass still works end-to-end for this language
   before considering the file done.
8. Alphabetize within semantic sections; verify by full-set diff, not by
   eye.

## 14. A DEVELOPMENT AI PROMPT suggestion

Here you can find some condensed sections with a concise, imperative structure
of the 13 chapters above and a built-in self-check at the end, as an example
what to give to an AI system of your choice as a [`DEVELOPER_AI_PROMPT`](https://github.com/ophian/additional_plugins/blob/master/serendipity_event_freetag/auto/docs/DEVELOPER_AI_PROMPT.md),
building a new language file alltogether. All you have to do is to insert your
preferred language to build, add the two reference files, and explain your real
intentions to get started. Good luck!

### Please try to read and understand the actual PROMPT first,
- then add the necessary changes and additions (language to build for and the
  files or their content),
- then explain your own intentions, pre-works and words-list and
- your desired language to talk to the model while development,
- understand that the first and the last paragraphs of the **example** prompt
  file are **NOT** within the PROMPTs context to give away,
- then paste its content to the AI form.
- Name it "Build a new `{LANGUAGE}` TF-IDF Stopword Language File for the
  auto-tag suggestion environment system".
- Keep the initial prompt language in english so you do not lose tokens for
  unnecessary translations, or translating errors.
- Give the model and yourself enough time to understand the needs until you
  both think you are ready for a first stable merge commit request.

## Appendix

This is for future DEVS only to develop NEW auto-tag suggestions files in
other languages that are supported by the Serendipity Styx Edition.

To only discuss or suggest words to this auto-tags environment system within
English or German language, please head to the Styx freetag plugin
[auto-tags discussion](https://github.com/ophian/styx/discussions/71) thread
and priorly first read the `DISCUSSION_PREAMBLE` header carefully to know
what to ask for and to keep things specific and precise only.

Please do not get offended if your question or suggested addition might get
dismissed or even the question itself removed, to keep this thread clean
& straitforward to really improve auto-tags for us all.

Our all time is limited and so a non-asked issue is better than too much of
rather unfocused questions. If you've taken this to heart and have really
thought the question through — ❤️ — go ahead and participate!

Your help is welcome! 💖

**Thank you**

### References

<sup>[0]</sup> TF-IDF stands for “Term Frequency-Inverse Document Frequency” and is a method
               for assessing the relevance of a word within a text corpus. It is therefore
               used to determine the importance of a term in relation to a document.
               https://en.wikipedia.org/wiki/Tf%E2%80%93idf
<sup>[1]</sup> https://en.wikipedia.org/wiki/Agglutinative_language
<sup>[2]</sup> https://en.wikipedia.org/wiki/Word_stem, https://en.wikipedia.org/wiki/Lemma_(morphology)