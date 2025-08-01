<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_custom_permalinks extends serendipity_event
{
    var $ids = array();
    var $title = PLUGIN_EVENT_CUSTOM_PERMALINKS;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_EVENT_CUSTOM_PERMALINKS);
        $propbag->add('description', PLUGIN_EVENT_CUSTOM_PERMALINKS_DESC);
        $propbag->add('event_hooks',  array(
                                        'genpage'                           => true,
                                        'backend_publish'                   => true,
                                        'css_backend'                       => true,
                                        'entry_display'                     => true,
                                        'backend_save'                      => true,
                                        'frontend_display:html:per_entry'   => true,
                                        'backend_display'                   => true));

        $propbag->add('author', 'Garvin Hicking, Ian Styx');
        $propbag->add('version', '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function show($id)
    {
        global $serendipity;

        $id = (int)$id;

        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }

        serendipity_track_referrer($id);
        $GLOBALS['track_referer'] = false;

        $_GET['serendipity']['action'] = 'read';
        $_GET['serendipity']['id']     = $id;

        $serendipity['plugindata']['smartyvars']['view'] = $serendipity['view'] = 'plugin';  // vs 'entry' helps to avoid 404 page not found message

        $title = serendipity_db_query("SELECT title FROM {$serendipity['dbPrefix']}entries WHERE id=$id", true);
        $serendipity['head_title']    = $title[0];
        $serendipity['head_subtitle'] = $serendipity['blogTitle'];
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_CUSTOM_PERMALINKS;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'genpage':
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $addData['uriargs'];
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $addData['uriargs'];
                    }

                    // do not allow default example page
                    if (false !== strpos($nice_url, 'unknown.html')) {
                        break;
                    }

                    $myi = strpos($nice_url, '&');
                    if ($myi != 0 && $serendipity['rewrite'] != 'none') {
                        $nice_url = substr($nice_url, 0, $myi);
                    }

                    $query = "SELECT entryid FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'permalink'
                                     AND value IN ('" . serendipity_db_escape_string($nice_url) . "', '/" . serendipity_db_escape_string($nice_url) . "')";

                    $retid = serendipity_db_query($query);
                    if (is_array($retid) && !empty($retid[0]['entryid'])) {
                        $this->show($retid[0]['entryid']);
                    }
                    break;

                case 'entry_display':
                    $ids = array();
                    if (!is_array($eventData)) {
                        break;
                    }

                    $ids = array();
                    foreach ($eventData AS $entry) {
                        $ids[] = $entry['id'] ?? -1; // eg. a DRAFT
                    }

                    if (empty($ids[0])) {
                        break;
                    }

                    $query = "SELECT entryid,value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . implode(', ', $ids) . ") AND property = 'permalink'";
                    $retval = serendipity_db_query($query);
                    if (is_array($retval)) {
                        foreach((array)$retval AS $pl) {
                            $this->ids[$pl['entryid']] = $pl['value'];
                        }
                    }
                    break;

                case 'frontend_display:html:per_entry':
                    if (isset($this->ids[$eventData['id']]) && stristr(strtolower($this->ids[$eventData['id']]), '/unknown') === FALSE) {
                        $eventData['link'] =  $this->ids[$eventData['id']];
                        $urldata = parse_url($serendipity['baseURL']);
                        $eventData['rdf_ident'] = $urldata['scheme'] . '://' . $urldata['host'] . $this->ids[$eventData['id']];
                    }
                    break;

                case 'css_backend':
                    // append css
                    $eventData .= '

/* serendipity_event_custom_permalink backend start */

#properties_permalink,
meta_properties_permalink {
    width: 100%;
}
#meta_properties_permalink .msg_notice {
    margin-top: 0;
    margin-bottom: 0;
}

/* serendipity_event_custom_permalink backend end */

';
                    break;

                case 'backend_display':
                    $permalink = !empty($serendipity['POST']['permalink']) ? $serendipity['POST']['permalink'] : '';

                    if (!empty($eventData['id']) && empty($permalink)) {
                        $query = "SELECT value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '" . $eventData['id'] . "' AND property = 'permalink'";
                        $retval = serendipity_db_query($query);
                        if (is_array($retval) && !empty($retval[0]['value'])) {
                            $permalink = $retval[0]['value'];
                        }
                    }

                    $title = $eventData['title'] ?? null;
                    if (empty($title)) {
                        $title = 'unknown';
                    }

                    if (empty($permalink)) {
                        $permalink = $serendipity['rewrite'] != 'none'
                                   ? $serendipity['serendipityHTTPPath'] . 'permalink/' . serendipity_makeFilename($title) . '.html'
                                   : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/permalink/' . serendipity_makeFilename($title) . '.html';
                    }
?>
            <fieldset id="edit_entry_custompermalinks" class="entryproperties_custompermalinks">
                <span class="wrap_legend">
                    <legend>
                        <?php echo PLUGIN_EVENT_CUSTOM_PERMALINKS_PL; ?>
                        <button class="toggle_info button_link active" type="button" data-href="#meta_properties_permalink">
                            <span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MORE; ?></span>
                        </button>
                    </legend>
                </span>
                <div class="form_field">
                    <input id="properties_permalink" class="input_textbox" type="text" style="width: 100%;" name="serendipity[permalink]" value="<?php echo htmlspecialchars($permalink); ?>">
                </div>
                <div id="meta_properties_permalink" class="clearfix xfield_info additional_info">
                    <span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> <?php echo PLUGIN_EVENT_CUSTOM_PERMALINKS_PL_DESC; ?></span>
                </div>
            </fieldset>

<?php
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['permalink']) || !isset($eventData['id']) || false !== strpos($serendipity['POST']['permalink'], 'unknown.html')) {
                        return true;
                    }
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '" . $eventData['id'] . "' AND property = 'permalink'");
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, value, property) VALUES ('" . $eventData['id'] . "', '" . serendipity_db_escape_string($serendipity['POST']['permalink']) . "', 'permalink')");
                    break;

                default:
                    return false;

            }
            return true;
        } else {
            return false;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>