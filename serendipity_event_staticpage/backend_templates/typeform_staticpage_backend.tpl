        <!-- smartified typeform_staticpage_backend.tpl -->
        <div id="staticpage_pagetype" class="configuration_group default_staticpage sp_ptype">
            <fieldset>
                <legend>Form Pagetype</legend>
                <div class="clearfix grouped odd form_field sp_sect">
                    <label class="sp_label" title="{staticpage_input item="description" what="desc"}">{staticpage_input item="description" what="name"} <button class="toggle_info button_link" type="button" data-href="#pt_description"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button></label>
                    {staticpage_input item="description"}
                    <span id="pt_description" class="field_info additional_info sp_ptype_desc">{staticpage_input item="description" what="desc"}</span>
                </div>
                <div class="clearfix grouped even form_field sp_sect">
                    <label class="sp_label" title="{staticpage_input item="template" what="desc"}">{staticpage_input item="template" what="name"} <button class="toggle_info button_link" type="button" data-href="#pt_template"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button></label>
                    {staticpage_input item="template"}
                    <span id="pt_template" class="field_info additional_info sp_ptype_desc">{staticpage_input item="template" what="desc"}</span>
                </div>
                <div class="clearfix grouped odd form_field sp_sect">
                    <label class="sp_label" title="{staticpage_input item="image" what="desc"}">{staticpage_input item="image" what="name"} <button class="toggle_info button_link" type="button" data-href="#pt_image"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> {$CONST.MORE}</span></button></label>
                    {staticpage_input item="image"}
                    <span id="pt_image" class="field_info additional_info sp_ptype_desc">{staticpage_input item="image" what="desc"}</span>
                </div>
            </fieldset>
        </div>
