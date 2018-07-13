CUSTOM EXAMPLE USAGE:

This example here enables to use a custom CSS-BODY-ID to render the page. Or you can specify, which sidebar you want to see, when this staticpage is rendered.
Example parts for 2k11/index.tpl:

<body{if $template_option.webfonts != 'none'} class="{$template_option.webfonts}{if !empty($staticpage_custom.css_class)} {$staticpage_custom.css_class}{/if}"{else}{if !empty($staticpage_custom.css_class)} class="{$staticpage_custom.css_class}"{/if}>

...

    <div class="clearfix{if $leftSidebarElements > 0 && $rightSidebarElements > 0 && empty($staticpage_custom.sidebars)} col3{elseif ($leftSidebarElements > 0 && $rightSidebarElements == 0) || $staticpage_custom.sidebars=='left'} col2l{else} col2r{/if}">
        <main id="content"{if $template_option.imgstyle != 'none'} class="{$template_option.imgstyle}"{/if}>
        {$CONTENT}
        </main>
    {if !empty($staticpage_custom.sidebars)}
        <aside id="sidebar_{$staticpage_custom.sidebars}">
            <h2 class="visuallyhidden">{$smarty.const.TWOK11_SIDEBAR}</h2>
            {serendipity_printSidebar side="{$staticpage_custom.sidebars}"}
        </aside>
    {else}
        {if $leftSidebarElements > 0}
        <aside id="sidebar_left">
            <h2 class="visuallyhidden">{$smarty.const.TWOK11_SIDEBAR}</h2>
            {serendipity_printSidebar side="left"}
        </aside>
        {/if}
        {if $rightSidebarElements > 0}
        <aside id="sidebar_right">
            <h2 class="visuallyhidden">{$smarty.const.TWOK11_SIDEBAR}</h2>
            {serendipity_printSidebar side="right"}
        </aside>
        {/if}
    {/if}
    </div>

--------------------------------------------------------------------------------------------------------

The related tags example, having the freetag event plugin installed, needs you to add the following additions:

1. Add a new staticpage pagetype, with description: "Staticpage with related article" and templatename: "plugin_staticpage_related_article.tpl" and save the form.

+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

2. Add a function to your templates "config.inc.php", which is:

function smarty_show_tags($params, &$smarty) {
    global $serendipity;
    $o = $serendipity['GET']['tag'];
    $serendipity['GET']['tag'] = $params['tag'];
    $e = serendipity_smarty_fetchPrintEntries($params, $smarty);
    echo $e;
    if (!empty($o)) {
        $serendipity['GET']['tag'] = $o;
    } else {
        unset($serendipity['GET']['tag']);
    }
}

and register it to Smarty:

$serendipity['smarty']->registerPlugin('function', 'show_tags', 'smarty_show_tags');

+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

3. Then create a file named "plugin_staticpage_related_article.tpl" to your template, with this content:

<article id="staticpage_{$staticpage_pagetitle|makeFilename}" class="clearfix serendipity_staticpage{if $staticpage_articleformat} serendipity_entry{/if}">
    <header>
        <h2>{if $staticpage_articleformat}{if $staticpage_articleformattitle}{$staticpage_articleformattitle}{else}{$staticpage_pagetitle|escape}{/if}{else}{if $staticpage_headline}{$staticpage_headline}{else}{$staticpage_pagetitle|escape}{/if}{/if}</h2>
    {if is_array($staticpage_navigation) AND ($staticpage_shownavi OR $staticpage_show_breadcrumb)}
        <div id="staticpage_nav">
        {if $staticpage_shownavi}
            <ul class="staticpage_navigation">
                <li class="staticpage_navigation_left">{if !empty($staticpage_navigation.prev.link)}<a href="{$staticpage_navigation.prev.link}" title="prev">{$staticpage_navigation.prev.name|escape}</a>{else}<span class="staticpage_navigation_dummy">{$CONST.PREVIOUS}</span>{/if}</li>
                <li class="staticpage_navigation_center">{if !empty($staticpage_navigation.top.topp_name)}<a href="{$staticpage_navigation.top.topp_link}" title="top">{$staticpage_navigation.top.topp_name|escape}</a> | {/if}&#171 {$staticpage_navigation.top.curr_name|escape} &#187; {if !empty($staticpage_navigation.top.exit_name)}| <a href="{$staticpage_navigation.top.exit_link}" title="exit">{$staticpage_navigation.top.exit_name|escape}</a>{/if}</li>
                <li class="staticpage_navigation_right">{if !empty($staticpage_navigation.next.link)}<a href="{$staticpage_navigation.next.link}" title="next">{$staticpage_navigation.next.name|escape}</a>{else}<span class="staticpage_navigation_dummy">{$CONST.NEXT}</span>{/if}</li>
            </ul>
        {/if}
        {if $staticpage_show_breadcrumb}
            <div class="staticpage_navigation_breadcrumb">
                <a href="{$serendipityBaseURL}">{$CONST.HOMEPAGE}</a>{if !empty($staticpage_navigation.crumbs)} &#187; {/if}
            {foreach name="crumbs" from=$staticpage_navigation.crumbs item="crumb"}
                {if !$smarty.foreach.crumbs.first}&#187; {/if}{if $crumb.id != $staticpage_pid} <a href="{$crumb.link}">{$crumb.name|escape}</a> {else} {$crumb.name|escape} {/if}
            {/foreach}
            </div>
        {/if}
        </div>
    {/if}
    </header>
{if $staticpage_pass AND $staticpage_form_pass != $staticpage_pass}
    <form class="staticpage_password_form" action="{$staticpage_form_url}" method="post">
    <fieldset>
        <legend>{$CONST.STATICPAGE_PASSWORD_NOTICE}</legend>
        <input name="serendipity[pass]" type="password" value="">
        <input name="submit" type="submit" value="{$CONST.GO}" >
    </fieldset>
    </form>
{else}
    {if $staticpage_precontent}
    <div class="clearfix content serendipity_preface">
    {$staticpage_precontent}
    </div>
    {/if}
    {if is_array($staticpage_childpages)}
    <div class="clearfix content staticpage_childpages">
        <ul id="staticpage_childpages">
            {foreach from=$staticpage_childpages item="childpage"}
            <li><a href="{$childpage.permalink}" title="{$childpage.pagetitle|escape}">{$childpage.pagetitle|escape}</a></li>
            {/foreach}
        </ul>
    </div>
    {/if}

    <div class="clearfix content serendipity_preface staticpage_related_article_list">
        {show_tags tag=$staticpage_custom.relTags template="related_articles.tpl" limit=$staticpage_custom.relNumb noSticky="true"}
    </div>

    {if $staticpage_content}
    <div class="clearfix content {if $staticpage_articleformat}serendipity_entry_body{else}staticpage_content{/if}">
    {$staticpage_content}
    </div>
    {/if}
{/if}

{if $staticpage_author or $staticpage_lastchange or $staticpage_adminlink}
    <footer class="staticpage_metainfo">
        <p>
        {if $staticpage_author}
            <span class="single_user"><span class="visuallyhidden">{$CONST.POSTED_BY} </span>{$staticpage_author|escape}
        {/if}
        {if $staticpage_author AND $staticpage_lastchange} | </span>{/if}
        {if $staticpage_lastchange}
            <span class="visuallyhidden">{$CONST.ON} </span>
            {if $staticpage_use_lmdate}
            <time datetime="{$staticpage_lastchange|serendipity_html5time}">{$staticpage_lastchange|formatTime:$template_option.date_format}</time>
            {if $staticpage_adminlink AND $staticpage_adminlink.page_user} ({$CONST.CREATED_ON|lower}: {$staticpage_created_on|date_format:"%Y-%m-%d"}){/if}
            {else}
            <time datetime="{$staticpage_created_on|serendipity_html5time}">{$staticpage_created_on|formatTime:$template_option.date_format}</time>
            {if $staticpage_adminlink AND $staticpage_adminlink.page_user} ({$CONST.LAST_UPDATED|lower}: {$staticpage_lastchange|date_format:"%Y-%m-%d"}){/if}
            {/if}
        {/if}
        {if $staticpage_adminlink AND $staticpage_adminlink.page_user}
            | <a href="{$staticpage_adminlink.link_edit}">{$staticpage_adminlink.link_name|escape}</a>
        {/if}
        </p>
    </footer>
{/if}
</article>

+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 

/* Staticpage related article by freetags. Better use a theme unique name, eg. mytheme_related_articles.tpl, because of the fallback line! */
4. This page calls another file, named: "related_articles.tpl", in need to be placed to your template too. This actually shows the tagged related entries by entry title link, with this content as example:

{if !empty($staticpage_custom.relTags)}

        <h3>Entries by related tags</h3>
        <div class="serendipity_freeTag">
             <p>({$staticpage_custom.relTags|replace:';':', '})</p>
        </div>

    {if !empty($entries)}
        <ul>
    {foreach from=$entries item="dategroup"}
        {foreach from=$dategroup.entries item="entry"}

            <li class="static-entries">
                ({$dategroup.date|date_format:"%d.%m.%Y"}) <a href="{$entry.link}">{$entry.title|default:$entry.id}</a>
            </li>
        {/foreach}
    {/foreach}

        </ul>
    {/if}

{/if}

+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 

5. Now create a staticpage via custom template, with the option field 'Articletype' set to: "Staticpage with related article". Add your related custom freetags into the custom option field: "Related Tag(s)" (delimiter for tags is a ";" with no spaces) and set the desired amount of pages to show up, when page is called, to the next required field.

After tweaking your theme templates margin needs, like such:

#staticpage_customtags.serendipity_entry  header {
    margin-top: 1.5em;
}

You are done!

