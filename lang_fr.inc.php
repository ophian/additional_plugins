<?php # 

/**
 *  @version 
 *  @author P'tit Lu <ptitlu@ptitlu.org>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Marquage des entr�es');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Autorise le marquage libre des billets');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Entrez tous les tags s\'appliquant. S�parer les tags multiples par des virgules (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags pour ce billet: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Billets marqu�s comme %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tags se rapportant au tag %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Pas de tags en rapport.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Tous les tags d�finis');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'G�rer les tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'G�rer tous les tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'G�rer les tags \'orphelins\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lister les billets non marqu�s');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lister les billets marqu�s \'orphelins\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Aucune entr�e non marqu�e');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Poids');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Action');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Renommer');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'S�parer');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Effacer');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'voulez-vous vraiment effacer le tag %s ?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'Utilisez la virgule pour s�parer les tags :');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Afficher le nuage de tags pour les tags en rapport ?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Send X-FreeTag-HTTP-Headers');
//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Nuage de tags');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Montre une liste des tags existant pour les billets');
@define('PLUGIN_FREETAG_NEWLINE', 'Retour � la ligne apr�s chaque tag ?');
@define('PLUGIN_FREETAG_XML', 'Afficher les icones XML ?');
@define('PLUGIN_FREETAG_SCALE','Ajuster la taille du tag par rapport � sa fr�quence (comme sur Technorati, flickr) ?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Mise � jour des tags %d pour le billet num�ro: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Combien de tags doivent �tre affich�s ?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Combien de fois un tag doit-il �tre pr�sent pour appara�tre ?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Taille de police minimale (%) d\'un tag dans le nuage');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Taille de police maximale (%) d\'un tag dans le nuage');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Nombre de mots-clef � ins�rer dans lfile:///home/ptitlu/www/blog/plugins/serendipity_event_freetag/lang_fr.inc.phpe code HTML (0: d�sactiv�)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Billets ayant les m�mes tags :');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Afficher les billets ayant les m�me tags  ?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Combien de billets doivent �tre affich�s ?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Montrer les tags dans le pied de page ?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Si activ�, les tags seront affich�s dans le pied de page du billet. Si non, ils seront affich�s dans le corps du billet.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Mettre les tags en minuscules.');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Tags en rapport');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Lien Tag');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Cr�er des tags pour toutes les cat�gories associ�es ?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Si activ�, les cat�gories dont un billet fait partie seront ajout�es en tant que tag � ce billet.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Convertir toutes les cat�gories assign�es � des billets en tags.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Cat�gories converties du billet #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Toutes les catogries sont converties.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Mots-clef automatis�s');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Vous pouvez assigner des mots-clef (s�parat�s par ",") � chaque tag. D�s que vous utilisez ces mots-clef dans le texte de vos billets, le tag correspondant est � votre billet. Notez que ceci allonge le temps de sauvegarde de votre billet.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Mot-clef trouv� <strong>%s</strong>, tag <strong><em>%s</em></strong> assign� automatiquement.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Recherche des billets %d � %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (totalisant %d billets)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Recherche du prochain groupe de billets...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Analyse des mots-clef automatiques');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Attention : Cette fonction va rechercher et re-sauvegarder chacun de vos billets. Cela va prendre du temps, et risque d\'endommager certains de vos billets. Il est conseill� de faire auparavant une sauvegarde de votre base de donn�es ! Cliquez sur "ANNULER" pour arr�ter.');
