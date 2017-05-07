<?php

	class Offers extends DefaultController {

		public function create($id, $payment) {

			$user = $this->model('Transaction');
			
			if ($user->getAvailable()) {
				return $user->setNewOffer($id, $payment);
			}

			return array();
		}

	}