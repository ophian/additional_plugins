<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_CONTACTFORM_TITLE', 'Contact Form');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH', 'Shows an email contactform on your blog as a static page. It can be accessed by either the custom permalink or by index.php?serendipity[subpage]=contactform. You can customize the look of the contact form by putting the plugin_contactform.tpl file into your template directory and modify it there. Captchas from Spamblock plugins (if enabled) will be applied.');
@define('PLUGIN_CONTACTFORM_PERMALINK', 'Permalink');
@define('PLUGIN_CONTACTFORM_PAGETITLE', 'URL shorthand name');
@define('PLUGIN_CONTACTFORM_PAGETITLE_DESC', 'A one-word parameter title, see description for compatibility index.php?serendipity[subpage]=contactform above. This pointer is also used as link title in the frontend banner. However, the title "'.PLUGIN_CONTACTFORM_TITLE.'" of the (optional) introduction text (see below), which is highlighted in the frontend, comes from a language constant. You can only individualize this title by copying the template file (mostly: "plugin_contactform.tpl") out of the fallback access mechanism according to this order for theme customization reasons, as far as it exists in it: A possible engine parent theme, the current Serendipity Standard theme ('.$serendipity['defaultTemplate'].'), or respectively last from the plugin folder itself.');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH', 'Defines the permalink for the URL. Needs the absolute HTTP path and needs to end with .htm or .html!');
@define('PLUGIN_CONTACTFORM_EMAIL', 'Target E-Mail address');
@define('PLUGIN_CONTACTFORM_INTRO', 'Introductory Text (optional)');
@define('PLUGIN_CONTACTFORM_MESSAGE', 'Message');
@define('PLUGIN_CONTACTFORM_SENT', 'Text, after message has been sent');
@define('PLUGIN_CONTACTFORM_SENT_HTML', 'Your message has been successfully mailed!');
@define('PLUGIN_CONTACTFORM_ERROR_HTML', 'An error occurred while posting the message!');
@define('PLUGIN_CONTACTFORM_ERROR_DATA', 'Name, E-Mail and your message must not be an empty string.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA', 'A required field is missing.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT', 'Format as article?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH', 'if yes, the output is automatically formatted as an article (colors, borders, etc.) (default: yes)');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL', 'Use the dynamic tpl?');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC', 'This setting allows you to choose the form type you wish to use.  You can use the standard form, a small business form, a more detailed form or an entirely custom form created from a manually entered string.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS', 'Form field string');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD', 'Standard');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ', 'Small Business');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED', 'Detailed Form');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC', 'Custom');
@define('PLUGIN_CONTACTFORM_FNAME', 'First Name');
@define('PLUGIN_CONTACTFORM_LNAME', 'Last Name');
@define('PLUGIN_CONTACTFORM_ADDRESS', 'Address');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC', 'This is the string that is parsed to determine which fields will appear on the form, whether they are required, and the default settings. If you had already build a custom string here and then change the dynamic tpl profile selection (with Save) and back to custom again, this form field string will contain one of the default profile strings. This can be irritating if your self-created string is only slightly different from the default, so you don\'t notice it right away.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE', '<p>The "Form field string" is a text string that is used to determine which fields are displayed on the dynamic form.  The string must be in the order of &lt;field&gt;:&lt;field&gt;:&lt;field&gt;.  Note the separation by colons.</p>
   <p>The individual fields (except for type "radio", as defined later) must be of the form {require;}Name;type{;default}.  Note the separation by semicolons.  Also, note that the curly brackets indicate an optional field.  If a field must be filled in to complete the form then the word "require" must appear at the start of the field definition (without the curly backets).</p>
   <p>Fields of different types are available.  Currently these types are supported:
        <ul> 
         <li>text - standard text box; Example: "Name;text"</li>
         <li>email - normal email text field; example: "Name;email" (unlike the "text" type, this one uses the placeholder attribute, depending on the template design. The forms "'.PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ.'" and "'.PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED.'" use the "text" type</li>
         <li>checkbox - A checkbox; Example: "Check Box;checkbox;Name displayed after checkbox,checked"</li>
         <li>radio - A group of radio buttons; Example: "Radio Button;radio;Yes,yes|No,no,checked"</li>
         <li>hidden - A hidden field; Example: "hiddendata;hidden"</li>
         <li>password - A password field. Note, this does not check the password against anything and it is included in the email in plaintext; Example: "require;Preferred Password;password"</li>
         <li>textarea - A large, multiline text area; Example: "Label;textarea"</li>
         <li>select - A dropdown box; Example: "Drop Down;select;Yes,yes|No,no,selected"</li>
        </ul>
   </p>
   <p>To indicate a default value for a field, you simply add an additional definition with that default.  The only valid default for type "checkbox" is "checked".</p><p>The type "radio" uses a field definition such as this: {require;}Name;radio;Name1,Value1|Name2,Value2{,checked}.  Note the additional definition of options, where the options themselves are separated by a pipe character (|), and each option has a name, a value, and an option default of checked.</p>
   <p>Examples (the quotation marks are for clarity and are not required):
       <ul>
         <li>Replicating the default form:- "require;Name;text:require;Email;text:require;Homepage;text:require;Message;textarea"</li>
         <li>A text field labeled for phone numbers:- "Phone number;text"</li>
         <li>A required text field labeled for phone numbers:- "require;Phone number;text"</li>
         <li>A textarea with default text:- "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;This is default text.  It is boring.  But it is default."
         <li>A yes/no radio button:- "Radio Button;radio;Yes,yes|No,no,checked"</li>
         <li>A checkbox, checked by default:- "Check Box;checkbox;checked"</li>
         <li>The last four together:- "require;Phone number;text:'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;This is default text.  It is boring.  But it is default.:Radio Button;radio;Yes,yes|No,no,checked:Check Box;checkbox;checked" </li>
       </ul>
   </p>
   <p>It is important that there are no hidden line breaks in the string, otherwise strange markups or even missing fields may result.</p>
   <p>For the textarea field there is a special feature to note: Since other plugins can hook in after the message field, the emoticonchooser event plugin in particular uses a fixed className selector to insert its smileys into the textarea field. For this case (as far as you use it) the name of the dynamically constructed textarea field must be exactly as defined in the currently used language constant. In this case: <strong>'.PLUGIN_CONTACTFORM_MESSAGE.'</strong>. The '.PLUGIN_CONTACTFORM_DYNAMICFIELDS.' for the text field must then be: "'.PLUGIN_CONTACTFORM_MESSAGE.';textarea" so that the plugin_dynamicform.tpl template file can refer to it exactly.</p>
   <p>If you use field types other than the predefined ones, you can specify a custom template file and use Smarty syntax to check for custom field types yourself, similar to how other types are already checked in the default template file.</p>');

@define('PLUGIN_CONTACTFORM_TEMPLATE', 'Template file name');
@define('PLUGIN_CONTACTFORM_TEMPLATE_DESC', 'Only enter the filename of a custom template file that will be used to render this contact form. You can upload custom files to either the directory of this plugin, or your current template directory.');
@define('PLUGIN_CONTACTFORM_SUBJECT', 'E-Mail subject');

@define('PLUGIN_CONTACTFORM_ISSUECOUNTER', 'Use issue counter?');
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER_DESC', 'When enabled, each sent contactform gets a unique ID.');
@define('PLUGIN_CONTACTFORM_MAIL_ISSUECOUNTER', 'Ticket: %s');
@define('PLUGIN_CONTACTFORM_SUBJECT_DESC', 'Enter the subject of the e-mail that gets sent to your address. You can place a %s variable that will contain the title of the contact form.');

@define('PLUGIN_CONTACTFORM_REQUIRED_FIELD', 'Required field');

