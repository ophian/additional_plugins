<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 */

@define('PLUGIN_EVENT_MIMETEX_NOTE','Plugin vykresluje obr�zky gif podle vstupu TeXu. Z�vis�m na extern�m spustiteln�m programu. Vy�aduje bu� MimeTex nebo plnou verzi laTeX. MimeTex je podstatn� jednodu��� nainstalovat, ale nevykresluje fonty tak �ist� jako opravdov� LaTeX. LaTeX vykresluje pomoc� pozm�n�n� knihovny GPL <a href="http://www.mayer.dial.pipex.com/tex.htm">LatexRender</a>, kter� se li�� podle distribuce LaTeXu a pomoc� ImageMagicku (kter� z�vis� na Ghostcriptu).<br />  Pro v�ce informac� �t�te <a href="http://www.forkosh.com/mimetex.html">http://www.forkosh.com/mimetex.html</a><br />');
@define('PLUGIN_EVENT_MIMETEX_NAME', 'Interpret p��kaz� MimeTex/LaTeX');
@define('PLUGIN_EVENT_MIMETEX_NAME_BUTTON', 'TeX');
@define('PLUGIN_EVENT_MIMETEX_DESC', 'Vytvo�� obr�zky gif z v�razu TeX pou�it�m softwaru MimeTex nebo LaTeX');
@define('PLUGIN_EVENT_MIMETEX_PATH', 'Cesta k instalaci MimeTex');
@define('PLUGIN_EVENT_MIMETEX_REPLACE_DESC', 'Pokud je povoleno, �et�zce TeXu mezi tagy [tex][/tex] (nap�.: [tex]\frac{2}{3}[/tex] pro vykreslen� zlomku 2/3) budou dynamicky p�em�n�ny. Pokud je vypnuto, �et�zce TeXu mus� b�t do p��sp�vku vlo�eny pomoc� tla��tka TeX nad polem editoru.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX', 'Pou��t MimeTeX nebo LaTeX?');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_BLAHBLAH', 'Jako vykreslovac� stroj se m� pou��t MimeTeX nebo LaTeX? Jeden z nich mus� b�t nainstalovan� nav�c vedle pluginu, plugin s�m o sob� neum� vykreslovat p��kazy TeX bez jejich p��tomnosti.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_LATEX','LaTeX');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_MIMETEX','MimeTeX');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH','Cesta k LaTeXu');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH_DESC','Absolutn� cesta ke spustiteln�m soubor�m LaTeXu.');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH','Cesta k dvips');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH_DESC','Absolutn� cesta ke spustiteln�mu souboru dvips.');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH','Cesta k convert');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH_DESC','Absolutn� cesta ke spustiteln�mu souboru convert.');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY','Pou��vat pr�hledn� pozad� v obr�zc�ch?');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY_DESC','P�ep�n�, jestli m� b�t u v�sledn�ho gif obr�zku pou�ita pr�hledn� barva. To je vhodn� u blog� s tmav�m nebo r�znorod�m pozad�m. Pamatujte, �e d��ve vytvo�en� obr�zky nebudou znovu tvo�eny a z�stanou v p�vodn� verzi.');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE','Typ obr�zku');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE_DESC','LatexRendere um� poskytnout obr�zky bu� ve form�tu gif nebo png.');

