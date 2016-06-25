<?php

/**
 *  @version 
 *  @author Ahmet Usal <ahmetusal@gmail.com>
 *  First public version: lang_tr.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', '�lgili yaz�lar/makaleler/web ba�lant�lar�');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Yaz� ba��na konuyla ilgili sitede mevcut yaz�-makale ya da site d��� web ba�lant�s� ekle. �l�eklenebilirlik amac�yla  "plugin_relatedlinks.tpl" adl� Smarty-�ablon dosyas�n� d�zenleyerek web sayfas� ��kt�n� istedi�in g�r�n�mde olu�turabilirsin.Not: Bu eklenti sadece yaz�n�n ayr�nt�l�-tam g�sterimi s�ras�nda etkin olur.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'G�stermek istedi�iniz ilgili web ba�lant�s�n� yaz�n. Her sat�r i�in bir URL adresi (HTML kodu i�ermesin!)  (altsat�rlar yeni sat�rba�lar� anlam�na gelir)yaz�n. A��klama eklemek isterseniz, �u format� kullanabilirsiniz: http://ornek.com/link.html=Ornek Link. �u i�aretten sonraki her�ey "=" a��klama amac�yla kullan�lacakt�r. E�er a��klama yazmazsan�z, sadece web ba�lant�n�z ba�l�k olarak g�r�nt�lenecektir.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', '�lgili Web Ba�lant�lar�:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', '�lgili yaz�lar/web ba�lant�lar� i�in yerle�im d�zeni');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Yaz�n�z�n alt�na ilgili makale ve web ba�lant�lar�n� ekleme ya da Smarty �ablonlama sistemini kullanma se�ene�idir. E�er Smarty �ablonlama sistemini etkin k�larsan�z, �u a�a��daki sat�r� entries.tpl �ablon dosyan�za, foreach d�ng�s�nde $entry de�i�keni neredeyse  oraya eklemeniz gerekmektedir.(burada g�r��ler, izd���mleri ve yaz�n�n daha fazla yaz� ekleme g�vde b�lgesi g�sterilmektedir): {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Yaz� alt�na yerle�tir');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Yaz�n�n i�ine yerle�tir');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Smarty �a�r�s� kullan');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Ba�lant� ay�rma karakteri');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Yaz�n�zdaki URL adreslerini ve a��klamalar� ay�racak bir harf karakteri ekleyin. Bu karakterin URL ya da ba�l�kta mevcut olmad���na emin olun, bunun gibi bir karakterle ayr�m yap�n: "|".');

