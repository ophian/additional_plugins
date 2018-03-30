<div id="bayesContent">
    <div id="bayesAnalysis">
        <ul class="bayesAnalysisTableNavigation plainList clearfix">
            {if $commentpage > 0}
                <li class="prev"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}" title="{$CONST.PREVIOUS}"><span class="icon-left-dir" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.PREVIOUS}</span></a></li>
            {/if}

            {if $comments|@count > 20}
                <li class="next"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}" title="{$CONST.NEXT}"><span class="visuallyhidden">{$CONST.NEXT} </span><span class="icon-right-dir" aria-hidden="true"></span></a></li>
            {/if}
        </ul>

        <form action="{$serendipityBaseURL}index.php?/plugin/bayesAnalyse" method="post">
            <ul id="bayesAnalysisList" class="plainList">
                {foreach from=$comments item=comment }
                <li>
                    <input type="checkbox" id="{$comment.id}" name="comments[{$comment.id}]" />
                    <label for="{$comment.id}">{$comment.id}:</label>
                    <div class="bayesComments">
                        {$comment.author|escape:"html"}, {$comment.body|escape:"html"}
                    </div>
                </li>
                {/foreach}
                <input type="submit" class="serendipityPrettyButton input_button" id="bayesAnalysisButton" value="{$CONST.GO}" />
            </ul>
        </form>

        <script src="{$path}jquery.excerpt.js" type="text/javascript"></script>
        <script>shortenAll("bayesComments", 1)</script>

        <ul class="bayesAnalysisTableNavigation plainList clearfix">
            {if $commentpage > 0}
                <li class="prev"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}" title="{$CONST.PREVIOUS}"><span class="icon-left-dir" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.PREVIOUS}</span></a></li>
            {/if}

            {if $comments|@count > 20}
                <li class="next"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}" title="{$CONST.NEXT}"><span class="visuallyhidden">{$CONST.NEXT} </span><span class="icon-right-dir" aria-hidden="true"></span></a></li>
            {/if}
        </ul>
    </div>
</div>