{* backend_staticpage template file v. 1.27, 2017-04-03 *}

<!-- backend_staticpage.tpl START -->

{include file="./svg_iconizr.tpl"}

{if $switch_spcat == 'pageorder' || $switch_spcat == 'pagetype' || $switch_spcat == 'pageadd'}
<div id="serendipityStaticpagesNav">
    <ul class="sp_tabnav">
        <li{if $s9y_get_cat == 'pageedit'} id="active"{/if} class="spnav"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageedit"><span title="{$CONST.STATICPAGE_CATEGORY_PAGES}"><svg role="img" class="icon icon-pagelist"><title>{$CONST.STATICPAGE_CATEGORY_PAGES}</title><use xlink:href="#icon-pagelist"></use></svg></span><span class="spshow"> {$CONST.STATICPAGE_CATEGORY_PAGES}</span></a></li>
        <li{if $s9y_get_cat == 'pageorder'} id="active"{/if} class="spnav"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder"><span title="{$CONST.STATICPAGE_CATEGORY_PAGEORDER}"><svg role="img" class="icon icon-pageorder"><<title>{$CONST.STATICPAGE_CATEGORY_PAGEORDER}</title><use xlink:href="#icon-pageorder"></use></svg></span><span class="spshow"> {$CONST.STATICPAGE_CATEGORY_PAGEORDER}</span></a></li>
        <li{if $s9y_get_cat == 'pagetype' || $s9y_post_cat == 'pagetype'} id="active"{/if} class="spnav"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pagetype"><span title="{$CONST.STATICPAGE_CATEGORY_PAGETYPES}"><svg role="img" class="icon icon-pagetype"><title>{$CONST.STATICPAGE_CATEGORY_PAGETYPES}</title><use xlink:href="#icon-pagetype"></use></svg></span><span class="spshow"> {$CONST.STATICPAGE_CATEGORY_PAGETYPES}</span></a></li>
        <li{if $s9y_get_cat == 'pageadd'} id="active"{/if} class="spnav"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageadd"><span title="{$CONST.STATICPAGE_CATEGORY_PAGEADD}"><svg role="img" class="icon icon-otherplugins"><title>{$CONST.STATICPAGE_CATEGORY_PAGEADD}</title>><use xlink:href="#icon-otherplugins"></use></svg></span><span class="spshow"> {$CONST.STATICPAGE_CATEGORY_PAGEADD}</span></a></li>
    </ul>
</div>
{/if}

{if $switch_spcat == 'pageorder'}

<div id="splistorder" class="sp_msg_success"></div>

    {if is_array($sp_pageorder_pages)}

<div id="sp_sequencer" class="configuration_group even">
    <fieldset class="sp_sequence">
        <legend>{$CONST.STATICPAGE_PAGEORDER_DESC}</legend>
        <input type="hidden" name="serendipity[plugin][sequence]" id="sequence_value" value="{foreach $sp_pageorder_pages AS $orderlist}{$orderlist['pagetitle']}{if !$orderlist@last},{/if}{/foreach}">

        <ol id="sequence" data-placement="sqid" class="sequence_container pluginmanager_container">
        {foreach $sp_pageorder_pages AS $entryorder}
            <li id="{$entryorder['id']}" class="sequence_item pluginmanager_item_{cycle values="odd,even"}">{*  in normal situations id=$entryorder['pagetitle'], but we need id for js sequence mode *}
                <input type="hidden" name="serendipity[plugin][sequence][id]" id="sid{$sp_element['id']}" value="{$entryorder['id']}">
                <div id="sg{$entryorder['id']}" class="pluginmanager_grablet sequence_grablet">
                    <button class="icon_link" type="button" title="{$CONST.MOVE}"><span class="icon-move" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MOVE}</span></button>
                </div>
                {if $entryorder['parent_id'] > 0}<span class="entry_status sp_ptree">#{$entryorder['parent_id']}</span><span class="icon-right-dir sp_ctree" aria-hidden="true"></span>{/if}<span title="#{$entryorder['id']} {if !empty($entryorder['headline'])}{$entryorder['headline']}{else}{$entryorder['pagetitle']|escape}{/if}" class="sp_grablet_title">{$entryorder['pagetitle']|escape|truncate:50}</span>{if !empty($entryorder['lang'])} <span class="clearfix sp_orderlang"><span class="sp_dim">[<em class="sp_lang">{$entryorder['lang']}</em>]</span></span>{/if}
            </li>
        {/foreach}
        </ol>
    </fieldset>
    <form action="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder" method="post" name="saveOrder">
        <input type="submit" class="input_button state_submit" name="serendipity[typeSubmit]" value="{$CONST.GO}">
    </form>
</div>
    {else}

    <p class="sp_bold">{$CONST.STATICPAGE_PAGEORDER_DESC}</p>

    {/if} {* is_array($sp_pageorder_pages) end *}

{elseif $switch_spcat == 'pagetype'}

    {if $sp_pagetype_saveconf}
<div class="msg_success spmsg"><svg aria-hidden="true" class="icon icon-ok"><use xlink:href="#icon-ok"></use></svg> {$CONST.DONE}! {$CONST.SETTINGS_SAVED_AT|sprintf:($smarty.now|formatTime:'%H:%M:%S')}</div>
    {/if}

    {if $sp_pagetype_purged}
<div class="msg_success spmsg"><svg aria-hidden="true" class="icon icon-ok"><use xlink:href="#icon-ok"></use></svg> {$CONST.DONE}! {$CONST.RIP_ENTRY|sprintf:$sp_pagetype_ripped}</div>
    {/if}

    {if $sp_pagetype_update}
<div class="msg_error spmsg"><svg aria-hidden="true" class="icon icon-error"><use xlink:href="#icon-error"></use></svg> {$CONST.ERROR}: {$sp_pagetype_mixedresult}</div>
    {/if}

<form action="serendipity_admin.php" method="post" name="serendipityEntry">
  <div>
    <input type="hidden" name="serendipity[adminModule]" value="event_display">
    <input type="hidden" name="serendipity[adminAction]" value="staticpages">
    <input type="hidden" name="serendipity[staticpagecategory]" value="pagetype">
    <div>
        <p class="sp_bold">{$CONST.PAGETYPES_SELECT}</p>
        <select name="serendipity[pagetype]">
            <option value="__new">{$CONST.NEW_ENTRY}</option>
            <option value="__new">-----------------</option>
{if $sp_pagetype && is_array($sp_pagetype_types)}
    {foreach $sp_pagetype_types AS $type}
        <option value="{$type['id']}"{if $smarty.post.serendipity.pagetype == $type['id']} selected="selected"{/if}>{$type['description']|escape}</option>
    {/foreach}
{/if}

        </select>
        <input type="submit" class="input_button state_submit" name="serendipity[typeSubmit]" value="{$CONST.GO}">
        <input type="submit" class="input_button state_cancel" name="serendipity[typeDelete]" value="{$CONST.DELETE}">
        {if $sp_pagetype_submit}<input type="hidden" name="serendipity[typeSave]" value="true">{/if}
        {if $sp_pagetype_isshowform && !empty($sp_pagetype_showform)}

        <!-- sp_pagetype_showform start -->
        {$sp_pagetype_showform}
        <!-- sp_pagetype_showform end -->

        <div class="clearfix form_field">
            <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="input_button state_submit">
        </div>
        {/if}

    </div>
  </div>
</form>

{elseif $switch_spcat == 'pageadd'}

<div id="staticpage_pageadd" class="sp_padd">

    {if $sp_addsubmit}
    <div class="msg_success spmsg"><svg aria-hidden="true" class="icon icon-ok"><use xlink:href="#icon-ok"></use></svg> {$CONST.DONE}! {$CONST.SETTINGS_SAVED_AT|sprintf:($smarty.now|formatTime:'%H:%M:%S')}</div>
    {/if}

    <p>{$CONST.STATICPAGE_PAGEADD_DESC}</p>

    {if is_array($sp_pageadd_plugins)}

    <form action="serendipity_admin.php" method="post" name="serendipityPlugins">
        <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display">
        <input type="hidden" name="serendipity[adminAction]" value="staticpages">
        <input type="hidden" name="serendipity[staticpagecategory]" value="pageadd">
    {foreach $sp_pageadd_plugins AS $plugin}

        <input class="input_checkbox" type="checkbox" name="serendipity[externalPlugins][]" value="{$plugin@key}"{if isset($sp_pageadd_insplugins[$plugin@key])} checked="checked"{/if}>{$plugin['name']}<br>
    {/foreach}

        <input type="submit" name="serendipity[typeSubmit]" class="input_button state_submit" value="{$CONST.GO}">
        </div>
    </form>

    {/if} {* is_array($sp_pageadd_plugins) end *}

    <fieldset class="sp_add">
        <legend>{$CONST.STATICPAGE_PAGEADD_PLUGINS}</legend>

        <table>
            <tr class="sp_thead">
                <th>{$CONST.EVENT_PLUGIN}</th>
                <th>{$CONST.STATICPAGE_STATUS}</th>
            </tr>

    {foreach $sp_pageadd_plugstats AS $plugstats}

            <tr class="sp_t{cycle values="odd,even"}">
                <td>{$plugstats@key}</td>
                <td><span class="sp_t{$plugstats['color']|lower}">{$plugstats['status']}</span></td>
            </tr>

    {/foreach}

        </table>
    </fieldset>
</div>

{else} {* == 'pages' || 'pageedit' || default *}

    {if $sp_staticsubmit}
        {if !empty($sp_defpages_upd_result)}
<div class="msg_error spmsg"><svg aria-hidden="true" class="icon icon-error"><use xlink:href="#icon-error"></use></svg> {$CONST.ERROR}: {$sp_defpages_upd_result}</div>
        {else}
<div class="msg_success spmsg"><svg aria-hidden="true" class="icon icon-ok"><use xlink:href="#icon-ok"></use></svg> {$CONST.DONE}! {$CONST.SETTINGS_SAVED_AT|sprintf:($smarty.now|formatTime:'%H:%M:%S')}</div>
        {/if}
    {/if}

    {if $sp_staticdelete}
        {if isset($sp_defpages_rip_success)}
<div class="msg_success spmsg"><svg aria-hidden="true" class="icon icon-ok"><use xlink:href="#icon-ok"></use></svg> {$sp_defpages_rip_success}</div>
        {else}
<div class="msg_notice spmsg">
    <svg aria-hidden="true" class="icon icon-error"><use xlink:href="#icon-error"></use></svg> {$CONST.IMPORT_NOTES}: {$CONST.STATICPAGE_CANNOTDELETE_MSG}
</div>
        {/if}
    {/if}
    {if $sp_relcatchange}
<div class="msg_notice spmsg">
    <svg aria-hidden="true" class="icon icon-error"><use xlink:href="#icon-error"></use></svg> {$CONST.IMPORT_NOTES}: {$CONST.RELATED_CATEGORY_CHANGE_MSG|sprintf:$prev_relcat_staticpage:$this_relcat_staticpage}
</div>
    {/if}

    {if !$sp_listentries_entries} {* show selectbox form header start, if showform is present, since we need to select entries quickly *}

<form action="serendipity_admin.php" method="post" name="serendipityEntry">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display">
        <input type="hidden" name="serendipity[adminAction]" value="staticpages">
        <input type="hidden" name="serendipity[staticpagecategory]" value="pages">
    </div>

    {if isset($sp_cookie_value)}
    <script type="text/javascript">
        if (window.jQuery) { jQuery(function ($) { serendipity.SetCookie("backend_template", unescape("{$sp_cookie_value}")); }); } else { serendipity.SetCookie("backend_template", unescape("{$sp_cookie_value}")); }
    </script>
    {/if}

    <div id="sp_navigator">
        <div class="sp_templateselector">
            <label for="sp_templateselector">{$CONST.STATICPAGE_TEMPLATE}</label>
            <select id="sp_templateselector" name="serendipity[backend_template]">
            {if isset($sp_defpages_top) && is_array($sp_defpages_top)}

                {foreach $sp_defpages_top AS $templateform}{$templateform}{/foreach}
            {/if}
            </select>
        </div><!-- class sp_templateselector end -->

        <div class="sp_pageselector">
            <p class="sp_bold sp_top">{$CONST.STATICPAGE_SELECT}</p>
            <select id="staticpage_dropdown" name="serendipity[staticpage]">
                <option value="__new">{$CONST.NEW_ENTRY}</option>
                <option value="__new">-----------------</option>
            {if isset($sp_defpages_pop) && is_array($sp_defpages_pop)}

                {foreach $sp_defpages_pop AS $selectpage}{$selectpage}{/foreach}
            {/if}
            </select>
        {if isset($smarty.post.serendipity['staticpagecategory']) || isset($smarty.get.serendipity['staticid'])}
            <script>var dropdown_dialog = "{$CONST.STATICPAGE_CONFIRM_SELECTDIALOG}";</script>
        {/if}
            <input class="input_button state_submit" type="submit" name="serendipity[staticSubmit]" value="{$CONST.GO}"> -
            <input class="input_button state_cancel" type="submit" name="serendipity[staticDelete]" onclick="return confirm('{$CONST.DELETE_SURE|sprintf:"{$sp_selected_id} ({$sp_selected_name|truncate:30})"}');" value="{$CONST.DELETE}">
            {if (int)$smarty.request.serendipity.staticid || (int)$smarty.post.serendipity.staticpage}
            - <button type="submit" name="serendipity[staticPreview]" value="1" title="{$CONST.PREVIEW}" class="button_link entry_preview icon-search"><span class="visuallyhidden">{$CONST.PREVIEW}</span></button>
            {/if}
        {if $sp_defpages_sbplav}
            <span class="sp_right sp_info" title="Staticpage Sidebar {$CONST.STATICPAGE_PLUGIN_AVAILABLE}"><svg aria-hidden="true" class="icon icon-info"><use xlink:href="#icon-info"></use></svg></span>
        {/if}
            <ul class="sp_listnav">
                <li{if $s9y_get_cat == 'pageedit'} id="active"{/if} class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageedit"><span title="{$CONST.STATICPAGE_CATEGORY_PAGES}"><svg role="img" class="icon icon-pagelist"><title>{$CONST.STATICPAGE_CATEGORY_PAGES}</title><use xlink:href="#icon-pagelist"></use></svg></span></a></li>
                <li class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder"><span title="{$CONST.STATICPAGE_CATEGORY_PAGEORDER}"><svg role="img" class="icon icon-pageorder"><<title>{$CONST.STATICPAGE_CATEGORY_PAGEORDER}</title><use xlink:href="#icon-pageorder"></use></svg></span></a></li>
                <li class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pagetype"><span title="{$CONST.STATICPAGE_CATEGORY_PAGETYPES}"><svg role="img" class="icon icon-pagetype"><title>{$CONST.STATICPAGE_CATEGORY_PAGETYPES}</title><use xlink:href="#icon-pagetype"></use></svg></span></a></li>
                <li class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageadd"><span title="{$CONST.STATICPAGE_CATEGORY_PAGEADD}"><svg role="img" class="icon icon-otherplugins"><title>{$CONST.STATICPAGE_CATEGORY_PAGEADD}</title>><use xlink:href="#icon-otherplugins"></use></svg></span></a></li>
            </ul>
        </div><!-- class sp_pageselector end -->

    {if isset($sp_defpages_link)}
        <script type="text/javascript">
            var staticpage_preview = window.open("{$sp_defpages_link}", "staticpage_preview");
            staticpage_preview.focus();
        </script>
        <div class="msg_notice spmsg"><svg aria-hidden="true" class="icon icon-info"><use xlink:href="#icon-info"></use></svg> {$CONST.PLUGIN_STATICPAGE_PREVIEW|sprintf:"<a href=\"$sp_defpages_link\">{$sp_defpages_pagetitle|escape}</a>"}</div>
    {/if}
    </div><!-- //id sp_navigator end -->

    {/if}{* showform, but not not entrylist end *}
    {if false === $sp_defpages_showlist} {* SELECT LIST BAR start WE NEED === here, do not use plain ! *}

    {if $sp_defpages_staticsave}

    <div>
        <input type="hidden" name="serendipity[staticSave]" value="true">
    </div>

    <!-- sp_defpages_showform -->
    {$sp_defpages_showform}{* this might come already smartified (default form) or as hardcoded table row stuff (old form) *}

    {/if}{* sp_defpages_staticsave end *}

</form><!-- sp select form bar end -->

    {else} {* EBTRIES LIST by OPTION *}

    {if is_array($sp_listentries_entries)}

<h2>{$CONST.STATICPAGE_LIST_EXISTING_PAGES}</h2>

<ul class="sp_listnav">
    <li{if $s9y_get_cat == 'pageedit'} id="active"{/if} class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageedit"><span title="{$CONST.STATICPAGE_CATEGORY_PAGES}"><svg aria-hidden="true" role="img" class="icon icon-pagelist"><title>{$CONST.STATICPAGE_CATEGORY_PAGES}</title><use xlink:href="#icon-pagelist"></use></svg></span></a></li>
    <li class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder"><span title="{$CONST.STATICPAGE_CATEGORY_PAGEORDER}"><svg aria-hidden="true" role="img" class="icon icon-pageorder"><<title>{$CONST.STATICPAGE_CATEGORY_PAGEORDER}</title><use xlink:href="#icon-pageorder"></use></svg></span></a></li>
    <li class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pagetype"><span title="{$CONST.STATICPAGE_CATEGORY_PAGETYPES}"><svg aria-hidden="true" role="img" class="icon icon-pagetype"><title>{$CONST.STATICPAGE_CATEGORY_PAGETYPES}</title><use xlink:href="#icon-pagetype"></use></svg></span></a></li>
    <li class="spnav splist"><a href="{$serendipityHTTPPath}serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageadd"><span title="{$CONST.STATICPAGE_CATEGORY_PAGEADD}"><svg aria-hidden="true" role="img" class="icon icon-otherplugins"><title>{$CONST.STATICPAGE_CATEGORY_PAGEADD}</title>><use xlink:href="#icon-otherplugins"></use></svg></span></a></li>
</ul>

<div id="sp_entry_pagination"></div>

<div id="step" class="clearfix">

{foreach $sp_listentries_entries AS $entry}

    <div class="sp_entries_pane {cycle values="odd,even"}{if $entry@last} sp_close{/if}">
        <ul id="sp_entries_list" class="plainList{if $entry['parent_id'] > 0} sp_isChild{/if}">
            <li id="sple{$entry['id']}" class="clearfix">
                <h3>{if $entry['parent_id'] > 0}<span class="entry_status sp_ptree" title="parent static page ID">#{$entry['parent_id']}</span><span class="icon-right-dir sp_ctree" aria-hidden="true"></span>{/if}{if empty($entry['headline'])}<span class="five">{$CONST.STATICPAGE_PAGETITLE}: </span>{/if}<a href="?serendipity[action]=admin&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pages&amp;serendipity[staticid]={$entry['id']}" title="#{$entry['id']} {$entry['pagetitle']|escape}">{if !empty($entry['headline'])}{$entry['headline']|truncate:50}{else}{$entry['pagetitle']|escape}{/if}</a></h3>
                <div class="clearfix spnav spmod" title="{$CONST.LAST_UPDATED}: {$entry['last_modified']|formatTime:'%Y-%m-%d'}">{$entry['timestamp']|formatTime:'%Y-%m-%d'} {if $entry['timestamp'] <= ($entry['last_modified'] - 1800)}<svg aria-hidden="true" class="icon icon-clock"><use xlink:href="#icon-clock"></use></svg>{/if}</div>
            </li>
            <li class="clearfix">
                {$CONST.POSTED_BY} {$sp_listentries_authors[$entry['authorid']]|escape} <span class="sp_dim">[<em class="sp_lang">{$entry['language']}</em>]</span>
                <div class="sp_entry_info clearfix spform">
                    {if $entry['publishstatus'] == false}<span class="entry_status sp_status_draft">{$CONST.DRAFT}</span>{/if}
                    {if $entry['parent_id'] > 0}<span class="entry_status sp_tree_child">{$CONST.STATICPAGE_TREE_CHILD} #{$entry['parent_id']}</span>{/if}

                    <a target="_blank" class="button_link" href="{$serendipityHTTPPath}{$serendipityIndexFile}?serendipity[staticid]={$entry['id']}&amp;serendipity[staticPreview]=1" title="{$CONST.VIEW} #{$entry['id']} ({$entry['pagetitle']|escape})"><span class="icon-search" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.VIEW} #{$entry['pagetitle']|escape}</span></a>
                    <form action="serendipity_admin.php" method="post" name="sp_listentry_{$entry['id']}">
                    <div>
                        <input type="hidden" name="serendipity[adminModule]" value="event_display">
                        <input type="hidden" name="serendipity[adminAction]" value="staticpages">
                        <input type="hidden" name="serendipity[staticpagecategory]" value="pages">
                        <input type="hidden" name="serendipity[staticpage]" value="{$entry['id']}">
                        <input type="hidden" name="serendipity[listentries_formSubmit]" value="true">{* necessary to open form on entrylist POST submits *}
                        <input type="submit" name="serendipity[staticSubmit]" class="icon-edit sp-btn sp-btn-edit" value="&#xe803;" title="{$CONST.EDIT} #{$entry['id']} ({$entry['pagetitle']|escape})">
                        <input type="submit" name="serendipity[staticDelete]" class="icon-trash sp-btn sp-btn-purge" value="&#xe80d;" onclick="return confirm('{$CONST.DELETE_SURE|sprintf:"{$entry['id']} ({$entry['pagetitle']|escape})"}');" title="{$CONST.DELETE} #{$entry['id']} ({$entry['pagetitle']|escape})">
                    </div>
                    </form>
                </div>
            </li>
        </ul>
    </div>

{/foreach}

</div>

    {else} {* if !$sp_listentries_entries || empty($sp_listentries_entries) *}

<div class="msg_notice spmsg">
    <svg aria-hidden="true" class="icon icon-attention"><use xlink:href="#icon-attention"></use></svg> {$CONST.NO_ENTRIES_TO_PRINT}
</div>

    {/if} {* is_array($sp_listentries_entries) end *}

<div class="sp_listfooter">
    <form action="serendipity_admin.php" method="post" name="sp_ListFooter">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display">
        <input type="hidden" name="serendipity[adminAction]" value="staticpages">
        <input type="hidden" name="serendipity[staticpagecategory]" value="pages">
        {$CONST.NEW_ENTRY} <em>{$CONST.WORD_OR|lower}</em> {$CONST.EDIT_ENTRY}: #<input class="input_textbox" type="text" size="3" name="serendipity[staticpage]">
        <input type="hidden" name="serendipity[listentries_formSubmit]" value="true">{* necessary to open form on entrylist post submits *}
        <input type="hidden" name="serendipity[pagetype]" value="__new">
        <input class="input_button state_submit" type="submit" name="serendipity[staticSubmit]" value="{$CONST.GO}">
    </div>
    </form>
</div>

    {/if} {* sp_defpages_showlist false/true end  *}
    {if $sp_pagetype_showform_isnuggets}

<!-- sp_pagetype_showform_isnuggets start -->
<script>
    {** NOTE: for the rare case, someone uses the full CKEDITOR package, including the toolbar CKE save button,
        we need to disable/remove the "save" button for static pages only, since it currently is not compatible with current staticpage form submits.
        Sorry! Do not re-active, or you may lose data, when used/click-saved! The code for this has moved to staticpage_backend.js **}

    function Spawnnugget() {
{foreach $sp_pagetype_showform_htmlnuggets AS $htmlnuggetid}
        if (window.Spawnnuggets) Spawnnuggets('{$htmlnuggetid}');
{/foreach}
    }
</script>
<!-- sp_pagetype_showform_isnuggets end -->
    {/if} {* is nuggets end *}

{/if} {* switch end *}

{if $switch_spcat == 'pageedit' || !$switch_spcat}
<script>
    var spconfig_listPerPage = {$sp_listpp|default:6};
</script>
<script src="{$serendipityHTTPPath}plugins/serendipity_event_staticpage/jquery.simplePagination.js"></script>
{/if}
<script src="{$serendipityHTTPPath}plugins/serendipity_event_staticpage/staticpage_backend.js"></script>

<!-- backend_staticpage.tpl END -->

