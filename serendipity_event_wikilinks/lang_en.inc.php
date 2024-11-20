<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Free Wiki links for your entries');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'You can specify new/existing links to your blog entries via [[title]], link to staticpages via ((title)) and link to both via {{title}}. References can be automatically appended to the blog entry.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Path to images');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Enter the path to where the wikilink edit icons are located.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Edit blog entry');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Edit staticpage');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Create blog entry');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Create staticpage');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Link to entry');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Please choose the entry you would like to link to.');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Create links to drafts?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Should links to entries be created, even if they are still at draft state?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Create links to future entries?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Should links to entries be created, even if they are still dated in the future?');

@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME', 'Pattern for reference capturing');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC', 'Here you can specify the pattern that will be used to go through your text, and that will capture all references written in this way. It will collect those references, store them in a database and format them below the blogentry. Also you can use {$entry.properties.references} to place it anywhere you like in your Smarty template file. The pattern is specified as a regular expression, be sure to escape special characters. The default looks complex because it uses named subpatterns, but it can be easily used like this: <ref name="xxx">yyy</ref> - where xxx is an optional name of a reference (see below) and yyy the actual text, where yyy can be any HTML or markup you like.');
@define('PLUGIN_EVENT_WIKILINKS_REFDOC', '<h3><strong>Re-Using references</strong></h3>
<p>If you want to use references on multiple occasions, it\'s helpful to only specify them once and reuse them later. If you have this text for example:
<pre style="border: 1px solid black; padding: inherit; background-color: var(--color-auto-gray-3)">
Serendipity&lt;ref&gt;&lt;a href="https://ophian.github.io/"&gt;Serendipity Styx Weblog&lt;/a&gt; - also, Serendipity stands for several other interpretations like a movie, or a dancer in a movie, or a movie of a dancer in a movie.&lt;/ref&gt; can be found in many places.
</pre></p>
<p>Since you surely will mention Serendipity a lot of times in your blog, you should make a referenced mention, which works by adding a <em>name</em> attribute to the &lt;ref&gt; tag, and make it look like this:
<pre style="border: 1px solid black; padding: inherit; background-color: var(--color-auto-gray-3)">
Serendipity&lt;ref name="Serendipity"&gt;&lt;a href="https://ophian.github.io/"&gt;Serendipity Styx Weblog&lt;/a&gt; - also, Serendipity stands for several other interpretations like a movie, or a dancer in a movie, or a movie of a dancer in a movie.&lt;/ref&gt; can be found in many places.</pre>
</pre>
</p>
<p>Now you only need to do this for the first occurrence of your reference. Whenever you want to use the same reference in future blog entries you simply write this:
<pre style="border: 1px solid black; padding: inherit; background-color: var(--color-auto-gray-3)">
Serendipity&lt;ref name="Serendipity"&gt;&lt;/ref&gt;
</pre></p>
<p>This will take care of fetching the existing, named reference text from the database. Please note that you must use the &lt;ref&gt;...&lt;/ref&gt; notation, &lt;ref.../&gt; is not supported due to the regular expression syntax not properly supporting this.
<h3>PLEASE NOTE:</h3>
When using the TinyMCE RichText Editor (up from Styx 5.0) and you want to use ref tags containing a link like in our example here then you have to use this (markdown) alike syntax <code>[title](url)</code> for the link to avoid editor cleanups doubling the ref tags by the Editors rich text mode:</p>
<pre style="border: 1px solid black; padding: inherit; background-color: var(--color-auto-gray-3)">
Serendipity&lt;ref name="Serendipity"&gt;[Serendipity Styx Weblog](https://ophian.github.io/) - also, Serendipity stands for several other interpretations like a movie, or a dancer in a movie, or a movie of a dancer in a movie.&lt;/ref&gt; can be found in many places.<br>
</pre>For severity against SPAM we do not allow this for comments though!</p>');

@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME', 'Format for replaced reference output');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC', 'Here you can enter how the captured reference will be replaced, usually a number linking to the list of references. {count} and {text} are placeholders for the replaced reference number and its original text. {refname} corresponds to an optional name of the reference.');

@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME', 'Format for reference list output');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC', 'Here you can enter how the captured reference will be displayed in the list. If set to "-", then no output will take place (useful if you want to style the output via Smarty yourself!)');

@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Maintain reference index');
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Here you can edit stored references. Be sure to note that if you edit the original entry where the reference occurred in, that the text of a reference there always takes precedence over anything you edit here. If you frequently re-edit old entries, you should better maintain the texts of references inside the entries, and not here.');

@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'Reference name');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Reference content');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Defined in:');

