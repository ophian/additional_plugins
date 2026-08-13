# Eine Sprachdatei für das Auto-Tagging-Stopwortsystem bauen

*[English version: LANGUAGE_GUIDE.md](https://github.com/ophian/additional_plugins/blob/master/serendipity_event_freetag/auto/docs/LANGUAGE_GUIDE.md)*

Dieses Dokument erklärt die *Prinzipien* hinter `Stopwords.php` (Deutsch) und
`StopwordsEn.php` (Englisch), damit ein zukünftiger Mitentwickler eine
Stopwortdatei für eine dritte Sprache bauen kann (oder eine bestehende
erweitert), ohne die Begründung allein aus dem Code rekonstruieren zu
müssen. Es ist keine Vorlage, die `IrgendeineNeueSprache.php` Zeile für
Zeile kopieren sollte – dafür unterscheiden sich Sprachen zu stark –
sondern ein Entscheidungsrahmen: die Fragen, die in dieser Reihenfolge zu
stellen sind, und die Abwägungen bei jeder einzelnen.

## 1. Wofür dieses System eigentlich da ist

Die Stopwortliste versorgt einen TF-IDF<sup>[0]</sup>-Tagger (`TfIdfTagger.php`), der Tags
für Blogartikel vorschlägt. Ein Wort auf der Liste wird von *automatisch
vorgeschlagenen* neuen Tags ausgeschlossen. Es wird **niemals** vom Matching
ausgeschlossen, falls es bereits ein etablierter Tag auf dem Blog ist (die
`matched`-Logik in `suggest()` läuft auf dem rohen Artikeltext, komplett
unabhängig von der Stopwortliste – siehe §7). Diese Unterscheidung ist für
jede Entscheidung weiter unten wichtig: bei einem Stopwort-Eintrag "falsch"
zu liegen ist billig (schlimmstenfalls ein plausibler Auto-Vorschlag
weniger), weil der Autor immer manuell taggen kann, und weil ein wirklich
nützliches, ausgeschlossenes Wort **nie** dauerhaft verloren geht – es wird
nur nicht automatisch vorgeschlagen.

## 2. Schritt 0 – gibt die Sprache dir ein spezifischen Hinweis?

Bevor du auch nur ein Wort aufschreibst, frag dich: Hat diese Sprache ein
orthografisches oder morphologisches Merkmal, das themen­tragende Wörter
(Nomen) zuverlässig von Funktions-/Füllwörtern unterscheidet, unabhängig von
einer Wortliste?

- **Deutsch**: ja – alle Nomen werden großgeschrieben, auch mitten im Satz.
  Das wird direkt in `Stopwords.php` / `TfIdfTagger::tokenize()`
  ausgenutzt: ein Kandidat muss großgeschrieben UND nicht satzanfänglich
  sein. Die Stopwortliste selbst kann dadurch deutlich kleiner bleiben, da
  die meisten Nicht-Nomen schon allein durch die Großschreibungsregel
  ausgeschlossen werden.
- **Englisch**: nein – nur Eigennamen werden großgeschrieben, normale Nomen
  nicht. Es gibt keine Abkürzung; die Stopwortliste muss die gesamte Arbeit
  übernehmen, weshalb `StopwordsEn.php` bei vergleichbarer Abdeckung
  etwa 4x größer ist als die deutsche Liste.
- **Andere Sprachen**: prüfe auf Großschreibungsregeln, aber denk auch an
  andere Merkmale – z.B. an Nomen verschmolzene bestimmte Artikel,
  Kasusmarkierungen, oder (bei Sprachen mit reicher agglutinierender
  Morphologie)<sup>[1]</sup> ob ein Stemming-/Lemmatisierungsschritt<sup>[2]</sup> mit handgeschriebenen
  Regeln überhaupt machbar ist, oder ob es einen echten morphologischen
  Analysator bräuchte (in diesem Fall lieber explizit so benennen, statt
  eine brüchige "Eigenbau-Näherung" zu versuchen).

## 3. Schritt 1 – Funktionswörter (geschlossene Klasse)

Jede Sprache hat eine endliche Menge an Pronomen, Präpositionen,
Konjunktionen, Artikeln, Hilfs-/Modalverben und gängigen
Diskurs-Konnektoren. Diese Klasse wächst nicht – einmal gründlich
aufgelistet, ist sie weitgehend erledigt. Dazu gehören:

- Personal-, Possessiv-, Reflexiv- und Demonstrativpronomen
- Präpositionen und Konjunktionen
- Hilfs- und Modalverben (auch in ihren flektierten Formen, sofern dein
  Verb-Konjugationssystem sie nicht schon abdeckt – siehe §4)
- Gängige Diskursmarker/Konnektoren (jedoch, deshalb, es sei denn, ...)
- Quantifizierer (viele, wenige, mehrere, ...) – Vorsicht bei Überschneidung
  mit der Adjektivliste; einen Quantifizierer nicht doppelt eintragen, wenn
  er anderswo schon als Adjektiv gelistet ist (siehe §9)

**Kurze/triviale Einträge**: 1-2-Buchstaben-Funktionswörter nicht
weglassen, nur weil sie unmöglich relevant wirken. In der Praxis stimmt das
meist auch – ein separater `minWordLength`-Filter schließt alles Kürzere als
den konfigurierten Schwellenwert schon aus, bevor die Stopwort-Prüfung
überhaupt läuft – aber sie kosten nichts, aufgelistet zu werden, und werden
zu einem echten Sicherheitsnetz, falls `minWordLength` je niedriger
eingestellt wird. Diese Begründung direkt im Code dokumentieren (siehe die
Notiz über `$functionWords` in `StopwordsEn.php`), damit niemand vermeintlich
unnötigen Ballast "aufräumt", ohne zu verstehen, warum dieser dort steht.

## 4. Schritt 2 – Strategie für Verbflexion

Entscheide für die Zielsprache, ob Verbflexion *produktiv und regelbasiert*
ist (wenige Muster decken die große Mehrheit der Verben ab) oder *von Natur
aus unregelmäßig* (deutsche starke Verben, englische unregelmäßige Verben).

- Falls regelmäßig: schreib ein `conjugate()`-Äquivalent, das flektierte
  Formen aus einer Grundform-Liste ableitet, sodass Pflege nur noch heißt,
  eine Grundform zu ergänzen (siehe `StopwordsEn.php::conjugate()` für
  Konsonantenverdopplung, e-Wegfall, y-zu-ies und Endungen der 3. Person
  als Beispiel).
- Nur wirklich unregelmäßige Formen von Hand in eine separate
  Schlüssel-Struktur eintragen (`IRREGULAR` in `StopwordsEn.php`). Nicht
  versuchen, die Regel-Engine "schlau genug" zu machen, um Unregelmäßiges
  über immer mehr Sonderfälle mitzuerledigen – das führt zu einem
  unwartbaren Dickicht aus Randfällen. Eine flache Nachschlagetabelle ist
  ehrlicher und leichter zu erweitern.
- **Nie algorithmisch raten, was eine allgemeine Regel-Heuristik nicht
  zuverlässig bestimmen kann** (z.B. Silbenzählung, um Konsonantenverdopplung
  im Englischen zu entscheiden – "happen" und "get" sehen strukturell
  identisch aus, flektieren aber unterschiedlich). Stattdessen eine kleine,
  kuratierte Ausnahmeliste nutzen (`DOUBLING_VERBS`). Ein falscher Rateversuch
  erzeugt hier lautlos eine fehlerhafte Wortform, die dann nie mehr etwas
  matcht – schlimmer, als die Regel gar nicht zu haben, weil es unsichtbar
  bleibt.
- Falls die Zielsprache regionale/historische Rechtschreibvarianten hat
  (britisches vs. amerikanisches Englisch ist hier das Beispiel –
  `NOUN_ADJ_VARIANTS`, plus die automatische `-ize`/`-ise`-Ableitung in
  `conjugate()`), entscheiden, ob sich die Varianten über ein Muster
  ableiten lassen (lohnt sich zu automatisieren) oder explizite Paarung
  brauchen (auflisten, nicht raten).

## 5. Schritt 3 – Adjektive: die eigentliche Ermessensfrage

Hier steckt der Großteil der eigentlichen Denkarbeit, und ein
systematischer Test hilft mehr als reines Bauchgefühl. Für jedes
Kandidatenwort fragen:

> **Könnte dieses Wort für sich allein jemals das eigentliche Thema eines
> Artikels sein – in *irgendeinem* plausiblen Themenbereich, nicht nur in
> dem Blog, den du gerade vor dir hast?**

- Wenn nein (es *beschreibt* immer nur etwas anderes – "wichtig",
  "mehrere", "offensichtlich"): gefahrlos auszuschließen.
- Wenn ja, auch nur themenspezifisch (Farb-/Textur-/Geschmackswörter für
  einen Food-Blog; "sicher"/"remote"/"smart" für einen Tech-Blog;
  Genre-Wörter wie "Horror" oder "Klassiker"; Geografie, Materialien,
  Familienbeziehungen, Farben, Berufe): **nicht ausschließen**, selbst wenn
  es grammatikalisch ein Adjektiv ist und selbst wenn es isoliert betrachtet
  "generisch" wirkt. Die Wortart eines Wortes bestimmt nicht, ob es
  themenhaft ist – das tut nur sein tatsächlicher semantischer Inhalt.

Dieses System wurde an einer konkreten Auswahl von thematischen Blogs
abgestimmt (Rezepte, PHP/CMS-Tooling), aber bleibt bewusst offen für fachfremde
Themenbereiche (Reisen, Politik, Astronomie, Hobbys, Familie, ...), die ein
anderer / derselbe Blog nächsten Monat abdecken könnte. Beim Kuratieren einer
großen Frequenzliste (Wort-Häufigkeits-Exporte sind eine gute Kandidatenquelle)
nicht standardmäßig nach "klingt generisch = ausschließen" vorgehen –
den Test oben auf *jedes* Wort anwenden, und im Zweifel draußen lassen. Ein
verpasster Auto-Vorschlag kostet nichts; ein unterdrücktes echtes Thema
kostet jedes Mal einen manuellen Schritt, wenn es vorkommt.

## 6. Schritt 4 – Domänenanpassung statt universeller Vollständigkeit

Dies ist keine allgemeine NLP-Stopwortliste nach akademischem Standard und
sollte auch nicht versuchen, eine zu werden. Vollständigkeit priorisieren
für die Wörter, die in *diesem* Autors echten Inhalten tatsächlich als
Rauschen auftauchen – nicht jedes theoretisch mögliche Wort der Sprache
aufzählen. Der lange Schwanz seltener Wörter ist per Definition selten –
und die TF-IDF-Mathematik selbst stuft schon alles herunter, was im Korpus
wirklich ungewöhnlich ist, sodass ein fehlendes seltenes Wort meist
harmlos bleibt (siehe §8).

## 7. Schritt 5 – das Sicherheitsventil: den Matched-Tag-Bypass nie brechen

`TfIdfTagger::suggest()` prüft per direktem Regex-Abgleich auf dem rohen
Text, ob ein bereits etablierter Tag im Artikeltext vorkommt – das läuft
unabhängig von, und vor, jeder Stopwort-Filterung. Deshalb ist es
gefahrlos, beim Ausschließen eines Wortes aus Auto-Vorschlägen aggressiv zu
sein: falls der Autor das Wort bereits als Tag nutzt, wird es trotzdem
gefunden. Beim Implementieren einer neuen Sprache diese Trennung erhalten.
"Ist dieses Wort stopwort-ausgeschlossen"-Logik nicht in die
Matched-Tag-Prüfung einbauen, und keine sprachspezifische
Tokenizer-Eigenheit (z.B. Großschreibungs-Anforderungen) versehentlich den
Matched-Tag-Pfad unterdrücken lassen.

## 8. Schritt 6 – Robustheit gegen fehlerhaften Text (sprachunabhängig)

Mehrere Sicherheitsregeln gelten unabhängig von der Sprache, weil sie gegen
vorgelagerte Datenprobleme absichern, nicht gegen Grammatik:

- **HTML-Entities dekodieren, bevor Tags entfernt werden**
  (`HtmlText::toPlainText()`): `strip_tags()` allein lässt buchstäblichen
  Entity-Text (`&nbsp;`) zurück, der dann für ein echtes Wort ("nbsp")
  gehalten wird. Erst dekodieren.
- **Tags durch Leerzeichen ersetzen, nicht durch nichts**: natives
  `strip_tags()` verschmilzt benachbarte Tabellenzellen/Block-Inhalte
  (`<td>A</td><td>B</td>` -> "AB"). Jedes `<`/`>` vor dem Entfernen mit
  einem Leerzeichen polstern.
- **Wörter mit mehr als einem Bindestrich ablehnen**, und **Wörter, die auf
  einem Bindestrich enden, ablehnen** (Fragmente aus elliptischen
  Konstruktionen wie "Schlag- und Suchwörter", oder fehlerhaftes Markup).
- **Unplausible interne Großschreibung ablehnen**: mehr als zwei
  Großbuchstaben in einem einzelnen Bindestrich-Segment, das nicht
  komplett großgeschrieben ist, ist sehr wahrscheinlich verstümmelter/
  verketteter Text, kein echtes Wort – geprüft *pro Bindestrich-Segment*,
  nicht über ein ganzes Bindestrich-Kompositum hinweg, damit echte
  Komposita mit einer Akronym-Hälfte ("Section-IDs") weiter funktionieren.
  Komplett großgeschriebene Segmente sind ausgenommen (echte Akronyme:
  "CMS", "HTTPS").
- Diese Regeln sind billige Absicherung und sprachunabhängig – einmal im
  Tokenizer implementieren, nicht pro Sprachdatei.

## 9. Schritt 7 – Singular/Plural-Behandlung: von Natur aus konservativ

Falls die Zielsprache eine produktive, risikoarme Pluralbildung für eine
bestimmte Teilmenge des Vokabulars hat (z.B. Englisch "+s" für die meisten
Nomen; Deutsch "+s" speziell bei modernen Lehnwörtern), kann ein enger,
**opt-in** Normalisierungsschritt "task"/"tasks" zu einem Kandidaten
zusammenführen, statt ihre Häufigkeit aufzuspalten. Grundregeln, die sich
in diesem Codebase auf die harte Tour ergeben haben:

- Das nie für die *allgemeine* Pluralbildung einer Sprache versuchen, wenn
  sie mehrere produktive Muster ohne eine einzige verlässliche Regel hat
  (deutsche native Plurale: +e, +er+Umlaut, +en, +s, oder unverändert – es
  gibt keine Abkürzung). Die Normalisierung eng abgrenzen (z.B. "nur das
  +s-Lehnwort-Muster") und das im Code-Kommentar so benennen.
- Eine explizite **Invarianz-/Ausnahmeliste** für Wörter pflegen, bei denen
  die "offensichtliche" Abschneide-Regel ein falsches oder anderes echtes
  Wort erzeugen würde (Englisch: "status" -> "statu" ist falsch;
  "analysis" -> "analysi" ist falsch, abgedeckt durch suffix-basierte
  Schutzregeln für `-us`/`-ss`/`-sis`/`-ics`. Deutsch: "Kreis" -> "Krei" ist
  falsch, "Klaus" -> "Klau" macht aus einem Namen ein unverwandtes Wort).
  Eine falsche Verschmelzung ist schlimmer als gar keine – im Zweifel die
  Ausnahmeliste erweitern statt die Regel zu lockern.
- Jede längenbasierte Schwelle in der Abschneide-Regel an die tatsächliche
  `minWordLength`-Einstellung des Taggers binden, nicht an eine separate
  fest verdrahtete Zahl – zwei unabhängige Begrenzungszahlen, die zufällig
  gleich starten, laufen sonst lautlos auseinander, sobald eine von beiden
  verstellt wird.

## 10. Schritt 8 – Evidenz statt Spekulation

Wörter ergänzen, wenn sie tatsächlich als Rauschen in echten Testläufen
gegen echten Content auffallen – nicht durch vorsorgliches Aufzählen jedes
theoretisch denkbaren Wortes. Ein einzelner beobachteter Fall lohnt sich zu
ergänzen (billig); hunderte Wörter auf Verdacht durchzuraten, die noch nie
jemand als Problem beobachtet hat, ist meist keine gute Zeitnutzung und
riskiert zu breite Ausschlüsse durch falsches Raten bei der Themenhaftigkeit
eines Wortes (§5). Wenn tatsächlich eine große Kandidatenquelle vorliegt
(z.B. eine frequenz-annotierte Wortliste), zuerst programmatisch gegen die
bestehende Liste abgleichen (`isStopword()` berücksichtigt schon Flexion,
Plural-Abschneiden und die `-ly`-Regel), damit nur bei wirklich neuen
Kandidaten eine Ermessensentscheidung nötig ist, statt bereits abgedeckte
Wörter erneut zu verhandeln.

## 11. Schritt 9 – Hygiene: alphabetisieren, Duplikate entfernen, Sektionen in Ruhestand schicken

- Einträge unter `// Kommentar`-Überschriften nach *semantischer* Kategorie
  gruppieren (Funktionswörter, Adjektive, Tech-Domänen-Verben, ...), und
  *innerhalb* jeder Gruppe alphabetisieren. Das macht "ist X schon da" zu
  einem schnellen visuellen Scan statt einer Volltextsuche, und bewahrt
  grob nachvollziehbar, wie die Liste gewachsen ist.
- Regelmäßig neu alphabetisieren und das Ergebnis gegen die vollständige
  Wortmenge der Vorversion abgleichen (nicht nur die Zeilenzahl), um zu
  bestätigen, dass nichts lautlos verloren ging oder dupliziert wurde –
  eine große Liste von Hand zu alphabetisieren ist genau die Art
  mechanischer Aufgabe, die skriptgesteuert und verifiziert gehört, nicht
  nach Augenmaß.
- Eine Sektion, deren einziger Existenzgrund die Dokumentation eines
  inzwischen behobenen Bugs war (zB. "diese Einträge fehlten früher wegen
  eines Verdrahtungsfehlers"), sollte in die semantische Sektion
  verschmolzen werden, zu der ihre Wörter eigentlich gehören, sobald der
  Bug Geschichte ist – sie für immer separat zu halten macht aus einem
  Changelog-Eintrag eine dauerhafte, verwirrende Kategorie.
- Auf Einträge achten, die die Regel, zu deren Absicherung sie ergänzt
  wurden, strukturell *nie* erfüllen können (z.B. ein Wort, das gegen eine
  "endet auf -s"-Regel absichern soll, aber gar nicht auf "s" endet) – die
  sind harmlos, aber bedeutungslos, und es lohnt sich, sie zu entfernen,
  sobald sie auffallen, genau wie ein Code-Review toten Code markieren
  würde.

## 12. Anti-Muster – was man nicht tun sollte

- Keine allgemeine "schlaue" Heuristik bauen (Silbenzählung, algorithmisches
  Stemming)<sup>[2]</sup>, wo eine kleine kuratierte Ausnahmeliste verlässlicher und
  leichter nachvollziehbar wäre.
- Ein Wort nicht ausschließen, nur weil es grammatikalisch ein
  Adjektiv/Adverb ist – ausschließen, weil es keinen Themenbezug hat, das
  ist eine semantische Entscheidung, keine nach Wortart.
- Eine Stopwort-Entscheidung nie einen bereits etablierten Tag blockieren
  lassen – wer sich dabei ertappt, Stopwort-Ausschluss-Logik in den
  Matched-Tag-Pfad einzubauen, sollte innehalten und die Architektur
  überdenken.
- Eine "historische" Sektion nicht über ihren erzählerischen Nutzen hinaus
  am Leben halten.
- Bei Plural-/Singular-Abschneiden nicht ohne Ausnahmeliste für die Wörter
  raten, bei denen es etwas kaputt machen würde.
- Den Diff-und-Verifizier-Schritt nach einem großen
  Umformatierungs-/Sortierdurchgang nicht auslassen – "sieht noch richtig
  aus" ist nicht dasselbe wie "nichts ging verloren".

## 13. Kurz-Checkliste für eine neue Sprachdatei

1. Gibt die Sprache einen konkreten morphologischen Hinweis (wie die
   deutsche Großschreibung)? Falls ja, im Tokenizer ausnutzen, nicht nur in
   der Wortliste.
2. Funktionswörter (geschlossene Klasse) erschöpfend auflisten – Pronomen,
   Präpositionen, Konjunktionen, Hilfsverben, Konnektoren, Quantifizierer.
3. Verbflexions-Strategie festlegen: regelbasierter Generator +
   Unregelmäßigkeits-Tabelle, oder (falls Flexion zu unregelmäßig für
   Regel-Generierung ist) eine flache Liste vorflektierter Formen.
4. Adjektive/beschreibende Wörter mit dem "könnte das je ein echtes Thema
   sein"-Test aus §5 kuratieren – nicht mit einem Wortart-Test.
5. Die sprachunabhängigen Robustheitsregeln wiederverwenden (HTML-Dekodierung,
   Tag-Polsterung, Bindestrich-Regeln, Cap-Count-Regel) – einmal
   implementieren, nicht pro Sprache.
6. Falls Pluralisierungs-Normalisierung gewünscht ist, eng abgrenzen,
   opt-in machen, und von Anfang an eine Ausnahmeliste aufbauen.
7. Bestätigen, dass der Matched-Tag-Bypass für diese Sprache Ende-zu-Ende
   noch funktioniert, bevor die Datei als fertig gilt.
8. Innerhalb semantischer Sektionen alphabetisieren; per Vollmengen-Diff
   verifizieren, nicht nach Augenmaß.

## 14. Ein DEVELOPMENT AI PROMPT Vorschlag

Hier finden Sie eine komprimierte Version der 13 vorhergehenden Abschnitte
auf eine dichte, imperative Struktur mit eingebautem Selbst-Check am Ende;
als ein Beispiel was Sie einer KI ihrer Wahl als [`DEVELOPER_AI_PROMPT`](https://github.com/ophian/additional_plugins/blob/master/serendipity_event_freetag/auto/docs/DEVELOPER_AI_PROMPT.md),
als Richtlinie eingeben können, wenn sie eine neue Sprachdatei im oben
genannten Sinne mit einer solchen KI entwickeln möchten. Sie müssen nur noch
die Sprache ihrer Wahl eintragen und die zwei Referenzdateien hinzufügen, sowie
ihre eigene Absicht darlegen, um loslegen zu können. Viel Erfolg!

### Bitte versuchen Sie
- geduldigst das eigentliche PROMPT zuerst durchzulesen und zu verstehen,
- dann die erforderlichen Änderungen und Ergänzungen vornehmen (die Sprache,
  die entstehen soll, sowie die Dateien oder deren Inhalt),
- dann erkären Sie ihre eigenen Intentionen, Vorarbeiten wie Wortsammlungen und
- die Sprache in der Sie mit dem "Model" während des Entwickelns hauptsächlich
  reden möchten,
- verstehen Sie, dass der erst- und letztgestellte Paragraph des **Vorschlagprompts**
  **NICHT** zum PROMPT Kontext selbst gehören,
- dann geben Sie das PROMPT in das KI Eingabeformular.
- Benennen Sie es: "Build a new `{LANGUAGE}` TF-IDF Stopword Language File for
  the auto-tag suggestion environment system".
- Behalten Sie die Sprache der ursprünglichen Eingabeaufforderung auf Englisch
  bei, damit Sie keine Tokens durch unnötige Übersetzungen oder
  Übersetzungsfehler verlieren.
- Geben Sie dem "Model" und sich selbst genug Zeit um alle Gegebenheiten einer
  neuen Sprachdatei auszuloten – zu verstehen, bis Sie am Ende beide denken es
  wäre fertig für eine erste sinnvoll stabile Veröffentlichungsanfrage.

## Anhang

Wie Sie bereits gemerkt haben, richtet sich diese dokumentarische Auflistung
hauptsächlich an künftige Mitentwickler dieses automatischen Vorschlagssystems
für Tag-/Schlagworte, insbesondere für NEUE Sprachen die nicht bereits
implementiert sind, aber in der persönlichen Sprachauswahl der Serendipity Styx
Edition ausgewählt werden können.

Um nur solche Worte/Vorschläge zu besprechen, die für die bereits vorhandene
Implementation in Deutsch und Englisch geschrieben wurde, wechseln Sie bitte
in den extra dafür aufgemachten [Auto-Tag Discussions](https://github.com/ophian/styx/discussions/71) Thread.
Bitte **lesen** Sie sorgfältig **zuallererst** die zweisprachig vorangestellte
Präambel, um herauszufinden was Sie hier eigentlich spezifisch erfragen bzw
beitragen können.

Fühlen Sie sich bitte nicht zurückgestoßen falls ihr Vorschlag abgelehnt oder
zurückgewiesen, oder ihr Diskussions-Post gar gelöscht wird. Dies dient nur
dazu den eigentlichen Thread sauber und lesbar zu erhalten; es hilft uns
allen, wenn die Entwicklung mit ihrer Hilfe ungestört voranschreiten kann.

Unser aller Zeit ist begrenzt und eine ungestellte Frage ist tatsächlich in
manchem Fall allemal besser, als eine Anzahl unrelevanter Ergänzungsfragen.
Wenn Sie sich dies zu Herzen genommen und alle Erfordernisse gewichtet oder
gar Fragen erst gesammelt und durchdacht haben — ❤️ — go ahead and participate!

Your help is welcome! 💖

**Thank you**

### Einzelnachweise

<sup>[0]</sup> TF-IDF steht für "Term Frequency-Inverse Document Frequency" und ist eine Methode zur
               Bewertung der Relevanz eines Wortes innerhalb eines Textkörpers. Sie wird also eingesetzt,
               um die Wichtigkeit eines Begriffs in Bezug auf ein Dokument zu bestimmen.
               https://de.wikipedia.org/wiki/Tf-idf-Ma%C3%9F, https://en.wikipedia.org/wiki/Tf%E2%80%93idf
<sup>[1]</sup> https://de.wikipedia.org/wiki/Agglutinierende_Sprache, https://en.wikipedia.org/wiki/Agglutinative_language
<sup>[2]</sup> https://de.wikipedia.org/wiki/Wortstamm, https://de.wikipedia.org/wiki/Lemma_(Lexikographie)
               https://en.wikipedia.org/wiki/Word_stem, https://en.wikipedia.org/wiki/Lemma_(morphology)