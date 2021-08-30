{* THIS IS A VERY OLD example template adapted to the 'default' theme loooonng years ago and only a fallback! Today you would use a grid system or fieldsets in containers for modern markup. *}

<div id="plugin_contact" class="clearfix serendipity_staticpage staticpage_plugin_contactform">
{if $plugin_contactform_articleformat}
<div class="serendipity_Entry_Date">
    <h3 class="serendipity_date">{$plugin_contactform_name}</h3>
{/if}

<h4 class="serendipity_title"><a href="#">{$plugin_contactform_pagetitle}</a></h4>

{if $plugin_contactform_articleformat}
<div class="serendipity_entry serendipity_staticpage staticpage_plugin_contactform"><div class="serendipity_entry_body">
{/if}

<div>
    {$plugin_contactform_preface}
</div>
<br /><br />

{if NOT empty($is_contactform_sent)}
<div class="serendipity_center serendipity_msg_notice">
    {$plugin_contactform_sent}
</div>
{else}

{if NOT empty($is_contactform_error)}
<div class="serendipity_center serendipity_msg_important">
    {$plugin_contactform_error}
</div>
<br /><br />

<!-- Needed for Captchas -->
{foreach $comments_messagestack AS $message}
<div class="serendipity_center serendipity_msg_important">{$message}</div>
{/foreach}
{/if}

<!-- This whole commentform style, including field names is needed for Captchas. The spamblock plugin relies on the field names [name], [email], [url], [comment]! -->
<div class="serendipity_commentForm">
    <a id="serendipity_CommentForm"></a>
    <form id="serendipity_comment" action="{$commentform_action}#feedback" method="post">
    <div>
        <input type="hidden" name="serendipity[subpage]" value="{$commentform_sname}" />
        <input type="hidden" name="serendipity[commentform]" value="true" />
         {foreach $commentform_dynamicfields AS $field}
            {if $field.type == "hidden"}

                <input type="hidden" name="serendipity[{$field.id}]" value="{$field.default}" />
            {/if}
         {/foreach}

    </div>
    <table border="0" width="100%" cellpadding="3">
      {foreach $commentform_dynamicfields AS $field}
        {if $field.type != "hidden"}

        <tr>
            <td class="serendipity_commentsLabel">{if $field.required}<span title="{$CONST.PLUGIN_CONTACTFORM_REQUIRED_FIELD}">&#8727;</span> {/if}<label for="serendipity_contactform_{$field.id}">{$field.name}</label></td>
            <td class="serendipity_commentsValue">
         {if $field.type == "checkbox"}

                <input type="checkbox" name="{$field.id}" id="{$field.id}" {$field.default|default:''} /><label for="{$field.id}">{$field.message|default:''}</label>
         {elseif $field.type == "radio"}
            {foreach $field.options AS $option}

                <input type="radio" name="{$field.id}" id="{$field.id}.{$option.id}" value="{$option.value}" {$option.default|default:''} /><label for="{$field.id}.{$option.id}">{$option.name}</label>
            {/foreach}
         {elseif $field.type == "select"}<select name="{$field.id}">
            {foreach $field.options AS $option}

                <option name="{$field.id}" id="{$field.id}.{$option.id}" value="{$option.value}" {$option.default|default:''} >{$option.name}</option>
            {/foreach}</select>
         {elseif $field.type == "password"}

                <input type="password" id="serendipity_contactform_{$field.id}" name="serendipity[{$field.id}]" value="{$field.default}" size="30" />
         {elseif $field.type == "textarea"}

                <textarea rows="{if $field.name == $CONST.PLUGIN_CONTACTFORM_MESSAGE}10{else}4{/if}" cols="40" id="{if $field.name == $CONST.PLUGIN_CONTACTFORM_MESSAGE}serendipity_commentform_comment{else}serendipity_contactform_{$field.id}{/if}" name="serendipity[{$field.id}]">{$field.default}</textarea><br />
             {* If you do NOT need AND run the emoticonchooser plugin, you can as well just use serendipity_contactform_{$field.id} here! *}

         {elseif $field.type == "email"}

                <input type="email" id="serendipity_contactform_{$field.id}" name="serendipity[{$field.id}]" value="{$field.default}" size="30" />
         {else}

                <input type="text" id="serendipity_contactform_{$field.id}" name="serendipity[{$field.id}]" value="{$field.default}" size="30" />
         {/if}

              </td>
           </tr>
          {/if}
        {/foreach}

        <tr>
            <td>&#160;</td>
            <td>
                <!-- This is where the spamblock/Captcha plugin is called -->
                {serendipity_hookPlugin hook="frontend_comment" data=$commentform_entry}
            </td>
        </tr>

       <tr>
            <td>&#160;</td>
            <td><input type="submit" name="serendipity[submit]" value="{$CONST.SUBMIT_COMMENT}" /></td>
        </tr>
    </table>
    </form>
</div>
{/if}

{if $plugin_contactform_articleformat}
</div></div></div>
{/if}
</div>
