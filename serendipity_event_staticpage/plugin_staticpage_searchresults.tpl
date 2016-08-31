<div class="staticpage_results" style="text-align: left">
    <p class="staticpage_result_header">{$CONST.STATICPAGE_SEARCHRESULTS|sprintf:$staticpage_searchresults}</p>

    {if $staticpage_results}
    <ul class="staticpage_result">
    {foreach $staticpage_results AS $result}
        <li><strong><a href="{$result.permalink|escape}" title="{$result.pagetitle|escape}">{if !empty($result.headline)}{$result.headline}{else}{$result.pagetitle|escape}{/if}</a></strong> ({$result.realname|escape})<br />
        {$result.content|strip_tags|strip|truncate:200:"&hellip;"}</li>
    {/foreach}
    </ul>
    {/if}
</div>
