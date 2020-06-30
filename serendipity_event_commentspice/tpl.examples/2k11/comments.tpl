{foreach from=$comments item=comment name="comments"}
<article id="c{$comment.id}" class="serendipity_comment{if $entry.author == $comment.author} serendipity_comment_author_self{/if} {cycle values="odd,even"} {if $comment.depth > 8}commentlevel-9{else}commentlevel-{$comment.depth}{/if}">
{if $comment.avatar}{$comment.avatar}{/if}
    <h4>{if $comment.url}<a href="{$comment.url}" rel="nofollow">{/if}{$comment.author|@default:$CONST.ANONYMOUS}{if $comment.url}</a>{/if} {if $comment.spice_twitter_name}<a href="{$comment.spice_twitter_url}" target="_blank" rel="noopener{if $comment.spice_twitter_nofollow} nofollow{/if}">{$comment.spice_twitter_icon_html}</a>{/if} {$CONST.ON} <time datetime="{$comment.timestamp|@serendipity_html5time}" pubdate>{$comment.timestamp|@formatTime:$template_option.date_format}</time>:</h4>
    {if $comment.spice_twitter_followme}{$comment.spice_twitter_followme}{/if}
    <div class="serendipity_commentBody clearfix content">
    {if $comment.body == 'COMMENT_DELETED'}
        {$CONST.COMMENT_IS_DELETED}
    {else}
        {$comment.body}
    {/if}
    </div>

    <footer>
        <time>{$comment.timestamp|@formatTime:'%H:%M'}</time>
        | <a class="comment_source_trace" href="#c{$comment.id}" title="{$CONST.TWOK11_PLINK_TITLE}" rel="nofollow">{$CONST.TWOK11_PLINK_TEXT}</a>
    {if $entry.is_entry_owner}
        | <a class="comment_source_ownerlink" href="{$comment.link_delete}" title="{$CONST.COMMENT_DELETE_CONFIRM|@sprintf:$comment.id:$comment.author}" rel="nofollow">{$CONST.DELETE}</a>
    {/if}
    {if $entry.allow_comments AND $comment.body != 'COMMENT_DELETED'}
        | <a class="comment_reply" href="#serendipity_CommentForm" id="serendipity_reply_{$comment.id}"{if $comment_onchange != ''} onclick="{$comment_onchange}"{/if} rel="nofollow">{$CONST.REPLY}</a>
        <div id="serendipity_replyform_{$comment.id}"></div>
    {/if}
    </footer>
</article>
{foreachelse}
<p class="nocomments">{$CONST.NO_COMMENTS}</p>
{/foreach}
