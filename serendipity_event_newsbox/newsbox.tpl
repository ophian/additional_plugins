<!-- NEWSBOX ENTRIES START -->
    <fieldset class="newsbox"><legend class="newsbox_title">{$newsbox_data.title}</legend>
    {foreach $entries AS $dategroup}
        <div class="serendipity_Entry_Date">
        {if $dategroup.is_sticky}
            <h4 class="serendipity_date">{$CONST.STICKY_POSTINGS}</h4>
        {/if}

        {foreach $dategroup.entries AS $entry}
            {assign var="entry" value=$entry scope="root"}{* See scoping issue(s) for comment "_self" *}
            <div class="shadow">
              <div class="serendipity_entry serendipity_entry_author_{$entry.author|makeFilename} {if NOT empty($entry.is_entry_owner)}serendipity_entry_author_self{/if} drop newsbox_entry">
                <h3 class="serendipity_title"><a href="{$entry.link}">{$entry.title}</a></h3>
                <h4 class="serendipity_date">{$dategroup.date|formatTime:DATE_FORMAT_ENTRY}</h4>

                <div class="serendipity_entry_body">
                    {$entry.body}
                </div>

            {if $entry.has_extended}
                <p><a href="{$entry.link}#extended">{$CONST.VIEW_EXTENDED_ENTRY|sprintf:$entry.title}</a></p>
            {/if}

              </div>
            </div>
            <!--
            <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                     xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/"
                     xmlns:dc="http://purl.org/dc/elements/1.1/">
            <rdf:Description
                     rdf:about="{$entry.link_rdf}"
                     trackback:ping="{$entry.link_trackback}"
                     dc:title="{$entry.title_rdf|default:$entry.title}"
                     dc:identifier="{$entry.rdf_ident}" />
            </rdf:RDF>
            -->
        {/foreach}
        </div>
    {foreachelse}
    {if NOT $plugin_clean_page AND $view != '404'}
        <p class="nocontent">{$CONST.NO_ENTRIES_TO_PRINT}</p>
    {/if}
    {/foreach}
{if $is_nbpagination}

        <div class="serendipity_entries_footer">
            <form style="display:inline;" action="{$newsbox_data.multicat_action}" method="post">
            {foreach $newsbox_data.cats AS $cat_id}
                <input type="hidden" name="serendipity[multiCat][]" value="{$cat_id}">
            {/foreach}
                <input type="submit" name="serendipity[isMultiCat]" value="{$CONST.MORE} {$newsbox_data.title}">
            </form>
        </div>
{/if}

    </fieldset>
<!-- NEWBOX ENTRIES END -->
