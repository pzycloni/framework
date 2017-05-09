<?php

	class Clients extends DefaultController {

		public function show($args = null) {

			$transaction = $this->model('Transaction');
			
			if ($this->is_available()) {

				$token = 'bot' . $this->getTokenTelegram();

				$transaction->setTokenTelegram($token);

				return $transaction->getListClients($args);
			}

			return false;
		}

	}