<?php

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.6
 */

@define('PLUGIN_CONTACTFORM_TITLE', 'Форма за обратна връзка');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH', 'Показва форма за изпращане на e-mail в блога като статична страница. Тя може да бъде достигната или чрез постоянна връзка, указана тук при конфигурирането на приставката или чрез \'index.php?serendipity[subpage]=contactform\'. Можете да промените външния вид на формата като поставите файл \'plugin_contactform.tpl\' в директорията на вашата тема и я модифицирате там. Captchas от приставка Spamblock (ако са позволени) ще бъдат приложени.');
@define('PLUGIN_CONTACTFORM_PERMALINK', 'Постоянна връзка');
@define('PLUGIN_CONTACTFORM_PAGETITLE', 'Късо URL име (за обратна съвместимост)');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH', 'Дефинира постоянна връзка за URL. Трябва да бъде абсолютен HTTP път и да завършва с \'.htm\' или \'.html\'.');
@define('PLUGIN_CONTACTFORM_EMAIL', 'e-mail адрес');
@define('PLUGIN_CONTACTFORM_INTRO', 'Въвеждащ текст, който се появява над полето за въвеждане на съобщението (може да бъде оставено празно)');
@define('PLUGIN_CONTACTFORM_MESSAGE', 'Съобщение');
@define('PLUGIN_CONTACTFORM_SENT', 'Текст след като съобщението е било изпратено успешно');
@define('PLUGIN_CONTACTFORM_SENT_HTML', 'Съобщението беше успешно изпратено.');
@define('PLUGIN_CONTACTFORM_ERROR_HTML', 'Съобщението не беше изпратено поради възникнала грешка.');
@define('PLUGIN_CONTACTFORM_ERROR_DATA', 'Въведете вашето име, e-mail и съобщението.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA', 'Не е попълнено задължително поле.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT', 'Форматиране като статия ?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH', 'При избор \'Да\' съобщението се форматира автоматично като статия (цветове, шрифтове и т.н.).');
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

