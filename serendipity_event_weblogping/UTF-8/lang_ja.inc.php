<?php

/**
 *  @version
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 690
 */

@define('PLUGIN_EVENT_WEBLOGPING_PING', 'XML-RPC ping のアナウンス先エントリ:');
@define('PLUGIN_EVENT_WEBLOGPING_SENDINGPING', 'XML-RPC ping をホスト %s に送信中');
@define('PLUGIN_EVENT_WEBLOGPING_TITLE', 'アナウンスエントリ一覧');
@define('PLUGIN_EVENT_WEBLOGPING_DESC', '新規エントリの通知をオンラインサービスに送信します。');
@define('PLUGIN_EVENT_WEBLOGPING_SUPERSEDES', '(supersedes %s)');
@define('PLUGIN_EVENT_WEBLOGPING_CUSTOM', 'カスタム ping サービス');
@define('PLUGIN_EVENT_WEBLOGPING_CUSTOM_BLAHBLA', '「,」で区切られた、一つ以上の特別な ping サービスです。「host.domain/path」のような書式で入力する必要があります。"*"がホスト名の初めに入力されれば、拡張 XML-RPC オプションは、そのホスト(ただもしホストに支援されれば)のもとへ送られるでしょう。"*"がホスト名の初めに入力されれば、拡張 XML-RPC オプションは、そのホスト(ただもしホストがサポートしていれば)のもとへ送られるでしょう。 You have to submit this form several times, until the new entries are placed into the upper list.');
@define('PLUGIN_EVENT_WEBLOGPING_SEND_FAILURE', '失敗( 理由: %s)');
@define('PLUGIN_EVENT_WEBLOGPING_SEND_SUCCESS', '成功!!');

