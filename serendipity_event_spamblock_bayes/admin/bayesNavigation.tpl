{if $jquery_needed == true}
    <script src="{$serendipityHTTPPath}{$templatePath}jquery.js"></script>
{/if}
<style> {$css} </style>
<script src="{$path}serendipity_event_spamblock_bayes.js" type="text/javascript"></script>
<h2>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME}</h2>
<div id="bayesNav">
    <ul>
        <li{if $subpage == 1} class="current"{/if}>
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=1">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER}</a>
        </li>
        <li{if $subpage == 2} class="current"{/if}>
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE}</a>
        </li>
        <li{if $subpage == 3} class="current"{/if}>
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=3">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN}</a>
        </li>
        <li{if $subpage == 4} class="current"{/if}>
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=4">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS}</a>
        </li>
        <li{if $subpage == 5} class="current"{/if}>
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=5">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT}</a>
        </li>
    </ul>
</div>
