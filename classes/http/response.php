<?php

	class Response {

		/**
			* @var Header
		*/
		public $headers;

		/**
			* @var Content
		*/
		protected $content;

		/**
			* @var int
		*/
		protected $statusCode;

		/**
			* @var string
		*/
		protected $version;

		/**
			* @var string
		*/
		protected $statusText;

		/**
			* Таблица http кодов
			*
			* @var array
		*/
		public static $statusTexts = [
			100 => 'Continue',  
			101 => 'Switching Protocols',  
			200 => 'OK',
			201 => 'Created',  
			202 => 'Accepted',  
			203 => 'Non-Authoritative Information',  
			204 => 'No Content',  
			205 => 'Reset Content',  
			206 => 'Partial Content',  
			300 => 'Multiple Choices',  
			301 => 'Moved Permanently',  
			302 => 'Found',  
			303 => 'See Other',  
			304 => 'Not Modified',  
			305 => 'Use Proxy',  
			306 => '(Unused)',  
			307 => 'Temporary Redirect',  
			400 => 'Bad Request',  
			401 => 'Unauthorized',  
			402 => 'Payment Required',  
			403 => 'Forbidden',  
			404 => 'Not Found',  
			405 => 'Method Not Allowed',  
			406 => 'Not Acceptable',  
			407 => 'Proxy Authentication Required',  
			408 => 'Request Timeout',  
			409 => 'Conflict',  
			410 => 'Gone',  
			411 => 'Length Required',  
			412 => 'Precondition Failed',  
			413 => 'Request Entity Too Large',  
			414 => 'Request-URI Too Long',  
			415 => 'Unsupported Media Type',  
			416 => 'Requested Range Not Satisfiable',  
			417 => 'Expectation Failed',  
			500 => 'Internal Server Error',  
			501 => 'Not Implemented',  
			502 => 'Bad Gateway',  
			503 => 'Service Unavailable',  
			504 => 'Gateway Timeout',  
			505 => 'HTTP Version Not Supported'
		];

		/**
			* Конструктор
		*/
		public function __construct() {

			$this->content = new Data();
			$this->headers = new Header();

			$this->setStatusCode(200);
			$this->setProtocolVersion('1.0');
		}

		/**
			* Установка версии протокола http
			* 
			* @param $version
			* 
			* @return $this
		*/
		public function setProtocolVersion($version) {
			$this->version = $version;

			return $this;
		}

		/**
			* Установка нового контента
			* 
			* @param array $content
		*/
		public function setContent($content) {
			$this->content->set($content);
		}

		/**
			* Установка нового заголовка
			* 
			* @param array $header
		*/
		public function setHeaders($headers) {
			$this->headers->set($headers);
		}

		/**
			* Получение контента
			* 
			* @param array $content
		*/
		public function getContent() {
			return $this->content;
		}

		/**
			* Установка статуса
			*
			* @param int $code
			*
			* @param string $text
			*
			* @return $this
		*/
		public function setStatusCode($code, $text = null) {

			$this->statusCode = (int) $code;

			if ($this->isInvalid()) {
				throw new InvalidArgumentException('The HTTP status code ' . $code . ' is not valid.');
			}

			if (is_null($text)) {
				$this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'unknown status';

				return $this;
			}

			$this->statusText = $text;

			return $this;
		}

		/**
			* Получение кода статуса
			*
			* @return int
		*/
		public function getStatusCode() {
			return $this->statusCode;
		}

		/**
			* Получение расшифровка статуса
			*
			* @return string
		*/
		public function getStatusText() {
			return $this->statusText;
		}

		/**
			* Преобразование в json
			*
			* @return json
		*/
		public function JSON() {
			return json_encode($this->content->get(), JSON_UNESCAPED_UNICODE);
		}


		/**
			* Получение версии http протокола 
			*
			* @return string
		*/
		public function getProtocolVersion() {
			return $this->version;
		}

		/**
			* Собираем запрос
			*
			* @param array $data
			*
			* @return $this

		*/
		public function build($data = []) {

			$http_version = $this->getProtocolVersion();

			$code = $this->getStatusCode();
			$message = $this->getStatusText();

			$this->setHeaders(
				[
					'http_version' 	=> $http_version,
					'http_status' 	=> 
					[
						'code' 		=> $code,
						'message' 	=> $message
					],
					'date' 			=> date('d F Y'),
					'time'			=> date('H:i:s')
				]
			);

			$content = array_merge($this->headers->get(), $this->content->get());
			$this->setContent($content);

			return $this;
		}

		/**
			* Проверка на пустоту
			*
			* @return bool
		*/
		public function isEmpty() {
			return in_array($this->statusCode, array(204, 304));
		}

		/**
			* Проверка на существование статуса
			*
			* @return bool
		*/
		public function isInvalid() {
			return $this->statusCode < 100 || $this->statusCode >= 600;
		}

		/**
			* Проверка запроса на корректность
			*
			* @return bool
		*/
		public function isSuccessful() {
			return $this->statusCode >= 200 && $this->statusCode < 300;
		}

		/**
			* Проверка запроса на ошибки
			*
			* @return bool
		*/
		public function isClientError() {
			return $this->statusCode >= 400 && $this->statusCode < 500;
		}

		/**
			* Успех
			*
			* @return bool
		*/
		public function isOk() {
			return $this->statusCode === 200;
		}

		/**
			* Запрет
			*
			* @return bool
		*/
		public function isForbidden() {
			return $this->statusCode === 403;
		}

		/**
			* Существование
			*
			* @return bool
		*/
		public function isNotFound() {
			return $this->statusCode === 404;
		}
	}