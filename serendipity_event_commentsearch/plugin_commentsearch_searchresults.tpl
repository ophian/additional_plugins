<!-- commentsearch searchresults origin template file start -->

<div class="comment_results">
    <p class="comment_result_header">{$CONST.COMMENT_SEARCHRESULTS|sprintf:$comment_searchresults}</p>

    <ul class="comment_result">
    {foreach $comment_results AS $result}
        <li>{$result.ctimestamp|formatTime:DATE_FORMAT_ENTRY}:
        {if $result.type == 'TRACKBACK'}
            <strong><a href="{$result.url|escape}">{$result.author|escape}</a> - <a href="{$result.permalink|escape}">{$result.title|escape}</a></strong>
        {else}
            <strong>{$result.author|escape}</strong> - <strong><a href="{$result.permalink|escape}">{$result.title|escape}</a></strong>
        {/if}<br />
        {$result.comment|strip_tags|strip|truncate:200:" ..."}</li>
    {/foreach}
    </ul>
</div>

<!-- commentsearch searchresults origin template file end -->
