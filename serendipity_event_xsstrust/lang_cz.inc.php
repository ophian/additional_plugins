<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

//
//  serendipity_event_xsstrust
//
@define('PLUGIN_EVENT_XSSTRUST_NAME',     'N�stroje pro d�v�ryhodnou spr�vu v�ce-u�ivatelsk�ch blog�');
@define('PLUGIN_EVENT_XSSTRUST_DESC',     'Tento plugin umo��uje up�esnit, kte�� auto�i na v�ce-u�ivatelsk�m blogu jsou d�v�ryhodn� a lze se spolehnout, �e se nebudou pokou�et o hackov�n�. V�ichni ostatn� auto�i jsou br�ni jako potenci�ln� nebezpe�n� a nemohou vytv��tet p��sp�vky v HTML k�du.');
@define('PLUGIN_EVENT_XSSTRUST_AUTHORS',  'D�v�ryhodn� auto�i');

//
//  serendipity_plugin_xsstrust
//
@define('PLUGIN_ETHICS_NAME', 'Zobrazit d�v�ryhodn� autory');
@define('PLUGIN_ETHICS_INTRO', 'Tento plugin zobrazuje autory se zobrazen�m jejich etick� �rovn�, semafor m� n�sleduj�c� v�znam:');
@define('PLUGIN_ETHICS_REDLIGHT', 'zak�zan�');
@define('PLUGIN_ETHICS_YELLOWLIGHT', 'podez�el�');
@define('PLUGIN_ETHICS_GREENLIGHT', 'v pohod�');
@define('PLUGIN_ETHICS_BLAHBLAH', 'Zobrazuje u�ivatele s vyobrazen�m jejich etick� �rovn� (vyj�d�enou semaforem). Zelen� znamen� "'.PLUGIN_ETHICS_GREENLIGHT.'"; oran�ov� znamen� "'.PLUGIN_ETHICS_YELLOWLIGHT.'"; a �erven� znamen� "'.PLUGIN_ETHICS_REDLIGHT.'". Administr�tor m��e lehce m�nit tyto hodnoty u jednotliv�ch u�ivatel�.');
@define('PLUGIN_ETHICS_BASEVAL', 'V�choz� �rove� etick� �rovn� autora');
@define('PLUGIN_ETHICS_BASEVAL_BLAHBLAH', 'V�choz� �rove� (1 = zelen�; 2 = oran�ov�; 3 = �erven�; p�ednastaveno: 1)');

