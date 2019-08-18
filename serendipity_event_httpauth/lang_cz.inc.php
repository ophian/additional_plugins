<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP autentifikace');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Ov��uje u�ivatele pomoc� HTTP auth s pou�it�m jejich serendipity p�ihla�ovac�ch dat.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'Povolit REMOTE_USER autentifikace?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'Pokud je povoleno, u�ivatel� mohou b�t autentifikov�ni pomoc� serveru IIS/Apache. Ty budou ukl�dat centr�ln� serverovou prom�nnou REMOTE_USER se jm�nem p�ihl�en�ho u�ivatele a Serendipity se pak m��e p�ihl�sit pomoc� tohoto u�ivatelsk�ho jm�na. Pokud umo�n�te tuto volbu, m�jte na pam�ti, �e v� vlastn� autentifika�n� syst�m mus� zaru�ovat, �e se p�ihl�s� pouze k tomu opr�vn�n� u�ivatel�, proto�e tato volba p�emos�uje p�ihla�ovac� syst�m Serendipity!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Povolit wildcard autentifikaci?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'Tato volba se pou�ije pouze pokud je zapnuta autentifikace pomoc� REMOTE_USER. Pokud je toto nastaven� pou�ito, pak ka�d� REMOTE_USER, kter� nen� v datab�zi serendipity, bude p�ihl�en jako v�choz� u�ivatel. To znamen�, �e pokud se u�ivatel p�ihl�s� jako "Pepan", ale v Serendipity ��dn� takov� ��et neexistuje, pak bude u�ivatel p�ihl�en jako "N�v�t�vn�k".');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Wildcard autentifikace: ID autora');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Zadejte ID autora, pod kter�m bude p�ihl�en ka�� "wildcard" p�ihl�en� u�ivatel.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Wildcard autentifikace: Opr�vn�n�');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Zadejte opr�vn�n�, kter�mi bude disponovat u�ivatele p�ihl�en� jako "wildacard".');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Vy�adovat autentifikaci pro frontend');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'M� b�t autentifika�n� rutina vy�adov�na u� pro frontend blogu? Pokud ano, pak je p��stup k blogu nemo�n� bez p�hl�en�. Pokud volba nen� zapnuta, pak je p�ih�en� vy�adov�no pouze pro p��stup do backendu (zadn� - admnistr�torsk� ��sti) blogu.');

