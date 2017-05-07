<?php

	class Clients extends DefaultController {

		public function show($args = null) {

			$transaction = $this->model('Transaction');
			
			if ($this->is_available()) {
				return $transaction->getListClients($args);
			}

			return false;
		}

	}