
<!-- plugin_faq_category_faqs.tpl start -->

<div id="serendipity_faq_plugin" class="clearfix serendipity_entry faq-categoryfaqs">
    <div id="serendipityFAQNav" class="faq-nav">
        <p>
            <a href="{$serendipityBaseURL}">{$smarty.const.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$smarty.const.FAQ_CATEGORIES}</a>

        {foreach $cat_tree AS $cat}
            &gt; {if $cat.id != $faq_plugin.catid}<a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">{/if}{$cat.category}{if $cat.id != $faq_plugin.catid}</a>{/if}
        {/foreach}
        </p>
    </div>

    <h3>{$faq_plugin.category}</h3>
    {if $faq_plugin.introduction}<p>{$faq_plugin.introduction}</p>{/if}

    {if is_array($faq_plugin.subcategories)}
        <ul>
        {foreach $faq_plugin.subcategories AS $subcat}
            <li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$subcat.id}">{$subcat.category}</a></li>
        {/foreach}
        </ul>
    {/if}

    {if is_array($faq_plugin.faqs)}
        <ul>
        {foreach $faq_plugin.faqs AS $faq}
            <li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq.cid}/{$faq.id}">{$faq.question}</a> {$faq.status}</li>
        {/foreach}
        </ul>
    {/if}
</div>

<!-- plugin_faq_category_faqs.tpl end -->
