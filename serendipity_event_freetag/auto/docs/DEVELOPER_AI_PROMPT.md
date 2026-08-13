# AI Task Prompt: Build a Stopword Language File

Use this as the task prompt (system or first-user message) when asking an AI
to build or extend a stopword file for the auto-tagging system in this repo.
Fill in `{LANGUAGE}` and hand this to the model along with `Stopwords.php`
(German) and `StopwordsEn.php` (English) as reference implementations.

---

## Task

Build `Stopwords{LANGUAGE}.php` for a TF-IDF auto-tagging system. The class
exposes `isStopword(string $word): bool`. A word returning `true` is
excluded from *auto-suggested* tags only — it is never blocked from
matching an *already-assigned* tag (separate mechanism, untouched by this
file). Being wrong here is cheap: false = one missed suggestion, not a lost
feature. Calibrate accordingly — when unsure, exclude nothing.

## Step 0 — Check for a free morphological signal

Does {LANGUAGE} mark nouns/topical words distinctly and cheaply (e.g.
German: all nouns capitalized, even mid-sentence)? If yes, that signal
belongs in the tokenizer (candidate-selection logic), not the word list —
it shrinks the word list dramatically. If no (e.g. English: only proper
nouns capitalized), the word list carries the full load; expect ~4x the
size of a language that has the signal.

## Step 1 — Closed-class function words (do this exhaustively, once)

List completely: personal/possessive/reflexive/demonstrative pronouns,
prepositions, conjunctions, auxiliary/modal verbs (+ inflected forms unless
covered by Step 2's generator), discourse connectors, quantifiers.
Include 1–3 letter entries even though a `minWordLength` filter usually
makes them unreachable in practice — cheap insurance if that threshold is
ever lowered. Comment *why* inline so nobody deletes them as "dead code."

## Step 2 — Verb inflection: generate, don't enumerate

1. Determine if {LANGUAGE} verb inflection is productive/rule-based or
   inherently irregular for a large class of verbs.
2. If rule-based: write a `conjugate($base): array` that derives all
   surface forms from a base-form list (`VERB_BASES`). Maintenance must
   reduce to "add one base form."
3. Hand-list ONLY true irregulars in a keyed `IRREGULAR` map
   (`base => [form, form, ...]`). Never special-case irregulars into the
   general rule engine.
4. NEVER use an algorithmic heuristic (e.g. syllable-counting) to decide
   an inflection edge case (e.g. English consonant-doubling: "get" doubles,
   "happen" doesn't, same surface shape). Use a small curated exception
   list instead (see `DOUBLING_VERBS` in `StopwordsEn.php`). A wrong guess
   here silently produces a form that never matches anything again.
5. If {LANGUAGE} has regional spelling variants with a derivable pattern
   (e.g. `-ize`/`-ise`), derive automatically. If pattern-less (e.g.
   colour/color), list explicit pairs (`NOUN_ADJ_VARIANTS`-style),
   generating singular+plural for each.

## Step 3 — Adjectives/descriptors: apply this test to EVERY candidate, no exceptions

> Could this word, alone, ever be the actual SUBJECT of an article, in ANY
> content domain — not just the one you're picturing?

- No → safe to exclude (generic evaluative/degree words: "important",
  "several", "obviously").
- Yes, even domain-specifically (colors, textures, tastes, materials,
  genres, occupations, places, tech terms, hobbies) → DO NOT exclude, even
  if it's grammatically an adjective and "feels" generic out of context.
  Part of speech ≠ topicality. This is a semantic judgment, not a
  grammatical one.

When curating a bulk source (frequency list, corpus export): cross-check
each candidate against the existing `isStopword()` first (it already
covers inflection/plural-stripping/any `-ly`-type rule) so you only spend
judgment on genuinely new words. Apply the test above to every single one —
do not batch-approve on vibes.

## Step 4 — Scope to the actual content, not universal completeness

Prioritize words that demonstrably cause noise in this author's real
content over exhaustively enumerating the language. TF-IDF's own math
already deprioritizes genuinely rare corpus words, so gaps in the long tail
are low-cost. Add words from evidence (a real test run, a real false
positive), not speculative pre-enumeration of "words that might someday
appear."

## Step 5 — Do not touch the matched-tag bypass

`suggest()` matches already-established tags directly against raw article
text, independent of and prior to any stopword filtering. Keep it that
way. Do not route stopword logic into that path; do not let a
language-specific tokenizer rule (e.g. a capitalization requirement)
suppress it.

## Step 6 — Reuse these language-independent robustness rules as-is (do not reimplement per language)

- Decode HTML entities before stripping tags (`&nbsp;` → real space, not
  literal text "nbsp").
- Pad `<`/`>` with spaces before `strip_tags()`, so adjacent block/table
  content doesn't fuse ("`<td>A</td><td>B</td>`" → "A B", not "AB").
- Reject tokens with >1 dash, and tokens ending in a dash (elliptical
  fragments, malformed markup).
- Reject tokens where a single dash-segment (not the whole hyphenated
  compound) has >2 capital letters AND isn't fully uppercase (malformed/
  concatenated text) — check per-segment so genuine acronym-compounds
  survive ("Section-IDs" fine: segment "IDs" = 2 caps, ok). Exempt fully
  uppercase segments (real acronyms: "CMS", "HTTPS").

## Step 7 — Plural/singular merging (OPTIONAL, opt-in only)

Only attempt if {LANGUAGE} has ONE narrow, low-risk productive pattern
(e.g. English "+s"; German "+s" specifically for modern loanwords). Never
attempt for a language's general pluralization if it has multiple
productive patterns with no single rule (e.g. German native plurals: +e,
+er+umlaut, +en, +s, unchanged — don't even try a shortcut here).
Mandatory: a curated invariant/exception list for words the naive rule
would break (English: "status"→"statu" wrong, guard `-us`/`-ss`/`-sis`/
`-ics`; German: "Kreis"→"Krei" wrong, "Klaus"→"Klau" turns a name into a
different word). Tie any length threshold to the tagger's actual
`minWordLength`, not a separate hardcoded number.

## Step 8 — Organization & hygiene

- Group entries under `// comment` headers by semantic category; sort
  alphabetically WITHIN each group (fast "is X already here" scanning).
  For development stick to the users preferred language the user is talking to
  you, so we have no language barriers. At the end, comments, DocTypes and
  descriptions should be held in `English` language. Remember this for a late
  task.
- A section whose only purpose was documenting a since-fixed bug gets
  merged into its real semantic category once the bug is history — don't
  keep it as a permanent quarantine zone.
- After any bulk edit (sort, merge, dedupe): verify by diffing the FULL
  extracted word set against the pre-edit version (not line count, not
  "looks right") — confirm zero words lost, zero unintended additions,
  then separately check for duplicate entries. Do this programmatically.

## Hard "never" list

- Never build a "smart" general heuristic where a small exception list is
  more reliable (syllable-counting, algorithmic stemming).
- Never exclude a word for its part of speech; exclude for lack of
  topicality only.
- Never let stopword logic block an already-matched/established tag.
- Never keep a historical/bugfix section alive past its narrative purpose.
- Never strip plurals/singulars without an exception list.
- Never skip the post-bulk-edit diff-and-verify step.
- Never add a word to a language file just because it exists in another
  language's file — re-run the topicality test per language; domains and
  connotations don't transfer 1:1.

## Before declaring the file done, self-check:

1. `php -l` (or language equivalent) passes.
2. Full word-set diff against previous version (if extending) shows only
   intended changes.
3. Zero duplicate entries anywhere.
4. Spot-test: 3–5 known-generic words → `true`; 3–5 known-domain-topical
   words (colors, tech terms, genres relevant to the actual blog) → `false`.
5. Spot-test the matched-tag path still recognizes an existing tag that
   happens to also be stopword-listed (confirms bypass intact).
6. Every new inflection/exception list entry has a one-line comment stating
   WHY (what it guards against), not just what it is.

---

For the full reasoning and worked examples behind every rule above, see
`LANGUAGE_GUIDE.md` (English) / `LANGUAGE_GUIDE.de.md` (German) — written
for human contributors, much longer, same underlying principles.