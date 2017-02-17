<?php
	/*
		Формирование хеша, соли,
		а также стравнение строк 
		(как строгое, так и просто поиск вхождений)
	*/
	class Hash {
		/*
			формирование хеша
			используя шифрование sha256
		*/
		public static function make($string, $salt = '') {
			return hash('sha256', $string . $salt);
		}

		/*
			формирование соли
		*/
		public static function salt($length) {
			for ($pointer = 0; $pointer < $length; $pointer++) {
				$string .= "{$pointer}"; 
			}
			return md5($string);
		}

		/*
			формирование уникального значения
		*/
		public static function unique() {
			return self::make(uniqid());
		}

		/*
			поиск вхождений
		*/
		public static function like($haystack, $needle) {
			return (strpos($haystack, $needle) === false) ? false : true;
		}

		/*
			преобразование в хеш и сравнение
		*/
		public static function equal($string, $salt, $hash) {
			$temp_hash = self::make($string, $salt);

			if (self::compareHash($hash, $temp_hash))
				return true;
			if (self::like($temp_hash, $hash))
				return true;
			return false;
		}

		/*
			сравнение двух строк
		*/
		public static function compareHash($haystack, $needle) {
			return ($haystack === $needle) ? true : false;
		}
	}
?>