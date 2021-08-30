<?php

/**
 *  @version 
 *  @Rikkie Neutelings <nb@3gz.com>
  */

@define('PLUGIN_CONTACTFORM_TITLE', 'Contactformulier');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH', 'Geeft een contactformulier weer op uw blog als een statische pagina. Het kan zowel worden opgeroepen via een zelfgemaakte permalink of door index.php?serendipity[subpage]=contactform. Het uiterlijk van het contactformulier kan worden aangepast door het plugin_contactform.tpl-bestand in de template map te plaatsen en vervolgens te bewerken. Captchas van de Spamblock plugin worden ondersteund (indien geactiveerd).');
@define('PLUGIN_CONTACTFORM_PERMALINK', 'Permalink');
@define('PLUGIN_CONTACTFORM_PAGETITLE', 'Korte URL omschrijving (terugwerkende compatibiliteit)');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH', 'Definieert de permalink voor de URL. Dit moet een absoluut HTTP-pad zijn en eindigen op .htm or .html!');
@define('PLUGIN_CONTACTFORM_EMAIL', 'Doel e-mailadres');
@define('PLUGIN_CONTACTFORM_INTRO', 'Korte toelichting (optioneel)');
@define('PLUGIN_CONTACTFORM_MESSAGE', 'Bericht');
@define('PLUGIN_CONTACTFORM_SENT', 'Tekst nadat het bericht is verzonden');
@define('PLUGIN_CONTACTFORM_SENT_HTML', 'Uw bericht is succesvol verzonden!');
@define('PLUGIN_CONTACTFORM_ERROR_HTML', 'Er is een fout opgetreden bij het versturen van uw bericht!');
@define('PLUGIN_CONTACTFORM_ERROR_DATA', 'Naam, e-mail en bericht mogen niet leeg zijn.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA', 'Niet alle verplichte velden zijn ingevuld.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT', 'Opmaken als een inzending?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH', 'bij ja wordt de uitvoer automatisch opgemaakt als een inzending (kleuren, randen, etc.). Standaard: ja');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL', 'Dynamische tpl gebruiken?');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC', 'Met deze instelling kan een tpl-bestand gebruikt worden, om dynamische velden te maken in het formulier.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS', 'Tekenreeks voor formulier-veld');
@define('PLUGIN_CONTACTFORM_FNAME', 'Voornaam');
@define('PLUGIN_CONTACTFORM_LNAME', 'Achternaam');
@define('PLUGIN_CONTACTFORM_ADDRESS', 'Adres');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC', 'Dit is de tekenreeks die wordt toegepast om te bepalen welke velden zichtbaar zullen zijn op het formulier, of ze al dan niet verplicht zijn, en met welke standaardwaarden. If you had already build a custom string here and then change the dynamic tpl profile selection (with Save) and back to custom again, this form field string will contain one of the default profile strings. This can be irritating if your self-created string is only slightly different from the default, so you don\'t notice it right away.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE', '<p>De "Tekenreeks voor formulier-veld" wordt toegepast om te bepalen welke velden zichtbaar zullen zijn op het dynamische formulier. De tekenreeks moet worden opgemaakt als <field>:<field:<field>. Let op de scheiding door de dubbele punt.</p>
   <p>De individuele velden (die van het type "radio", worden later gedefinieerd) moeten worden opgemaakt als {require;}Name;type{;default}. Let op de scheiding door de punt-komma. N.B.: de accolades geven een optioneel veld aan. Indien een veld verplicht is, dan moet het "require" gebruikt worden bij het veld (zonder accolades).</p>
   <p>Er zijn verschillende velden beschikbaar. Momenteel worden de volgende velden ondersteund:
        <ul> 
         <li>text</li>
         <li>email - normal email text field; example: "Name;email" (unlike the "text" type, this one uses the placeholder attribute, depending on the template design. The forms "'.PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ.'" and "'.PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED.'" use the "text" type</li>
         <li>checkbox</li>
         <li>radio</li>
         <li>hidden</li>
         <li>password</li>
         <li>textarea</li>
         <li>text</li>
        </ul>
   </p>
   <p>Om de standaardwaarde voor een veld op te geven, volstaat het op een nieuwe definitie toe te voegen. De enige geldige waarde voor het veld "checkbox" is "checked".</p><p>Het veld "radio" wordt gedefinieerd als: {require;}Name;radio;Name1,Value1|Name2,Value2{,checked}. Let op de extra toegevoegde waarden bij de definities, waarbij de opties gescheiden moeten worden door een verticale lijn (|), dat elke optie een naam moet hebben, een waarde en een standaardwaarde.</p>
   <p>Voorbeelden (de aanhalingstekens worden gebruikt voor de leesbaarheid en zijn niet verplicht):
       <ul>
         <li>De opmaak van het standaard formulier:- "require;Naam;text:require;E-mail;text:require;Web-pagina;text:require;Bericht;textarea"</li>
         <li>Een tekst-veld voor telefoonnummers:- "Telefoonnummer;text"</li>
         <li>Een verplicht tekst-veld voor telefoonnummers:- "require;Telefoonnummer;text"</li>
         <li>Een tekst-veld met een standaard tekst:- "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;Dit is een standaard tekst.  Saai?  Wat wil je, hij is standaard!."
         <li>Een Ja/nee opsommingsteken (radio button):- "Opsommingsteken;radio;Ja,ja|Nee,nee,checked"</li>
         <li>Een afvinkveld, standaard aangevinkt:- "Afvinkveld;checkbox;checked"</li>
         <li>Alle 4 velden samen:- "require;Telefoonnummer;text:'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;Dit is een standaard tekst.  Saai?  Wat wil je, hij is standaard! :Opsommingsteken;radio;Ja,ja|Nee,nee,checked:Afvinkveld;checkbox;checked" </li>
       </ul>
   </p>
   <p>It is important that there are no hidden line breaks in the string, otherwise strange markups or even missing fields may result.</p>
   <p>For the textarea field there is a special feature to note: Since other plugins can hook in after the message field, the emoticonchooser event plugin in particular uses a fixed className selector to insert its smileys into the textarea field. For this case (as far as you use it) the name of the dynamically constructed textarea field must be exactly as defined in the currently used language constant. In this case: <strong>'.PLUGIN_CONTACTFORM_MESSAGE.'</strong>. The '.PLUGIN_CONTACTFORM_DYNAMICFIELDS.' for the text field must then be: "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea" so that the plugin_dynamicform.tpl template file can refer to it exactly.</p>
   <p>If you use field types other than the predefined ones, you can specify a custom template file and use Smarty syntax to check for custom field types yourself, similar to how other types are already checked in the default template file.</p>');

