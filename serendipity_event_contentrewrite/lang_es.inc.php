<?php
/**
 *  @version $Revision$
 *  @author Rodrigo Lazo Paz <rlazo.paz@gmail.com>
 *  EN-Revision: 690
 */

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'de');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'a');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'Reemplazar texto');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Reemplaza palabras con nuevas cadenas (�til para acr�nimos)');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Nuevo t�tulo');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Ingresa el t�tulo-acr�nimo para un nuevo �tem aqu� ({de})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'T�tulo #%d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Ingresa el acr�nimo aqu� ({de})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'T�tulo de la extensi�n');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'El nombre de esta extensi�n');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Nueva descripci�n');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Ingresa la descripci�n para un nuevo �tem aqu� ({a})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Descripci�n #%s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Ingresa la descripci�n aqu� ({a})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'Cadena de reemplazo');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'La cadena utilizada para reemplazar. Posiciona {de} y {a} donde desees para conseguir un reemplazo.' . "\n" . 'Por ejemplo: <acronym title="{a}">{de}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'Caracter de reemplazo');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Si existe alg�n caracter que a�adiste para forzar el reemplazo, ingr�salo aqu�. Por ejemplo: si s�lo deseabas reemplazar \'serendipity*\' con lo que ingresaste para esa palabra y quieres el \'*\' eliminado, ingr�salo aqu�.');

