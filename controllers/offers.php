<?php

	class Offers extends DefaultController {

		public function create($id, $payment) {

			$transation = $this->model('Transaction');
			
			if ($this->is_available()) {
				return $transation->setNewOffer($id, $payment);
			}

			return false;
		}

	}