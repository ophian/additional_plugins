<?php

/**
 * Compact German stopword list. Extend as needed - a larger list (e.g. from
 * a PHP stopwords package via Composer) would improve results further.
 *
 * The English-only leftover section from the original combined list was
 * removed here since StopwordsEn.php now covers English separately (this
 * class is only ever used in $language === 'de' mode).
 */
final class Stopwords
{
    /** @return array<string,true> set for fast isset() lookups */
    public static function set(): array
    {
        static $words = null;
        if ($words !== null) {
            return $words;
        }

        $list = [
            'der','die','das','den','dem','des','ein','eine','einer','eines','einem','einen',
            'und','oder','aber','doch','wenn','dann','also','weil','damit','dass','als','wie',
            'ist','sind','war','waren','sein','wird','werden','wurde','wurden','hat','haben',
            'habe','hast','habt','bin','bist','bist','seid','gewesen','worden',
            'hatte','hatten','kann','können','konnte','konnten','muss','müssen','soll','sollen','will',
            'wollen','nicht','kein','keine','auch','nur','noch','schon','sehr','mehr','ganz',
            'für','von','vor','nach','bei','mit','ohne','durch','über','unter','zwischen',
            'auf','aus','um','an','in','im','am','zum','zur','zu','sich','sie','wir','ich',
            'du','ihr','man','es','er','diese','dieser','dieses','diesen','diesem','jede',
            'jeder','jedes','alle','allen','aller','alles','was','wer','wo','wann','warum',
            'wieso','weshalb','hier','dort','da','dabei','dazu','also','deshalb','daher',
            'zwar','jedoch','allerdings','beispielsweise','etwa','etwas','nichts','immer',
            'oft','manchmal','selten','heute','gestern','morgen','jahr','jahre','sowie',
            // Extended list (user-supplied, deduped against the above)
            'abend','abends','abermals','abgerufen','abgerufene','abgerufener',
            'abgerufenes','acht','achte','achten','achter','achtes','aktueller','allein',
            'allem','allemal','allenfalls','allenthalben','allerlei','allesamt',
            'allgemein','allgemeinen','allmählich','allzu','alsbald','alte','andauernd',
            'ander','andere','anderem','anderen','anderer','andererseits','anderes',
            'anderm','andern','andernfalls','anderr','anders','anerkannt','anerkannte',
            'anerkannter','anerkanntes','angesetzt','angesetzte','angesetzter','angewinkelt','angewinkelte',
            'anscheinend','anstatt','auffallend','aufgrund','aufs','augenscheinlich',
            'ausdrücklich','ausdrückt','ausdrückte','ausgedrückt','ausgenommen',
            'ausgerechnet','ausnahmslos','ausreichend','ausser','ausserdem','außen','außer','außerdem',
            'außerhalb','bald','beide','beiden','beiderlei','beides','beim','beinahe',
            'beispiel','bekannt','bekannte','bekannter','bekanntlich','bekommt','bereits',
            'besonders','besser','besten','bestenfalls','bestimmt','beträchtlich','bevor',
            'bezüglich','bisher','bislang','bloß','dadurch','dafür','dagegen','dahin',
            'dahinter','damals','danach','daneben','dank','danke','dannen','daran',
            'darauf','daraus','darf','darfst','darin','darum','darunter','darüber',
            'dasein','daselbst','dasselbe','davon','davor','dazwischen','dein','deine',
            'deinem','deinen','deiner','deines','dementsprechend','demgegenüber',
            'demgemäss','demgemäß','demnach','demselben','demzufolge','denen','denkbar',
            'denn','dennoch','denselben','derart','derartig','deren','derer','derjenige',
            'derjenigen','dermassen','dermaßen','derselbe','derselben','derzeit',
            'desselben','dessen','desto','deswegen','dich','diejenige','diejenigen',
            'dienstag','dies','dieselbe','dieselben','diesmal','diesseits','direkt',
            'direkte','direkten','direkter','donnerstag','dorther','dorthin','drei',
            'drin','dritte','dritten','drittens','dritter','drittes','drunter','drüber',
            'dunklen','durchaus','durchweg','durfte','durften','dürfen','dürft','eben',
            'ebenfalls','ebenso','eher','ehrlich','eigen','eigene','eigenen','eigener',
            'eigenes','eigentlich','einander','einerseits','einfach','einig','einige',
            'einigem','einigen','einiger','einigermaßen','einiges','einmal','eins',
            'einseitig','einseitige','einseitigen','einseitiger','einst','einstmals',
            'einzig','ende','endlich','entsprechend','entweder','ergo','erheblich',
            'erhält','erneut','ernst','erst','erste','ersten','erster','erstes','etliche',
            'euch','euer','eure','eurem','euren','eurer','eures','falls','fast','ferner',
            'folgende','folgenden','folgender','folgendermaßen','folgendes','folglich',
            'fortwährend','fraglos','frei','freie','freies','freilich','freitag','früher',
            'förmlich','fünf','fünfte','fünften','fünfter','fünftes','ganze','ganzem',
            'ganzen','ganzer','ganzes','gbdr','gedurft','geehrte','geehrten','geehrter',
            'gefälligst','gegen','gegenüber','gehabt','gehen','geht','gekannt','gekonnt',
            'gelegentlich','gemacht','gemeinhin','gemocht','gemusst','gemäß','genau',
            'genommen','genug','genügend','gerade','geradezu','gern','gesagt',
            'geschweige','gestrige','getan','geteilt','geteilte','getragen','gewiss',
            'gewisse','gewissermaßen','gewollt','geworden','gibt','ging','gleich',
            'gleichsam','gleichwohl','gleichzeitig','glücklicherweise','gmbh','gott',
            'gross','grosse','grossen','grosser','grosses','groß','große','großen',
            'großer','großes','grunde','größtenteils','gute','guten','guter','gutes',
            'gängig','gängige','gängigen','gängiger','gängiges','gänzlich','halb','hallo',
            'halt','hattest','hattet','heisst','heraus','herein','heutige','hiermit',
            'hiesige','hinein','hingegen','hinlänglich','hinten','hinter','hinterher',
            'hoch','hätte','hätten','häufig','höchst','höchstens','ihnen','ihre','ihrem',
            'ihren','ihrer','ihres','immerhin','immerzu','indem','indessen','infolge',
            'infolgedessen','innen','innerhalb','insbesondere','insofern','inzwischen',
            'irgend','irgendein','irgendeine','irgendjemand','irgendwann','irgendwas',
            'irgendwen','irgendwer','irgendwie','irgendwo','jahren','jedem','jeden',
            'jedenfalls','jederlei','jedermann','jedermanns','jemals','jemand','jemandem',
            'jemanden','jene','jenem','jenen','jener','jenes','jenseits','jetzt','jährig',
            'jährige','jährigen','jähriges','kamen','kannst','kaum','keinem','keinen',
            'keiner','keinerlei','keines','keinesfalls','keineswegs','klar','klare',
            'klaren','klares','klein','kleine','kleinen','kleiner','kleines','kommen',
            'kommt','konkret','konkrete','konkreten','konkreter','konkretes','kurz',
            'könnt','könnte','könnten','künftig','lagen','lang','lange','langsam',
            'lassen','laut','lediglich','leer','leicht','leide','leider','lesen','letzte',
            'letzten','letztendlich','letztens','letztes','letztlich','lichten','lieber',
            'links','längst','längstens','mache','machen','macht','machte','magst','mahn',
            'manche','manchem','manchen','mancher','mancherorts','manches','mann',
            'mehrere','mehrfach','mein','meine','meinem','meinen','meiner','meines',
            'meinetwegen','meist','meiste','meisten','meistens','meistenteils','mensch',
            'menschen','meta','mich','mindestens','mithin','mittag','mittags','mittel',
            'mittwoch','mitunter','mochte','mochten','montag','morgens','morgige','musst',
            'musste','mussten','mußt','möchte','mögen','möglich','mögliche','möglichen',
            'möglicher','möglicherweise','möglichst','mögt','müsst','müsste','müssten',
            'müßt','nachdem','nachher','nachhinein','nahm','naturgemäß','natürlich',
            'neben','nebenan','nebenbei','nein','neue','neuem','neuen','neueste','neuer',
            'neuerdings','neuerlich','neues','neulich','neun','neunte','neunten',
            'neunter','neuntes','nichtsdestotrotz','nichtsdestoweniger','niemals',
            'niemand','niemandem','niemanden','nimm','nimmer','nimmt','nirgends',
            'nirgendwo','nunmehr','nächste','nämlich','nötigenfalls','oben','oberhalb',
            'obgleich','obschon','obwohl','offen','offenbar','offenkundig',
            'offensichtlich','ohnedies','ordnung','partout','persönlich','plötzlich',
            'praktisch','quasi','recht','rechte','rechten','rechter','rechtes','rechts',
            'regelmäßig','reichlich','relativ','restlos','richtig','richtiggehend',
            'riesig','rund','rundheraus','rundum','sache','sagt','sagte','samstag','satt',
            'sattsam','schlecht','schlechter','schlicht','schlichtweg','schließlich',
            'schluss','schlussendlich','schnell','schwerlich','schwierig','schätzen',
            'schätzt','schätzte','schätzten','sechs','sechste','sechsten','sechster',
            'sechstes','seien','seine','seinem','seinen','seiner','seines','seit',
            'seitdem','seite','seiten','seither','selber','selbst','selbstredend',
            'selbstverständlich','seltsamerweise','sicher','sicherlich','sieben',
            'siebente','siebenten','siebenter','siebentes','siebte','siehe','sieht',
            'sobald','sodass','soeben','sofern','sofort','sogar','solang','solange',
            'solch','solche','solchem','solchen','solcher','solches','sollst','sollt',
            'sollte','sollten','solltest','somit','sondern','sonders','sonnabend',
            'sonntag','sonst','sooft','soviel','soweit','sowieso','sowohl','sozusagen',
            'spielen','später','startet','startete','starteten','startseite','statt',
            'stattdessen','steht','stellenweise','stets','suche','sämtliche','tage',
            'tagen','tatsächlich','tatsächlichen','tatsächlicher','tatsächliches','teil',
            'teile','total','tritt','trotzdem','umso','umstandshalber','umständehalber',
            'unbedingt','unbeschreiblich','unerhört','ungefähr','ungemein','ungewöhnlich',
            'ungleich','unglücklicherweise','unlängst','unmaßgeblich','unmöglich',
            'unmögliche','unmöglichen','unmöglicher','unnötig','unsagbar','unse','unsem',
            'unsen','unser','unsere','unserem','unseren','unserer','unseres','unserm',
            'unses','unstreitig','unsäglich','unten','unterbrach','unterbrechen',
            'unterhalb','unwichtig','unzweifelhaft','vergangenen','vergleichsweise',
            'vermutlich','viel','viele','vielem','vielen','vieler','vieles','vielfach','vielseitig','vielseitige',
            'vielleicht','vielmals','vier','vierte','vierten','vierter','viertes','voll',
            'vollends','vollkommen','vollständig','voran','vorbei','vorher','vorne',
            'vorüber','völlig','wahr','wahrscheinlich','warst','wart','weder','wegen',
            'weidlich','weise','weit','weitem','weiter','weitere','weiterem','weiteren',
            'weiterer','weiteres','weiterhin','weitgehend','weiß','welche','welchem',
            'welchen','welcher','welches','wenig','wenige','weniger','weniges',
            'wenigstens','wenngleich','werde','werdet','wessen','wichtig','wieder',
            'wiederum','wiewohl','willst','wirklich','wirst','wissen','wodurch','wogegen',
            'woher','wohin','wohingegen','wohl','wohlgemerkt','wohlweislich','wollt',
            'wollte','wollten','wolltest','wolltet','womit','womöglich','woraufhin',
            'woraus','worin','während','währenddem','währenddessen','wäre','wären',
            'würde','würden','zahlreich','zehn','zehnte','zehnten','zehnter','zehntes',
            'zeit','zeitweise','ziemlich','zudem','zuerst','zufolge','zugegeben',
            'zugleich','zuletzt','zumal','zumeist','zunächst','zurück','zusammen',
            'zusehends','zuvor','zuweilen','zwanzig','zwei','zweifellos','zweifelsfrei',
            'zweifelsohne','zweite','zweiten','zweiter','zweites','zwölf','ähnlich',
            'äußerst','übel','überall','überallhin','überaus','überdies','überhaupt',
            'üblich','üblicher','üblicherweise','übrig','übrigens',
            // German verbs, incl. umlaut forms
            'aßen','backen','backt','backte','beißen','beißt','biss','bissen','bleiben',
            'bleibst','bleibt','blieb','blieben','brach','brachen','brechen','brecht',
            'brichst','bricht','bäckt','empfahl','empfahlen','empfehlen','empfehlt',
            'empfiehlst','empfiehlt','empfohlen','erfüllen','erfüllt','erfüllte',
            'erfüllten','erhöhen','erhöht','erhöhte','erhöhten','erklären','erklärt',
            'erklärte','erklärten','erscheinen','erscheint','erschien','erschienen',
            'erzählen','erzählt','erzählte','erzählten','essen','esst','fahren','fahrt',
            'fallen','fallt','fangen','fangt','fiel','fielen','fing','fingen','fliegen',
            'fliegst','fliegt','fließen','fließt','flog','flogen','floss','flossen',
            'fraß','fraßen','fressen','fresst','frieren','frierst','friert','frisst',
            'fror','froren','fuhr','fuhren','fuhrst','fährst','fährt','fällst','fällt',
            'fängst','fängt','fördern','fördert','förderte','förderten','fühlen','fühlt',
            'fühlte','fühlten','führen','führt','führte','führten','füllen','füllt',
            'füllte','füllten','gaben','galt','galten','gebacken','geben','gebissen',
            'geblieben','gebrochen','gebt','gefahren','gefallen','gefangen','geflogen',
            'geflossen','gefressen','gefroren','gefördert','gefühlt','geführt','gefüllt',
            'gegeben','gegessen','gegolten','gegriffen','gegründet','gehalten','geholfen',
            'gehören','gehört','gehörte','gehörten','gelassen','gelaufen','gelesen',
            'gelitten','gelten','geltet','gelöst','genießen','genießt','genoss',
            'genossen','geprüft','gerissen','geschah','geschahen','geschehen','geschieht',
            'geschienen','geschlafen','geschlagen','geschlossen','geschnitten',
            'geschrieben','gesehen','gesprochen','gestochen','gestohlen','gestorben',
            'gestört','getreten','getrieben','getroffen','gewachsen','gewaschen',
            'geworfen','gewählt','gezogen','gezählt','geändert','gibst','gilt','giltst',
            'greifen','greifst','greift','griff','griffen','gründen','gründet','gründete',
            'gründeten','half','halfen','halten','haltet','helfen','helft','hielt',
            'hielten','hilfst','hilft','hält','hältst','hören','hört','hörte','hörten',
            'isst','lasen','lasst','laufen','lauft','leiden','leidest','leidet','lest',
            'lief','liefen','liest','ließ','ließen','litt','litten','lässt','läufst',
            'läuft','lösen','löst','löste','lösten','nahmen','nehmen','nehmt','nimmst',
            'prüfen','prüft','prüfte','prüften','reißen','reißt','riss','rissen','sahen',
            'scheinen','scheinst','scheint','schien','schienen','schlafen','schlaft',
            'schlagen','schlagt','schlief','schliefen','schließen','schließt','schloss',
            'schlossen','schlug','schlugen','schläfst','schläft','schlägst','schlägt',
            'schneiden','schneidest','schneidet','schnitt','schnitten','schreiben',
            'schreibst','schreibt','schrieb','schrieben','sehen','seht','siehst','sprach',
            'sprachen','sprechen','sprecht','sprichst','spricht','stach','stachen',
            'stahl','stahlen','starb','starben','stechen','stecht','stehlen','stehlt',
            'sterben','sterbt','stichst','sticht','stiehlst','stiehlt','stirbst','stirbt',
            'stören','stört','störte','störten','traf','trafen','tragen','tragt','trat',
            'traten','treffen','trefft','treiben','treibst','treibt','treten','tretet',
            'trieb','trieben','triffst','trifft','trittst','trug','trugen','trägst',
            'trägt','vergaß','vergaßen','vergessen','vergesst','vergisst','verlieren',
            'verlierst','verliert','verlor','verloren',
            'verändern','verändert', 'veränderte','veränderten','wachsen','warf','warfen',
            'waschen','waschte','abwaschen','auswaschen','gewaschen','verwaschen',
            'werfen','werft','wirfst','wirft','wuchs','wuchsen','wusch','wuschen',
            'wächst','wählen','wählt','wählte','wählten','wäschst','wäscht','ziehen',
            'ziehst','zieht','zogen','zählen','zählt','zählte','zählten','ändern',
            'ändert','änderte','änderten','überprüfen','überprüft','überprüfte',
            'überprüften',
            // more verbs not yet sorted - but IMHO auswahl, aktivieren, anzeigen, einwahl, verschieben seem valid to tag...
            'öffnen','gucken','beten','verwenden','wenden','auswählen','erwählen','abwechseln','auswechseln','einwechseln','wechseln','rühren','einrühren','verrühren','ächzen','tanzen','mangeln',
            'rösten','anrösten','anröstest','kühlen','abkühlen','auskühlen','ausfüllen','einfüllen','pürieren','bewahren','aufbewahren',
            'abschließen','aufschließen','einschließen','zuschließen','verschließen','ablösen','auflösen','erlösen','schälen','abschälen','halbieren',
            'drücken','abdrücken','ausdrücken','eindrücken','wegdrücken','zudrücken','spülen','abspülen','trocknen','abtrocknen','schütteln','abschütteln','aufschütteln','hacken','stellen',
            'schmecken','abschmecken','kopieren','kopierte','kopiert','weilen',
            // adjectives not yet sorted
            'sämig','sämige','sämigen','bunt','bunte','gelangweilt','gelangweilte',
            // colors
            'rote','blaue','grüne','gelbe','weiße','schwarze','rot','blau','grün','gelb','weiß','schwarz',
            // denglish ... shall we?
            'however',
        ];

        $words = array_fill_keys($list, true);
        return $words;
    }

    public static function isStopword(string $word): bool
    {
        $set = self::set();
        if (isset($set[$word])) {
            return true;
        }

        // Catch genitive/weak inflected forms with an appended "s", e.g.
        // "karins" -> "karin". Deliberately just this one simple suffix,
        // to avoid accidentally matching unrelated words.
        if (mb_strlen($word) > 2 && mb_substr($word, -1) === 's') {
            $stripped = mb_substr($word, 0, -1);
            if (isset($set[$stripped])) {
                return true;
            }
        }

        return false;
    }
}
