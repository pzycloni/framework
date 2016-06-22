<?
	// В этом файле мы подключаем все классы из папки "classes",
	// обЪявляем в глобальном массиве основные настройки, 
	// а также создаем объект класса User
	session_start();

	// основные настройки конфига
	$GLOBALS['config'] = array(
		'mysql' => array(
			'host' 		=> 'framework',
			'db' 		=> 'users_table',
			'username'	=> 'mysql',
			'password' 	=> 'mysql'
		),
		'table' => array(
			'user' => array(
				'uid' 		=> 'id',
				'username' 	=> 'username',
				'last' 		=> 'lastname',
				'first' 	=> 'firstname',
				'pass'		=> 'password',
				'email' 	=> 'email',
				'salt' 		=> 'salt',
				'joined'	=> 'joined',
				'group'		=> 'group'
			),
			'information' => array(
				'uid' 	=> 'id',
				'icon' 	=> 'icon',
				'data' 	=> 'session'
			),
			'user_messages' => array(
				'mid' 		=> 'id',
				'uid' 		=> 'id_user',
				'title' 	=> 'header',
				'message' 	=> 'message',
				'time' 		=> 'time'
			),
		),
		'session' => array(
			'session_name' 	=> 'uname',
			'session_id'	=> 'id'
		),
		'remember' => array(
			'cookie_name' => 'hash',
			'cookie_life' => 604800
		),
		'post' => array()
	);

	
	// подгружаем все классы
	spl_autoload_register(function($class){
		require_once "classes/" . $class . '.php';
	});
?>