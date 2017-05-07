<?php

	class Clients extends DefaultController {

		public function show($args = null) {

			$user = $this->model('Transaction');
			
			if ($user->getAvailable()) {
				return $user->getListClients($args);
			}

			return array();
		}

	}