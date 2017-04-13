{* origin plugin - frontend plugin_staticpage_related_category.tpl file v. 1.07, 2017-04-13 *}
<article id="staticpage_{$staticpage_pagetitle|makeFilename}" class="clearfix serendipity_staticpage{if $staticpage_articleformat} serendipity_entry{/if}">
    <header>
        <h2>{if $staticpage_articleformat}{if $staticpage_articleformattitle}{$staticpage_articleformattitle}{else}{$staticpage_pagetitle|escape}{/if}{else}{if $staticpage_headline}{$staticpage_headline}{else}{$staticpage_pagetitle|escape}{/if}{/if}</h2>
    {if is_array($staticpage_navigation) AND ($staticpage_shownavi OR $staticpage_show_breadcrumb)}
        <div id="staticpage_nav">
        {if $staticpage_shownavi}
            <ul class="staticpage_navigation">
                <li class="staticpage_navigation_left">{if !empty($staticpage_navigation.prev.link)}<a href="{$staticpage_navigation.prev.link}" title="prev">{$staticpage_navigation.prev.name|escape}</a>{else}<span class="staticpage_navigation_dummy">{$CONST.PREVIOUS}</span>{/if}</li>
                <li class="staticpage_navigation_center">{if $staticpage_navigation.top.new}{if !empty($staticpage_navigation.top.topp_name)}<a href="{$staticpage_navigation.top.topp_link}" title="top">{$staticpage_navigation.top.topp_name|escape}</a> | {/if}&#171 {$staticpage_navigation.top.curr_name|escape} &#187; {if !empty($staticpage_navigation.top.exit_name)}| <a href="{$staticpage_navigation.top.exit_link}" title="exit">{$staticpage_navigation.top.exit_name|escape}</a>{/if}{else}<a href="{$staticpage_navigation.top.link}" title="current page">{$staticpage_navigation.top.name|escape}</a>{/if}</li>
                <li class="staticpage_navigation_right">{if !empty($staticpage_navigation.next.link)}<a href="{$staticpage_navigation.next.link}" title="next">{$staticpage_navigation.next.name|escape}</a>{else}<span class="staticpage_navigation_dummy">{$CONST.NEXT}</span>{/if}</li>
            </ul>
        {/if}
        {if $staticpage_show_breadcrumb}
            <div class="staticpage_navigation_breadcrumb">
                <a href="{$serendipityBaseURL}">{$CONST.HOMEPAGE}</a>{if !empty($staticpage_navigation.crumbs)} &#187; {/if}
            {foreach $staticpage_navigation.crumbs AS $crumb}
                {if !$crumb@first}&#187; {/if}{if $crumb.id != $staticpage_pid}<a href="{$crumb.link}">{$crumb.name|escape}</a>{else}{$crumb.name|escape}{/if}
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
            {foreach $staticpage_childpages AS $childpage}
            <li><a href="{$childpage.permalink}" title="{$childpage.pagetitle|escape}">{$childpage.pagetitle|escape}</a></li>
            {/foreach}
        </ul>
    </div>
    {/if}
    {if $staticpage_content}
    <div class="clearfix content {if $staticpage_articleformat}serendipity_entry_body{else}staticpage_content{/if}">
    {$staticpage_content}
    </div>
    {/if}
{/if}

<div class="clearfix content serendipity_preface staticpage_related_category_entry_list">
{* Standard - if you use it on a shared-s9y-installation you have to correct the path to staticpage-entries-listing.tpl
   PLEASE NOTE: (for S9y 2.0 and up, the fallback template name is 2k11 instead of bulletproof)
   The Serendipity fallback mode uses serendipity/templates/bulletproof/plugin_staticpage_related_category.tpl. That file overwrites this file here.
   If you need to change anything, better copy this file to your template, to make the desired changes! *}
{serendipity_fetchPrintEntries category=$staticpage_related_category_id template="../../plugins/serendipity_event_staticpage/staticpage-entries-listing.tpl" limit="5" noSticky="true"}

{*  if you use your own static-entries.tpl in your template, take this:  *}
{*  {serendipity_fetchPrintEntries category=$staticpage_related_category_id template="staticpage-entries-listing.tpl" limit="5" noSticky="true"}  *}
</div>

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

