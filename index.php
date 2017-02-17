<?
	require_once __DIR__ . "/core/init.php";

	$user = new User();

	$u = $user->getDataUser('gukklucky');
	print_r($u);

	$user_name = Input::get('login');
	$password = Input::get('password');
	echo '<br>';
	echo 'this login: ' . $user_name . '<br>';
	echo 'this password: ' . $password . '<br>';
	 

	$logined = $user->logined($user_name, $password);
 	print '<br>';
	if ($logined) {
		print '<p> Your is logined!</p>';
	} else {
		print '<p> Error! Try it now!</p>';
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>test</title>
</head>
<body>
	<form action="index.php" method="post">
		<label for="login">login</label>
		<input type="text" name="login" placeholder="enter your name" />
		<br>
		<label for="password">password</label>
		<input type="text" name="password" placeholder="enter your password" />
		<input type="submit" value="send"/>
	</form>
</body>
</html>