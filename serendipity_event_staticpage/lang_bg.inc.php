<?php # 

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.11
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', '��������');
@define('STATICPAGE_HEADLINE_BLAHBLAH', '��������, ����� �� ������� ��� ������������ � � ����������� ���� ����� ����� �������� � �����.');
@define('STATICPAGE_TITLE', '�������� ��������');
@define('STATICPAGE_TITLE_BLAHBLAH', '������� �������� �������� ��� ����� ���� ����������� ����� ������ �� �����. ������ ���� ������� ��� ����������������� ����.');
@define('CONTENT_BLAHBLAH', '');
@define('STATICPAGE_PERMALINK', 'Permalink (���������� ������)');
@define('STATICPAGE_PERMALINK_BLAHBLAH', '�������� permalink �� URL. ������ �� ���� ��������� HTTP ��� � �� �������� � \'.htm\' or \'.html\' !');
@define('STATICPAGE_PAGETITLE', '���� ��� �� URL (������������ �����)');
@define('STATICPAGE_ARTICLEFORMAT', '����������� ���� ������ ?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', '��� ����� \'��\' ���������� ����������� �� ���� ����������� ���� ������ (�������, �������, �������� � �.�.), �� ������������: \'��\'.');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', '�������� �� ����������, ������ � ����������� ���� ������');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', '��� ���������� �� ������ ���� ������, ������ �� �������� ����� ����� �� �� �������, ������ �� ������� ������ ��� �������� �� ���� ���.');
@define('STATICPAGE_SELECT', '�������� �������� �� ����������� ��� \'����\' �� ��������� �� ���� ��������.');
@define('STATICPAGE_PASSWORD_NOTICE', '������������� �� ���� �������� ������� ����������� �� ������. �������� � ���. ');
@define('STATICPAGE_PARENTPAGES_NAME', '���������� ��������');
@define('STATICPAGE_PARENTPAGE_DESC', '�������� ���������� �������� �� ���� ��������');
@define('STATICPAGE_PARENTPAGE_PARENT', '���� � ���������� ��������');
@define('STATICPAGE_AUTHORS_NAME', '��� �� ������');
@define('STATICPAGE_AUTHORS_DESC', '���� ����� � ���������� �� ����������');
@define('STATICPAGE_FILENAME_NAME', 'Smarty ������ �� ����������');
@define('STATICPAGE_FILENAME_DESC', '��� �� ����� - Smarty ������, ����� �� �� �������� �� ���� ��������. ���� ���� ���� �� ���� �������� � ������������ �� ���� ��������� ��� � ������������ �� ��������� �� ��� ���� (templates/your_theme).');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', '��������� �� �������� ����');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', '��������� �� ����������-���� � ������ �� ������.');
@define('STATICPAGE_PRECONTENT_NAME', '������������� ����������');
@define('STATICPAGE_PRECONTENT_DESC', '���� ���������� �� ������� ����� ������� �� ���������� ����.');
@define('STATICPAGE_CANNOTDELETE_MSG', '���� �������� �� ���� �� ���� �������, ������ �� ��� �������� ����. ����� ������ �� �������� ���.');
@define('STATICPAGE_IS_STARTPAGE', '���� �������� �� ���� ������ �������� �� ����� (�� �����)');
@define('STATICPAGE_IS_STARTPAGE_DESC', '������ �� �� ������� �������������� �� ������ �������� (��� ��������) �� �� ������� ���� ��������. ��� ������� ������ ��� ���������� ������ ��������, ����������� \'index.php?frontpage\'.');
@define('STATICPAGE_TOP', '����');
@define('STATICPAGE_NEXT', '��������');
@define('STATICPAGE_PREV', '��������');
@define('STATICPAGE_LINKNAME', '�����������');

@define('STATICPAGE_ARTICLETYPE', '��� �� ����������');
@define('STATICPAGE_ARTICLETYPE_DESC', '�������� ���� �� ����������.');

@define('STATICPAGE_CATEGORY_PAGEORDER', '����������');
@define('STATICPAGE_CATEGORY_PAGES', '�����������');
@define('STATICPAGE_CATEGORY_PAGETYPES', '������ ��������');
@define('STATICPAGE_CATEGORY_PAGEADD', '����� ���������');

@define('PAGETYPES_SELECT', '�������� ��� �� ����������.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', '��������');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', '������ �������� �� ���� ��� �������� - ����� ��������, ��������������. ������ �� ������������ ������� ���� �������� ������ ��������������.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Smarty ������ �� ����������');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', '��� �� ����� - Smarty ������, ����� �� �� �������� �� ���� ��������. ���� ���� ���� �� ���� �������� � ������������ �� ���� ��������� ��� � ������������ �� ��������� �� ��� ���� (\'templates/your_theme\').');
@define('STATICPAGE_ARTICLETYPE_IMAGE', '��� �� ���������� �� ����');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', ' ������ �� ������� �������� �����������, ����� �� ���� �������� � ���� ���. ���� ����������� �� �� ������� �� ������ �������� �� ���� ���. ���� ����������� �� ���� ��-����� �� �� ��������� � ������������ �� ����� ����. ��� � ��������� ����� ��� �� �����.');

@define('STATICPAGE_SHOWNAVI', '��������� �� ���������');
@define('STATICPAGE_SHOWNAVI_DESC', '��������� �� ������������ ������ � ����������.');
@define('STATICPAGE_SHOWONNAVI', '��������� � ����������� ���������');
@define('STATICPAGE_SHOWONNAVI_DESC', '��������� �� ������ ��� ���������� � ����������� � ����������� ���������.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', '��������� �� ��������� � ��������� ���������');
@define('STATICPAGE_DEFAULT_DESC', '������������ �� �������� �� ���� ��������.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', '��������� �� ���������� ��� ��������� � ��������� ���������');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', '��������� �� ������');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', '����������� ���� ������');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', '��������� �� �������� ���� (�� ���� ������������)');

@define('STATICPAGE_PAGEORDER_DESC', '���������� �� ���������� ��������');
@define('STATICPAGE_PAGEADD_DESC', '����� �� ���������, ����� �� ����� �������� ���� ������ � ����������� �� ���������� ��������');
@define('STATICPAGE_PAGEADD_PLUGINS', '���������� ��������� ����� �� ����� �������� � ����������� ��������� �� ���������� ��������:');

@define('STATICPAGE_PUBLISHSTATUS', '���������');
@define('STATICPAGE_PUBLISHSTATUS_DESC', '������ �� ��������� �� ����������.');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', '��������� �� ���������� ��� \'��������\'/\'��������\' ��� �����������');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', '��������/��������');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', '��������');

@define('STATICPAGE_LANGUAGE', '����');
@define('STATICPAGE_LANGUAGE_DESC', '���������� ����� �� ���� ��������.');

@define('STATICPAGE_PLUGINS_INSTALLED', '����������� � �����������');
@define('STATICPAGE_PLUGIN_AVAILABLE', '����������� � �������, �� �� � �����������');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', '����������� �� � �������');

@define('STATICPAGE_SEARCHRESULTS', '�������� �� %d �������� ��������:');

@define('LANG_ALL', '������ �����');
@define('LANG_EN', 'English');
@define('LANG_DE', 'German');
@define('LANG_DA', 'Danish');
@define('LANG_ES', 'Spanish');
@define('LANG_FR', 'French');
@define('LANG_FI', 'Finnish');
@define('LANG_CS', 'Czech (Win-1250)');
@define('LANG_CZ', 'Czech (ISO-8859-2)');
@define('LANG_NL', 'Dutch');
@define('LANG_IS', 'Icelandic');
@define('LANG_PT', 'Portuguese Brazilian');
@define('LANG_BG', 'Bulgarian');
@define('LANG_NO', 'Norwegian');
@define('LANG_RO', 'Romanian');
@define('LANG_IT', 'Italian');
@define('LANG_RU', 'Russian');
@define('LANG_FA', 'Persian');
@define('LANG_TW', 'Traditional Chinese (Big5)');
@define('LANG_TN', 'Traditional Chinese (UTF-8)');
@define('LANG_ZH', 'Simplified Chinese (GB2312)');
@define('LANG_CN', 'Simplified Chinese (UTF-8)');
@define('LANG_JA', 'Japanese');
@define('LANG_KO', 'Korean');

@define('STATICPAGE_STATUS', '���������');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',                   '�������� �������� - ������');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              '���� ��������� ������� ������������� ������ �� �������� ��������.');
@define('PLUGIN_STATICPAGELIST_TITLE',                  '��������');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             '�������� �� ����������� ���������');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          '�������� ��������');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  '���� ��������');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             '����� ������ ��� �������� �������� �� �� ��������. 0 �������� ��� �����������.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         '������ ��� �������� ��������');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         '�� ��� �� ������ ��� �������� �������� (��� ��������) ?');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     '�������� ��������');
@define('PLUGIN_LINKS_IMGDIR',                          '���������� � �������� �� ��������� �� �������');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 '����� URL �� ����������, ��������� ������������ ���������. ���������� \'img\' ������ �� �� ������ � ���� ���������� (�� � ���� �� ���� ���������).');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         '������� ��� ���� �����');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         '�������� �� �� �������� � ���������� ��������� ��� ���� ���� �����.');
@define('PLUGIN_STATICPAGELIST_ICON',                   'JS �����');
@define('PLUGIN_STATICPAGELIST_TEXT',                   '�����');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            '���� ���������� �������� ?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       '��� ����� \'��\' ���� ������������ �������� �� ��������. ��� ����� \'��\' �� ������ ������ ��������.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               '���������� �� ������� � ������������ ���������');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES',      'URL �� ������������ ���������� � ������ � %s �������� ��������.'); 

@define('STATICPAGE_QUICKSEARCH_DESC', '��� � ���������, ������� ������� �� ������ � � ���������� ��������.');

@define('STATICPAGE_CATEGORYPAGE','�������� �������� ��������');
@define('STATICPAGE_RELATED_CATEGORY', '�������� ���������');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', '��������� �� �������� �� ���� ��������� ��� ��������� �� ������ ��� ����������� �� ���������� ��������. ����������� "plugin_staticpage_related_category.tpl" �� ���� ����������.');

@define('STATICPAGE_ARTICLE_OVERVIEW','������� �� ����������');
@define('STATICPAGE_NEW_HEADLINES','���-���� ������:');

@define('STATICPAGE_TEMPLATE','������ �� �����������');
@define('STATICPAGE_TEMPLATE_EXTERNAL', '������ ������');

@define('STATICPAGE_SECTION_META', '����-�����');
@define('STATICPAGE_SECTION_BASIC', '������� ����������');
@define('STATICPAGE_SECTION_OPT', '�����');
@define('STATICPAGE_SECTION_STRUCT', '�������������');
