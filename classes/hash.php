<?
	class Hash {
		public static function make($string, $salt = '') {
			return hash('sha256', $string . $salt);
		}

		public static function salt($length) {
			for ($pointer = 0; $pointer < $length; $pointer++) {
				$string .= "{$pointer}"; 
			}
			return md5($string);
		}

		public static function unique() {
			return self::make(uniqid());
		}
	}
?>