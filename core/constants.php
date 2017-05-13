<?php
	
	define('PREFIX', 			'/www/framework/framework/');
	define('ROOT', 				$_SERVER['DOCUMENT_ROOT'] . PREFIX);
	define('SERVER', 			'mysql/');

	define('RESOURCE', 			'http://othertaxiapi.ru/');
	define('RESOURCE_URL', 		RESOURCE . 'your_token/');
	
	define('CLASSES', 			ROOT . 'classes/');
	define('EXCEPTIONS',		CLASSES . 'exceptions/');
	
	define('VIEWS',				ROOT . 'views/');
	
	define('CONTROLLERS',		ROOT . 'controllers/');
	
	define('MODELS',			ROOT . 'models/');
	
	define('TOKEN', 			'token');
	define('URL', 				'url');
	define('TIMEZONE', 			'view');
	define('ID', 				'id');
	define('PAYMENT', 			'payment');
	define('ERROR',				'error');
	define('DOCS',				'docs');
	
	define('TABLE_CLIENTS', 	'clients');
	define('TABLE_ORG', 		'organizations');
	define('TABLE_TELEGRAM', 	'access');
	
	define('CLIENTS', 			'table/' . TABLE_CLIENTS . '/');
	define('ORGANIZATIONS', 	'table/' . TABLE_ORG . '/');
	define('TELEGRAM', 			'table/' . TABLE_TELEGRAM . '/');
