<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP autentifikace');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Ovìøuje uivatele pomocí HTTP auth s pouitím jejich serendipity pøihlašovacích dat.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'Povolit REMOTE_USER autentifikace?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'Pokud je povoleno, uivatelé mohou bıt autentifikováni pomocí serveru IIS/Apache. Ty budou ukládat centrální serverovou promìnnou REMOTE_USER se jménem pøihlášeného uivatele a Serendipity se pak mùe pøihlásit pomocí tohoto uivatelského jména. Pokud umoníte tuto volbu, mìjte na pamìti, e váš vlastní autentifikaèní systém musí zaruèovat, e se pøihlásí pouze k tomu oprávnìní uivatelé, protoe tato volba pøemosuje pøihlašovací systém Serendipity!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Povolit wildcard autentifikaci?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'Tato volba se pouije pouze pokud je zapnuta autentifikace pomocí REMOTE_USER. Pokud je toto nastavení pouito, pak kadı REMOTE_USER, kterı není v databázi serendipity, bude pøihlášen jako vıchozí uivatel. To znamená, e pokud se uivatel pøihlásí jako "Pepan", ale v Serendipity ádnı takovı úèet neexistuje, pak bude uivatel pøihlášen jako "Návštìvník".');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Wildcard autentifikace: ID autora');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Zadejte ID autora, pod kterım bude pøihlášen kaá "wildcard" pøihlášenı uivatel.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Wildcard autentifikace: Oprávnìní');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Zadejte oprávnìní, kterımi bude disponovat uivatele pøihlášenı jako "wildacard".');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Vyadovat autentifikaci pro frontend');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'Má bıt autentifikaèní rutina vyadována u pro frontend blogu? Pokud ano, pak je pøístup k blogu nemonı bez pøhlášení. Pokud volba není zapnuta, pak je pøihášení vyadováno pouze pro pøístup do backendu (zadní - admnistrátorské èásti) blogu.');

