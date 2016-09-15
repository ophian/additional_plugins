
<!-- plugin_faq_category_faq.tpl start -->

<div id="serendipity_faq_plugin" class="clearfix serendipity_entry faq-category">
    <div id="serendipityFAQNav" class="faq-nav">
        <p><a href="{$serendipityBaseURL}">{$CONST.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$CONST.FAQ_CATEGORIES}</a>

        {foreach $cat_tree AS $cat}
            &gt; {if $cat.id != $faq_plugin.catid}<a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">{/if}{$cat.category}{if $cat.id != $faq_plugin.catid}</a>{/if}
        {/foreach}
        </p>
    </div>

    <h3>{$faq_plugin.this_faq.category}</h3>

    <p><b>{$CONST.FAQ_QUESTION}:</b> {$faq_plugin.this_faq.question}</p>
    <p><b>{$CONST.FAQ_ANSWER}:</b> {$faq_plugin.this_faq.answer}</p>

    <p><icon class="faq_question-icon"></icon> {$CONST.FAQ_PREVOUS} <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq_plugin.prev_faq.categoryid}/{$faq_plugin.prev_faq.faqid}">{$faq_plugin.prev_faq.question|truncate:30:'...'}</a></p>
    <p><icon class="faq_question-icon"></icon> {$CONST.FAQ_NEXT} <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq_plugin.next_faq.categoryid}/{$faq_plugin.next_faq.faqid}">{$faq_plugin.next_faq.question|truncate:30:'...'}</a></p>
</div>

<!-- plugin_faq_category_faq.tpl end -->
