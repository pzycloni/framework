<?php

	class Data {

		/**
			* @var array
		*/
		protected	$data;

		/**
			* @var array
		*/
		protected	$size;

		/**
			* Инициализция полей
		*/
		public function __construct() {
			$this->data = array();
			$this->size = 0;
		}	

		/**
			* Получение элемента
			*
			* @param string $column
			*
			* @param void
			*
			* @return array
		*/
		public function get($column = null) {
			if ($column != null) {
				$data = array();

				if (!$this->size) {
					return array();
				}

				foreach ($this->data as $row) {
					foreach ($row as $field => $value) {
						if ($field == $column) {
							$data[] = $value;
						}
					}
				}
				return $data;
			}
			return $this->data;
		}

		/**
			* Добавление новых данных
			*
			* @param mixed $data
		*/
		public function push($data) {
			$this->data[] = $data;
			$this->size++;
		}

		/**
			* Переопредение данных
			*
			* @param array $data
		*/
		public function set($data) {
			$this->size = count($data);
			$this->data = $data;
		}

		/**
			* Добавление словаря
			*
			* @param string $key
			*
			* @param mixed $value
		*/
		public function install($key, $data) {
			$this->data[$key] = $data;
		}

		/**
			* Удаление всех данных
		*/
		public function clean() {
			$this->size = 0;
			unset($this->data);
		}

		/**
			* Проверка на существование данных
			*
			* @return bool
		*/
		public function is_clean() {
			return !(bool)$this->size;
		}

		/**
			* Получение первого элемента
			* 
			* @param string $column
			*
			* @param int $column
			*
			* @return mixed
		*/
		public function first($column = null) {
			if ($this->size) {
				if ($column != null) {
					return $this->data[0][$column];
				}
				return $this->data[0];
			}
			return null;
		}

		/**
			* Получение последнего элемента
			* 
			* @param string $column
			*
			* @param int $column
			*
			* @return mixed
		*/
		public function last($column = null) {
			if ($this->size) {
				if ($column != null) {
					return $this->data[$this->size - 1][$column];
				}
				return $this->data[$this->size - 1];
			}
			return null;
		}
	}