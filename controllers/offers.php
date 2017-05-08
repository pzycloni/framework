<?php

	class Offers extends DefaultController {

		public function create($id, $payment) {

			$transation = $this->model('Channel');
			
			if ($this->is_available()) {
				return $transation->create($id, $payment);
			}

			return false;
		}

	}