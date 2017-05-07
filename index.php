<?
	require_once __DIR__ . "/core/init.php";

	
	/*$tables = ['organizations'];
	$fields = [
		Config::get('table/organizations/name'),
		Config::get('table/organizations/pass')
	];
	$where = "`id`='6'";

	$select = new Select($tables, $fields);

	$connection = DB::connect();

	$result = $connection->get($select);

	print_r($result);

	if ($result) {
		print 'ok';
	}
	else print 'bad';*/

	print_r(Route::run());

	print_r(Request::get());

	if (Request::issetGet(ERROR)) {
		print Request::get(ERROR);
	}

