<?
	// В этом файле мы подключаем все классы из папки "classes",
	// обЪявляем в глобальном массиве основные настройки, 
	// а также создаем объект класса User
	session_start();

	// основные настройки конфига
	$GLOBALS['config'] = require_once "settings.php";

	require_once "constants.php";

	include_once(CLASSES . 'autoload.php');