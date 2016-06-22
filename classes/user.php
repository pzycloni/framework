<?
	class User {
		private $_permission  	= null,
				$_db			= null,
				$_group			= null;

		public function __construct() {
			$this->_db = DB::getInstance();
		}

		public function getInfoAboutUser() {
			$this->_db->get(
				"user",
				array(
					Config::get("table/user/username"),
					Config::get("table/user/pass"),
					Config::get("table/user/group"),
					Config::get("table/user/salt"),
					Config::get("table/user/email")
				),
				Config::get("table/user/username") . " = '" . Session::get(Config::get("session/session_name")) . "'"
			);
			$this->_db->printResult(true);
			print_r($this->_db->getLastQuery());
		}
	}
?>