<?php

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Cronjob-Planer');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'Dieses Plugin f�hrt andere Plugins, die regelm��ig bestimmte Aufgaben ausf�hren sollen, in bestimmten Zeitabst�nden aus. Einzelheiten finden Sie in der Konfiguration dieses Plugins.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'Dieses Plugin stellt neue Plugin-API-Hooks (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly) bereit, die andere Plugins verwenden k�nnen. HINWEIS: Die Ausf�hrung von Cronjobs erfordert Seitenabrufe; wenn niemand Ihre Seite besucht, k�nnen keine Cronjobs ausgef�hrt werden. Wenn Sie einen eigenen Server haben, der Cronjobs ausf�hren kann, sollten folgenden Eintrag zu ihrer Crontab hinzuf�gen: <br /><br />5 * * * wget http://yourblog/index.php?Serendipity[cronjob]=all<br /><br /> und hier im Plugin dann die Ausf�hrung von besucherbasierten Cronjobs deaktivieren.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Besucherbasierte Cronjobs?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'Wenn diese Option aktiviert ist, werden Cronjobs von Ihren Besuchern ausgef�hrt. Dazu wird ein unsichtbares Bild ausgegeben, das (durch Aufruf von index.php?Serendipity[cronjob]=true) die Cronjob-Funktionalit�t �bernimmt. F�r Benutzer, die keine benutzerdefinierten Cronjobs auf ihrem Server hinzuf�gen k�nnen, ist dies die einzige M�glichkeit, regelm��ige Ereignisse auf dem Webserver auszuf�hren. Sie sollten beachten, dass Cronjobs nur bei Seitenaufrufen ausgef�hrt werden und daher gew�hlte Zeitspanne zwischen Cronjobs nur einen Mindestwert angibt; es kann 3 Stunden dauern, bis der st�ndliche Cronjob ausgef�hrt wird, wenn erst nach 3 Stunden der erste Besucher kommt.');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Letzte Cronjob-Ereignisse');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Wann ausf�hren?');

