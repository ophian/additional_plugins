<?php

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.8
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', '������ �� ������');
@define('PLUGIN_LINKLIST_DESC', '������� �� �������� - ������� ������ ��� ����� ������� � ��������� ���������.');
@define('PLUGIN_LINKLIST_LINK', '������');
@define('PLUGIN_LINKLIST_LINK_NAME', '���');
@define('PLUGIN_LINKLIST_ADMINLINK', '���������� �� ��������');
@define('PLUGIN_LINKLIST_ORDER', '���������� �� ��������');
@define('PLUGIN_LINKLIST_ORDER_DESC', '�������� ��� �� �� �������� �������� ��� ��������� � ����������� ���������.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', '�� �����');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', '���� (�� ����� ��� ����)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', '���� (�� ���� ��� �����)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', '�� ���������');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', '�������');
@define('PLUGIN_LINKLIST_LINKS', 'Manage Links');
@define('PLUGIN_LINKLIST_NOLINKS', 'No Links in List');
@define('PLUGIN_LINKLIST_CATEGORY', 'Use categories');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Use categories to organize links.');
@define('PLUGIN_LINKLIST_ADDLINK', '�������� �� ������');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', '������: http://www.s9y.org ��� http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', '����������� �� ������');
@define('PLUGIN_LINKLIST_LINKDESC', '�������� �� ��������');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', '������� �� ���������:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', '������ �� �������� ���������� �� ����������� ������� �� ��������� ��� ����������� �� �����.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', '����������');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', '�� �����');
@define('PLUGIN_LINKLIST_ADD_CAT', '���������� �� �����������');
@define('PLUGIN_LINKLIST_CAT_NAME', '��� �� �����������');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', '���������� ���������');
@define('PLUGIN_LINKLIST_ADMINCAT', '�������������� �� �����������');
@define('PLUGIN_LINKLIST_CACHE_NAME', '�������� �� ����������� ���������');
@define('PLUGIN_LINKLIST_CACHE_DESC', '���������� �� ����������� ��������� ��������� ��������� �� ������ ��������. ���������� �� ��������, ������ �� ������� ������ ���� ���������������� ���������.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'Enabled');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'Enable the plugin.');
@define('PLUGIN_LINKLIST_DELETE_WARN', '������ ��������� ��������� �� �������, �������� ����� �� �� ��������� ������ � ��������� ���������� (�� ����� ����).');

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKS_NAME', '������ �� ������');
@define('PLUGIN_LINKS_BLAHBLAH', '������� �� �������� - ������� ������ ��� ����� ������� � ��������� ��������� ���� ���������� ����.');
@define('PLUGIN_LINKS_TITLE', '���');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', '��� �� ����������� ���������, ��������� ������� �� ��������.');
@define('PLUGIN_LINKS_TOP_LEVEL', '����� �� ���-������� ����');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', '�������� �����, ����� �� �� ������� �� ���-������� ���� (���� �� ���� �������� ������).');
@define('PLUGIN_LINKS_DIRECTXML', '�������� ��������� �� XML');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', '�������� �� �������� � XML ������. ������ �� ��������� ���� ��� �������� ��� �� ���������� ���������������� ���������.');
@define('PLUGIN_LINKS_LINKS', '������');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', '�������� �� ������� �� ��������. ����������� XML: �� ���������� - "<dir name="dirname"> ... </dir>; �� ������ - "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', '����� �� �������� �� ������');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', '�������� ����� �� ��������, � ����� �� ������� ������ ������ � �������.');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', '������ ������');
@define('PLUGIN_LINKS_CLOSEALL', '����� �� ��������� �� ������');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', '�������� ����� �� ��������, � ����� �� �������� ������ ������ � �������.');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', '������� ������');
@define('PLUGIN_LINKS_SHOW', '��������� �� ������ � ������� ������');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', '�� �� �������� �� �������� �� �������� � ��������� �� ������ ����� ?');
@define('PLUGIN_LINKS_LOCATION', '������� �� ������ � ������� ������');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', '������� �� �������� \'������ ������\' � \'������� ������\'.');
@define('PLUGIN_LINKS_LOCATION_TOP', '����');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', '����');
@define('PLUGIN_LINKS_SELECTION', '����� �� ������������');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', '����� \'��\' ��������, �� ������� �� ������������ ����� �� ����� �������� (�� ����� ������, ����� ������� ������������).');
@define('PLUGIN_LINKS_COOKIE', '���������� �� ����');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', '����� \'��\' ��������, �� ������� �� �������� �������� ����, �� �� ������� ����������� ��.');
@define('PLUGIN_LINKS_LINE', '���������� �� �����');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', '����� \'��\' ��������, �� �� �������������� �� ������� �� ��������� �����.');
@define('PLUGIN_LINKS_ICON', '���������� �� �����');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', '����� \'��\' ��������, �� �� �������������� �� ������� �� ��������� �����.');
@define('PLUGIN_LINKS_STATUS', '����� �� ������ ����');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', '����� \'��\' ��������, �� �� ������ ���� �� �������� �� �������� ������� �� �������� ������ URL, ��� ����� �����.');
@define('PLUGIN_LINKS_CLOSELEVEL', '��������� �� ������ ����');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', '����� \'��\' ��������, �� ���� ���� ������������� � ��������� ���������� ���� �� ���� ��������. � ���� ������ �������� \'������ ������\' � \'������� ������\' �� �������.');
@define('PLUGIN_LINKS_TARGET', '�������� �� ��������');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', '��������, � ����� �� �� ������� �������� - ���� �� ���� "_blank", "_self", "_top", "_parent" ��� ��� �� ����� (frame).');
@define('PLUGIN_LINKS_IMGDIR', '���������� �� ���������� �� �������');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', '����� \'��\' ��������, �� ����������� �� �������� ���������� �� ����������� �� ���������� \'img\'. ��� ����� \'��\' ����������� �� ����� ���������� � \'/templates/default/img/\'. ���� ����, ����� \'��\' � ��������� ��� ���������� �� ����� ������� (shared install), �� ������ ���������� ������ �� ����� ���������� � \'/templates/default/img/\' �����.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', '��������� �� ������� � ����������� �� ��������');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', '������ ���������� ���������� �� \'���������\', ������ �� �������� ���� �� �� ���� �������� ��� ��������� ������������.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', '���������');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', '��������');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'CSS ������');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', '��������� CSS ����');
@define('PLUGIN_LINKS_OUTSTYLE', '�������� ����� �� �������');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', '�������� ���� �� ������� � ������.  Dtree �������� JavaScript, �� �� ������������ ���������� ������ �� �������. ������� CSS �������� CSS divs � ��������� JavaScript, �� �� �������� dtree, �� �� �������� ������ ������ �������. ������������ CSS �� ��������� ����� CSS ����������� ������, ����� ��������� ����� ������� ��� ������������� �� �������. Dtree ���������� �� � ���������� �� ��������� ������.');
@define('PLUGIN_LINKS_CALLMARKUP', '��������� �� ����������� ?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH', '�������� ���� �� ��������� ����������� �� ������ �� �����������.');
@define('PLUGIN_LINKS_USEDESC', '���������� �� �������� ��������');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH', '���������� �� ���������� �� ���������� �� ��������, ��� ��� ������.');
@define('PLUGIN_LINKS_PREPEND', '�������� �����, ����� �� ���� �������� ����� ������� �� ��������.');
@define('PLUGIN_LINKS_APPEND', '�������� �����, ����� �� ���� �������� ���� ������� �� ��������.');

