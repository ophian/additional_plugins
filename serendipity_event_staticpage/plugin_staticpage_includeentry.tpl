{* origin plugin - A "default fallback" frontend "plugin_staticpage_includeentry.tpl" file v. 1.01, 2016-08-31 - in case it was set in a template, OR an entry, switching to a new theme without this file! *}
<article id="staticpage_{$staticpage_pagetitle|makeFilename}" class="clearfix serendipity_staticpage_includeentry{if $staticpage_articleformat} serendipity_entry{/if}">
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
</article>
