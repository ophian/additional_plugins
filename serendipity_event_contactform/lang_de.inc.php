<?php

@define('PLUGIN_CONTACTFORM_TITLE', 'Kontaktformular');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH', 'Stellt ein E-Mail Kontaktformular auf Ihrem Blog als statische Seite dar. Darauf kann entweder �ber den (virtuellen) Permalink oder aus Kompatibilit�tsgr�nden mittels index.php?serendipity[subpage]=contactform zugegriffen werden. Die Darstellung kann durch Smarty Templates angepasst werden, indem die Datei plugin_contactform.tpl in Ihren Templateordner kopiert und modifiziert wird. Captchas der Spamblock-Plugins (falls aktiviert) werden angewendet.');
@define('PLUGIN_CONTACTFORM_PERMALINK', 'Permalink');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH', 'Definiert den Permalink f�r die URL. Ben�tigt den absoluten HTTP-Pfad und muss mit .htm oder .html enden!');
@define('PLUGIN_CONTACTFORM_PAGETITLE', 'URL-Zeiger (Titel) der Seite');
@define('PLUGIN_CONTACTFORM_PAGETITLE_DESC', 'Kurzer (Ein-Wort) URL-Titel der Seite, siehe obige Beschreibung index.php?serendipity[subpage]=contactform. Dieser Zeiger wird auch als verlinkter "Sprung" Titel im Banner des Frontends verwendet. Der im Frontend hervorgehobene Titel "'.PLUGIN_CONTACTFORM_TITLE.'" des (optionalen) Einf�hrungstextes (s.u.), entstammt jedoch einer Sprachkonstante. Diesen Titel k�nnen Sie nur ver�ndern, in dem Sie sich eine geeignete Template Datei (meist: "plugin_contactform.tpl", soweit darin vorhanden) aus dem Fallback-Template-Mechanismus nach dieser Reihenfolge heraus in Ihr eigenes Theme kopieren und selbst gestalten: Ein m�gliches Engine Parent-Theme, das augenblickliche Serendipity Standard-Theme ('.$serendipity['defaultTemplate'].'), oder bzw. zuletzt aus dem Plugin Ordner selbst.');
@define('PLUGIN_CONTACTFORM_EMAIL', 'E-Mail Adresse f�r Kontaktmails');
@define('PLUGIN_CONTACTFORM_INTRO', 'Einf�hrungstext (optional)');
@define('PLUGIN_CONTACTFORM_MESSAGE', 'Nachricht');
@define('PLUGIN_CONTACTFORM_SENT', 'Dargestellter Text nach �bermittlung der Nachricht.');
@define('PLUGIN_CONTACTFORM_SENT_HTML', 'Ihre Nachricht wurde erfolgreich verschickt');
@define('PLUGIN_CONTACTFORM_ERROR_HTML', 'Ein Fehler trat bei der �bermittlung der E-Mail auf. Eventuell ist ihre E-Mail Adresse ung�ltig oder der Server ist spazieren gegangen.');
@define('PLUGIN_CONTACTFORM_ERROR_DATA', 'Name, E-Mail und ihre Nachricht d�rfen nicht leer gelassen werden.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT', 'Als Artikel formatieren?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH', 'Legt fest ob die Ausgabe automatisch wie ein Artikel formatiert werden soll (Farben, R�nder, etc.) (Standard: ja)');

@define('PLUGIN_CONTACTFORM_TEMPLATE', 'Template-Datei');
@define('PLUGIN_CONTACTFORM_TEMPLATE_DESC', 'Legt den Namen der Templatedatei fest, mit der das Kontaktformular dargestellt wird. Diese Datei kann entweder in dem Verzeichnis dieses Plugins oder dem Template-Verzeichnis gespeichert werden.');

@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA', 'Ein ben�tigtes Feld wurde nicht ausgef�llt.');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL', 'Dynamische Vorlage (tpl) benutzen?');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC', 'Erlaubt die Auswahl, welches Formular benutzt wird. Sie k�nnen zwischen dem Standard-Formular, einem Formular f�r kleine Gesch�fte, einem detaillierten Formular und einem komplett selbsterstellten Formular, das aus der manuell eingegebenen Zeichenkette erstellt wird, w�hlen.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS', 'Formularfeld-Zeichenkette');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD', 'Standard');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ', 'Kleines Gesch�ft');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED', 'Detailliertes Formular');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC', 'Benutzerdefiniert');
@define('PLUGIN_CONTACTFORM_FNAME', 'Vorname');
@define('PLUGIN_CONTACTFORM_LNAME', 'Nachname');
@define('PLUGIN_CONTACTFORM_ADDRESS', 'Adresse');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC', 'Dies ist die Zeichenkette, die festlegt, welche Felder im Formular angezeigt werden, ob sie erforderlich sind und was die Standardwerte sind. Wechseln Sie eine bereits selbsterstellte Zeichenkette mit einer der dynamischen Vorlagen (mit Speichern) und wieder zur�ck, steht in diesem Feld eine der default Vorlagen-Zeichenketten. Das kann irritierend sein, wenn ihre selbsterstellte Zeichenkette nur geringf�gig anders als die Voreinstellung ist, so dass man es nicht gleich bemerkt.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE', '<p>Die "Formularfeld-Zeichenkette" ist ein Text, der benutzt wird, um festzulegen, welche Felder im dynamischen Formular angezeigt werden. Die Zeichenkette muss folgenderma�en aussehen: &lt;Feld&gt;:&lt;Feld&gt;:&lt;Feld&gt;.  Beachten Sie die Trennung durch Doppelpunkte.</p>
<p>Die einzelnen Felder (mit Ausnahme des Typs "radio") m�ssen in der Form {require;}Name;type{;default} sein. Beachten Sie die Trennung durch Strichpunkte. Beachten Sie auch die geschweiften Klammern, die ein optionales Feld markieren. Wenn ein Feld zwingend ausgef�llt werden muss, muss das Wort "require" (ohne die geschweiften Klammern) am Anfang der Felddefinition stehen.</p>
<p>Es sind mehrere verschiedene Feldtypen verf�gbar. Momentan werden die folgenden Feldtypen unterst�tzt:
 <ul>
  <li>text - Normales Textfeld; Beispiel: "Name;text"</li>
  <li>email - Normales Email Textfeld; Beispiel: "Name;email" (im Unterschied zum "text" type nutzt dieses das placeholder attribute, je nach template Ausfertigung. Die Formulare "'.PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ.'" und "'.PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED.'" nutzen den "text" type.</li>
  <li>checkbox - Eine Checkbox; Beispiel: "Check Box;checkbox;hinter der Checkbox angezeigter Text,checked"</li>
  <li>radio - Eine Gruppe von radio buttons; Beispiel: "Radio Button;radio;Ja,ja|Nein,nein,checked"</li>
  <li>hidden - Ein verstecktes Feld; Beispiel: "verstecktedaten;hidden"</li>
  <li>password - Ein Passwortfeld. Hinweis: Das Passwort wird nicht gegen irgendwas �berpr�ft und wird in der Mail unverschl�sselt enthalten. Beispiel: "require;Bevorzugtes Passwort;password"</li>
  <li>textarea - Ein gro�es, mehrzeiliges Texteingabefeld; Beispiel: "Beschreibung;textarea"</li>
  <li>select - Eine Ausklappliste; Beispiel: "Drop Down;select;Ja,ja|Nein,nein,selected"</li>
 </ul>
</p>
<p>Um einen Standardwert f�r ein Feld einzustellen, h�ngen Sie einfach eine zus�tzliche Definition mit diesem Standardwert an. Der einzig g�ltige Standardwert f�r ein "checkbox"-Feld ist "checked".</p>
<p>"radio"-Felder benutzen die folgende Felddefinition: {require;}Name;radio;Name1,Value1|Name2,Value2{,checked}. Beachten Sie die zus�tzliche Definition von Optionen, wobei die Optionen selbst durch ein Pipe-Zeichen (|) getrennt werden und jede Option einen Namen, einen Wert und ggf. die "checked"-Option hat.</p>
<p>Beispiele (die Anf�hrungszeichen werden nicht ben�tigt):
<ul>
  <li>Das Standardformular nachbauen:- "require;Name;text:require;Email;text:require;Homepage;text:require;Message;textarea"</li>
  <li>Ein Textfeld f�r Telefonnummern: :- "Telefonnummer;text"</li>
  <li>Ein erforderliches Textfeld f�r Telefonnummern:- "require;Telefonnummer;text"</li>
  <li>Ein mehrzeiliges Textfeld mit Standardtext:- "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;Das ist Standardtext. Er ist langweilig. Aber er ist Standard."
  <li>Ein Ja/Nein radio button:- "Radio Button;radio;Ja,ja|Nein,nein,checked"</li>
  <li>Eine Checkbox, standardm��ig ausgew�hlt:- "Check Box;checkbox;checked"</li>
  <li>Die letzen vier zusammen:- "require;Telefonnummer;text:'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;Das ist Standardtext. Er ist langweilig. Aber er ist Standard.:Radio Button;radio;Ja,ja|Nein,nein,checked:Check Box;checkbox;checked" </li>
</ul>
</p>
<p>Wichtig ist, dass keine versteckten Zeilenumbr�che im String sind, da sonst merkw�rdige Auszeichnungen oder gar fehlende Felder entstehen k�nnen.</p>
<p>F�r das Textarea Feld gibt es eine Besonderheit zu beachten: Da andere Plugins sich nach dem Nachricht-Feld einklinken k�nnen, verwendet insbesondere das emoticonchooser Ereignis-Plugin einen fest definierten className selector um seine Smileys in das Textfeld einzuf�gen. F�r diesen Fall muss (soweit sie es verwenden) der Name des dynamisch konstruierten textarea Feldes genau so lauten, wie es in der augenblicklich benutzen Sprachkonstante definiert ist. In diesem Fall: <strong>'.PLUGIN_CONTACTFORM_MESSAGE.'</strong>. Die '.PLUGIN_CONTACTFORM_DYNAMICFIELDS.' f�r das Textfeld muss dann so lauten: "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea", damit die plugin_dynamicform.tpl Template Datei genau darauf Bezug nehmen kann.</p>
<p>Falls Sie andere Feldtypen au�er den vordefinierten verwenden wollen, k�nnen Sie eine benutzerdefinierte Vorlage verwenden und die Smarty Syntax�berpr�fung f�r benutzerdefinierte Feldtypen verwenden, �hnlich wie bei anderen Typen, die bereits in der Standardvorlagendatei �berpr�ft werden.</p>');

@define('PLUGIN_CONTACTFORM_TEMPLATE', 'Template-Dateiname');
@define('PLUGIN_CONTACTFORM_TEMPLATE_DESC', 'Geben Sie nur den Dateinamen einer benutzerdefinierten Template-Datei ein. Diese Datei wird zur Anzeige dieses Kontaktformulars benutzt. Sie k�nnen die Datei wahlweise ins Verzeichnis dieses Plugins oder ins Verzeichnis Ihres derzeitigen Templates hochladen.');
@define('PLUGIN_CONTACTFORM_SUBJECT', 'E-Mail Betreff');

@define('PLUGIN_CONTACTFORM_ISSUECOUNTER', 'Z�hler verwenden?');
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER_DESC', 'Wenn aktiviert, bekommt jedes abgeschickte Kontaktformular eine eindeutige ID.');
@define('PLUGIN_CONTACTFORM_MAIL_ISSUECOUNTER', 'Ticket: %s');
@define('PLUGIN_CONTACTFORM_SUBJECT_DESC', 'Geben Sie den Betreff der Mail ein, die an Ihre Adresse geschickt wird. Mit der Variable %s k�nnen Sie den Titel Ihres Kontaktformulars einf�gen.');

@define('PLUGIN_CONTACTFORM_REQUIRED_FIELD', 'Pflichtfeld');

