<?php

/**
 *  @version
 *  @author Matthias Mees <matthiasmees@googlemail.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_METADESC_NAME', 'HTML Meta-Tags');
@define('PLUGIN_METADESC_DESC', 'Setzt Tags f�r HTML Meta-Schl�sselw�rter/-Beschreibungen und das title-Element f�r Seiten mit nur einem einzelnen Eintrag bzw. allgemeine Meta-Schl�sselw�rter/-Beschreibungen f�r Seite mit mehr als einem Eintrag.');
@define('PLUGIN_METADESC_FORM', 'Bleibt dieses Feld leer, so werden die ersten 120 Zeichen des Eintrages
als Meta-Beschreibung verwendet. Kann auf Basis der Liste von HTML-Tags f�r die Schl�sselw�rter keine Schl�sselwortphrase generiert werden, so
werden die standardm��igen Meta-Schl�sselw�rter f�r Seiten mit nicht nur einem Eintrag verwendet.<br /><br />Vorschlag f�r die Meta-Beschreibung<sup>*</sup>: 20-30 W�rter, maximal 120-180 Zeichen inklusive Leerzeichen.<br />Vorschlag f�r die Meta-Schl�sselw�rter<sup>*</sup>: 15-20 W�rter, vor allem Schl�sselbegriffe und -phrasen aus dem Inhalt des Eintrags.');
@define('PLUGIN_METADESC_DESCRIPTION', 'Meta-Beschreibung:');
@define('PLUGIN_METADESC_KEYWORDS', 'Meta-Schl�sselw�rter:');
@define('PLUGIN_METADESC_HEADTITLE_DESC', 'Das title-Element einer HTML-Seite kann �ber das unten stehende Feld eingestellt werden. Bleibt dieses Feld leer, wird das title-Element �ber das Template bestimmt, �blicherweise ist es dann "Titel des Eintrags - Blog-Titel".  <br /><br />Vorschlag<sup>*</sup>: 3-9 W�rter, maximal 64 Zeichen inklusive Leerzeichen, die wichtigsten W�rter zuerst..');
@define('PLUGIN_METADESC_HEADTITLE', 'title-Element der HTML-Seite');
@define('PLUGIN_METADESC_LENGTH', 'L�nge');
@define('PLUGIN_METADESC_WORDS', 'W�rter');
@define('PLUGIN_METADESC_CHARACTERS', 'Zeichen');
@define('PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER', 'Die Vorschl�ge f�r W�rter- und Zeichenzahl sind gesch�tzte Richtlinien, nicht tats�chliche Einschr�nkungen.');
@define('PLUGIN_METADESC_TAGNAMES', 'HTML-Tags f�r Schl�sselw�rter');
@define('PLUGIN_METADESC_TAGNAMES_DESC', 'Hier eine durch Kommata getrennte Liste von HTML-Tags eingeben, die durchsucht werden sollen. �blicherweise enthalten diese die Schl�sselw�rter.');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION', 'Standard-HTML-Meta-Beschreibung');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC', 'Hier die standardm��ig auf Seiten mit nicht nur einem Eintrag verwendete META-Beschreibung eingeben.');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS', 'Standard-HTML-Meta-Schl�sselw�rter');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC', 'Hier eine durch Kommata getrennte Liste der Schl�sselw�rter eingeben, die auf Seitem mit nicht nur einem Eintrag verwendet werden sollen.');
@define('PLUGIN_METADESC_ESCAPE', 'HTML-Sonderzeichen escapen');
@define('PLUGIN_METADESC_ESCAPE_DESC', 'In Meta-Beschreibung oder -Schl�sselw�rtern enthaltene HTML-Sonderzeichen mittels htmlspecialchars() durch deren entsprechende HTML-Entities ersetzen.');

