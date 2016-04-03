<?
	require_once "core/init.php";
	$user = DB::getInstance();
	$u = new User();
	//$result = $user->query("SELECT * FROM user WHERE id=3");
	//$result = $user->insert(array("user"), array("username"=>"gukklucky2", "email"=>"okokok@efjfi.com"));
	//$user->createTable('test', array('id'=>"int(11) unsigned NOT NULL ",'date' => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'"));

	Session::put(Config::get("session/session_name"), "gukklucky");
	//$user->get("user", "*");
	//print_r($user->result());
	if ($user->error()) {
		$user->printErrors();
	}
	else {
		$u->getInfoAboutUser();
		//$user->createTable('test', array('id'=>"int(11) unsigned NOT NULL AUTO_INCREMENT",'date' => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'"));
		echo $user->getLastQuery();
	}
?>