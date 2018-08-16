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

@define('PLUGIN_KARMA_VERSION', '1.2');
@define('PLUGIN_KARMA_NAME', 'Karma');
@define('PLUGIN_KARMA_BLAHBLAH', 'Donne � vos visiteurs la possibilit� de noter vos billets');
@define('PLUGIN_KARMA_VOTETEXT', 'Karma de cet article: ');
@define('PLUGIN_KARMA_RATE', 'Noter cet article: %s');
@define('PLUGIN_KARMA_VOTEPOINT_1', 'Excellent!');
@define('PLUGIN_KARMA_VOTEPOINT_2', 'Bon');
@define('PLUGIN_KARMA_VOTEPOINT_3', 'Neutre');
@define('PLUGIN_KARMA_VOTEPOINT_4', 'Pas int�ressant');
@define('PLUGIN_KARMA_VOTEPOINT_5', 'Mauvais');
@define('PLUGIN_KARMA_VOTED', 'Votre notation "%s" a �t� enregistr�e.');
@define('PLUGIN_KARMA_INVALID', 'Votre notation est invalide.');
@define('PLUGIN_KARMA_ALREADYVOTED', 'Votre notation a d�j� �t� enregistr�e.');
@define('PLUGIN_KARMA_NOCOOKIE', 'Votre navigateur doit accepter les cookies pour que vous puissiez voter.');
@define('PLUGIN_KARMA_CLOSED', 'Votez pour les billets �crits il y a moins de %s jours!');
@define('PLUGIN_KARMA_ENTRYTIME', 'Temps de vote apr�s publication');
@define('PLUGIN_KARMA_VOTINGTIME', 'Temps de vote');
@define('PLUGIN_KARMA_ENTRYTIME_BLAHBLAH', 'Pendant combien de temps (en minutes) apr�s que votre billet ait �t� publi� les visiteurs peuvent-ils donner leur vote sans restriction? Valeur par d�faut: 1440 (un jour). Quelques valeurs utiles: 2 jours = 2880, 3 jours = 4320, 4 jours = 5760, 5 jours = 7200');
@define('PLUGIN_KARMA_VOTINGTIME_BLAHBLAH', 'Laps de temps (en minutes) n�cessaire entre deux votes. Ceci n\'entre en vigueur qu\'apr�s le temps ci-dessus a expir�. Valeur par d�faut: 5');
@define('PLUGIN_KARMA_TIMEOUT', 'Protection contre l\'inindation: Un autre visteur vient juste de donner sa note. Merci de patienter %s minutes avant de donner la v�tre.');
@define('PLUGIN_KARMA_CURRENT', 'Karma actuel: %2$s, %3$s note(s)');
@define('PLUGIN_KARMA_EXTENDEDONLY', 'Dans la vue d�taill�e seulement');
@define('PLUGIN_KARMA_EXTENDEDONLY_BLAHBLAH', 'Afficher la notation Karma seulement dans la vue d�taill�e d\'un billet.');
@define('PLUGIN_KARMA_MAXKARMA', 'Temps de notation autoris�');
@define('PLUGIN_KARMA_MAXKARMA_BLAHBLAH', 'N\'autoriser la notation que pour une p�riode de X jours. Valeur par d�faut: 7');
@define('PLUGIN_KARMA_LOGGING', 'Loguer les notes?');
@define('PLUGIN_KARMA_LOGGING_BLAHBLAH', 'Les notations Karma doivent-elles �tre logu�es?');
@define('PLUGIN_KARMA_ACTIVE', 'Activer la notation Karma?');
@define('PLUGIN_KARMA_ACTIVE_BLAHBLAH', 'Est-ce que la notation Karma doit �tre activ�e?');
@define('PLUGIN_KARMA_VISITS', 'Activer le compteur de visites?');
@define('PLUGIN_KARMA_VISITS_BLAHBLAH', 'Chaque visite d\'un billet (vue d�taill�e) doit-elle �tre compt�e et affich�e?');
@define('PLUGIN_KARMA_VISITSCOUNT', ' %4$s visites');
@define('PLUGIN_KARMA_STATISTICS_VISITS_TOP', 'Billets les plus lus');
@define('PLUGIN_KARMA_STATISTICS_VISITS_BOTTOM', 'Billets les moins lus');
@define('PLUGIN_KARMA_STATISTICS_VOTES_TOP', 'Billets les plus charg�s en Karma');
@define('PLUGIN_KARMA_STATISTICS_VOTES_BOTTOM', 'Billets les moins charg�s en Karma');
@define('PLUGIN_KARMA_STATISTICS_POINTS_TOP', 'Billets les mieux not�s');
@define('PLUGIN_KARMA_STATISTICS_POINTS_BOTTOM', 'Billets les moins not�s');
@define('PLUGIN_KARMA_STATISTICS_VISITS_NO', 'visites');
@define('PLUGIN_KARMA_STATISTICS_VOTES_NO', 'notes');
@define('PLUGIN_KARMA_STATISTICS_POINTS_NO', 'points');

