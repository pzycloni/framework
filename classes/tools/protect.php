<?php
	class Protect {

		public static function complex($value) {

			//$value = self::sql($value);
			$value = self::xss($value);

			return $value;
		}

		public static function xss($value = null) {
			if (is_null($value)) 
				return false;
			return htmlspecialchars($value);
		}

		public static function sql($value = null) {
			if (is_null($value)) 
				return false;
			return mysql_real_escape_string($value);
		}
	}