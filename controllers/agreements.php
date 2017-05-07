<?php

	class Agreements extends DefaultController {

		public function show($count = null) {
			$transation = $this->model('Transaction');
			
			if ($this->is_available()) {
				return $transation->getListAgreements($count);
			}

			return false;
		}

	}