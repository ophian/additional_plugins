{*
     plugin_guestbook_backend_entries.tpl for v.4.0.1- 2023-12-01
*}

<!-- plugin_guestbook_backend_entries start -->

<div id="wrapGB" class="clearfix">
    {include file='./plugin_guestbook_backend_header.tpl'}
{if !empty($gb_gbadd_approve)}

    <div class="gb_head">
{if !empty($msg_header)}
        {call feedback}
{else}
        <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_APP}</h2>
        {$CONST.PLUGIN_GUESTBOOK_ADMIN_APP_DESC}
{/if}
    </div>
{elseif !empty($gb_gbadd_view)}

    <div class="gb_head">
{if !empty($msg_header)}
        {call feedback}
{else}
        <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW}</h2>
        {$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC}
{/if}
    </div>
{elseif !empty($gb_gbadd_add)}

    <div class="gb_head">
{if !empty($msg_header)}
        {call feedback}
{else}
        <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_ADD}</h2>
{/if}
    </div>
{/if}
{if !empty($is_guestbook_message)}{$msg_header=$error_occured}{call feedback}{/if}
{if !empty($is_gbadmin_noappresult)}
    <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT}</div>
{/if}
{if !empty($is_gbadmin_noviewresult)}
    <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT}</div>
{/if}
{if !empty($is_gbadmin_nodbcdb)}
    <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC}</div>
{/if}
{if $guestbook_entries}

    <nav class="pagination" role="navigation">
        <ul class="gb_paginator">
            {$guestbook_paginator}
        </ul>
    </nav>

    <div class="entries_pane">
        <ul id="entries_list" class="plainList zebra_list">
{foreach $guestbook_entries AS $entry}
            <li id="entry_{$entry.id}" class="clearfix {cycle values="odd,even"}">
                <form name="checkform" method="post" action="{$plugin_guestbook_backend_path}">
                <div>
                    <input type="hidden" name="guestbook[id]" value="{$entry.id}">
                    {if $entry.approved == 0}<input type="hidden" name="serendipity[guestbook_category]" value="gbapp">{/if}
                    {if isset($smarty.get.serendipity.guestbooklimit)}<input type="hidden" name="serendipity[guestbooklimit]" value="{$smarty.get.serendipity.guestbooklimit}">{/if}

                </div>

                <div class="gb_entryhead{if !empty($gb_app)} approve{/if}">
                    <span>
                        <a href="mailto:{$entry.email}">{$entry.name}</a>
                        {$CONST.PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY} <span class="icon-clock" aria-hidden="true" title="{$CONST.TEXT_IMG_LASTMODIFIED}: {$entry.timestamp}"></span>
                    </span>
{if $is_guestbook_admin_noapp != true}

                    <span class="gb_validation"><input type="image" class="gb_move approve" src="{$entry.pluginpath}img/check-square.svg" name="Approve_Selected" alt="notes-approve" title=" Approve " align="bottom"></span>
{else}

                    <span class="gb_validation"><img class="gb_move checked" src="{$entry.pluginpath}img/check2-square.svg" name="Approve_Selected" alt="notes-approve" title=" is approved already - no action " align="bottom"></span>
{/if}

                    <span class="gb_validation"><input type="image" class="gb_move edit" src="{$entry.pluginpath}img/pencil-square.svg" name="Change_Selected" alt="notes-change" title=" {$CONST.EDIT} " align="bottom"></span>
                    <span class="gb_validation"><input type="image" class="gb_move reject" src="{$entry.pluginpath}img/x-square.svg" name="Reject_Selected" alt="notes-delete" title=" Reject immediately " align="bottom"></span>
{if $entry.homepage}

                    <span>
                        {$CONST.TEXT_USERS_HOMEPAGE}: <a href="{$entry.homepage}" title="{$entry.homepage}" target="_blank" rel="noopener">{$entry.homepage|truncate:24:'&hellip;'}</a>
                    </span>
{/if}
                </div>

                <div class="gb_entrybody">
                    <label for="show">
                        <span class="icon-show" aria-hidden="true"></span>
                    </label>
                    <input type=radio id="show" name="group">
                    <input type=radio id="hide" name="group">
                    <span class="gbboxfull">{$entry.body|replace:'&amp;quot;':'&quot;'|nl2br}</span>
                    <span class="gbsummary">{$entry.body|strip|replace:'<br />':''|replace:'&amp;quot;':'&quot;'|truncate:50}</span>
                </div>
                </form>
            </li>
{/foreach}
        </ul>
    </div>

    <nav class="pagination" role="navigation">
        <ul class="gb_paginator">
            {$guestbook_paginator}
        </ul>
    </nav>
{/if}

    <script>
        jQuery(document).ready(function ($) {
            // hide all
            $('.gbboxfull').hide('fast');
            // shows the entry
            $('.icon-show').click(function() {
                $this = $(this);
                //console.log($this);
                $this.parent().siblings('.gbboxfull').toggle('slow');
                $this.parent().siblings('.gbsummary').toggle('slow');
                $this.toggleClass('icon-hide');
                return false;
            });
        });
    </script>

</div><!-- #wrapGB tpl end -->