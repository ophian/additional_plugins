{if $linktrimmer_external}
<!DOCTYPE html>
<html{if $linktrimmer_darkmode} data-color-mode="dark"{else} data-color-mode="slight"{/if} class="no-js page_linktrm" dir="ltr" lang="{$lang}">
<head>
    <meta charset="{$CONST.LANG_CHARSET}">
    <title>{$CONST.PLUGIN_LINKTRIMMER_NAME}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{$serendipityBaseURL}serendipity.css.php?serendipity[css_mode]=serendipity_admin.css">
    <script src="{serendipity_getFile file='admin/js/modernizr.min.js'}"></script>

    <style>{* popup only classes *}

        .serendipity_linktrimmer_page .linktrimmer {
            display: block;
            margin: 1em auto auto;
        }
        #main_linktrimmer {
            border: 1px solid #BBB;
            background: none repeat scroll 0% 0% #EEE;
            padding: 0.75em;
            margin: 0px 0px 1em;
        }
        #main_linktrimmer legend {
            border: 1px solid #72878A;
            background: none repeat scroll 0% 0% #DDD;
            padding: 2px 5px;
        }
        #linktrimmer_url.input_textbox { width: inherit; }
    </style>
</head>
<body id="serendipity_admin_page" class="serendipity_linktrimmer_page">
    <main id="workspace" class="clearfix">
        <div id="content" class="clearfix">
{/if}

{if $linktrimmer_external}
<div class="linktrimmer">
{else}
<section id="dashboard_linktrimmer" class="quick_list dashboard_widget">
    <h3>{$CONST.PLUGIN_LINKTRIMMER_NAME}</h3>
{/if}
    <form action="" method="post">
        <input type="hidden" name="txtarea" value="{$linktrimmer_txtarea|escape:'url'}">
        <fieldset id="main_linktrimmer" class="">
        {if $linktrimmer_external}
            <legend>{$CONST.PLUGIN_LINKTRIMMER_NAME}</legend>
        {/if}

        {if $linktrimmer_error}
            <span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> {$CONST.PLUGIN_LINKTRIMMER_ERROR}</span>
        {/if}

            <div class="form_field">
                <label for="linktrimmer_url">{$CONST.PLUGIN_LINKTRIMMER_ENTER}</label>
                <input id="linktrimmer_url" class="input_textbox" type="text" value="" name="linktrimmer_url" placeholder="http://www.s9y.org">
    {if $linktrimmer_external === false}
            </div>

            <div class="form_field">
    {/if}
                <label for="linktrimmer_hash">{$CONST.PLUGIN_LINKTRIMMER_HASH}</label>
                <input id="linktrimmer_hash" class="input_textbox" type="text" value="" name="linktrimmer_hash" size="14">
            </div>

            <div class="form_field">
                <input type="submit" name="submit" value="{$CONST.GO}" class="input_button">
            </div>

    {if $linktrimmer_url != '' && $linktrimmer_external}
            <script>
        {if !$linktrimmer_ispopup}
                window.parent.parent.serendipity.serendipity_imageSelector_addToBody('<a href="{$linktrimmer_url|escape}" title="{$linktrimmer_origurl|escape}">{$linktrimmer_origurl|escape}</a>', '{$linktrimmer_txtarea|escape}');
                window.parent.parent.$.magnificPopup.close();
        {else}
                self.opener.serendipity.serendipity_imageSelector_addToBody('<a href="{$linktrimmer_url|escape}" title="{$linktrimmer_origurl|escape}">{$linktrimmer_origurl|escape}</a>', '{$linktrimmer_txtarea|escape}');
                self.close();
        {/if}
            </script>
    {elseif $linktrimmer_url != ''}
            <div class="form_field">
                <label for="linktrimmer_result">{$CONST.PLUGIN_LINKTRIMMER_RESULT}</label>
                <input id="linktrimmer_result" class="input_textbox" type="text" value="{$linktrimmer_url|escape}" name="linktrimmer_result">
                <script>
                    document.getElementById('linktrimmer_result').select();
                    document.getElementById('linktrimmer_result').focus();
                </script>
            </div>
    {else}
            <script>
                document.getElementById('linktrimmer_url').select();
                document.getElementById('linktrimmer_url').focus();
            </script>
    {/if}
        </fieldset>
    </form>
{if $linktrimmer_external}
</div>
{else}
</section>
{/if}

{if $linktrimmer_external}
        </div>
    </main>
</body>
</html>
{/if}
