<?php

	class Request {

		private static $url;

		/**
			* Получение  URI
			*
			* @return string
		*/
		public static function uri() {
			return $_SERVER['REQUEST_URI'];
		}

		/**
			* Проверка на валидность запроса
		*/
		public static function isBad() {
			return !isset(self::$url[0], self::$url[1]);
		}

		/**
			* Делим на части запрос
		*/
		public static function parse() {
			return self::$url = explode('/', filter_var(rtrim(self::any(URL), '/'), FILTER_SANITIZE_URL));
		}

		/**
			* Получаем тип запроса
			*
			* @return string
		*/
		public static function method() {
			return $_SERVER['REQUEST_METHOD'];
		}

		/**
			* Идентификация типа запроса
			*
			* @param string $method
			*
			* @return bool
		*/
		public static function isMethod($method) {
			return $method == self::method();
		}

		/**
			* Получение параметра content-type	
			*	
			* @return bool
		*/
		public static function contentType() {
			return !count($_SERVER['CONTENT_TYPE']) ? $_SERVER['HTTP_ACCEPT'] : $_SERVER['CONTENT_TYPE'];
		}

		/**
			* Проверка на json запрос
			*	
			* @return bool
		*/
		public static function isJSON() {
			$contentType = self::contentType();

			if (preg_match('/(json)/', $contentType) || preg_match('/(urlencoded)/', $contentType)){
				return true;
			}

			return false;
		}

		/**
			* Проверка на GET запрос
			*
			* @return bool
		*/
		public static function isGet() {
			return self::isMethod('GET');
		}


		/**
			* Проверка на POST запрос
			*
			* @return bool
		*/
		public static function isPost() {
			return self::isMethod('POST');
		}

		/**
			* Проверка на существование поля в POST
			*
			* @return bool
		*/
		public static function issetPost($name) {
			return isset($_POST[$name]);
		}

		/**
			* Проверка на существование поля в GET
			*
			* @return bool
		*/
		public static function issetGet($name) {
			return isset($_GET[$name]);
		}

		/**
			* Проверка на пустоту POST
			*
			* @return bool
		*/
		public static function emptyPost($name = null) {
			return is_null($name) ? !count($_POST) : empty($_POST[$name]);
		}

		/**
			* Проверка на пустоту GET
			*
			* @return bool
		*/
		public static function emptyGet($name = null) {
			return is_null($name) ? !count($_GET) : empty($_GET[$name]);
		}

		/**
			* Получение данных из GET
			*
			* @param string $name
			*
			* @param void $name
			*
			* @return array
		*/
		public static function get($name = null) {
			return is_null($name) ? $_GET : Protect::complex($_GET[$name]);
		}

		/**
			* Получение данных из POST
			*
			* @param string $name
			*
			* @param void $name
			*
			* @return array
		*/
		public static function post($name = null) {
			return is_null($name) ? $_POST : Protect::complex($_POST[$name]);
		}

		/**
			* Получение данных из GET или POST, в зависимости от того какой существует
			*
			* @param string $name
			*
			* @param void $name
			*
			* @return array
		*/
		public static function any($name = null) {
			if (self::isGet()) {
				return self::get($name);
			}

			if (self::isPost()) {
				return self::post($name);
			}
		}
	}