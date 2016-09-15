<div id="serendipity_faq_plugin" class="clearfix serendipity_entry faq-searchresults">
    <div class="faq-results">
        <p class="faq_result_header">{$CONST.FAQ_SEARCHRESULTS|sprintf:$faq_searchresults}</p>
    {if !empty($faq_results)}
        <ul class="faq_result">
        {foreach $faq_results AS $result}
            <li><strong><a href="{$serendipityBaseURL}{$faq_pluginpath}/{$result.cid}/{$result.id}" title="{$result.question|truncate:50:" ... "|escape}">{$result.question|truncate:50:" ... "}</a></strong><br />
            {$result.answer|truncate:200:" ... "}</li>
        {/foreach}
        </ul>
    {/if}
    </div>
</div>
