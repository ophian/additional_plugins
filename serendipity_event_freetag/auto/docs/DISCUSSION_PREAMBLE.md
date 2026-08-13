# Before you suggest a word — read this first / Bevor du ein Wort vorschlägst — bitte zuerst lesen

*(English below / Deutsch weiter unten)*

---

## English

This thread is for suggesting words to add to (or remove from) the
auto-tagging stopword lists. To keep the discussion focused and avoid
re-litigating the same question for every word, please read this before
posting.

**What a "stopword" is here:** a word the auto-tagger will *not* suggest as
a new tag on its own. It has nothing to do with hiding or censoring a word -
if you've already tagged an article with that exact word, it still gets
recognized every time, regardless of this list (that's a separate,
independent mechanism). Adding a word here only means "don't *auto-suggest*
this as a new tag" - nothing more, nothing less. If we get it wrong, the
cost is one missed suggestion, not a lost feature.

**Before posting, ask yourself:**

> Could this word, on its own, ever be the actual *subject* of an article —
> in any content domain, not just the one you're thinking of right now?

- If the word only ever *describes* something else and never *names* a
  topic (e.g. "important", "several", "obviously") → good candidate to add.
- If the word could name a real topic in some domain — a color, a texture,
  a taste, a material, a genre, an occupation, a place, a tech term, a
  hobby, anything — please **don't** propose it, even if it looks "generic"
  in the sentence you found it in. Words don't get excluded for their
  grammatical role (adjective, adverb, ...); they get excluded for having
  no topical content at all. Those are different questions.

**What's useful to include in your suggestion:**
- The word itself (base form is enough - inflected forms are usually
  derived automatically, see [`LANGUAGE_GUIDE.md`](https://github.com/ophian/additional_plugins/serendipity_event_freetag/auto/docs/LANGUAGE_GUIDE.md)).
- Where you actually saw it cause noise (a specific article, a specific
  auto-suggestion you didn't want) - real examples move faster than
  hypotheticals.
- Which language it's for.

**What tends to slow things down:**
- Long speculative lists of "words that could theoretically show up
  someday" without a concrete example. One real instance is worth adding;
  guessing at hundreds usually isn't a good use of anyone's time.
- Proposing a word that's already covered by an existing rule (inflection,
  plural-stripping, the `-ly` rule, etc.) - please check `isStopword()`
  against the word first if you can.

If you want the full reasoning behind how this list is built (verb
inflection strategy, plural handling, why some short words are kept even
though they never fire, etc.), see [`LANGUAGE_GUIDE.md`](https://github.com/ophian/additional_plugins/serendipity_event_freetag/auto/docs/LANGUAGE_GUIDE.md) in this repo.

---

## Deutsch

Dieser Thread ist für Vorschläge, welche Wörter zu den Stopwort-Listen des
Auto-Tagging-Systems hinzugefügt (oder daraus entfernt) werden sollten. Damit
die Diskussion fokussiert bleibt und nicht bei jedem Wort dieselbe
Grundsatzfrage neu verhandelt wird, bitte das hier vorher lesen.

**Was ein "Stopwort" hier bedeutet:** ein Wort, das das Auto-Tagging-System
*nicht von selbst* als neuen Tag vorschlägt. Das hat nichts mit Verstecken
oder Zensur zu tun – wenn ein Artikel bereits mit genau diesem Wort getaggt
ist, wird es trotzdem jedes Mal erkannt, unabhängig von dieser Liste (das
läuft über einen komplett separaten Mechanismus). Ein Wort hier einzutragen
heißt nur "schlage das nicht automatisch als neuen Tag vor" – nicht mehr und
nicht weniger. Liegen wir falsch, kostet das einen verpassten Vorschlag,
keine verlorene Funktion.

**Bevor du postest, frag dich:**

> Könnte dieses Wort für sich allein jemals das eigentliche *Thema* eines
> Artikels sein – in irgendeinem Themenbereich, nicht nur in dem, an den du
> gerade denkst?

- Wenn das Wort immer nur etwas anderes *beschreibt* und nie selbst ein
  Thema *benennt* (z.B. "wichtig", "mehrere", "offensichtlich") → guter
  Kandidat zum Hinzufügen.
- Wenn das Wort in irgendeinem Themenbereich ein echtes Thema benennen
  könnte – eine Farbe, eine Textur, ein Geschmack, ein Material, ein Genre,
  ein Beruf, ein Ort, ein Fachbegriff, ein Hobby, alles – dann **bitte
  nicht** vorschlagen, auch wenn es im gefundenen Satz "generisch" wirkt.
  Wörter werden nicht wegen ihrer Wortart ausgeschlossen (Adjektiv, Adverb,
  ...), sondern weil ihnen jeder inhaltliche Themenbezug fehlt. Das sind
  zwei verschiedene Fragen.

**Was einem Vorschlag hilft:**
- Das Wort selbst (Grundform reicht – flektierte Formen werden meist
  automatisch abgeleitet, siehe [`LANGUAGE_GUIDE.md`](https://github.com/ophian/additional_plugins/serendipity_event_freetag/auto/docs/LANGUAGE_GUIDE.md)).
- Wo du es tatsächlich als Störung erlebt hast (ein konkreter Artikel, ein
  konkreter unerwünschter Auto-Vorschlag) – echte Beispiele sind schneller
  zu klären als Hypothesen.
- Für welche Sprache der Vorschlag gilt.

**Was die Sache eher verlangsamt:**
- Lange, spekulative Listen von "Wörtern, die theoretisch mal auftauchen
  könnten" ohne konkretes Beispiel. Ein real beobachteter Fall lohnt sich zu
  ergänzen; hunderte Wörter auf Verdacht durchzuspekulieren meist nicht.
- Wörter vorschlagen, die durch eine bestehende Regel schon abgedeckt sind
  (Flexion, Plural-Abschneiden, die "-ly"-Regel usw.) – wenn möglich vorher
  kurz gegen `isStopword()` prüfen.

Für die komplette Begründung, wie diese Liste aufgebaut ist (Strategie zur
Verb-Flexion, Umgang mit Plural, warum manche kurzen Wörter trotz
Wirkungslosigkeit drinbleiben, usw.), siehe [`LANGUAGE_GUIDE.md`](https://github.com/ophian/additional_plugins/serendipity_event_freetag/auto/docs/LANGUAGE_GUIDE.md) in diesem
Repository.
