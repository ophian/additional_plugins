<?php

/**
 *  @version
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.3
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', '������� ������/������');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', '������ ������ ��� ������� (�������� � ���� ������) ����� ������ ��� WEB ��������. �� ��������� �� ��������� ������ �� ����������� ���� "plugin_relatedlinks.tpl" (Smarty-Template), �� �� ��������� ��� �� �������� ��������. ���������: ���� ��������� ������� �������� ���� � �������� / ����� ��� �� ��������.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', '�������� ��������, ����� ������ �� �� �������� - �� ���� ������ �� ���, ��� HTML ��� (���� �������� �������� �� �� ��������� � ��� ���). ��� ������ �� �������� �������� �� ��������, ����������� ������� ������: http://example.com/link.html=�������� ������. ������ ���� "=" �� �� �������� ���� ��������. ��� �������� �� ���� ��������, �� ���� �������� ������ ������ (URL �������)');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', '������� ������/������ :');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', '������� �� ��������');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', '��� ���������� Smarty templating, � ���������� �� �������� ���� ��� ��� ����� entries.tpl ������ ����� � ������ foreach, ������ �� ���������� ������������ $entry. ���� � �������� �������, ������ ����������� � ��������� ������������� �� ��������: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', '������� ��� ��������');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', '������� � ������ �� ��������');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', '��������� Smarty');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', '������ ����������');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', '�������� ������, ����� �� ������� ������ �� �������� � ���������� �. �������� �� ������ �� ��������� ���� � ������, ���� � ����������. �������� ������ � \'|\'.');

