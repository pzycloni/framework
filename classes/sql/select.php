<?php

	class Select extends Query {

		/**
			*Создание объекта
			*@param array $tables
			*@param array $fields
			*@param string $where
		*/
		public function __construct($tables, $fields, $where = '1') {

			Query::__construct($tables, $fields, $where);

			$this->build();
		}

		/**
			*Сборка запроса
		*/
		public function build() {

			$action = 'SELECT ' . implode(', ', $this->fields);

			$tables = 'FROM ' . implode('`, `', $this->tables);

			$where = 'WHERE ' . $this->where;

			$this->query = "{$action} {$tables} {$where}";

			return $this; 
		}

	}