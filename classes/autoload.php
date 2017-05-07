<?php
	
	/*
		Все Exceptions
	*/
	$files = [
		'exceptions' => [
			'defaultexception',
			'sqlexception',
			'invalidrequestexception',
			'invalidcontrollerexception',
			'invalidmethodexception'
		],
		'sql' => [
			'query',
			'delete',
			'select',
			'insert',
			'update'
		],
		'tools' => [
			'config',
			'data',
			'error',
			'content',
			'header',
			'cookie',
			'db',
			'hash',
			'input',
			'protect',
			'redirect',
			'session',
			'validate'
		],
		'http' => [
			'request',
			'response',
			'route'
		]
	];

	function autoloader($dir, $classes) {
		
		foreach ($classes as $class) {
			try {
				require_once CLASSES . $dir . '/' . $class . '.php';
			} catch (Exception $e) {

			}
		}
	}

	foreach ($files as $dir => $file) {
		autoloader($dir, $file);
	}