<?
	require_once __DIR__ . "/core/init.php";

	// запускаем приложение
	$answer = Route::run();

	if (Request::isJSON()) {
		echo $answer;
	} 
	else {
		// проверяем на ошибки
		if (Request::issetGet(ERROR)) {
			require_once VIEWS . 'error.php';
		}
		// подгружаем документацию
		else if (Request::issetGet(DOCS)) {
			require_once VIEWS . 'docs.php';
		}
		// подгружаем регистрацию
		else if (Request::emptyPost() && Request::emptyGet()) {
			require_once VIEWS . 'signup.php';
		}
		else {
			echo $answer;
		}
	}
	