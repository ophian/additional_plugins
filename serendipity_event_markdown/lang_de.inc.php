<?php

/**
 *  @version 1.26
 *  @author Thomas Hochstein <thh@inter.net>
 *  EN-Revision: 1.26
 */

@define('PLUGIN_EVENT_MARKDOWN_NAME', 'Textformatierung: Markdown');
@define('PLUGIN_EVENT_MARKDOWN_DESC', 'Markdown-Textformatierung durchführen');
@define('PLUGIN_EVENT_MARKDOWN_EXTRA_NAME', '"Markdown Extra" verwenden');
@define('PLUGIN_EVENT_MARKDOWN_EXTRA_DESC', 'Markdown Extra ist eine erweiterte Markdown-Variante, vgl. https://michelf.ca/projects/php-markdown/extra/');
@define('PLUGIN_EVENT_MARKDOWN_TRANSFORM', '<a href="https://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown</a>-Formatierung erlaubt');

@define('PLUGIN_EVENT_MARKDOWN_VERSION', 'Markdown-Version');
@define('PLUGIN_EVENT_MARKDOWN_VERSION_BLABLAH', 'Welche Markdown-Version verwenden? (Siehe https://michelf.ca/projects/php-markdown/ und https://michelf.ca/blog/2013/php-markdown-lib/)');

@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NAME', 'SmartyPants (und Typographer) verwenden');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_DESC', 'SmartyPants (oder SmartyPants Typographer) "verschönern" Text durch Ersetzung bestimmter Zeichen mit passenden HTML-Entities, vgl. https://michelf.ca/projects/php-smartypants/ - Nur mit der "lib"-Version von Markdwon möglich!');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS', 'SmartyPants');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_EXTENDED', 'SmartyPants Typographer');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NEVER', 'keine');

@define('PLUGIN_EVENT_MARKDOWN_ATTENT_NOTE', '<strong>ACHTUNG</strong>: Wenn Sie bereits Einträge mit Markdown-Formatierung geschrieben haben - insbesondere unter Verwendung von Code-Snippets - und dann den Editor auf den RichText-Editor umstellen (wieder zurück oder neu), müssen Sie diese Einträge<ul><li>entweder in richtiges HTML umschreiben (z.B. durch Kopieren der vorherigen Frontend-Eintragsausgabe in das Eintragsformular vom RT-Editor in der Quellcode-Ansicht) ODER</li><li>Sie müssen dieses Plugin aktiv lassen und NICHT etwa als versteckt sichern oder es gar komplett löschen.</li></ul>Andernfalls könnten Sie feststellen, dass Teile Ihrer bisherigen Frontend-Einträge durch etwaige Browser-Reparaturen beeinträchtigt werden.');

