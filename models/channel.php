<?php

	class Channel {

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
		private function sendMessage($token, $parameters) {

			$url = 'https://api.telegram.org/bot' . $token . '/sendMessage?' 
					. http_build_query($parameters);

			file_get_contents($url);
		}

		/**
			* Получение идентификатора организации
			*
			* @param Select $query
			*
			* @return int
		*/
		private function getOrganization(Select $query) {

			$this->db->get($query);

			$this->result->set($this->db->results());

			return $this->result->get()->first();
		}

		public function create($id, $payment) {
			
			$select = new Select(
				[TABLE_ORG],
				[
					Config::get(ORGANIZATIONS . 'id'),
					Config::get(ORGANIZATIONS . 'name')

				],
				"`" . Config::get(ORGANIZATIONS . 'token') . "`='" . $this->token . "'"
			);

			$organization = $this->getOrganization($select);

			$id = $organization[Config::get(ORGANIZATIONS . 'id')];
			$name = $organization[Config::get(ORGANIZATIONS . 'name')];

			$token = "334547867:AAFaa394p4WWUE1Vh7dYRwN0vOeHTj411Gs";

			$chatId = 111989844;
			$message = "/{$id} Такси {$name} предлагает Вам поездку за {$payment} руб.";

			$parameters = [
				'chat_id' => $chatId,
				'text' => $message
			];

			$this->sendMessage($token, $parameters);

			return [];
		}

	}