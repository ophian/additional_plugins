<div id="bayesContent">
    <form action="{$serendipityBaseUrl}index.php?/plugin/bayesRecycler" method="post">
        <div id="bayesControls">
                <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE}" name="restore"/>
                <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY}" name="empty" />
        </div>

        <div id="bayesRecycler">
            <ul class="bayesRecyclerTableNavigation plainList clearfix">
                {if $commentpage > 0}
                    <li class="prev"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage-1}" title="{$CONST.PREVIOUS}"><span class="icon-left-dir" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.PREVIOUS}</span></a></li>
                {/if}
                {if ($commentpage+1)*20 < $comments|@count}
                    <li class="next"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage+1}" title="{$CONST.NEXT}"><span class="visuallyhidden">{$CONST.NEXT} </span><span class="icon-right-dir" aria-hidden="true"></span></a></li>
                {/if}
            </ul>
            <ul id="serendipity_comments_list" class="clearfix plainList zebra_list">
            {foreach $comments AS $comment}
                <li id="comment_{$comment.id}" class="clearfix {cycle values="odd,even"}">
                    <input type="hidden" name="serendipity[comments][{$comment.id}]">
                    <div class="form_check">
                        <input id="serendipity[selected][{$comment.id}]" type="checkbox" class="bayesRecyclerSelectBox" name="serendipity[selected][{$comment.id}]">
                        <label for="serendipity[selected][{$comment.id}]" class="visuallyhidden">{$CONST.TOGGLE_SELECT}</label>
                    </div>
                    <h4 id="c{$comment.id}">{$comment.author|truncate:20:"..."|escape:"html"} {$CONST.IN_REPLY_TO} <a href="{$comment.article_link}" target="_blank" rel="noopener">{$comment.article_title}</a> {$CONST.ON} {$comment.timestamp|date_format:"%d.%m.%y, %R"} – <span title="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING}">{$comment.rating|regex_replace:"/\..*/":""}%</span> <button class="toggle_info button_link" type="button" data-href="#comment_data_{$comment.id}"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> More</span></button></h4>

                    <div id="comment_data_{$comment.id}" class="additional_info">
                        <dl class="comment_data clearfix">
                        {foreach $types AS $type}
                            <dt>{$type}</dt>
                            <dd>{$comment.$type|escape:"html"}</dd>
                        {/foreach}
                        </dl>
                    </div>
                </li>
            {/foreach}
            </ul>
            <ul class="bayesRecyclerTableNavigation plainList clearfix">
            {if $commentpage > 0}
                <li class="prev"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage-1}" title="{$CONST.PREVIOUS}"><span class="icon-left-dir" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.PREVIOUS}</span></a></li>
            {/if}
            {if ($commentpage+1)*20 < $comments|@count}
                <li class="next"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage+1}" title="{$CONST.NEXT}"><span class="visuallyhidden">{$CONST.NEXT} </span><span class="icon-right-dir" aria-hidden="true"></span></a></li>
            {/if}
            </ul>
        </div>
    </form>
</div>