<?php

	$files = [
		'defaultcontroller'
	];

	function autoloader($dir, $classes) {
		
		foreach ($classes as $class) {
			try {
				require_once CONTROLLERS . $dir . '/' . $class . '.php';
			} catch (Exception $e) {

			}
		}
	}

	foreach ($files as $dir => $file) {
		autoloader($dir, $file);
	}