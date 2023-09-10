
<!-- RESPONSIVE_TEMPLATE.TPL start -->

<div id="backend_sp_respond" class="default_staticpage">

    <fieldset id="sp_main_data" class="sect_basic">
        <legend>{$CONST.STATICPAGE_SECTION_BASIC}</legend>
        <span class="sp_legend_submit">
            <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="serendipityPrettyButton input_button state_submit">
            <span class="sp_toggle_navigator">
                <button class="toggle_info button_link" type="button" data-href="#sp_navigator">
                    <span class="icon-right-dir" aria-hidden="true"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                      <title>{$CONST.TOGGLE_TOP_NAV}</title>
                      <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                    </svg>
                </button>
            </span>
        </span>
        <div id="entry_main_headline" class="form_field_long sp_sect">
            <label class="sp_label" title="{staticpage_input item="headline" what="desc"}">{staticpage_input item="headline" what="name"}</label>
                {staticpage_input item="headline"}
        </div>

        <div id="entry_main_aftitle" class="form_field_long sp_sect">
            <label class="sp_label" title="{staticpage_input item="articleformattitle" what="desc"}">{staticpage_input item="articleformattitle" what="name"}</label>
                {staticpage_input item="articleformattitle"}
        </div>

        <div id="entry_main_data">
            <div id="entry_meta_urltitle" class="form_field sp_sect">
                <label class="sp_label sp_button" title="{staticpage_input item="pagetitle" what="desc"}">{staticpage_input item="pagetitle" what="name"}</label>
                <button class="toggle_info button_link" type="button" data-href="#meta_urltitle_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button>
                    {staticpage_input item="pagetitle"}
                <div id="meta_urltitle_info" class="clearfix field_info additional_info">
                    <span id="urltitle_info" class="field_info">
                        {$CONST.PLAIN_ASCII}
                    </span>
                </div>
            </div>

            <div id="entry_meta_permalink" class="form_field sp_sect">
                <label class="sp_label sp_button" title="{staticpage_input item="permalink" what="desc"}">{staticpage_input item="permalink" what="name"}</label>
                <button class="toggle_info button_link" type="button" data-href="#meta_permalink_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button>
                    {staticpage_input item="permalink"}
                <div id="meta_permalink_info" class="clearfix field_info additional_info">
                    <span id="permalink_info" class="field_info">
                        {$CONST.PLAIN_ASCII}
                    </span>
                </div>
            </div>
        </div>

        <div class="clearfix sp_sect"></div>

        <div id="entry_main_content" class="sp_sect">
            <label class="sp_label" title="{staticpage_input item="content" what="desc"}">{staticpage_input item="content" what="name"}</label>
                {staticpage_input item="content"}
        </div>

    </fieldset>

    {if $showmeta}
    <div class="sp_sect configuration_group">
        <h3 class="toggle_headline"><button id="optionel1" class="toggle_info show_config_option sp_toggle" type="button" data-href="#el1" title="{$CONST.STATICPAGE_TOGGLEANDSAVE|sprintf:$CONST.TOGGLE_OPTION}"><span class="icon-right-dir" aria-hidden="true"></span> {$CONST.STATICPAGES_CUSTOM_META_SHOW}</button></h3>
    </div>

    <div id="el1" class="config_optiongroup additional_info">

        <fieldset id="sp_metafield_data" class="sect_struct">
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
    </div>
    {/if}

    <div class="sp_sect configuration_group">
    {if empty($is_wysiwyg)}{* $is_wysiwyg means old xinha or others than CKE! *}
        <h3 class="toggle_headline"><button id="optionel2" class="toggle_info show_config_option sp_toggle" type="button" data-href="#el2" title="{$CONST.STATICPAGE_TOGGLEANDSAVE|sprintf:$CONST.TOGGLE_OPTION}"><span class="icon-right-dir" aria-hidden="true"></span> {$CONST.STATICPAGES_CUSTOM_STRUCTURE_SHOW}</button></h3>
    {/if}
    </div>

    <div id="el2" class="config_optiongroup additional_info">

        <fieldset id="sp_structure_data" class="clearfix sect_struct">
        <legend>{$CONST.STATICPAGE_SECTION_STRUCT}</legend>
            <div id="entry_struc_name" class="form_field sp_sect">{* S1 *}
                <label class="sp_label" title="{staticpage_input item="authorid" what="desc"}">{staticpage_input item="authorid" what="name"}</label>
                    {staticpage_input item="authorid"}
            </div>

            <div id="entry_struc_desc" class="form_field sp_sect">{* S2 *}
                <label class="sp_label" title="{staticpage_input item="articletype" what="desc"}">{staticpage_input item="articletype" what="name"}</label>
                    {staticpage_input item="articletype"}
            </div>

            <div id="entry_struc_date" class="form_field sp_sect">{* S3 *}
                <label class="sp_label" title="{staticpage_input item="timestamp" what="desc"}">{staticpage_input item="timestamp" what="name"}</label>
                    {staticpage_input item="timestamp"}
            </div>

            <div id="entry_struc_lang" class="form_field sp_sect">{* O2 *}
                <label class="sp_label sp_button" title="{staticpage_input item="language" what="desc"}">{staticpage_input item="language" what="name"}</label>
                <button class="toggle_info button_link" type="button" data-href="#entry_language_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button>
                    {staticpage_input item="language"}
                <div id="entry_language_info" class="clearfix field_info additional_info">
                    <span id="sp_language_info" class="field_info">
                        {$CONST.STATICPAGE_LANGUAGE_INFO}
                    </span>
                </div>
            </div>

            <div id="entry_struc_password" class="form_field sp_sect">{* O8 *}
                <label class="sp_label" title="{staticpage_input item="pass" what="desc"}">{staticpage_input item="pass" what="name"}</label>
                    {staticpage_input item="pass"}
            </div>

            <div id="entry_struc_cat" class="form_field sp_sect">{* S4 *}
                <label class="sp_label sp_button" title="{staticpage_input item="related_category_id" what="desc"}">{staticpage_input item="related_category_id" what="name"}</label>
                <button class="toggle_info button_link" type="button" data-href="#entry_relcat_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button>
                    {staticpage_input item="related_category_id"}
                <div id="entry_relcat_info" class="clearfix field_info additional_info">
                    <span id="related_category_info" class="field_info">
                        {$CONST.STATICPAGE_RELCAT_INFO|sprintf:"{$serendipityHTTPPath}plugins/serendipity_event_staticpage/README_FOR_RELATED_CATEGORIES.txt"}
                    </span>
                </div>
            </div>

            <div id="entry_struc_format" class="form_field form_radio sp_sect">{* O6 *}
                <label class="sp_label" title="{staticpage_input item="markup" what="desc"}">{staticpage_input item="markup" what="name"}</label>
                    {staticpage_input item="markup"}
            </div>

            <div id="entry_struc_article" class="form_field form_radio sp_sect">{* O7 *}
                <label class="sp_label" title="{staticpage_input item="articleformat" what="desc"}">{staticpage_input item="articleformat" what="name"}</label>
                    {staticpage_input item="articleformat"}
            </div>

            <div id="entry_struc_precon" class="form_area sp_sect">{* S9 *}
                <label class="sp_label" title="{staticpage_input item="pre_content" what="desc"}">{staticpage_input item="pre_content" what="name"}</label>
                    {staticpage_input item="pre_content"}
            </div>
        </fieldset>

    </div>


    <div class="sp_sect configuration_group">
        <h3 class="toggle_headline"><button id="optionel3" class="toggle_info show_config_option sp_toggle" type="button" data-href="#el3" title="{$CONST.STATICPAGE_TOGGLEANDSAVE|sprintf:$CONST.TOGGLE_OPTION}"><span class="icon-right-dir" aria-hidden="true"></span> {$CONST.STATICPAGES_CUSTOM_OPTION_SHOW}</button></h3>
    </div>

    <div id="el3" class="config_optiongroup additional_info">

        <fieldset id="sp_option_data" class="clearfix sect_opt">
            <legend>{$CONST.STATICPAGE_SECTION_OPT}</legend>
            <div id="entry_option_start" class="form_field form_radio sp_sect">{* O3 *}
                <label class="sp_label" title="{staticpage_input item="is_startpage" what="desc"}">{staticpage_input item="is_startpage" what="name"}</label>
                    {staticpage_input item="is_startpage"}
            </div>

            <div id="entry_option_404" class="form_field form_radio sp_sect">{* O4 *}
                <label class="sp_label" title="{staticpage_input item="is_404_page" what="desc"}">{staticpage_input item="is_404_page" what="name"}</label>
                    {staticpage_input item="is_404_page"}
            </div>

            <div id="entry_option_status" class="form_field sp_sect">{* O1 *}
                <label class="sp_label" title="{staticpage_input item="publishstatus" what="desc"}">{staticpage_input item="publishstatus" what="name"}</label>
                    {staticpage_input item="publishstatus"}
            </div>

            <div id="entry_option_nav" class="form_field form_radio sp_sect">{* O5 *}
                <label class="sp_label" title="{staticpage_input item="showonnavi" what="desc"}">{staticpage_input item="showonnavi" what="name"}</label>
                    {staticpage_input item="showonnavi"}
            </div>

            <div id="entry_option_nav" class="form_field form_radio sp_sect">{* S7 *}
                <label class="sp_label" title="{staticpage_input item="shownavi" what="desc"}">{staticpage_input item="shownavi" what="name"}</label>
                    {staticpage_input item="shownavi"}
            </div>

            <div id="entry_option_bcrump" class="form_field form_radio sp_sect">{* S8 *}
                <label class="sp_label" title="{staticpage_input item="show_breadcrumb" what="desc"}">{staticpage_input item="show_breadcrumb" what="name"}</label>
                    {staticpage_input item="show_breadcrumb"}
            </div>

            <div id="entry_option_parent" class="form_field sp_sect">{* S5 *}
                <label class="sp_label" title="{staticpage_input item="parent_id" what="desc"}">{staticpage_input item="parent_id" what="name"}</label>
                    {staticpage_input item="parent_id"}
            </div>

            <div id="entry_option_child" class="form_field form_radio sp_sect">{* S6 *}
                <label class="sp_label" title="{staticpage_input item="show_childpages" what="desc"}">{staticpage_input item="show_childpages" what="name"}</label>
                    {staticpage_input item="show_childpages"}
            </div>
        </fieldset>

    </div>

</div>

{staticpage_input_finish}

<div class="sp_responsform_submit">
    <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="serendipityPrettyButton input_button state_submit">
</div>

<script>
    $('.sp_toggle').click(function () {
        var $id   = $(this).attr('id');
        var $name = 'staticpage_mobileform_' + $id;
        var cb    = localStorage.getItem($name);
        if ( cb !== null ) {
            $('#'+$id+' > .icon-down-dir').removeClass('icon-down-dir').addClass('icon-right-dir');
            localStorage.removeItem($name);
        } else {
            $('#'+$id+' > .icon-right-dir').removeClass('icon-right-dir').addClass('icon-down-dir');
            setLocalStorage($name, true);
        }
    });

    const TOPNAV = '.sp_toggle_navigator > .toggle_info';

    // remember stored top nav toggled true
    if (localStorage.getItem('staticpage_topnav_toggle') !== null) {
        $('#sp_navigator').removeClass('additional_info');
        $(TOPNAV+' > .icon-right-dir').removeClass('icon-right-dir').addClass('icon-up-dir');
    }
    $(TOPNAV).click(function () {
        var $tnt  = 'staticpage_topnav_toggle';
        var nb    = localStorage.getItem($tnt);
        // on click true case
        if ( nb !== null ) {
            $(TOPNAV+' > .icon-up-dir').removeClass('icon-up-dir').addClass('icon-right-dir');
            localStorage.removeItem($tnt);
        } else {
            $(TOPNAV+' > .icon-right-dir').removeClass('icon-right-dir').addClass('icon-up-dir');
            setLocalStorage($tnt, true);
        }
    });
</script>

<!-- RESPONSIVE_TEMPLATE.TPL end -->

