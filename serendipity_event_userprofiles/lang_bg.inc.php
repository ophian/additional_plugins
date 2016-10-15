<?php

/**
 *  @version
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.8
 */

//
//  for serendipity_event_userprofiles.php
//

@define('PLUGIN_EVENT_USERPROFILES_CITY',               '����');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',            '�������');
@define('PLUGIN_EVENT_USERPROFILES_URL',                '�������� ��������');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION',         '������');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',            '������');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',              'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',                'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',             'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',                'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',                'MSN');
@define('PLUGIN_EVENT_USERPROFILES_SKYPE',               'Skype');
@define('PLUGIN_EVENT_USERPROFILES_STREET',             '�����');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',           '������ ���');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',          '��������� �� e-mail �����');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',           '��������� �� \'����\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',        '��������� �� \'�������\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',            '��������� �� \'�������� ��������\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION',     '��������� �� \'������\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',        '��������� �� \'������\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',          '��������� �� \'Yahoo\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',            '��������� �� \'AIM\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',         '��������� �� \'Jabber\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',            '��������� �� \'ICQ\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',            '��������� �� \'MSN\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',          '��������� �� \'Skype\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',         '��������� �� \'�����\'');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',               '������������� ������');
@define('PLUGIN_EVENT_USERPROFILES_TITLE',              '������������� �������');
@define('PLUGIN_EVENT_USERPROFILES_DESC',               '������� ������ �� ������ � ���������� �� ��������� �� ������ ������.');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',             '�������� ����� �� �����������');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',              '��������� �� VCard');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',    'VCard � ��������� � %s');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',  '������ �� �������� ����������� VCard � ��������� ���������� (\'uploads/...\').');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',    '������������ �� ��������� �� VCard.');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION', '��� �� ��������');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH', '��� �� �����, �������� �������� �� ������ �� �������� (jpg, png ...) ?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED', '������ �� ������ � �������� ?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC', '��� ����� \'��\' ������ �� ������ �� ���� ��������� � ��������, �� �� �� ����� ��� �� � �����. ������ ��� �������� ������ �� ���� ������� � ������������� \'img\' �� ��������� �� ��� ���� (\'templates/your_template/img\') � ������ �� ���� � ��� ����� �� ������. ������ ��������� ������� (�������, ���������, ...) ������ �� ����� �������� �  \'_\' � ����� �� �����.');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',          "�������� �� ���� ����");
@define('PLUGIN_USERPROFILES_NAME_DESC',     "������� ������ �� ��������, ������ ������ �� ���� ����.");
@define('PLUGIN_USERPROFILES_TITLE',         "��������");
@define('PLUGIN_USERPROFILES_TITLE_DESC',    "�������� ���������� �� ����������� ���������, ��������� ������� �� ��������.");
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT', "������");

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT', '��������� �� ���� �� ����������� ?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH', '������ �� ��������� ���� �� �����������, ����� � �������� �����������, ����� �� ������� ��������. ���� ���� �� ���� ��������� ��� ������� �� ���� �������� �����/���� ������ �� ���������. ������ ���� ���� �� �� ���������, ������ ������� ����� � ��������� ���� ����������� ����� ������ comments.tpl � ��������� � ���� {$comment.plugin_commentcount} �� �����, ����� ������. ������, ����� ���� ������ �� ��������� ������ �� ��������� ���� ����������� �� CSS ���� .serendipity_commentcount.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND', '���� ������ �� ���������');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND', '����� ������ �� ���������');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY', '{$comment.plugin_commentcount}');

@define('PLUGIN_USERPROFILES_GRAVATAR', '���������� �� Gravatar ������ ������� ����������� (avatar) ?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC', '�������� Gravatar (�������� avatar), ��������� � ����� e-mail �����. ������ ������������� �� �� ������������ � http://www.gravatar.com');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE', '������ �� �������������');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC', '������ �� �������������', '���������� ������� �� ������������� � �������. ��������� �� X � Y �� �������, ���� ������������ �������� � 80.');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING', '���������� ������� �� Gravatar');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC','���������� ����������� �������� ������� �� Gravatars. G, PG, R ��� X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT', '����� �� Gravatar �� ������������');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC', '������ ������� �� ����������, ����� �� �� �������, ������ ������������ �� � ������ Gravatar �� ���� ��.');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME', '�������� ��� �� �������������');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE', '�������� ���');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION', '������� ���� ������������� ��� �������� ���');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT', '�������� ���');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN', '������ ��� ���� %d ���');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY', '������ ��� ����');

