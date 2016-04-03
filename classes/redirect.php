<?
	class Redirect {
		public static function to($location = null) {
			if ($location) {
				if (is_numeric($location)) {
					switch ($location) {
						case 404:
							header('Location: ' . $location);
							require "includes/errors/404.php";
							exit();
							break;
					}
				}
				header('Location: ' . $location);
				exit();
			}
		}
	}