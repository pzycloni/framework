<?php
	/*
		Запросы к бд, 
		их формирование, 
		возвращение результатов
	*/
	class DB {
		private static $_instance 	= null;

		private $errors 			= null;
		private	$_query  			= null;

		private $result 			= null;

		/*
			Подключение к базе
			по умолчанию устанавливает кодировку базы как 1251
		*/
		public function __construct($names = "cp1251") {
			if (!self::$_instance) {
				try {
					mysql_connect(
						Config::get(SERVER_SQL . "host"), 
						Config::get(SERVER_SQL . "username"), 
						Config::get(SERVER_SQL . "password")
					);
					mysql_select_db(Config::get(SERVER_SQL . "db"));
					mysql_set_charset("SET NAMES {$names}");
				}
				catch (Exception $exception) {
					die($exception->getMessage());
				}
			}
			// создаем механизм обработки данных
			$this->result = new Data();
			// создаем меxанизм ошибок
			$this->errors = new Error();
		}

		/*
			Устанавливает единственное соединение с базой
			если соединение уже установлено, то оно будет единственным
		*/
		public static function connect() {
			if (!isset(self::$_instance)) {
				self::$_instance = new DB;
			}
			return self::$_instance;
		}

		/*
			Возвращает последний запрос к бд
		*/
		public function getLastQuery() {
			return $this->_query;
		}

		/*
			Проверка, выполнен ли запрос к бд
		*/
		public function executed() {
			return $this->errors->is_clean();
		}

		/*
			Получение массива ошибок
		*/
		public function errors() {
			return $this->errors->get();
		}

		/*
			Получаем данные
		*/
		public function results() {
			return $this->result;
		}

		/*
			Запрос к бд и формирование массива с результатом
			В случае, если бд вернет boolean, метод вернет true
			Также идет подсчет элементов массива
			Метод возвращает объект
		*/
		private function query($sql) {
			// удаляем предыдущие данные
			$this->result->clean();
			// удаляем предыдущие ошибки
			$this->errors->clean();
			// сохраняем новый sql запрос
			$this->_query = $sql;

			$resource = mysql_query($sql);

			if (!$resource) {
				$this->errors->push(mysql_error());
				return false;
			}

			if (is_bool($resource)) {
				return true;
			}

			while ($item = mysql_fetch_assoc($resource)) {
				$this->result->push($item);
			}

			return $this;
		}

		/**
			* Select запрос (получение данных)
			* 
			* @param Query $select
			*
			* @return Data
		*/
		public function get(Query $select) {
			return $this->query($select->get());
		}

		/*
			Удаление записи из бд
		*/
		public function delete(Query $delete) {

			if ($this->query($delete->get())) {
				return true;
			}
			
			return false;
		}

		/*
			Обновление информации бд
		*/
		public function update(Query $update) {
			
			if ($this->query($update->get())){
				return true;
			}

			return false;
		}

		/*
			Вставка новой записи в таблицу
		*/
		public function insert(Query $insert) {

			if ($this->query($insert->get())){
				return true;
			}

			return false;
		}
	}
?>