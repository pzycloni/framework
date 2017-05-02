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

		/**
			*Сборка запроса
		*/
		public function build() {

			$tables = array_values($this->tables);

			$table = $tables[0];

			$x = 1;
			$set = null;

			foreach ($this->fields as $name => $value){
				$set .= "`{$name}` = '{$value}'";
				if ($x < count($this->fields)){
					$set .= ', ';
				}
				$x++;
			}

			$action = 'UPDATE ' . $table . ' ';

			$set = 'SET ' . $set . ' ';

			$where = 'WHERE ' . $this->where;

			$this->query = "{$action} {$set} {$where}";

			return $this; 
		}
	}