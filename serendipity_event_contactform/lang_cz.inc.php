<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/05/06
 */

@define('PLUGIN_CONTACTFORM_TITLE',		'Kontaktn� formul��');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH',		'Zobrazuje kontaktn� formul�� k posl�n� e-mailu jako statickou str�nku. P��stup k fromul��i bu� pomoc� st�l�ho odkazu (permalinku) nebo na adrese index.php?serendipity[subpage]=contactform. Vzhled fromul��e si m��ete upravit podle sv�ho vlo�en�m souboru plugin_contactform.tpl do adres��e s Va�� �ablonou. Kryptogramy z pluginu SpamBlock budou pou�ity, pokud je SpamBlock nainstalov�n.');
@define('PLUGIN_CONTACTFORM_PERMALINK',		'St�l� odkaz - Permalink');
@define('PLUGIN_CONTACTFORM_PAGETITLE',		'URL zkratka (kv�li zp�tn� kompatibilit�, v nov�j��ch verz�ch ignorujte)');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH',		'Definuje permanetn� URL adresu. Je t�eba zadat absolutn� cestu a mus� kon�it na .html nebo .html!');
@define('PLUGIN_CONTACTFORM_EMAIL',		'C�lov� e-mailov� adresa');
@define('PLUGIN_CONTACTFORM_INTRO',		'�vodn� text (voliteln�)');
@define('PLUGIN_CONTACTFORM_MESSAGE',		'Text zpr�vy');
@define('PLUGIN_CONTACTFORM_SENT',		'Text po odesl�n� zpr�vy');
@define('PLUGIN_CONTACTFORM_SENT_HTML',		'Zpr�va byla �sp�n� odesl�na!');
@define('PLUGIN_CONTACTFORM_ERROR_HTML',		'P�i odes�l�n� zpr�vy se vyskytla chyba!');
@define('PLUGIN_CONTACTFORM_ERROR_DATA',		'Jm�no, e-mail ani text zpr�vy nesm� z�stat pr�zdn�.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA',		'Povinn� pole je pr�zdn�.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT',		'Form�tovat jako �l�nek?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH',		'Pokud je vybr�no, v�sledn� str�nka je form�tov�na jako obvykl� p��sp�vek (barvy, okraje, apod.) (Standardn�: ANO)');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL',		'�ablona');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC',		'Tato volba V�m umo��uje nastavit vzhled kontaktn�ho formul��e podle Va�ich p��n�. M��ete pou��t standardn� vzhled, �sporn� obchodn� vzhled, vzhled s podrobnostmi nebo v� vlastn� vzhled, kter� mus�te ru�n� zadat.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS',		'Pole formul��e');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD',		'Standardn�');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ',		'Obchodn�');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED',		'Podrobn�');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC',		'Vlastn�');
@define('PLUGIN_CONTACTFORM_FNAME',		'Jm�no');
@define('PLUGIN_CONTACTFORM_LNAME',		'P��jmen�');
@define('PLUGIN_CONTACTFORM_ADDRESS',		'Adresa');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC',		'Tento �et�zec ur�uje, kter� z pol� se objev� v kontaktn�m formul��i, zda jsou tato pole povinn� a jejich p�ednastavenou hodnotu. If you had already build a custom string here and then change the dynamic tpl profile selection (with Save) and back to custom again, this form field string will contain one of the default profile strings. This can be irritating if your self-created string is only slightly different from the default, so you don\'t notice it right away.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE',		'<p>"Pole formul��e" je textov� �et�zec, podle kter�ho se budou zobrazovat pole v kontaktn�m formul��i. �et�zec mus� m�t n�sleduj�c� syntaxi &lt;pole&gt;:&lt;pole&gt;:&lt;pole&gt;.  Odd�lov�n� pol� je pomoc� dvojte�ky.</p>
   <p>Jednotliv� pole (krom� typu "radio", "checkbox" a "select", kter� bude samostatn� rozebr�no) mus� b�t zad�ny ve tvaru {require;}Jm�no;typ{;default}.  Pamatujte na odd�lov�n� jednotliv�ch pol� pomoc� dvojte�ky. Ve tvaru syntaxe znamenaj� p��kazy ve slo�en�ch z�vork�ch, �e se jedn� o nepovinn� parametry. Pokud m� b�t pole kontrolov�n�, zda je vypln�n�, vlo�te na za��tek definice pole slovo "require".
</p>
   <p>Pole mohou b�t n�sleduj�c�ch typ�:
        <ul> 
         <li>text - standardn� textov� pole; P��klad: "Jm�no;text"</li>
         <li>email - normal email text field; example: "Name;email" (unlike the "text" type, this one uses the placeholder attribute, depending on the template design. The forms "'.PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ.'" and "'.PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED.'" use the "text" type</li>
         <li>checkbox - za�krt�vac� pol��ko; P��klad: "��d�m odpov��;checkbox;n�zev, kter� se m� zobrazit po za�krtnut� pol��ka"</li>
         <li>radio - skupina vyb�rac�ch kole�ek; P��klad: "Z aut m�m nejrad�i;radio;Citroeny|Peugeoty|Renaulty"</li>
         <li>hidden - skryt� pole; P��klad: "skryte_pole;hidden"</li>
         <li>password - heslo. Pozor, toto pol��ko nen� nijak testov�no, je jen vlo�eno do mailu, kde se objev� jeho textov� hodnota.; P��klad: "require;Heslo;password"</li>
         <li>textarea - velk� oblast pro text o n�kolika ��dc�ch; P��klad: "Zde napi�te sv�j dopis;textarea"</li>
         <li>select - Rozbalovac� pol��ko s v�b�rem n�kolika voleb; P��klad: "Neobl�ben�j�� kategorie na blogu;select;auta|letadla|kyti�ky|drogy"</li>
        </ul>
   </p>
   <p>K p�ednastaven� hodnoty pro pol��ko jednodu�e p�id�te dal�� definici k poli. Pro pol��ko checkbox je jedin� spr�vn� hodnota "checked"</p>
   <p>Typ "radio" pou��v� n�sleduj�c� syntaxi {require;}N�zev;radio;Volba1,Hodnota1|Volba1,Hodnota1{,checked}.</p>
   <p>P��klady:
       <ul>
         <li>Standardn� formul�� lze zapsat takto: "require;Jm�no;text:require;E-mail;text:require;Dom�c� str�nka;text:require;Text zpr�vy;textarea;"</li>
         <li>Textov� pole pro telefon� ��slo: "Telefon;text"</li>
         <li>Textov� pole pro telefon� ��slo, kter� m� b�t povinn� vypln�n�:- "require;Telefon;text"</li>
         <li>Textov� oblast s p�ednastaven�m textem: "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;Tohle je p�ednastaven� text...  P�kn� nuda...  Ale je to p�ednastaven�."
         <li>V�b�r mezi ano/ne: "V�b�r;radio;Ano,ano|Ne,ne a je�t� jednou ne"</li>
         <li>Za�krt�vac� pol��ko standardn� za�krtnut�: "Povol�n� Student;checkbox;checked"</li>
         <li>Posledn� �ty�i p��klady dohromady: "require;Telefon;text:'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;Tohle je p�ednastaven� text...  P�kn� nuda...  Ale je to p�ednastaven�.:V�b�r;radio;Ano,ano|Ne,ne a je�t� jednou ne:Povol�n� Student;checkbox;checked" </li>
       </ul>
   </p>
   <p>It is important that there are no hidden line breaks in the string, otherwise strange markups or even missing fields may result.</p>
   <p>For the textarea field there is a special feature to note: Since other plugins can hook in after the message field, the emoticonchooser event plugin in particular uses a fixed className selector to insert its smileys into the textarea field. For this case (as far as you use it) the name of the dynamically constructed textarea field must be exactly as defined in the currently used language constant. In this case: <strong>'.PLUGIN_CONTACTFORM_MESSAGE.'</strong>. The '.PLUGIN_CONTACTFORM_DYNAMICFIELDS.' for the text field must then be: "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea" so that the plugin_dynamicform.tpl template file can refer to it exactly.</p>
   <p>If you use field types other than the predefined ones, you can specify a custom template file and use Smarty syntax to check for custom field types yourself, similar to how other types are already checked in the default template file.</p>');

@define('PLUGIN_CONTACTFORM_TEMPLATE',		'Jm�no souboru se �ablonou');
@define('PLUGIN_CONTACTFORM_TEMPLATE_DESC',		'Zadejte pouze jm�no souboru jak�koliv �ablony, kter� m� b�t pou�ita k vykreslen� kontaktn�ho formul��e. M��ete nahr�t vlastn� soubory bu� do adres��e tohoto pluginu, nebo do adres��e se �ablonou, kterou pou��v�te.');
@define('PLUGIN_CONTACTFORM_SUBJECT',		'P�edm�t emailu');
@define('PLUGIN_CONTACTFORM_SUBJECT_DESC',		'Zadejte p�edm�t emailu, kter� bude posl�n na Va�i adresu. M��ete do n�j um�stit prom�nnou %s, kter� bude obsahovat nadpis kontaktn�ho formul��e.');

// Next lines were translated on 2009/05/06
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER',		'Pou��vat po��tadlo kontaktn�ch formul���?');
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER_DESC',		'Pokud je pou�ito, ka�d� odeslan� kontaktn� formul�� dostane jedine�n� ID identifika�n� ��slo.');
@define('PLUGIN_CONTACTFORM_MAIL_ISSUECOUNTER',		'��slo l�stku: %s');

