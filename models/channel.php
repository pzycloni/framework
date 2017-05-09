<?php

	class Channel {

		/**
			* @param DB
		*/
		private $db;

		/**
			* @param Dada
		*/
		private $result;

		/**
			* @param string
		*/
		private $token;

		/**
			* @param string
		*/
		private $telegram;

		/**
			* Конструктор
		*/
		public function __construct() {
			$this->db = DB::connect();
			// создаем контейнер результата
			$this->result = new Data();
			// устанавливаем токен доступа
			$this->token = Request::get(TOKEN);
		}

		/**
			* Отправляем сообщение пользователю
			*
			* @param string $token
			*
			* @param array $parameters
			*
			* @return void
		*/
		private function sendMessage($parameters) {

			$url = 'https://api.telegram.org/' . $this->telegram . '/sendMessage?' 
					. http_build_query($parameters);

			try {
				file_get_contents($url);
			} 
			catch (InvalidMessageException $e){
				return ['error' => 'faild to send message!'];
			}

			return [];
		}

		/**
			* Получение идентификатора организации
			*
			* @param Select $query
			*
			* @return int
		*/
		private function get(Select $query) {

			$this->db->get($query);

			return $this->db->results()->first();
		}

		/**
			* Устанавливаем токен Telegram
			*
			* @param string $token
		*/
		public function setTokenTelegram($token) {
			$this->telegram = $token;
		}


		public function create($id, $payment) {

			$query = new Select(
				[TABLE_ORG],
				[
					Config::get(ORGANIZATIONS . 'id'),
					Config::get(ORGANIZATIONS . 'name')

				],
				"`" . Config::get(ORGANIZATIONS . 'token') . "`='" . $this->token . "'"
			);

			$organization = $this->get($query);

			$id = $organization[Config::get(ORGANIZATIONS . 'id')];
			$name = $organization[Config::get(ORGANIZATIONS . 'name')];

			$chatId = 111989844;
			$message = "/{$id} Такси {$name} предлагает Вам поездку за {$payment} руб.";

			$parameters = [
				'chat_id' => $chatId,
				'text' => $message
			];

			return $this->sendMessage($parameters);
		}

	}