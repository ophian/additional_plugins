<?php

/**
 *  @version
 *  @author Ivan Cenov <JWalker@hotmail.bg>
 *  EN-Revision: 1.3
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'TextLinkAds.com Ad');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', '������� �������� ������ � ���������� �� �����.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>������������ Smarty .tpl ����� �� ����� ������ �� �� ������� ���� �� ���� ���������� ������, ����� ��� �� �� �� ������ �� �����. ����������� ���� Smarty ���, ���� ������� ������: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. ��� ������ �� ���������� ���������� ����� �� ���������, ������ �� �������� �������� Smarty ���������:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>�������� "X" � ����� �� ��������������� (����������� �������� ���������� �� �����������), ������ ������� the Ad-Snippets �� �� ������. ����������� �� ������� ���� ������������� ��� �������� ������� Y ("��������", "������", "�� ��� ���", "�� ����� ������� ���", "��� ����� ���������") � �� ������ �� ������� ����� .html ����.</p>
<p> ��������, ����� ������������� "headers" � "footers". � "headers" �� ������� ��������� "nice.html", "nifty.html" � "great.html". � "footers" �� ������� "great.html" � "awesome.html". ������������ ������ ���� index.tpl � ��������� ������� ��� ���-������ (� ������ "top"):</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="headers:daily"}</p>
<p>���� ����, ��������� ������� ��� � ������ "footer":</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="footers:weekly"}</p>
<p>���� ���� �� �������� ��� �����, �� ������ ������������ �� �������� ������ .html ���� ������� � ������������ ��. ��� �� ���� �������� ���� �������� �� ��������� ������ (�������, ���, ��� ...). � HTML ��������� ������ �� ������� HTML ���, ������� �������, ���� � JavaScript, GoogleAdSense � �.�.');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', 'CSS ID �� HTML �������� � ������ �������');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '������� ��� �� ����, ������ �� �� ������ ��������');

