Have a look at staticpage-entries-listing.tpl and plugin_staticpage_related_category.tpl!

for the backlinks from a category to the related static-page use this in your entries.tpl, below the hook {serendipity_hookPlugin hook="entries_header" addData="$entry_id"}:
(you can use {$CONST.PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME} instead of {$blogTitle})

{if ($view == 'archives' && isset($head_subtitle)) || ($view == 'frontpage')}
    <div id="staticpage_nav" class="staticpage_index_navigation">
        <ul class="staticpage_navigation">
            <li class="staticpage_navigation_center">&raquo;<a href="{$serendipityBaseURL}">{$blogTitle}</a>&raquo; {$CONST.STATICPAGE_ARTICLE_OVERVIEW}{if $view == 'archives'} {$dateRange.0|@formatTime:"%B %Y"}{/if}</li>
        </ul>
    </div>
{/if}

{if ($view == 'categories')}
    <div id="staticpage_nav" class="staticpage_index_navigation">
        <ul class="staticpage_navigation">
            <li class="staticpage_navigation_center">&raquo;
            {if $staticpage_categorypage}
                <a href="{$staticpage_categorypage.permalink}">{$staticpage_categorypage.pagetitle|escape}</a>
            {else}
                <a href="{$serendipityBaseURL}">{$blogTitle}</a>
            {/if}
            &raquo; {$CONST.STATICPAGE_ARTICLE_OVERVIEW} {$CONST.CATEGORY}: {$category_info.category_name}</li>
        </ul>
    </div>
{/if}
