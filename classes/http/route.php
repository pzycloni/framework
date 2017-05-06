<?php

	class Route {

		private static $errors;

		public static function run() {

			Request::parse();	

			if (Request::isBad()) {
				self::$errors[] = new InvalidRequestException('Bad Request!');
				// ошибка
				return self::error(400, 'Bad Request! Invalid one of parameters!');
			}

			try {
				require_once CONTROLLERS . Request::controller() . '.php';
			} catch (InvalidControllerException $e) {
				self::$errors[] = new InvalidControllerException('Controller ' . Request::controller() . ' not found!');
				// ошибка
				return self::error(400, 'Bad Request! Invalid one of parameters!');
			}

			$controller = Request::controller();
			$controller = new $controller;

			if (!method_exists($controller, Request::func())) {
				self::$errors[] = new InvalidMethodException(
					'Method ' . Request::funct() . 
					' from controller' . Request::controller() . 
					' not found!'
				);
				// ошибка
				return self::error(400, 'Bad Request! Invalid one of parameters!');
			}

			$method = Request::func();

			$args = Request::arguments();

			self::execute($controller, $method, $args);

		}

		private static function error($codeStatus, $reason) {
			$response = new Response();

			$response->setContent(['error' => $reason]);

			$response->setStatusCode($codeStatus);

			return $response->build()->JSON();
		}

		private static function execute($controller, $method, $args) {
			
			$result = call_user_func_array([$controller, $method], $args);

		}
	}