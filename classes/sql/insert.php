<?php

	class Insert extends Query {

		/**
			*Создание объекта
			*@param array $tables
			*@param array $fields
			*@param string $where
		*/
		public function __construct($tables, $fields) {

			Query::__construct($tables, $fields, null);

			$this->build();
		}

		/**
			*Сборка запроса
		*/
		public function build() {

			$fields = array_keys($this->fields);
			$values = array_values($this->fields);
			$tables = array_values($this->tables);

			$table = $tables[0];

			$action = 'INSERT INTO ' . $table;

			$params = '(`' . implode('`, `', $fields) . '`) ';

			$values = "VALUES('" . implode("', '", $values) .  "')";

			$this->query = "{$action} {$params} {$values}";

			return $this; 
		}


	}