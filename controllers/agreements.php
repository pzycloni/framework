<?php

	class Agreements extends DefaultController {

		public function show($count = null) {
			$user = $this->model('Transaction');
			
			if ($user->getAvailable()) {
				return $user->getListAgreements($count);
			}

			return array();
		}

	}