
<!-- DEFAULT_STATICPAGE_BACKEND.TPL start -->

<div id="backend_sp_simple" class="default_staticpage">

    <div class="sp_defaultform_left">
        <!-- LEFT -->

        <fieldset class="sect_basic">
            <legend>{$CONST.STATICPAGE_SECTION_BASIC}</legend>
            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="headline" what="desc"}">{staticpage_input item="headline" what="name"}</label>
                {staticpage_input item="headline"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="articleformattitle" what="desc"}">{staticpage_input item="articleformattitle" what="name"}</label>
                {staticpage_input item="articleformattitle"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="content" what="desc"}">{staticpage_input item="content" what="name"}</label>
                {staticpage_input item="content"}
            </div>

            {if $showmeta}
            <div class="sp_sect configuration_group">
                <h3 class="toggle_headline"><button id="optionel1" class="toggle_info show_config_option sp_toggle" type="button" data-href="#el1" title="{$CONST.STATICPAGE_TOGGLEANDSAVE|sprintf:$CONST.TOGGLE_OPTION}"><span class="icon-right-dir" aria-hidden="true"></span> {$CONST.STATICPAGES_CUSTOM_META_SHOW}</button></h3>
            </div>

            <fieldset id="el1" class="config_optiongroup additional_info">
                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="title_element" what="desc"}">{staticpage_input item="title_element" what="name"}</label>
                    {staticpage_input item="title_element"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="meta_description" what="desc"}">{staticpage_input item="meta_description" what="name"}</label>
                    {staticpage_input item="meta_description"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="meta_keywords" what="desc"}">{staticpage_input item="meta_keywords" what="name"}</label>
                    {staticpage_input item="meta_keywords"}
                </div>
            </fieldset>
            {/if}

        </fieldset>

        <fieldset class="sect_struct">
            <legend>{$CONST.STATICPAGE_SECTION_STRUCT}</legend>
            {if empty($is_wysiwyg)}
            <div class="sp_sect configuration_group">
                <h3 class="toggle_headline"><button id="optionel2" class="toggle_info show_config_option sp_toggle" type="button" data-href="#el2" title="{$CONST.STATICPAGE_TOGGLEANDSAVE|sprintf:$CONST.TOGGLE_OPTION}"><span class="icon-right-dir" aria-hidden="true"></span> {$CONST.STATICPAGES_CUSTOM_STRUCTURE_SHOW}</button></h3>
            </div>
            {/if}

            <fieldset id="el2" class="config_optiongroup additional_info">

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="authorid" what="desc"}">{staticpage_input item="authorid" what="name"}</label>
                        {staticpage_input item="authorid"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="articletype" what="desc"}">{staticpage_input item="articletype" what="name"}</label>
                        {staticpage_input item="articletype"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="language" what="desc"}">{staticpage_input item="language" what="name"}
                    <button class="toggle_info button_link" type="button" data-href="#entry_language_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button></label>
                        {staticpage_input item="language"}
                    <div id="entry_language_info" class="clearfix field_info additional_info">
                        <span id="sp_language_info" class="field_info">
                            {$CONST.STATICPAGE_LANGUAGE_INFO}
                        </span>
                    </div>
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="related_category_id" what="desc"}">{staticpage_input item="related_category_id" what="name"}
                    <button class="toggle_info button_link" type="button" data-href="#entry_relcat_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button></label>
                        {staticpage_input item="related_category_id"}
                    <div id="entry_relcat_info" class="clearfix field_info additional_info">
                        <span id="related_category_info" class="field_info">
                            {$CONST.STATICPAGE_RELCAT_INFO|sprintf:"{$serendipityHTTPPath}plugins/serendipity_event_staticpage/README_FOR_RELATED_CATEGORIES.txt"}
                        </span>
                    </div>
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="parent_id" what="desc"}">{staticpage_input item="parent_id" what="name"}</label>
                        {staticpage_input item="parent_id"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="show_childpages" what="desc"}">{staticpage_input item="show_childpages" what="name"}</label>
                        {staticpage_input item="show_childpages"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="shownavi" what="desc"}">{staticpage_input item="shownavi" what="name"}</label>
                        {staticpage_input item="shownavi"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="show_breadcrumb" what="desc"}">{staticpage_input item="show_breadcrumb" what="name"}</label>
                        {staticpage_input item="show_breadcrumb"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="pre_content" what="desc"}">{staticpage_input item="pre_content" what="name"}</label>
                        {staticpage_input item="pre_content"}
                </div>

            </fieldset>
        </fieldset>
    </div>

    <div class="sp_defaultform_right">
        <!-- RIGHT -->
        <fieldset class="sect_meta">
            <legend>{$CONST.STATICPAGE_SECTION_META}</legend>
            <div class="sp_sect">{capture name="pagetitle"}{staticpage_input item="pagetitle" what="name"}{/capture}
                <label class="sp_label sp_button" title="{$smarty.capture.pagetitle}">{$smarty.capture.pagetitle|truncate:30}</label>
                <button class="toggle_info button_link" type="button" data-href="#meta_urltitle_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button>
                    {staticpage_input item="pagetitle"}
                <div id="meta_urltitle_info" class="clearfix field_info additional_info">
                    <span id="urltitle_info" class="field_info">
                        {$CONST.PLAIN_ASCII}
                    </span>
                </div>
            </div>

            <div class="sp_sect">
                <label class="sp_label sp_button" title="{staticpage_input item="permalink" what="desc"}">{staticpage_input item="permalink" what="name"}</label>
                <button class="toggle_info button_link" type="button" data-href="#meta_permalink_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button>
                    {staticpage_input item="permalink"}
                <div id="meta_permalink_info" class="clearfix field_info additional_info">
                    <span id="permalink_info" class="field_info">
                        {$CONST.PLAIN_ASCII}
                    </span>
                </div>
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="pass" what="desc"}">{staticpage_input item="pass" what="name"} <i class="icon-info-circled" aria-hidden="true" title="{$CONST.ENTRY_PAGE_PASSWORD_INFO_SET|escape}"></i></label>
                    {staticpage_input item="pass"}
            </div>

        </fieldset>

        <fieldset class="sect_opt">
            <legend>{$CONST.STATICPAGE_SECTION_OPT}</legend>
            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="publishstatus" what="desc"}">{staticpage_input item="publishstatus" what="name"}</label>
                    {staticpage_input item="publishstatus"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="is_startpage" what="desc"}">{staticpage_input item="is_startpage" what="name"}</label>
                    {staticpage_input item="is_startpage"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="is_404_page" what="desc"}">{staticpage_input item="is_404_page" what="name"}</label>
                    {staticpage_input item="is_404_page"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="showonnavi" what="desc"}">{staticpage_input item="showonnavi" what="name"}</label>
                    {staticpage_input item="showonnavi"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="markup" what="desc"}">{staticpage_input item="markup" what="name"}</label>
                    {staticpage_input item="markup"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="articleformat" what="desc"}">{staticpage_input item="articleformat" what="name"}</label>
                    {staticpage_input item="articleformat"}
            </div>

           <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="timestamp" what="desc"}">{staticpage_input item="timestamp" what="name"}</label>
                    {staticpage_input item="timestamp"}
           </div>

        </fieldset>

        {* EXAMPLE FOR CUSTOM STATICPAGE PROPERTIES

        <fieldset class="sect_custom">
            <legend>Custom</legend>

            <div class="sp_sect">
                <label class="sp_label" title="Choose the main sidebar that should be shown when this staticpage is evaluated">Sidebars</label>
                <select name="serendipity[plugin][custom][sidebars][]" multiple="multiple">
                    <option {if (@in_array('left', $form_values.custom.sidebars))}selected="selected"{/if} value="left">Left</option>
                    <option {if (@in_array('right', $form_values.custom.sidebars))}selected="selected"{/if} value="right">Right</option>
                    <option {if (@in_array('hidden', $form_values.custom.sidebars))}selected="selected"{/if} value="hidden">Hidden</option>
                </select>
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="CSS class of the main page body that should be associated">Main CSS class</label>
                    <input type="text" name="serendipity[plugin][custom][css_class]" value="{$form_values.custom.css_class|default:'None'}">
            </div>
        </fieldset>
         END OF EXAMPLE FOR CUSTOM STATICPAGE PROPERTIES *}

        <div class="sp_defaultform_submit">
            <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="input_button">
        </div>

    </div>
</div>


{staticpage_input_finish}

<div class="sp_defaultform_submit sp_input_finish">
    <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="input_button">
</div>

<script>
    $('.sp_toggle').click(function () {
        var $id   = $(this).attr('id');
        var $name = 'staticpage_defaultform_' + $id;
        var cb    = localStorage.getItem($name);
        if ( cb !== null ) {
            $('#'+$id+' > .icon-down-dir').removeClass('icon-down-dir').addClass('icon-right-dir');
            localStorage.removeItem($name);
        } else {
            $('#'+$id+' > .icon-right-dir').removeClass('icon-right-dir').addClass('icon-down-dir');
            setLocalStorage($name, true);
        }
    });
    $('#sp_navigator').addClass('additional_info ping'); // overwrite toggle re-movement of the better forms
</script>

<!-- DEFAULT_STATICPAGE_BACKEND.TPL end -->

