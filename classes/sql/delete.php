<?php


	class Delete extends Query {

		/**
			*Создание объекта
			*@param array $tables
			*@param string $where
		*/
		public function __construct($tables, $where) {

			Query::__construct($tables, [], $where);

			$this->build();
		}

		/*
			Сборка запроса
		*/
		public function build() {

			$action = 'DELETE';

			$tables = 'FROM ' . implode('`, `', $this->tables);

			$where = 'WHERE ' . $this->where;

			$this->query = "{$action} {$tables} {$where}";

			return $this; 
		}

	}