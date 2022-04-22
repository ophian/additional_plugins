<?php
##########################################################################
# serendipity - another blogger...                                       #
##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
# Translated by                                                          #
# Sebastian Mordziol <argh@php-tools.net>                                #
# http://sebastian.mordziol.de                                           #
#                                                                        #
##########################################################################

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'de');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'vers');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'R�ecriture de contenu');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Remplace des mots avec un texte d�fini (pratique par ex. pour les acronymes)');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Nouveau titre');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Entrez le titre de l\'acronyme pour la nouvelle entr�e ({de})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'Titre #%d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Entrez l\'acronyme ici ({de})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'Titre du plugin');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'Le nom de ce plugin');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Nouvelle description');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Entrez la description pour la nouvelle entr�e ({vers})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Description #%s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Entrez la description ici ({vers})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'Texte de remplacement');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'Entrez le texte par lequel vous voulez remplacer le mot que vous avez s�lectionn�. Vous pouvez utiliser {de} et {vers} o� vous le d�sirez pour ajouter une r�ecriture.' . "\n" . 'Exemple: <acronym title="{vers}">{de}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'Caract�re de r�ecriture');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Si vous utilisez un caract�re sp�cial pour forcer la r�ecriture, entrez-le ici. Exemple: si vous d�sirez seulement remplacer \'mot*\' avec le texte que vous avez d�fini, mais ne voulez pas que le \'*\' s\'affiche, entrez ce caract�re ici.');

/* vim: set sts=4 ts=4 expandtab : */
