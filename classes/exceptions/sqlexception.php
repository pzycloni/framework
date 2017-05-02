<?php

	class SqlException extends DefaultException {

		/*
			Содержит объект запроса к бд
		*/
		protected $_query;

		/*
			Инициализируем базовый конструктор
		*/
		public function __construct(Query $query = null) {

			if (!is_null($query)) {
				DefaultException::__construct('Invalid query: ' + $query->get());
			} else {
				DefaultException::__construct();
			}

			$this->_query = $query;
		}

		/*
			Получаем объект запроса к бд
		*/
		public function getQuery() {
			return $this->_query;
		}
	}