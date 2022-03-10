// serendipity_event_entrypaging plugin workaround, to be able to use our own Smarty function for output in entries.tpl
function smarty_entrypagination($params, $template) {
    $plink = isset($template->smarty->tpl_vars['pagination_prev_link']) ? $template->smarty->tpl_vars['pagination_prev_link'] : null;
    $nlink = isset($template->smarty->tpl_vars['pagination_next_link']) ? $template->smarty->tpl_vars['pagination_next_link'] : null;
    $tic = '<svg viewbox="0 0 100 100"><path class="arrow" d="M 50,0 L 60,10 L 20,50 L 60,90 L 50,100 L 0,50 Z" /></svg>';
    if ($plink || $nlink) {
        echo "
<style>
    #serendipity_smarty_entrypaging { display: inline-block; width: 100%; height: 34px; margin: 1rem auto; }
    #serendipity_smarty_entrypaging div { width: 32px; }
    .serendipity_smarty_entrypaging .arrow { fill: #333; }
    .smarty_pagination_left { float: left; margin-left: 1rem; }
    .smarty_pagination_right { float: right; margin-right: 1rem; }
    .smarty_pagination_right svg { transform: rotateY(180deg); }
    #serendipity_smarty_entrypaging div::after { clear: both; }
</style>\n";
        echo "<div id=\"serendipity_smarty_entrypaging\">\n";
        if ($plink) {
            echo "<div class=\"smarty_pagination_left\"><a href=\"$plink\" title=\"{$template->smarty->tpl_vars['pagination_prev_title']}\">$tic</a></div>\n";
        }
        if ($nlink) {
            echo "<div class=\"smarty_pagination_right\"><a href=\"$nlink\" title=\"{$template->smarty->tpl_vars['pagination_next_title']}\">$tic</a></div>\n";
        }
        echo "</div>\n";
    }
}

$serendipity['smarty']->registerPlugin('function', 'entrypagination', 'smarty_entrypagination');

Then you can place {entrypagination} anywhere in you entries tpl file and can style it in your templates user.css file (see example styles).

######################################################################################################################

OR just use this snippet to not call that function on every request inside the entries.tpl entry foreach loop (in example above your section id="comments"..):

{if $is_single_entry AND NOT $is_preview AND NOT empty($smarty_entrypaging)}
    <div id="serendipity_smarty_entrypaging">
        {if NOT empty($pagination_prev_link)}
            <div class="smarty_pagination_left"><a href="{$pagination_prev_link}" title="{$pagination_prev_title}"><svg viewbox="-10 -10 120 120"><path d="M 50,0 L 60,10 L 20,50 L 60,90 L 50,100 L 0,50 Z" class="arrow" stroke="black" stroke-width="10" /></svg>{$pagination_prev_title}</a></div> | 
        {/if}
        {if NOT empty($pagination_next_link)}
            <div class="smarty_pagination_right"><a href="{$pagination_next_link}" title="{$pagination_next_title}">{$pagination_next_title}<svg viewbox="-10 -10 120 120"><path d="M 50,0 L 60,10 L 20,50 L 60,90 L 50,100 L 0,50 Z" class="arrow" transform="translate(85,100) rotate(180)" stroke="black" stroke-width="10" /></svg></a></div>
        {/if}
    </div>
{/if}

And this to style it in your user.css file (build for Styx 3.0 pure Standard theme):

#serendipity_smarty_entrypaging {
    background-color: #fafafa;
    border: 1px solid #eee;
    border-radius: 4px;
    box-shadow: 1px 1px 2px rgba(111, 111, 111, 0.5);
    display: -webkit-inline-box;
    margin: .5em 0em 1em;
    padding: .5em;
    width: 100%;
}
#serendipity_smarty_entrypaging svg {
    width: 16px;
    height: auto;
    vertical-align: middle;
}
.smarty_pagination_left {
    margin-right: auto;
}
.smarty_pagination_right {
    margin-left: auto;
}
