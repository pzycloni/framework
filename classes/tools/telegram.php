<?php

	class Telegram {

		/**
			* @var string;
		*/
		private $token;

		/**
			* Конструктор 
			* инициализирует токен Telegram Bot API
			*
			* @param string $token
		*/
		public function __construct($token) {

			$this->token = 'bot' . $token;
		}

		/**
			* Отправка сообщения в определенный чат
			*
			* @param int $chat
			*
			* @param string $message
			*
			* @return array
		*/
		public function send($chat, $message) {

			$query = 'https://api.telegram.org/' 
					. $this->token . '/sendMessage?' 
					. http_build_query([
						'chat_id' 	=> $chat,
						'text' 		=> $message
					]);

			try {
				file_get_contents($query);
			} 
			catch (InvalidTelegramMessageException $e){
				return ['error' => 'faild to send message!'];
			}

			return [];
		} 

		/**
			* Открытие файла и получения из него данных
			*
			* @param string $file
			*
			* @return string
		*/
		private function open($file) {

			return file_get_contents($file);
		} 

		/**
			* Сохранение данных в файл
			*
			* @param string $file
			*
			* @param int $value
			*
			* @return bool
		*/
		private function save($file, $value) {

			try {
				file_put_contents($file, $value, LOCK_EX);
			}
			catch (Exception $e) {
				return false;
			}

			return true;
		}

		/**
			* Полчение последних сообщений из чатов
			*
			* @param int $offset
			*
			* @return array
		*/
		private function getUpdates($offset = null) {

			$query = 'https://api.telegram.org/' 
					. $this->token 
					. '/getUpdates';

			if (!is_null($offset)) {
				$query .= '?offset=' . $offset;
			}

			try {
				$content = file_get_contents($query);
				$output = json_decode($content, true);
			} 
			catch (InvalidTelegramMessageException $e){
				return ['error' => 'faild to get data!'];
			}

			return $output;
		}

		/**
			* Получение массива данных
			*
			* @return array
		*/
		public function get() {

			$updatefile 	= 'last_user_id.txt';
			$messagefile 	= 'last_message_id.txt';

			$updateoffset 	= $this->open($updatefile);
			$messageoffset 	= $this->open($messagefile);

			$res = $this->getUpdates($updateoffset + 1);

			$last = count($res['result']) - 1;

			$this->save($updatefile, $res['result'][$last]['update_id']);

			$this->save($messagefile, $res['result'][$last]['message']['message_id']);

			if ($res['result'][$last]['message']['message_id'] <= $messageoffset) {
				return [];
			}

			return $res;
		}

	}