<!-- plugin_faq_category_faq.tpl start -->
<!-- modifications January 2007 to duplicate design of entry page -->
<!-- modifications September 2016 for Smarty3 usage - though not being futher touched compared with the new plugin frontend template file modifications -->

<div class="serendipity_Entry_Date">
<h3 class="serendipity_date">{$CONST.FAQ_NAME}</h3>
<h4 class="serendipity_title"><a href="#">{$faq_plugin.this_faq.category}</a></h4>
     <div class="serendipity_entry">
          <div class="serendipity_entry_body">
               <div id="serendipityFAQNav">
                    <p><a href="{$serendipityBaseURL}">{$CONST.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$CONST.FAQ_CATEGORIES}</a>
                         {foreach $cat_tree AS $cat}&gt;
                              {if $cat.id != $faq_plugin.catid}
                                   <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">
                              {/if}
                              {$cat.category}
                              {if $cat.id != $faq_plugin.catid}
                                   </a>
                              {/if}
                         {/foreach}
                    </p>
               </div>
<!-- line below is redundant with h4 title above, but some users might like to include it anyway -->
<!-- <h3>{$faq_plugin.this_faq.category}</h3> -->
               <p><b>{$CONST.FAQ_QUESTION}:</b> {$faq_plugin.this_faq.question}</p><br />
               <p><b>{$CONST.FAQ_ANSWER}:</b> {$faq_plugin.this_faq.answer}</p><br />
               <p>{$CONST.FAQ_PREVOUS} <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq_plugin.prev_faq.categoryid}/{$faq_plugin.prev_faq.faqid}">{$faq_plugin.prev_faq.question|truncate:30:'...'}</a></p>
               <p>{$CONST.FAQ_NEXT} <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq_plugin.next_faq.categoryid}/{$faq_plugin.next_faq.faqid}">{$faq_plugin.next_faq.question|truncate:30:'...'}</p>
          </div>
     </div>
</div>

<div class='serendipity_entryFooter' style="text-align: center">
</div>
<!-- plugin_faq_category_faq.tpl end -->
