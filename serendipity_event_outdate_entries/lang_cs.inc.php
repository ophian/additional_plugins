<?php

/**
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @translated 2009/02/17
 */

@define('PLUGIN_EVENT_OUTDATE', 'Schovat/smazat star� p��sp�vky');
@define('PLUGIN_EVENT_OUTDATE_DESC', 'Pro nep�ihl�en� �ten��e schov� v�echny p��sp�vky star�� ne� nastaven� �as, tyto p��sp�vky jsou viditeln� pouze p�ihl�en�m u�ivatel�m/autor�m.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT', 'Kdy maj� b�t p��sp�vky schov�ny?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC', 'Zadejte dobu, po jej�m� uplynut� od vyd�n� bude p��sp�vek schov�n. (ve dnech, 0 pro deaktivaci volby)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY', 'Kdy maj� b�t p��sp�vky "odlepeny"?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC', 'Zadejte dobu, po jej�m� uplynut� od vyd�n� bude p��sp�veku zru�en p��znak "p�ilepen�". (ve dnech, 0 pro deaktivaci volby)');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD', 'P��davn� pole "Datum expirace"');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC', 'Pokud pou��v�te p��davn� modul "Roz���en� vlastnosti p��sp�vk�", m��ete definovat p��davn� pole, do kter�ho zad�te datum, kdy p��sp�vku vypr�� platnost. Datum mus� m�t form�t RRRR-MM-DD. Tento plugin najde toto datum vypr�en� platnosti a nastav� p��sp�vek jako KONCEPT, tak�e zmiz� ze zobrazen� p��sp�vk�. Zde zadejte n�zev p��davn�ho pole (nap��klad "DatumExpirace").');

