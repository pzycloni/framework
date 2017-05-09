<?php

	class Offers extends DefaultController {

		public function create($id, $payment) {

			$transaction = $this->model('Channel');
			
			if ($this->is_available()) {

				$token = 'bot' . $this->getTokenTelegram();

				$transaction->setTokenTelegram($token);

				return $transaction->create($id, $payment);
			}

			return false;
		}

	}