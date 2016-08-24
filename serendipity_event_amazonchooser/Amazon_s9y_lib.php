<?php
/*
https://docs.aws.amazon.com/AWSECommerceService/latest/DG/AnatomyOfaRESTRequest.html

BR
http://webservices.amazon.com.br/onca/xml

IN
http://webservices.amazon.in/onca/xml

MX
http://webservices.amazon.com.mx/onca/xml

*/

function Amazon_country_code($country)  {
    switch ($country) {
       case 'ca':
           $country_url = "http://webservices.amazon.ca/onca/xml";
           $mode = array (
                'Blended',
                'Books',
                'Classical',
                'DigitalMusic',
                'DVD',
                'Electronics',
                'ForeignBooks',
                'Music',
                'Software',
                'SoftwareVideoGames',
                'VHS',
                'Video',
                'VideoGames'
            );
            break;
        case 'de':
            $country_url = "http://webservices.amazon.de/onca/xml";
            $mode = array (
                'Apparel',
                'Automotive',
                'Baby',
                'Books',
                'Beauty',
                'Blended',
                'Classical',
                'DVD',
                'Electronics',
                'ForeignBooks',
                'Grocery',
                'HealthPersonalCare',
                'HomeGarden',
                'HomeImprovement',
                'Jewelry',
                'Kitchen',
                'Lighting',
                'Magazines',
                'Marketplace',
                'MP3Downloads',
                'Music',
                'MusicalInstruments',
                'MusicTracks',
                'OfficeProducts',
                'OutdoorLiving',
                'Outlet',
                'PCHardware',
                'Photo',
                'Shoes',
                'Software',
                'SoftwareVideoGames',
                'SportingGoods',
                'Tools',
                'Toys',
                'VHS',
                'Video',
                'VideoGames',
                'Watches'
            );
            break;
        case 'jp':
            $country_url = "http://webservices.amazon.co.jp/onca/xml";
            $mode = array (
                'Apparel',
                'Appliances',
                'Automotive',
                'Baby',
                'Beauty',
                'Blended',
                'Books',
                'Classical',
                'DVD',
                'Electronics',
                'ForeignBooks',
                'Grocery',
                'HealthPersonalCare',
                'Hobbies',
                'HomeImprovement',
                'Jewelry',
                'Kitchen',
                'Marketplace',
                'MP3Downloads',
                'Music',
                'MusicalInstruments',
                'MusicTracks',
                'OfficeProducts',
                'Shoes',
                'Software',
                'SportingGoods',
                'Toys',
                'VHS',
                'Video',
                'VideoGames',
                'Wireless',
                'WirelessAccessories'
            );
            break;
        case 'fr':
            $country_url = "http://webservices.amazon.fr/onca/xml";
            $mode = array (
                'Apparel',
                'Baby',
                'Beauty',
                'Blended',
                'Books',
                'Classical',
                'DVD',
                'Electronics',
                'ForeignBooks',
                'HealthPersonalCare',
                'HomeImprovement',
                'Jewelry',
                'Kitchen',
                'Lighting',
                'MP3Downloads',
                'Music',
                'MusicalInstruments',
                'MusicTracks',
                'OfficeProducts',
                'PCHardware',
                'Shoes',
                'Software',
                'SoftwareVideoGames',
                'SportingGoods',
                'Toys',
                'VHS',
                'Video',
                'VideoGames',
                'Watches'
            );
            break;
        case 'uk':
            $country_url = "http://webservices.amazon.co.uk/onca/xml";
            $mode = array (
                'Apparel',
                'Automotive',
                'Baby',
                'Books',
                'Beauty',
                'Blended',
                'Classical',
                'DVD',
                'Electronics',
                'Grocery',
                'HealthPersonalCare',
                'HomeGarden',
                'HomeImprovement',
                'Jewelry',
				'KindleStore',
                'Kitchen',
                'Lighting',
                'Marketplace',
                'MP3Downloads',
                'Music',
                'MusicalInstruments',
                'MusicTracks',
                'OfficeProducts',
                'OutdoorLiving',
                'Outlet',
                'PCHardware',
                'Shoes',
                'Software',
                'SoftwareVideoGames',
                'SportingGoods',
                'Tools',
                'Toys',
                'VHS',
                'Video',
                'VideoGames',
                'Watches'
            );
            break;
        case 'es':
            $country_url = "http://webservices.amazon.es/onca/xml";
            $mode = array (
                'Books',
                'DVD',
                'Electronics',
                'ForeignBooks',
                'Kitchen',
                'Music',
                'Software',
                'Toys',
                'VideoGames',
                'Watches'
            );
            break;
        case 'it':
            $country_url = "http://webservices.amazon.it/onca/xml";
            $mode = array (
                'Books',
                'DVD',
                'Electronics',
                'ForeignBooks',
                'Garden',
                'Kitchen',
                'Music',
                'Shoes',
                'Software',
                'Toys',
                'VideoGames',
                'Watches'
            );
            break;
        case 'cn':
            $country_url = "http://webservices.amazon.cn/onca/xml";
            $mode = array (
                'Apparel',
				'Appliances',
                'Automotive',
                'Baby',
                'Books',
                'Beauty',
                'Electronics',
                'Grocery',
                'HealthPersonalCare',
                'Home',
                'HomeImprovement',
                'Jewelry',
                'Miscellaneous',
                'Music',
                'OfficeProducts',
                'Photo',
                'Shoes',
                'Software',
                'SportingGoods',
                'Toys',
                'Video',
                'VideoGames',
                'Watches'
            );
            break;
        case 'us':
        default:
            $country_url = "http://webservices.amazon.com/onca/xml";
            $mode = array (
                'Apparel',
                'Appliances',
                'ArtsAndCrafts',
                'Automotive',
                'Baby',
                'Beauty',
                'Blended',
                'Books',
                'Classical',
                'Collectibles',
                'DigitalMusic',
                'DVD',
                'Electronics',
                'GourmetFood',
                'Grocery',
                'HealthPersonalCare',
                'HomeGarden',
                'Industrial',
                'Jewelry',
                'KindleStore',
                'Kitchen',
                'LawnAndGarden',
                'Magazines',
                'Marketplace',
                'Miscellaneous',
                'MobileApps',
                'MP3Downloads',
                'Music',
                'MusicalInstruments',
                'MusicTracks',
                'OfficeProducts',
                'OutdoorLiving',
                'PetSupplies',
                'OutdoorLiving',
                'PCHardware',
                'Photo',
                'Shoes',
                'Software',
                'SportingGoods',
                'Tools',
                'Toys',
                'UnboxVideo',
                'VHS',
                'Video',
                'VideoGames',
                'Watches',
                'Wireless',
                'WirelessAccessories'
            );
    }
    return array($country_url, $mode);
}

function Amazon_return_mode_array() {
    $mode_names = array (
        'Apparel'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_APPAREL'),
        'Automotive'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_AUTO'),
        'Appliances'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_APPLIANCES'),
        'ArtsAndCrafts'         => constant('PLUGIN_EVENT_AMAZONCHOOSER_ARTSANDCRAFTS'),
        'Baby'                  => constant('PLUGIN_EVENT_AMAZONCHOOSER_BABY'),
        'Beauty'                => constant('PLUGIN_EVENT_AMAZONCHOOSER_BEAUTY'),
        'Blended'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_BLENDED'),
        'Books'                 => constant('PLUGIN_EVENT_AMAZONCHOOSER_BOOKS'),
        'Classical'             => constant('PLUGIN_EVENT_AMAZONCHOOSER_CLASSICALMUSIC'),
        'DigitalMusic'          => constant('PLUGIN_EVENT_AMAZONCHOOSER_DIGITALMUSIC'),
        'DVD'                   => constant('PLUGIN_EVENT_AMAZONCHOOSER_DVD'),
        'Electronics'           => constant('PLUGIN_EVENT_AMAZONCHOOSER_ELECTRONICS'),
        'ForeignBooks'          => constant('PLUGIN_EVENT_AMAZONCHOOSER_FOREIGNBOOKS'),
        'Garden'                => constant('PLUGIN_EVENT_AMAZONCHOOSER_GARDEN'),
        'GourmetFood'           => constant('PLUGIN_EVENT_AMAZONCHOOSER_GORMETFOOD'),
        'Grocery'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_GROCERY'),
        'HealthPersonalCare'    => constant('PLUGIN_EVENT_AMAZONCHOOSER_HEALTH'),
        'Hobbies'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_HOBBIES'),
        'Home'                  => constant('PLUGIN_EVENT_AMAZONCHOOSER_HOME'),
        'HomeGarden'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_HOMEGARDEN'),
        'HomeImprovement'       => constant('PLUGIN_EVENT_AMAZONCHOOSER_HOMEIMPROVE'),
        'Industrial'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_INDUSTRIAL'),
        'Jewelry'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_JEWELRY'),
        'KindleStore'           => constant('PLUGIN_EVENT_AMAZONCHOOSER_KINDLESTORE'),
        'Kitchen'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_KITCHEN'),
        'Magazines'             => constant('PLUGIN_EVENT_AMAZONCHOOSER_MAGAZINE'),
        'Marketplace'           => constant('PLUGIN_EVENT_AMAZONCHOOSER_MARKETPLACE'),
        'Miscellaneous'         => constant('PLUGIN_EVENT_AMAZONCHOOSER_MISC'),
        'MobileApps'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_MOBILEAPP'),
        'MP3Downloads'          => constant('PLUGIN_EVENT_AMAZONCHOOSER_MP3DOWNLOADS'),
        'Music'                 => constant('PLUGIN_EVENT_AMAZONCHOOSER_MUSIC'),
        'MusicalInstruments'    => constant('PLUGIN_EVENT_AMAZONCHOOSER_MUSICALINST'),
        'MusicTracks'           => constant('PLUGIN_EVENT_AMAZONCHOOSER_MUSICTRACKS'),
        'OfficeProducts'        => constant('PLUGIN_EVENT_AMAZONCHOOSER_OFFICEPROD'),
        'OutdoorLiving'         => constant('PLUGIN_EVENT_AMAZONCHOOSER_OUTDOOR'),
        'Outlet'                => constant('PLUGIN_EVENT_AMAZONCHOOSER_OUTLET'),
        'PCHardware'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_COMPUTERS'),
        'PetSupplies'           => constant('PLUGIN_EVENT_AMAZONCHOOSER_PETS'),
        'Photo'                 => constant('PLUGIN_EVENT_AMAZONCHOOSER_PHOTO'),
        'Shoes'                 => constant('PLUGIN_EVENT_AMAZONCHOOSER_SHOES'),
        'Software'              => constant('PLUGIN_EVENT_AMAZONCHOOSER_SOFTWARE'),
        'SoftwareVideoGames'    => constant('PLUGIN_EVENT_AMAZONCHOOSER_SOFTWAREVIDEO'),
        'SportingGoods'         => constant('PLUGIN_EVENT_AMAZONCHOOSER_SPORTGOODS'),
        'Tools'                 => constant('PLUGIN_EVENT_AMAZONCHOOSER_TOOLS'),
        'Toys'                  => constant('PLUGIN_EVENT_AMAZONCHOOSER_TOYS'),
        'UnboxVideo'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_UNBOXVIDEO'),
        'VHS'                   => constant('PLUGIN_EVENT_AMAZONCHOOSER_VHS'),
        'Video'                 => constant('PLUGIN_EVENT_AMAZONCHOOSER_VIDEO'),
        'VideoGames'            => constant('PLUGIN_EVENT_AMAZONCHOOSER_COMPUTERGAMES'),
        'Watches'               => constant('PLUGIN_EVENT_AMAZONCHOOSER_WATCHES'),
        'Wireless'              => constant('PLUGIN_EVENT_AMAZONCHOOSER_WIRELESS'),
        'WirelessAccessories'   => constant('PLUGIN_EVENT_AMAZONCHOOSER_WIRELESSACC')
    );
    return $mode_names;
}

function Amazon_AttributesText ($SearchIndex,$items,$country_url) {
    $country = str_replace("http://ecs.amazonaws.","",$country_url);
    $country = str_replace("/onca/xml","",$country_url);
    if ($country == 'uk' || $country == 'de' || $country == 'fr') {
        $euro = TRUE;
    }
    $results = array();
/*
    if (is_array($items) && !empty($items)) {
        echo "No items to print! Sorry, something went wrong.<br>\n";
        return false;
    }*/

    foreach ($items as $item) {
        $itemlink_count = (count($item['ITEMLINKS'])-1)/2;
        for ($lcount=1; $lcount <= $itemlink_count ; $lcount++){
            $itemlink_name = "ITEMLINKS_" . $lcount . "_DESCRIPTION";
            $itemlink_url = "ITEMLINKS_" . $lcount . "_URL";
            switch ($item['ITEMLINKS'][$itemlink_name]) {
                case 'Technical Details':
                    $item['strings']['techurl'] = rawurldecode($item['ITEMLINKS'][$itemlink_url]);
                    break;
                case 'All Customer Reviews':
                    $item['strings']['reviewsurl'] = rawurldecode($item['ITEMLINKS'][$itemlink_url]);
                    break;
                case 'All Offers':
                    $item['strings']['offersurl'] = rawurldecode($item['ITEMLINKS'][$itemlink_url]);
                    break;
            }
        }
        if (isset($item['ASIN'])) {
            $item['strings']['ASIN'] = $item['ASIN'];
        }
        if (isset($item['DETAILPAGEURL'])) {
            $item['strings']['DETAILPAGEURL'] = rawurldecode($item['DETAILPAGEURL']);
        }
        if (isset($item['SALESRANK'])) {
            $item['strings']['SALESRANK'] = $item['SALESRANK'];
        }
        if (isset($item['SMALLIMAGE']['SMALLIMAGE_URL'])) {
            $item['strings']['smallurl'] = rawurldecode($item['SMALLIMAGE']['SMALLIMAGE_URL']);
        }
        if (isset($item['MEDIUMIMAGE']['MEDIUMIMAGE_URL'])) {
            $item['strings']['mediumurl'] = rawurldecode($item['MEDIUMIMAGE']['MEDIUMIMAGE_URL']);
        }
        if (isset($item['LARGEIMAGE']['LARGEIMAGE_URL'])) {
            $item['strings']['largeurl'] = rawurldecode($item['LARGEIMAGE']['LARGEIMAGE_URL']);
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_LISTPRICE_FORMATTEDPRICE'])) {
            $item['strings']['price'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_LISTPRICE_FORMATTEDPRICE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_LISTPRICE_FORMATTEDPRICE'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PRODUCTGROUP'])) {
            if ($SearchIndex == "" || !isset($SearchIndex)) {
                $SearchIndex = $item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PRODUCTGROUP'];
            }
            $item['strings']['productgroup'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PRODUCTGROUP']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PRODUCTGROUP'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_LANGUAGES_LANGUAGE_NAME'])) {
            $item['strings']['productlanguage'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_LANGUAGES_LANGUAGE_NAME']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_LANGUAGES_LANGUAGE_NAME'], ENT_COMPAT, LANG_CHARSET));
        }
        if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RELEASEDATE'])) {
            $item['strings']['releasedate'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RELEASEDATE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RELEASEDATE'], ENT_COMPAT, LANG_CHARSET));
        }
        if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RUNNINGTIME'])) {
            $item['strings']['running'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RUNNINGTIME']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RUNNINGTIME'], ENT_COMPAT, LANG_CHARSET)).' '.(function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RUNNINGTIME_UNITS']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RUNNINGTIME_UNITS'], ENT_COMPAT, LANG_CHARSET));
        }
        if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_NUMBEROFDISCS'])) {
            $item['strings']['numberofdiscs'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_NUMBEROFDISCS']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_NUMBEROFDISCS'], ENT_COMPAT, LANG_CHARSET));
        }
        if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_FORMAT'])) {
            $item['strings']['format'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_FORMAT']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_FORMAT'], ENT_COMPAT, LANG_CHARSET));
        }
        if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ISBN'])) {
            $item['strings']['ISBN'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ISBN']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ISBN'], ENT_COMPAT, LANG_CHARSET));
        }
        if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_EAN']) && $euro) {
            $item['strings']['EAN'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_EAN']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_EAN'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_TITLE'])) {
            $item['strings']['title'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_TITLE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_TITLE'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_HARDWAREPLATFORM'])) {
            $item['strings']['platform'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_HARDWAREPLATFORM']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_HARDWAREPLATFORM'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_GENRE'])) {
            $item['strings']['genre'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_GENRE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_GENRE'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ESRBAGERATING'])) {
            $item['strings']['esrbarating'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ESRBAGERATING']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ESRBAGERATING'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUDIENCERATING'])) {
            $item['strings']['audiencerating'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUDIENCERATING']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUDIENCERATING'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MODEL'])) {
            $item['strings']['model'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MODEL']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MODEL'], ENT_COMPAT, LANG_CHARSET));
        }
        if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMAPERTURE'])) {
            $item['strings']['maxaperture'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMAPERTURE_UNITS']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMAPERTURE_UNITS'], ENT_COMPAT, LANG_CHARSET))."/".(function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMAPERTURE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMAPERTURE'], ENT_COMPAT, LANG_CHARSET));
        }
        if ((isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MINIMUMFOCALLENGTH'])) && (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMFOCALLENGTH']))) {
            $item['strings']['focallength'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MINIMUMFOCALLENGTH']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MINIMUMFOCALLENGTH'], ENT_COMPAT, LANG_CHARSET)).'-'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMFOCALLENGTH']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MAXIMUMFOCALLENGTH'], ENT_COMPAT, LANG_CHARSET)).' '.(function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MINIMUMFOCALLENGTH_UNITS']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MINIMUMFOCALLENGTH_UNITS'], ENT_COMPAT, LANG_CHARSET));
        }
        if ((isset($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALNEW']) && ($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALNEW'] != 0))  && (isset($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTNEWPRICE_FORMATTEDPRICE']))) {
            $item['strings']['newoffers'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALNEW']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALNEW'], ENT_COMPAT, LANG_CHARSET)) . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_NEW') . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_FROM') . " " . (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTNEWPRICE_FORMATTEDPRICE']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTNEWPRICE_FORMATTEDPRICE'], ENT_COMPAT, LANG_CHARSET));
        }
        if ((isset($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALUSED']) && ($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALUSED'] != 0))  && (isset($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTUSEDPRICE_FORMATTEDPRICE']))) {
             $item['strings']['usedoffers'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALUSED']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALUSED'], ENT_COMPAT, LANG_CHARSET)) . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_USED') . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_FROM') . " " . (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTUSEDPRICE_FORMATTEDPRICE']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTUSEDPRICE_FORMATTEDPRICE'], ENT_COMPAT, LANG_CHARSET));
        }
        if ((isset($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALCOLLECTABLE']) && ($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALCOLLECTABLE'] != 0))  && (isset($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTCOLLECTABLEPRICE_FORMATTEDPRICE']))) {
            $item['strings']['collectableoffers'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALCOLLECTABLE']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALCOLLECTABLE'], ENT_COMPAT, LANG_CHARSET)) . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_COLLECTABLE') . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_FROM') . " " . (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTCOLLECTABLEPRICE_FORMATTEDPRICE']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTCOLLECTABLEPRICE_FORMATTEDPRICE'], ENT_COMPAT, LANG_CHARSET));
        }
        if ((isset($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALREFURBISHED']) && ($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALREFURBISHED'] != 0))  && (isset($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTREFURBISHEDPRICE_FORMATTEDPRICE']))) {
            $item['strings']['refurboffers'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALREFURBISHED']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_TOTALREFURBISHED'], ENT_COMPAT, LANG_CHARSET)) . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_REFURBISHED') . " " . constant('PLUGIN_EVENT_AMAZONCHOOSER_FROM') . " " . (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTREFURBISHEDPRICE_FORMATTEDPRICE']) : htmlspecialchars($item['OFFERSUMMARY']['OFFERSUMMARY_LOWESTREFURBISHEDPRICE_FORMATTEDPRICE'], ENT_COMPAT, LANG_CHARSET));
        }
        switch ($SearchIndex) {
            case 'Books':
            case 'ForeignBooks':
            case 'Magazines':
            case 'KindleStore':
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUTHOR'])) {
                    if (is_array($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUTHOR'])) {
                        $item['strings']['author'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars(implode(', ',$item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUTHOR'])) : htmlspecialchars(implode(', ',$item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUTHOR']), ENT_COMPAT, LANG_CHARSET));
                    } else {
                        $item['strings']['author'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUTHOR']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_AUTHOR'], ENT_COMPAT, LANG_CHARSET));
                    }
                }
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'])) {
                    $item['strings']['publisher'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'], ENT_COMPAT, LANG_CHARSET));
                }
                if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PUBLICATIONDATE'])) {
                    $item['strings']['publicationdate'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PUBLICATIONDATE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_PUBLICATIONDATE'], ENT_COMPAT, LANG_CHARSET));
                    unset($item['strings']['releasedate']);
                }
                if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_NUMBEROFPAGES'])) {
                    $item['strings']['numberofpages'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_NUMBEROFPAGES']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_NUMBEROFPAGES'], ENT_COMPAT, LANG_CHARSET));
                }
                break;
            case 'VHS':
            case 'VIDEO':
            case 'DVD':
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ACTOR'])) {
                    if (is_array($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ACTOR'])) {
                        $item['strings']['actor'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars(implode(', ',$item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ACTOR'])) : htmlspecialchars(implode(', ',$item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ACTOR']), ENT_COMPAT, LANG_CHARSET));
                    } else {
                        $item['strings']['actor'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ACTOR']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ACTOR'], ENT_COMPAT, LANG_CHARSET));
                    }
                }
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'])) {
                    $item['strings']['distributor'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'], ENT_COMPAT, LANG_CHARSET));
                }
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_DIRECTOR'])) {
                    $item['strings']['director'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_DIRECTOR']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_DIRECTOR'], ENT_COMPAT, LANG_CHARSET));
                }
                if (!empty($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RELEASEDATE'])) {
                    $item['strings']['releasedate'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RELEASEDATE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_RELEASEDATE'], ENT_COMPAT, LANG_CHARSET));
                }
                break;
            case 'Music':
            case 'Classical':
            case 'DigitalMusic':
            case 'MP3Downloads':
            case 'Music':
            case 'MusicTracks':
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ARTIST'])) {
                    if (is_array($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ARTIST'])) {
                        $item['strings']['artist'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars(implode(', ',$item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ARTIST'])) : htmlspecialchars(implode(', ',$item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ARTIST']), ENT_COMPAT, LANG_CHARSET));
                    } else {
                        $item['strings']['artist'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ARTIST']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_ARTIST'], ENT_COMPAT, LANG_CHARSET));
                    }
                }
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'])) {
                    $item['strings']['distributor'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'], ENT_COMPAT, LANG_CHARSET));
                }
                break;
            case 'Software':
            case 'VideoGames':
            case 'SoftwareVideoGames':
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'])) {
                    $item['strings']['distributor'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'], ENT_COMPAT, LANG_CHARSET));
                }
                break;
            case 'Apparel':
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_BRAND'])) {
                    $item['strings']['brand'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_BRAND']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_BRAND'], ENT_COMPAT, LANG_CHARSET));
                }
                break;
            default:
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'])) {
                    $item['strings']['distributor'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_MANUFACTURER'], ENT_COMPAT, LANG_CHARSET));
                }
                if (isset($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_FEATURE'])) {
                    $item['strings']['feature'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_FEATURE']) : htmlspecialchars($item['ITEMATTRIBUTES']['ITEMATTRIBUTES_FEATURE'], ENT_COMPAT, LANG_CHARSET));
                }
                break;
        }
        $new_items[] = $item;
    }
    return $new_items;
}

function buildSignedAmazonRequest($parameters,$server,$secret) {
    if (!function_exists('sha256')) {
        require_once('sha256/sha256.inc.php');
    }
    define("REQUEST_VERB","GET");
    $server_array = parse_url($server);
    $parse_string = REQUEST_VERB . "\n" . $server_array["host"] . "\n" . $server_array["path"] . "\n";
    ksort($parameters);
    $request = array();
    foreach ($parameters as $parameter=>$value) {
        $parameter = str_replace("%7E", "~", rawurlencode($parameter));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $request[] = $parameter . "=" . $value;
    }
    $request = implode("&", $request);
    $parse_string=$parse_string . $request;
    $signature = urlencode(base64_encode(hmac($secret, $parse_string)));
    $request = $server_array["scheme"]."://" . $server_array["host"] . $server_array["path"] . "?" . $request . "&Signature=" . $signature;
    return $request;
}

function Amazon_SearchItems ($AWSAccessKey,$AssociateTag,$secretKey,$SearchIndex,$keywords,$country_url,$page) {
    $params["ItemPage"]         = $page;
    $params["Version"]          = "2011-08-01";
    $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
    $params["ResponseGroup"]    = "Medium";
    $params["AWSAccessKeyId"]   = $AWSAccessKey;
    $params["AssociateTag"]     = $AssociateTag;
    $params["Service"]          = "AWSECommerceService";
    $params["Operation"]        = "ItemSearch";
    $params["Condition"]        = "All";
    $params["Keywords"]         = urldecode($keywords);
    $params["SearchIndex"]      = $SearchIndex;
    $request                    = buildSignedAmazonRequest($params, $country_url,$secretKey);
    $results                    = Amazon_Request($request);
    $results['items']           = Amazon_AttributesText($SearchIndex,$results['items'],$country_url);
    return $results;
}

function Amazon_ItemLookup ($AWSAccessKey,$AssociateTag,$secretKey,$SearchIndex,$ASIN,$country_url) {
    $params["Version"]          = "2011-08-01";
    $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
    $params["ResponseGroup"]    = "Medium,OfferFull";
    $params["AWSAccessKeyId"]   = $AWSAccessKey;
    $params["AssociateTag"]     = $AssociateTag;
    $params["Service"]          = "AWSECommerceService";
    $params["Operation"]        = "ItemLookup";
    $params["Condition"]        = "All";
    $params["ItemId"]           = $ASIN;
    $request                    = buildSignedAmazonRequest($params, $country_url,$secretKey);
    $results                    = Amazon_Request($request);
    $results['items']           = Amazon_AttributesText($SearchIndex,$results['items'],$country_url);
    return $results;
}

function Amazon_Request($request) {
    $items = array();
    $totalcount = -1;
    $error_message = "";
    $error_result  = "";
    $httpDirname = (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/';

    if (file_exists($httpDirname . 'Request2.php')) {
        set_include_path(get_include_path() . PATH_SEPARATOR . $httpDirname . '/..');
        require_once $httpDirname . 'Request2.php';
        $options = array('follow_redirects' => true, 'max_redirects' => 3);
        if (version_compare(PHP_VERSION, '5.6.0', '<')) {
            // restore old HTTP/Request behaviour
            $options['ssl_verify_peer'] = false;
        }
        $req = new HTTP_Request2($request, HTTP_Request2::METHOD_GET, $options);
        try {
            $res = $req->send();
            if (200 == $res->getStatus()) {
                $xml        = xml_parser_create(LANG_CHARSET);
                $totalcount = 0;
                $bodyxml    = $res->getBody();
                $initem     = false;
                $inattrib   = false;
                include dirname(__FILE__) . '/s9ylib_include_feedback_ok.inc.php';
            } elseif (403 == $res->getStatus()) {
                $error_message = constant('PLUGIN_EVENT_AMAZONCHOOSER_HTTPREQFAIL');
                $error_result  = constant('PLUGIN_EVENT_AMAZONCHOOSER_RESPONSE') . ": ".$res->getStatus()."<br />".constant('PLUGIN_EVENT_AMAZONCHOOSER_SETTINGS_PROBLEM');
            } else {
                $error_message = constant('PLUGIN_EVENT_AMAZONCHOOSER_HTTPREQFAIL');
                $error_result  = constant('PLUGIN_EVENT_AMAZONCHOOSER_REQUEST').": ". $request . "\n<br />" . constant('PLUGIN_EVENT_AMAZONCHOOSER_RESPONSE') . ": ".$res->getStatus();
                $returndate = FALSE;
            }
        } catch (HTTP_Request2_Exception $e) {
            $error_message = constant('PLUGIN_EVENT_AMAZONCHOOSER_HTTPREQFAIL');
            $error_result  = constant('PLUGIN_EVENT_AMAZONCHOOSER_REQUEST').": ". $request . "\n<br />" . constant('PLUGIN_EVENT_AMAZONCHOOSER_RESPONSE') . ": <pre>".print_r( $e ) . "</pre>";
            $returndate = FALSE;
        }
    } else {
        require_once $httpDirname . 'Request.php';
        $req = new HTTP_Request($request);
        if (!(PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200')) {
            $xml        = xml_parser_create(LANG_CHARSET);
            $totalcount = 0;
            $bodyxml    = $req->getResponseBody();
            $initem     = false;
            $inattrib   = false;
            include dirname(__FILE__) . 's9ylib_include_feedback_ok.inc.php';
        } else {
            if ($req->getResponseCode() == "403") {
                $error_message = constant('PLUGIN_EVENT_AMAZONCHOOSER_HTTPREQFAIL');
                $error_result  = constant('PLUGIN_EVENT_AMAZONCHOOSER_RESPONSE') . ": ".$req->getResponseCode()."<br />".constant('PLUGIN_EVENT_AMAZONCHOOSER_SETTINGS_PROBLEM');
            } else {
                $error_message = constant('PLUGIN_EVENT_AMAZONCHOOSER_HTTPREQFAIL');
                $error_result  = constant('PLUGIN_EVENT_AMAZONCHOOSER_REQUEST').": ". $request . "\n<br />" . constant('PLUGIN_EVENT_AMAZONCHOOSER_RESPONSE') . ": ".$req->getResponseCode();
                $returndate = FALSE;
            }
        }
    }
    return array("operation" => $searchmode, 'count' => count($items),'return_count' => $totalcount,'totalpages'=>$totalpages, 'items' => $items, 'error_message' => $error_message, "error_result" => $error_result, "return_date" => $returndate);
}

if (!function_exists('hmac')) {
   function hmac($key, $data, $hashfunc='sha256') {
      $blocksize=64;
      if (strlen($key) > $blocksize) $key=pack('H*', $hashfunc($key));
      $key=str_pad($key, $blocksize, chr(0x00));
      $ipad=str_repeat(chr(0x36), $blocksize);
      $opad=str_repeat(chr(0x5c), $blocksize);
      $hmac = pack('H*', $hashfunc(($key^$opad) . pack('H*', $hashfunc(($key^$ipad) . $data))));
      return $hmac;
   }
}
