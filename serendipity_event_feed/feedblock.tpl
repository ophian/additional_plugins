
    {foreach $thefeed AS $feed}
        <div id="feed_{$feed@iteration}" class="option_list">
            <div id="feedlist_{$feed@iteration}" class="serendipity_admin_list_item{if !$show_feedcontent} feed_data {cycle values="odd,even" name="listitem"}{/if}">
                <div id="feed_header_{$feed@iteration}" class="feed_header">
                    <div class="feed_title">
                        <label for="multi-select-feed-{$feed@iteration}" class="num">
                            {$CONST.PLUGIN_DASHBOARD_COMMENT_SELECTION_SHORT|sprintf:$feed@iteration}
                            {if $show_feedauthor && $feed.comments === null}<span class="feed_headline feed_author"><b>{$CONST.AUTHOR}:</b> {$feed.author|truncate:30:"&hellip;"} {$feed.action_author} </span>{/if}
                            <span class="feed_headline feed_timestamp">[{$feed.timestamp|formatTime:'%Y-%m-%d'}]</span><br>
                            <span><a href="{$feed.link}" title="{$feed.title}">{$feed.title|truncate:58:"&hellip;"}</a></span>
                        </label>
                        <time datetime="{$feed.pubDate}" pubdate></time>
                    </div>
                </div>
            {if $show_feedcontent}
                <details class="feed_data odd close">
                    <summary class="summary" role="button"><span class="sumtitle">{$feed.content|strip_tags|truncate:55:"&hellip;"}</span> <span class="icon-right-dir"></span></summary>

                    <div id="ft_{$feed@iteration}" class="feed_text comment_info clearfix">
                        <span class="fulltxt category_desc">{$feed.content}</span>
                    </div>
                    <div class="feed_boxed">
                        <ul class="plainList feed_fields horizontal">
                        {if $show_feedcontent && $feed.comments !== null}
                            <li class="mod_zoom">
                                <a class="icon_link toggle_text" href="#f{$feed@iteration}" title="{$CONST.VIEW}"><span id="text_{$feed@iteration}" class="text toggle-icon icon-zoom-in"></span><span class="visuallyhidden"> {$CONST.TOGGLE_OPTION}</span></a>
                            </li>
                        {/if}
                        {if $show_feedauthor && $feed.comments !== null}
                            <li class="mod_author"><b>{$CONST.AUTHOR}:</b> {$feed.author|truncate:30:"&hellip;"} {$feed.action_author} </li>
                        {/if}
                        {if $show_feedconum && $feed.comments !== null}
                            <li class="mod_comments"><b>{$CONST.COMMENTS}: [ <span class="num">{$feed.countcomments}</span> ]</b> {if $feed.comments}<a href="{$feed.comments}" title="{$feed.comments|truncate:60:"&hellip;"}">Link</a>{else}N/A{/if} </li>
                        {/if}
                        </ul>
                    </div><!-- class feed_boxed end -->
                </details>
            {/if}
            </div><!-- class serendipity_admin_list_item end -->
        </div><!-- // #feed_{$feed@iteration} end -->
    {/foreach}
