<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

@define('PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE', 'Antispamov� ochrana (RBL)');
@define('PLUGIN_EVENT_SPAMBLOCK_RBL_DESC', 'Odm�tne koment��e, kter� jsou zad�ny ze adres, kter� jsou vedeny v blacklistu RBL. Pozor, �e tato volba m��e znemo�nit pos�l�n� koment��� u�ivatel�m, kte�� sed� za proxy serverem nebo kte�� pou��vaj� vyt��en� spojen�.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL', 'Antispamov� kontrola: Va�e IP adresa je vedena jako Open Relay. Obra�te se na sv�ho poskytovatele internetov�ho p�ipojen�!');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST', 'Kter� RBL server m� b�t kontaktov�n?');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC', 'Blokuje koment��e v z�vislosti na poskytnut�ch RBL seznamech. Vyhn�te se seznam�m s dynamick�mi hosty.');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_RBL', 'RBL-block');

@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_TITLE', 'Spam Protector (projekt Honeypot)');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_DESC', 'Odm�tne koment��e zadan� z adres vyjmenovan�ch v blacklistu projektu Honeypot http:BL');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY', 'httpBL_key');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY_DESC', 'Zadejte http:BL kl��');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_HONEYPOT', 'Projekt Honeypot http:BL nalezl ');

