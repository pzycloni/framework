<?
	require_once "core/init.php";

	$user = new User();


	Session::put(Config::get("session/session_name"), "gukklucky");

	$user->getInfoAboutUser();
?>