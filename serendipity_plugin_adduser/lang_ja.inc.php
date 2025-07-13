<?php

/**
 *  @version
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.3
 */

@define('PLUGIN_ADDUSER_NAME',     'ユーザー自身での登録');
@define('PLUGIN_ADDUSER_DESC',     'ブログ訪問者が自分のアカウントを作成することを許可します。Together with the Event-plugin (index.php?serendipity[subpage]=adduser) you can choose whether only registered users may post comments.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS', '追加の手順書');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC', 'Add extra instructions which shall appear in the creation form');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT', 'ここで、このウェブログの著者として登録することができます。データを入力し、フォームを提出し、メールでさらに指示を受けてください。');
@define('PLUGIN_ADDUSER_USERLEVEL', 'デフォルトのユーザーレベル');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC', '新規ユーザーのデフォルトユーザーレベルはどれか選択します。');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF', USERLEVEL_CHIEF_DESC);
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR', USERLEVEL_EDITOR_DESC);
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN', USERLEVEL_ADMIN_DESC);
@define('PLUGIN_ADDUSER_USERLEVEL_DENY', 'アクセスを拒否する');
@define('PLUGIN_SIDEBAR_LOGIN', 'サイドバーにログインボックスを表示しますか?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC', '有効の場合、ログインしていない訪問者のためにサイドバーにログインボックスが表示されます。無効の場合、ユーザーは対応するイベントプラグインで設定された特別なページを通して登録する必要があります。');

@define('PLUGIN_ADDUSER_EXISTS', 'すみませんが、ユーザー名「%s」は既に取得されています。別の名前を選んでください。');
@define('PLUGIN_ADDUSER_MISSING', 'You must fill in all the fields to apply for an author account.');
@define('PLUGIN_ADDUSER_SENTMAIL', 'アカウントを作成しました。 You should receive an E-Mail with all the necessary information shortly.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION', '間違ったアクティベーション URL です!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT', '新しい著者アカウントを作成しました。');
@define('PLUGIN_ADDUSER_MAIL_BODY', "今「%s」というアカウントをブログ「%s」にて今作成しました。このアカウントをアクティブにするなら、ここをクリックします:\n\n%s\n\nAfter you have clicked there, logging in is possible with the submitted password. This E-Mail has been sent to the owner of the blog as well as the new author.");
@define('PLUGIN_ADDUSER_SUCCEED', 'このアカウントを有効にすることに成功しました。 You can now log in to the administrative panel of this blog, the link to there is contained in your activation email.');
@define('PLUGIN_ADDUSER_FAILED', 'アカウントを有効にできませんでした。おそらくアクティベーション電子メールから間違った URL をコピーしませんでしたか。?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY', '登録済ユーザーのみコメントを投稿してもいいですか?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC', 'If enabled, only registered users may post comments to your entries and need to be logged in to do so.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON', 'Only registered users may post comments here. Get your own account <a href="%s">here</a> and then <a href="%s">log into this blog</a>. ブラウザーはクッキーをサポートしてなければなりません。');

@define('PLUGIN_ADDUSER_STRAIGHT', 'Straight insert?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC', 'If enabled, a user will immediately be recorded as valid co-author. This is only recommended in setups where no mailserver is available. This feature can easily be abused by spammers. Only turn it on if you know what you are doing!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK', 'Prevent identity faking');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC', 'If enabled, the usernames registered by authors on your blog can only be used by those logged in users.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON', 'The username you entered is only available to registered authors of this blog. そのユーザー名でコメントを投稿するには<a href="%s" %s>ログイン</a>してください。もし著者登録しない場合、違う名前を使用してください。');

