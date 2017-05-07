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

			return self::execute($controller, $method, $args);

		}

		private static function error($codeStatus, $reason) {
			$response = new Response();

			$response->setContent(['error' => $reason]);

			$response->setStatusCode($codeStatus);

			return $response->build()->JSON();
		}

		private static function execute($controller, $method, $args) {
			$response = new Response();
			
			$result = call_user_func_array([$controller, $method], $args);

			if (!is_bool($result)) {
				foreach ($result as $row)
					$content['result'][] = $row;
				
				$response->setContent($content);

				$response->setStatusCode(200);
			}
			else {
				$response->setContent(
					[
						'error' => 'Invalid token ' . Request::get(TOKEN)
					]
				);

				$response->setStatusCode(406);
			}

			return $response->build()->JSON();
		}
	}