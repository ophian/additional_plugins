{*
    plugin_guestbook_entries.tpl for v.3.77 - 2020-06-30
*}

{if $plugin_guestbook_articleformat}
  <div class="serendipity_Entry_Date serendipity_guestbook">
    {if $staticpage_pagetitle}<h2 class="serendipity_title">{$staticpage_headline}</h2>{/if}

    <div class="serendipity_entry">
      <div class="serendipity_entry_body">
{/if}

        <div id="guestbook_wrapper">

          <div class="clearfix">

            <div class="entry-info">
              {if NOT $plugin_guestbook_articleformat}<h2 class="page-title">{$staticpage_headline}</h1>{/if}
              {if empty($is_contactform_sent) and $plugin_guestbook_intro}

              <div id="preface" class="preface guestbook_intro">{$plugin_guestbook_intro}</div>
              {/if}

            </div>

            {if $staticpage_formorder == 'top'}{$GUESTBOOK_FORM}{/if}

            <div class="entry-body">
            {if NOT empty($is_guestbook_message)}
              <p class="serendipity_center serendipity_msg_important guestbook_errorbundled">{$error_occurred}</p>
              {if $guestbook_messages}
                <ul>
                {foreach $guestbook_messages AS $messages}
                    <li class="guestbook_errors">{$messages}</li>
                {/foreach}
                </ul>
              {/if}
            {/if}

            {if isset($guestbook_entry_paging) AND $guestbook_entry_paging}<div id="guestbook_entrypaging">{$guestbook_paging}</div>{/if}

            {if isset($guestbook_entries) AND is_array($guestbook_entries)}
              {foreach $guestbook_entries AS $entry}

                <div id="guestbook_entrybundle">
                  <div class="guestbook_entrytop">
                    <dl class="guestbook_entries">
                      <dt><a href="mailto:{$entry.email}">{$entry.name}</a>
                           {$CONST.PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY} <img src="{$entry.pluginpath}img/shorttime.gif" width="14" height="17" onfocus="this.blur();" align="absmiddle" alt="{$CONST.TEXT_IMG_LASTMODIFIED}" title="{$CONST.TEXT_IMG_LASTMODIFIED}" />&nbsp;
                           {$entry.timestamp}
                      </dt>
                      {if $entry.homepage}
                      <dt>{$CONST.TEXT_USERS_HOMEPAGE}: <a href="{$entry.homepage}" target="_blank" rel="noopener">{$entry.homepage|truncate:24:'&hellip;'}</a></dt>
                      {/if}

                    </dl>

                    <dl class="guestbook_entrybottom">
                        <dd>{$entry.body|replace:'&amp;quot;':'&quot;'|nl2br}</dd>
                    </dl>
                  </div> <!-- //- class:guestbook_entrytop end -->
                </div> <!-- //- id:guestbook_entrybundle end -->

                <div class="guestbook_splitentries">&#160;</div>
              {/foreach}
            {/if}

            {if isset($guestbook_entry_paging) AND $guestbook_entry_paging}<div id="guestbook_entrypaging">{$guestbook_paging}</div>{/if}

            </div><!-- //- class:entry-body end -->

            {if $staticpage_formorder == 'bottom'}{$GUESTBOOK_FORM}{/if}

          </div> <!-- //- class:clearfix end -->

        </div> <!-- //- id:guestbook_wrapper end -->
        
{if $plugin_guestbook_articleformat}
      </div>  <!-- //- class:serendipity_entry_body end -->
    </div> <!-- //- class:serendipity_entry end -->
  </div> <!-- //- class:serendipity_Entry_Date end -->

{/if}
