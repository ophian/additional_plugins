<?php #

/**
 *  @author Ahmet Usal <ahmetusal@gmail.com>
 *  First public version: lang_tr.inc.php
 */

@define('STATICPAGE_HEADLINE', 'Ba�l�klar');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Ba�l�klar� i�erikten �stte �ncelikli g�ster');
@define('STATICPAGE_TITLE', 'Statik Sayfalar');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Statik sayfalar site i�erisinde tasar�m ve t�m bi�imlemeye dahil olsun. Y�netim arabirimine yeni men� unsuru olarak eklensin.');
@define('CONTENT_BLAHBLAH', 'i�erik');
@define('STATICPAGE_PERMALINK', 'Kal�c� Ba�lant�');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'URL adresleri i�in kal�c� ba�lant� tan�m�. Kesin HTTP yolunun belirtilmesi ve sonunun .htm ya da .html olarak bitmesi gerekli!');
@define('STATICPAGE_PAGETITLE', 'URL adresinin k�sa adland�rmas� (Geriye do�ru uyumluluk amac�yla)');
@define('STATICPAGE_ARTICLEFORMAT', 'Makale gibi bi�imlensin mi?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Evet se�ene�i i�aretlenirse  sitedeki bir makale, yaz� gibi bi�imlendirilecek. (renkler, kenarl�klar vb.) (�ntan�ml� : evet)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Sayfa Ba�l��� "Makale olarak bi�imlendir" modunda');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Makale bi�imini kullan�rken, yay�nlanma tarihine g�re hangi metni g�sterilebilece�inizi se�ebildi�iniz gibi statik sayfan�za da belirli bir yay�n tarihindeki makalelerle beraber g�sterilecek �ekilde yay�nlayabilirsiniz.');
@define('STATICPAGE_SELECT', 'D�zenlemek ya da olu�turmak i�in bir statik sayfa bi�imi se�in.');
@define('STATICPAGE_PASSWORD_NOTICE', 'Bu safya �ifre korumal�. L�tfen korumay� kald�rmak i�in size verilen �ifreyi yaz�n: ');
@define('STATICPAGE_PARENTPAGES_NAME', '�st Sayfa');
@define('STATICPAGE_PARENTPAGE_DESC', 'Sayfan�z�n ba�l� olmas�n� istedi�iniz �st sayfay� se�in');
@define('STATICPAGE_PARENTPAGE_PARENT', '�st Sayfa olarak');
@define('STATICPAGE_AUTHORS_NAME', 'Yazar\Yazarlar�n Ad�');
@define('STATICPAGE_AUTHORS_DESC', 'Bu yazar bu sayfan�n sahibidir.');
@define('STATICPAGE_FILENAME_NAME', '�ablon (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Bu sayfa i�in kullanmak istedi�iniz �ablon dosyas�n�n ad�n� yaz�n. Bu smarty dosyas� eklentileriniz ya da �ablonlar�n�z�n bulundu�u dizine yerle�tirilecek.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Alt Sayfalar� g�ster');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Bu sayfaya ba�l� t�m alt sayfalar� ba�lant�lar listesinde g�sterir.');
@define('STATICPAGE_PRECONTENT_NAME', '�n-i�erik');
@define('STATICPAGE_PRECONTENT_DESC', 'Bu i�eri�i kendisine ba�l� alt sayfalar�n listesinden �nce g�sterir.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Bu sayfa bu durumdayken silinemez.��nk� alt sayfalar� veritaban�na kay�tl� durumda.L�tfen �nce bu sayfaya ba�l� alt sayfalar� silin.');
@define('STATICPAGE_IS_STARTPAGE', 'Bu sayfay� Serendipity anasayfas� yap');
@define('STATICPAGE_IS_STARTPAGE_DESC', '�ntan�ml� olarak g�sterilen Serendipity ba�lang�� sayfas� yerine bu statik sayfa g�sterilecek. Sadece bir sayfa ba�lang�� sayfas�(Ana Sayfa) olarak tan�mlanabilir! �ntan�ml� olarak kullan�lan Serendipity Anasayfas�na ba�lant� vermek istiyorsan�z, "index.php?frontpage" ba�lant� kal�b�n� kullanabilirsiniz.Bu �zelli�i kullanmak istiyorsan�z, ba�ka bir kal�c� ba�lant� eklentisinin, Serendipity yap�land�rma s�ralamas�nda statik sayfa eklentisinden �nce gelmedi�ine emin olmal�s�n�z.(Anket, Konuk Defteri eklentileri vb.).');
@define('STATICPAGE_TOP', 'YUKARI');
@define('STATICPAGE_NEXT', 'Sonraki');
@define('STATICPAGE_PREV', '�nceki');
@define('STATICPAGE_LINKNAME', 'D�zenle');

@define('STATICPAGE_ARTICLETYPE', 'Makale t�r�');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Statik Sayfa olarak belirlemek istedi�iniz t�r� se�in.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Sayfa S�ralamas�');
@define('STATICPAGE_CATEGORY_PAGES', 'Sayfalar� D�zenle');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Sayfa T�rleri');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Di�er Eklentiler');

@define('PAGETYPES_SELECT', 'Bir sayfa t�r� se�in.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'A��klama:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Sayfa t�r�n�n a��klamas�.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', '�ablon Ad�:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', '�ablondan isim. Statik Sayfa eklentisinde ya da �n tan�ml� �ablon dizininizde mevcut olmal�.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Resim yolu:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'Kullan�lacak resmin URL adresi.');

@define('STATICPAGE_SHOWNAVI', 'Site Men�s�n� g�ster');
@define('STATICPAGE_SHOWNAVI_DESC', 'Bu sayfada site men�s�n� g�ster.');
@define('STATICPAGE_SHOWONNAVI', 'Yan-blok men�s�nde g�ster');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Bu sayfay� yan-blok men�s�nde g�ster.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Site Men�s�nde g�ster');
@define('STATICPAGE_DEFAULT_DESC', 'Yeni sayfalar i�in �ntan�ml� ayard�r.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Sayfay� Site Yan-Bloktaki men�de g�ster.');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', '��aretleme dilini g�ster');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Makale olarak bi�imle');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Sayfaya ba�l� altsayfalar� g�ster.');

@define('STATICPAGE_PAGEORDER_DESC', 'Buradan statik sayfalar�n�z�n g�sterilme s�ras�n� de�i�tirebilirsiniz.');
@define('STATICPAGE_PAGEADD_DESC', 'Statik Sayfalar men�s�ne eklemek istedi�iniz siteyi se�in.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'A�a��da s�ralanan eklentiler yanbloktaki statik sayfalar men�s�ne eklenebilir.');

@define('STATICPAGE_PUBLISHSTATUS', 'Yay�nlama-Durumu');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Bu sayfan�n yay�n durumu.');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', 'Taslak');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', 'Yay�nda');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Men�de ba�l��� ya da �nceki/Sonraki linklerini g�ster.');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Metin: �nceki/Sonraki');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Ba�l�k');

@define('STATICPAGE_LANGUAGE', 'Dil');
@define('STATICPAGE_LANGUAGE_DESC', 'Bu b�l�mde kulllan�lacak dili se�in.');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Eklenti kurulu');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Eklenti kurulabilir');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Eklenti kurulamaz');

@define('LANG_ALL', 'T�m Diller');
@define('LANG_EN', '�ngilizce');
@define('LANG_DE', 'Almanca');
@define('LANG_DA', 'Danimarkaca');
@define('LANG_ES', '�spanyolca');
@define('LANG_FR', 'Frans�zca');
@define('LANG_FI', 'Fince');
@define('LANG_CS', '�ekce (Win-1250)');
@define('LANG_CZ', '�ekce (ISO-8859-2)');
@define('LANG_NL', 'Flemenk�e');
@define('LANG_IS', '�zlandaca');
@define('LANG_PT', 'Portekiz Brezilcesi');
@define('LANG_BG', 'Bulgarca');
@define('LANG_NO', 'Norve�ce');
@define('LANG_RO', 'Rumence');
@define('LANG_IT', '�talyanca');
@define('LANG_RU', 'Rus�a');
@define('LANG_FA', 'Fars�a');
@define('LANG_TR', 'T�rk�e (ISO-8859-9)');
@define('LANG_TW', 'Geleneksel �ince (Big5)');
@define('LANG_TN', 'Geleneksel �ince (UTF-8)');
@define('LANG_ZH', 'Basit �ince (GB2312)');
@define('LANG_CN', 'Basit �ince (UTF-8)');
@define('LANG_JA', 'Japonca');
@define('LANG_KO', 'Korece');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',                   'Statik Sayfalar Listesi');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              'Bu eklenti statik sayfalar�n yap�land�r�labilir bir listesini g�sterir. Bu i�lemin ger�ekle�ebilmesi i�in Statik Sayfa Eklentisinin 1.22 ya da daha y�ksek bir s�r�m�n�n kurulu olmas� gereklidir.');
@define('PLUGIN_STATICPAGELIST_TITLE',                  'Ba�l�k');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             'Yan-Blokta g�sterilecek ba�l���n� yaz�n:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          'Statik Sayfalar');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  'G�sterilecek Statik Sayfa Say�s�');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             'G�sterilecek Statik Sayfa Say�s�n� yaz�n. 0, s�n�r yok anlam�ndad�r.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         'Anasayfa ba�lant�s�n� g�ster');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         'Anasayfada ba�lant� olu�tur');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     'Anasayfa');
@define('PLUGIN_LINKS_IMGDIR',                          'Eklenti resim dizinini kullan');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 'Resimlere ula��labilmesi i�in URL adresi yolunu belirtin. "img" altdizini bu tan�mlanacak �st dizine ihtiya� duyar ve bu eklentiyle an�lan dizini kullanabilir.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         '�konlar ya da d�z metin');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         'Dizinlerin a�a� yap�s�n� grafik ikonlarla ya da d�z metin olarak g�sterir.');
@define('PLUGIN_STATICPAGELIST_ICON',                   'JS A�a� Yap�s�');
@define('PLUGIN_STATICPAGELIST_TEXT',                   'D�z Metin');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            'Sadece �st-ebeveyn sayfalar g�sterilsin mi?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       'E�er bu se�enek etkin olursa sadece �st-ebeveyn sayfalar g�sterilir. Etkinle�tirilmezse �st sayfalara ba�l� altsayfalarda g�sterilir.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               'A�a� Yap�s�nda grafik g�sterim etkin');

