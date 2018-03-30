<div id="bayesContent">
    <span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> {$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION}</span>

    <form enctype="multipart/form-data" action="{$serendipityBaseURL}index.php?/plugin/spamblock_bayes_import" method="post">
        <div class="form_field">
            <input name="importcsv" type="file" />
            <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.GO}" />
        </div>
    </form>

    <h3>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA}</h3>

    <span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> {$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION}</span>

    <form class="bayesTrojaButtons" action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRequestDB" method="post">
        <input id="trojaImport" class="serendipityPrettyButton input_button" type="submit" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT}" />
    </form>
    {if $trojaRegistered}
    <form class="bayesTrojaButtons" action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRemove" method="post">
        <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE}" />
    </form>
    {else}
    <form class="bayesTrojaButtons" action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRegister" method="post">
        <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER}" />
    </form>
    {/if}
</div>
