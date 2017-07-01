<?php

	/**
		* Загрузчик всех классов
	*/
	function autoloader() {

		// родительский класс
		include_once(__DIR__ . "/sql/query.php");

		foreach (array_diff(scandir(__DIR__), ['.', '..', 'autoload.php']) as $dir) {
			
			foreach (array_diff(scandir(__DIR__ . "/{$dir}"), ['.', '..']) as $file) {

				include_once(__DIR__ . "/{$dir}/{$file}");
			}
		}
	}


	autoloader();