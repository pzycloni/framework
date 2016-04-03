<?
	/*
		Запросы к бд, 
		их формирование, 
		возвращение результатов
	*/
	class DB {
		private static $_instance = null;
		private $_errors 		= false,
				$_desc_error 	= array(),
				$_results 		= array(),
				$_query  		= null,
				$_count	 		= 0, 
				$_db	 		= null,
				$_primary_key	= null;

		/*
			Подключение к базе
			по умолчанию устанавливает кодировку базы как 1251
		*/
		public function __construct($names = "cp1251") {
			if (!self::$_instance) {
				// создаем подключение к бд
				//$this->_db = $this->getInstance();
				try {
					mysql_connect(
						Config::get('mysql/host'), 
						Config::get('mysql/username'), 
						Config::get('mysql/password')
					);
					mysql_select_db(Config::get('mysql/db'));
					mysql_set_charset("SET NAMES {$names}");
					echo "connected!";
				}
				catch (Exception $exception) {
					die($exception->getMessage());
				}
			}
		}

		/*
			Устанавливает единственное соединение с базой
			если соединение уже установлено, то оно будет единственным
		*/
		public static function getInstance() {
			if (!isset(self::$_instance)) {
				self::$_instance = new DB;
			}
			return self::$_instance;
		}

		/*
			Получаем список ошибок
		*/
		public function getErrors() {
			return $this->_desc_error;
		}

		/*
			Распечатка ошибок
		*/
		public function printErrors() {
			foreach ($this->getErrors() as $error) {
				print $error . '<br>';
			}
		}

		/*
			Проверка на существование ошибок
		*/
		public function error() {
			return isset($this->_desc_error) ? true : false;
		}

		/*
			Возвращает последний запрос к бд
		*/
		public function getLastQuery() {
			return $this->_query;
		}

		/*
			Получение размера массива резульататов
		*/
		public function counter() {
			return $this->_count;
		}

		/*
			Получение массива результатов
		*/
		public function result() {
			return $this->_results;
		}

		/*
			Получение первого результата массива
		*/
		public function first() {
			return $this->_results[0];
		}

		/*
			Запрос к бд и формирование массива с результатом
			В случае, если бд вернет boolean, метод вернет true
			Также идет подсчет элементов массива
			Метод возвращает объект
		*/
		public function query($sql) {
			unset($this->_desc_error);
			$this->_errors = false;
			$this->_query 	= $sql;
			if ($resource = mysql_query($sql)) {
				if (!is_bool($resource)) {
					while ($items = mysql_fetch_assoc($resource)) {
						$results[] = $items;
					}
					$this->_results = $results;
					$this->_count 	= count($results);
					// если размер массива с результатом < 1, преобразуем его
					// в более удобный массив
					if (!(count($results) - 1)) {
						$this->_results = $this->compressedArray($results);
						$this->_count 	= count($this->_results);
					}
				} else {
					return true;
				}
			} else {
				$this->_desc_error[] = mysql_error();
				$this->_error = true;
				return false;
			}
			return $this;
		}

		/*
			Преобразование в массив строки или числа
		*/
		private function toArray($param) {
			if (!is_array($param)) {
				$param = array($param);
			}
			return $param;
		}

		/*
			Формирование запроса
		*/
		public function action($action, $tables = array(), $where = array()) {
			$x 		= 1;
			$where 	= $this->toArray($where);
			$tables	= $this->toArray($tables);

			foreach ($where as $value) {
				$str .= $value;
				$str .= ($x < count($where)) ? ' ' : '';
				$x++;
			}
			$sql = "{$action} FROM `" . implode('`, `', $this->toArray($tables)) . "` WHERE {$str}";
			if(!$this->query($sql)->_error) {
				return $this;
			}
			return false;
		}

		/*
			Select запрос (получение данных)
		*/
		public function get($tables = array(), $fields = array(), $where = null) {
			$fields = $this->toArray($fields);
			// если $where пусто то присваиваем 1 во избежания ошибок
			$where = (!$where) ? '1' : $where;
			return $this->action("SELECT " . implode(', ', $fields) . "", $tables, $where);
		}

		/*
			Удаление записи из бд
		*/
		public function delete($tables = array(), $where = array()) {
			return $this->action("DELETE", $tables, $where);
		}

		/*
			Обновление информации бд
		*/
		public function update($table, $fields, $where) {
			$set = '';
			$x = 1;
			$table 	= $this->toArray($table);
			$fields = $this->toArray($fields);
			$where 	= $this->toArray($where);

			foreach ($fields as $name => $value){
				$set .= "`{$name}` = '{$value}'";
				if ($x < count($fields)){
					$set .= ', ';
				}
				$x++;
			}
			$sql = "UPDATE `" . implode('`, `', $table) . "` SET {$set} WHERE " . implode(' ', $where);
			if ($this->query($sql)){
				return true;
			}
			return false;
		}

		/*
			Вставка новой записи в таблицу
		*/
		public function insert($table, $fields) {
			$table 	= $this->toArray($table);
			$fields = $this->toArray($fields);

			if (count($fields)){
				$keys = array_keys($fields);
				foreach ($fields as $field){
					$values[] .= $field;
				}
				$sql = "INSERT INTO " . implode('`, `', $table) . " (`" . implode('`, `', $keys) . "`) VALUES ('" . implode("', '", $values) . "')";

				if($this->query($sql)){
					return true;
				}
			}
			return false;
		}

		/*
			Переработка массива
		*/
		private function compressedArray($items) {
			$items = $this->toArray($items);
			foreach ($items as $item) {
				if (is_array($item)) {
					foreach ($item as $key => $value) {
						$result[$key] = $value;
					}
				}
			}
			return $result;
		}

		/*
			Создание таблицы(если ее не существует)
			формат поля fields: 
					array('имя_поля' => 'опции', ...)
		*/
		public function createTable($name, $fields, $primary_key = null) {
			$x = 1;
			$fields = $this->toArray($fields);
			$sql = "CREATE TABLE IF NOT EXISTS `{$name}` (";
			if (!is_array($name)) {
				foreach ($fields as $key => $option) {
					$sql .= "`{$key}` {$option}";
					if ($x < count($fields)){
						$sql .= ', ';
					}
					$x++;
				}
				$sql .= ($primary_key) ? $this->setPrimaryKey($primary_key) : '';
				$sql .= ")";
			}
			if (!$this->query($sql)->_error) {
				return $this;
			}
			print $sql;
		}

		/*
			Установка первичного ключа
		*/
		private function setPrimaryKey($key = null) {
			if ($key) {
				$key = $this->toArray($key);
				return ", PRIMARY KEY (`" . implode('`, `', $key) . "`)";
			}
		}



		private function countArray($items, $ordered = false) {
			$this->_count = 0;
			if (!$ordered && is_array($items)) {
				foreach ($items as $item) {
					$this->_count++;
				}
			} else {
				return 0;
			}
			return $this->_count;
		}

	}
?>