<?php

##########################################################################
#                                                                        #
# Translated by                                                          #
# Jo�o P. Matos <jmatos@math.ist.utl.pt>                                 #
#                                                                        #
##########################################################################

@define('PLUGIN_EVENT_TEXTWIKI_NAME',     'C�digo: Wiki');
@define('PLUGIN_EVENT_TEXTWIKI_DESC',     'Codifica��o do texto usando Text_Wiki');
@define('PLUGIN_EVENT_TEXTWIKI_TRANSFORM', 'S�ntaxe <a href="http://c2.com/cgi/wiki">Wiki</a> autorizada');

// 

@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PREFILETER', 'Converte fins de linha de diferentes sistemas operativos (Unix/DOS) para um formato �nico e concatena linhas terminadas em \. Activado por omiss�o. � recomendado manter activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_DELIMITER', 'Converte o limitador interno do Text_Wiki "\xFF" (255) para evitar conflitos na interpreta��o. Activo por omiss�o. Recomendado manter activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_CODE', 'Marca texto texto entre <code> e </code> como c�digo. Usando <code type=".."> pode activar formata��o (e.g. para PHP). Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PHPCODE', 'Marca e formata texto entre <php> e </php> como c�digo php e adiciona etiquetas abertas de PHP . Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HTML', 'Permite escrever c�digo HTML entre <html> e </html>. Cuidado que JS tamb�m � poss�vel! Se usar isto, n�o use codifica��o de coment�rios! Inactivo por omiss�o. Recomendado manter inactivo.'); // Review
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_RAW', 'Texto entre `` e `` n�o �e interpretado por quaisquer outras regras. Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_INCLUDE', 'Permite incluir e correr c�digo PHP com a s�ntaxe [[include /caminho/para/script.php]]. O resultado � interpretado pelas regras de codifica��o. Cuidado, risco de seguran�a! Se usar isto, n�o use codifica��o de coment�rios! Inactivo por omiss�o. Recomendado manter inactivo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_INCLUDE_DESC_BASE', 'O direct�rio de base para os seus scripts. Por omiss�o "/caminho/para/scripts/". Se deixar em branco e ligar include s� pode usar caminhos absolutos.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HEADING', 'Linhas come�ando com "+ " s�o marcadas como t�tulos (+ = <h1>, ++++++ = <h6>). Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HORIZ', '---- � convertido para uma linha horizontal (<hr>). Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BREAK', 'Fins de linha marcados com " _" definem fins de linha expl�citos. Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BLOCKQUOTE', 'Permite usar cita��es de tipo email ("> ", ">> ",...). Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_LIST', 'Permite cria��o de listass ("* " = n�o numeradas, "# " = numeradas). Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_DEFLIST', 'Permite criar listas de defini��es. S�ntaxe: ": T�pico : Defini��o". Activo por omiss�o.'); //Verify
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TABLE', 'permite criar tabelas. S� usar para linhas completas. S�ntaxe: "|| C�lula 1 || C�lula 2 || C�lula 3 ||". Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_EMBED', 'Permite incluir e correr c�digo PHP com a s�ntaxe [[embed /caminho/para/script.php]]. O resultado n�o � interpretado pelas regras de codifica��o. Cuidado, risco de seguran�a! Se usar isto, n�o use codifica��o de coment�rios! Inactivo por omiss�o. Recomendado manter inactivo.'); //Verify
@define('PLUGIN_EVENT_TEXTWIKI_RULE_EMBED_DESC_BASE', 'O direct�rio de base para os seus scripts. Por omiss�o "/caminho/para/scripts/". Se deixar em branco e ligar embed s� pode usar caminhos absolutos.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_IMAGE', 'Permite a inclus�o de imagens. ([[image  /caminho/para/imagem.ext [atributos HTML] ]] or [[image  caminho/para/imagem.ext [link="NomeP�gina"] [atributos HTML] ]] para imagens com conex�o). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_IMAGE_DESC_BASE', 'O direct�rio de base para as suas imagens. Por omiss�o "/caminho/para/imagens". Se deixar em branco s� pode usar caminhos absolutos ou URLs.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PHPLOOKUP', 'Cria liga��es de busca ao manual de PHP com [[php function-name]]. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TOC', 'Gera um �ndice de todos os t�tulos usados com [[toc]]. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_NEWLINE', 'Converte "newlines" ("\n") isoladas to line breakspara mudan�as de linha. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_CENTER', 'Linhas come�adas com "= " s�o centradas. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PARAGRAPH', 'Converte "newlines" ("\n") duplas para par�grafos (<p></p>). Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_URL', 'Converte http://example.com para liga��o, [http://example.com] para nota de p� de p�gina e [http://example.com Example] para uma liga��o com descri��o. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_URL_DESC_TARGET', 'Define o alvo (target) das suas URLs. Por omiss�o � "_blank".'); //Verify
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_FREELINK', 'permite defini��o de liga��es n�o-standard de wiki via "((Non-standard link format))" e "((Non-standard link|Describtion))". Por omiss�o inactivo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_PAGES', 'A regra de freelink (assim como a regra wikilink) devem saber que p�ginas existem e que p�ginas devem ser marcadas como "novas". Isto especifica a localiza��o de um ficheiro (local ou remoto) que tem que conter 1 nome de p�gina por linha. Se o ficheiro for remoto, ser� posto em cache pelo tempo especificado.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_VIEWURL', 'Esta URL � especificada para visualizar freelinks. Tem que especificar um "%s" dentro desta URL que ser� substitu�do pelo nome da p�gina freelink.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_NEWURL', 'Esta URL � especificada para criar novas freelinks. Tem que especificar um "%s" dentro desta URL que ser� substitu�do pelo nome da p�gina freelink.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_NEWTEXT', 'Este texto ser� adicionado a freelinks n�o definidas para ligar � p�gina de cria��o. Incializado como "?".');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_CACHETIME', 'Se especificar um ficheiro remoto (URL) para as suas p�ginas de freelinks, este ficheiro estar� em cache durante o n�mero de segundos especificado aqui. O valor por omiss�o � de 1 hora.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_INTERWIKI', 'Permite liga��es inter wiki a MeatBall, Advogato e Wiki usando SiteName:PageName ou [NomeS�tio:NomeP�gina Mostrar este texto alternativo]. Activo por omiss�o.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_INTERWIKI_DESC_TARGET', '');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_WIKILINK', 'Permite uso de PalavrasWiki (WikiWords) standard (2-X x mai�sculas) como links wiki. por omiss�o inactivo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_PAGES', 'A regra wikilink deve saber que p�ginas existem e quais devem ser marcadas como "novas". Isto especifica a localiza��o de um ficheiro (local ou remoto) que tem que conter um nome de p�gina por linha. Se o ficheiro for remoto, ser� posto em cache pelo tempo especificado.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_VIEWURL', 'A URL especificada para ver as wikilinks. Tem que especificar "%s" dentro desta URL que ser� substitu�do pelo nome da p�gina wikilink.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_NEWURL', 'Esta URL � especificada para criar novos wikilinks. Tem que especificar "%s" dentro desta URL que ser� substitu�do pelo nome da p�gina wikilink.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_NEWTEXT', 'Este texto ser� adicionado a wikilinks n�o definidas para ligar � p�gina de cria��o. Incializado como "?".');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_CACHETIME', 'Se especificar um ficheiro remoto (URL) para as suas p�ginas wikilink, este ficheiro estar� em cache durante o n�mero de segundos especificado aqui. O valor por omiss�o � de 1 hora.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_COLORTEXT', 'Colorir texto usando ##cor|texto##. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_STRONG', '**Texto** � marcado como forte (strong). Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BOLD', '\'\'\'Texto\'\'\' � marcado a negrito (bold). Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_EMPHASIS', '//Texto// � marcado com �nfase. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_ITALIC', '\'\'Texto\'\' � marcado it�lico. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TT', '{{Texto}} � escrito com caracteres de teletipo (monotype). Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_SUPERSCRIPT', '^^Texto^^ � escrito como superescrito. Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_REVISE', 'Permite marcar texto como revis�es usando "@@---texto a apagar+++texto a inserir@@". Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TIGHTEN', 'Encontra seu�ncias de mais de 3 newlines e redu-las a 2 newlines (par�grafo). Por omiss�o activo.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_ENTITIES', 'Escapar entidades HTML. Por omiss�o activo.');


/* vim: set sts=4 ts=4 expandtab : */
