<?php
class GeoTagDb
{
    static function delete($entryId, $supported_properties)
    {
        global $serendipity;

        if (empty($entryId)) return;
        foreach($supported_properties AS $prop_key) {
            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$entryId . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
            serendipity_db_query($q);
        }
    }

    static function addEntryProperties($entryId, $supported_properties, &$properties, $deleteMissing = true)
    {
        global $serendipity;
        // Get existing data
        $property = serendipity_fetchEntryProperties($entryId);

        foreach($supported_properties AS $prop_key) {
            $prop_val = (isset($properties[$prop_key]) ? $properties[$prop_key] : null);
            if (!$deleteMissing && empty($prop_val)) continue; // Don't clear data if not allowed.
            $q = '';
            if (!isset($property[$prop_key]) && !empty($prop_val)) {
                if ($prop_val!='#') {
                    $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$entryId . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                }
            } elseif ($property[$prop_key] != $prop_val && !empty($prop_val)) {
                if ($prop_val=='#') {
                    $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$entryId . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                }
                else {
                    $q = "UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '" . serendipity_db_escape_string($prop_val) . "' WHERE entryid = " . (int)$entryId . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                }
            } elseif (empty($property[$prop_key])){
                $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$entryId . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
            }
            if (!empty($q)) serendipity_db_query($q);
        }
    }

}
