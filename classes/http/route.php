<?php

	class Route {

		private static $errors;

		public static function run() {

			Request::parse();	

			if (Request::controller() === false || Request::func() === false) {
				self::$errors[] = new InvalidRequestException('Bad Request!');
			}

			try {
				require_once CONTROLLERS . Request::controller() . '.php';
			} catch (InvalidControllerException $e) {
				self::$errors[] = new InvalidControllerException('Controller ' . Request::controller() . ' not found!');
			}

			$controller = Request::controller();
			$controller = new $controller;

			if (!method_exists($controller, Request::func())) {
				self::$errors[] = new InvalidMethodException(
					'Method ' . Request::funct() . 
					' from controller' . Request::controller() . 
					' not found!'
				);
			}

			$method = Request::func();

			$args = Request::arguments();

			self::execute($controller, $method, $args);

		}

		private static function execute($controller, $method, $args) {
			
			$result = call_user_func_array([$controller, $method], $args);

			

		}
	}