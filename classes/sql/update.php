<?php

	class Update extends Query {

		/**
			*Создание объекта
			*@param array $tables
			*@param array $fields
			*@param string $where
		*/
		public function __construct($tables, $fields, $where) {

			Query::__construct($tables, $fields, $where);

			$this->build();
		}

		private function equal($left_stmt, $right_stmt) {
			return "`{$left_stmt}`='{$right_stmt}'";
		}

		/**
			*Сборка запроса
		*/
		public function build() {

			$tables = array_values($this->tables);

			$table = $tables[0];

			$equals = array_map(array($this, 'equal'), $this->fields, $this->values);

			$action = 'UPDATE ' . $table . ' ';

			$set = 'SET ' . implode(', ', $equals);

			$where = 'WHERE ' . $this->where;

			$this->query = "{$action} {$set} {$where}";

			return $this; 
		}
	}