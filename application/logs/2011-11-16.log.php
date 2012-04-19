<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-11-16 04:16:58 -05:00 --- error: Missing i18n entry core.uncaught_exception for language Table "settings" cannot be found in the database. Please make sure you are using the latest version of the database for this version of Ushahidi
2011-11-16 04:16:58 -05:00 --- error: core.uncaught_exception
2011-11-16 07:34:23 -05:00 --- error: Missing i18n entry core.uncaught_exception for language mysql_connect() [<a href='function.mysql-connect'>function.mysql-connect</a>]: Can't connect to local MySQL server through socket '/var/lib/mysql/mysql.sock' (2)
2011-11-16 07:34:23 -05:00 --- error: core.uncaught_exception
2011-11-16 09:08:22 -07:00 --- error: Missing i18n entry core.uncaught_exception for language Database error: Got error 28 from storage engine - SELECT DISTINCT i.*, l.`latitude`, l.`longitude`, l.location_name, ((ACOS(SIN(37.938491 * PI() / 180) * SIN(l.`latitude` * PI() / 180) + COS(37.938491 * PI() / 180) * 	COS(l.`latitude` * PI() / 180) * COS((-107.813591 - l.`longitude`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance FROM `incident` AS i INNER JOIN `location` AS l ON (l.`id` = i.`location_id`) INNER JOIN `incident_category` AS ic ON (i.`id` = ic.`incident_id`) INNER JOIN `category` AS c ON (ic.`category_id` = c.`id`) WHERE i.incident_active = 1 AND i.id <> 17 ORDER BY distance ASC LIMIT 5
2011-11-16 09:08:22 -07:00 --- error: core.uncaught_exception
2011-11-16 10:54:13 -07:00 --- error: Missing i18n entry core.uncaught_exception for language Table "api_settings" cannot be found in the database. Please make sure you are using the latest version of the database for this version of Ushahidi
2011-11-16 10:54:13 -07:00 --- error: core.uncaught_exception
2011-11-16 14:14:36 -05:00 --- error: Missing i18n entry core.uncaught_exception for language Table "settings" cannot be found in the database. Please make sure you are using the latest version of the database for this version of Ushahidi
2011-11-16 14:14:36 -05:00 --- error: core.uncaught_exception
2011-11-16 15:07:52 -05:00 --- error: Missing i18n entry core.uncaught_exception for language mysql_connect() [<a href='function.mysql-connect'>function.mysql-connect</a>]: Can't connect to local MySQL server through socket '/var/lib/mysql/mysql.sock' (2)
2011-11-16 15:07:52 -05:00 --- error: core.uncaught_exception
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.login for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_name for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_email for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_phone for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_subject for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_message for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_code for language fr_FR
2011-11-16 18:52:45 -07:00 --- error: Missing i18n entry ui_main.contact_send for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.more_information for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.zoom_in for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.zoom_out for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.zoom_in for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.zoom_out for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.show for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.hide for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.show for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.login for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.hide for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.report_option_1 for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.report_option_2 for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.report_option_3 for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.report_option_4 for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.play for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.from for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.to for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.view_more for language fr_FR
2011-11-16 20:45:32 -07:00 --- error: Missing i18n entry ui_main.view_more for language fr_FR
