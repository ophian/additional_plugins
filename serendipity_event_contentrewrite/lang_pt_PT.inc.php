<?php

##########################################################################
# serendipity - another blogger...                                       #
##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
# Translated by                                                          #
# Jo�o P Matos <jmatos@math.ist.utl.pt>                                  #
#                                                                        #
##########################################################################

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'de');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'para');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'Reescrita de conte�do');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Substitui palavras por um texto pr� definido (pr�tico para as abreviaturas)');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Novo t�tulo');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Introduza o t�tulo da abreviatura para a nova entrada ({de})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'T�tulo #%d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Introduza a abreviatura aqui ({de})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'T�tulo do plugin');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'O nome deste plugin');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Nova descri��o');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Introduza a descri��o para a nova entrada ({para})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Descri��o #%s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Introduza a descri��o aqui ({para})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'Texto de substitui��o');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'Introduza o texto com o qual pretende substituir a palavra que escolheu. Pode utilizar {de} e {para} onde desejar para juntar uma reescrita.' . "\n" . 'Exemplo: <acronym title="{vers}">{de}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'Caracter de reescrita');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Se utiliza um caracter especial para for�ar a reescrita, introduza-lo aqui. Exemplo: se deseja somente substituir \'palavra*\' com o texto que definiu, mas n�o quer que o \'*\' seja mostrado, introduza o caracter aqui.');

/* vim: set sts=4 ts=4 expandtab : */
