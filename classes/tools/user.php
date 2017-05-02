<?php
	class User {
		private $_permission  	= null,
				$_db			= null,
				$_group			= null,
				$_user 			= null;

		public function __construct() {
			$this->_db = DB::getInstance();
		}
	}
