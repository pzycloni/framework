<?php

	class DefaultException extends Exception {

		protected $exceptions;

		protected $count;

		public function __construct($exception = null) {

			$this->exceptions = [];
			$this->count = 0;

			if (!is_null($exception)) {
				$this->push($exception);
			}
		}

		public function push($exception) {

			$this->exceptions[] = $exception;
			$this->count++;
		}

		public function exist() {
			return !(bool)$this->count;
		}

		public function get($column = null) {
			if ($column != null) {
				$data = array();

				foreach ($this->exceptions as $exception) {
					foreach ($exception as $field => $value) {
						if ($field == $column) {
							$data[] = $value;
						}
					}
				}
				return $data;
			}
			return $this->exceptions;
		}

		/**
			* Удаление всех данных
		*/
		public function clean() {
			$this->count = 0;
			unset($this->exceptions);
		}

	}