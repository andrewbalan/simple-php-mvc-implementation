<?php
/**
 * В этом файле регистрация всех роутов приложения.
 * Часть паттерна роута, окружённая фигурными скобками
 * считается за переменную и передаётся в коллбэк
 */

use Dev\Implementations\Router;
use Dev\Implementations\Config;
use Dev\App\Models\User;
use Dev\Implementations\Exceptions\HttpException;
use Dev\Implementations\Lang;


Router::get("/", function() {
	redirect('/ru');
});

/**
 * Логаут
 */
Router::get('/logout', function () {
	session_destroy();
	redirect('/');
});

/**
 * Роут формы логина
 */
Router::get("/{lang}", function($lang) {
	if (preg_match('/^ru|en$/', $lang)) {
		if (isset($_SESSION['loginForm']) && count($_SESSION['loginForm'])) {
			render("form", $_SESSION['loginForm'], $lang);
			unset($_SESSION['loginForm']);
		} else {
			render("form", null, $lang);	
		}
	} else {
		throw new HttpException("Bad request", 400);
	}
});

/**
 * Роут формы регистрации
 */
Router::get("/{lang}/register", function($lang) {
	if (preg_match('/^ru|en$/', $lang)) {
		if (isset($_SESSION['registerForm']) && count($_SESSION['registerForm'])) {
			render("register", $_SESSION['registerForm'], $lang);
			unset($_SESSION['registerForm']);
		} else {
			render("register", null, $lang);
		}
	} else {
		throw new HttpException("Bad request", 400);
	}
});

/**
 * Роут профиля
 */
Router::get("/{lang}/user/{id}", function($lang, $id) {
	if (preg_match('/^ru|en$/', $lang)) {
		if (!isset($_SESSION['user'])) {
			throw new HttpException(lang("errors.http.forbidden_acces", $lang), 403);
		}

		$u = new User(Config::instance());
		$arr = $u->findOne(intval($id));
		
		if($arr) {
			render("profile", $arr, $lang);
		} else {
			throw new HttpException(lang("errors.http.user_not_found", $lang), 404);
		}
	} else {
		throw new HttpException("Bad request", 400);
	}
});

/**
 * Авторизация юзера
 */
Router::post("/login", function() {
	$lang = "";
	$errors = array();

	/**
	 * 1. Валидация полей
	 */
	if (isset($_POST['lang']) && preg_match("/^ru|en$/", $_POST['lang'])) {
		$lang = $_POST['lang'];
	} else {
		throw new HttpException("Bad request", 400);
	}

	if (!preg_match("/^\w+@\w+\.\w+$/", $_POST['email'])) {
		$errors[] = lang("errors.login_validation.email", $lang);
	}

	if (!preg_match("/^\w{7,35}$/", $_POST['password'])) {
		$errors[] = lang("errors.login_validation.password", $lang);
	}

	if(count($errors))
	{
		redirectOnError("/$lang", 'loginForm', $errors, $_POST);
	}

	/**
	 * 2. Аутентификация юзера
	 */	
	$user = (new User(Config::instance()))->findByEmail($_POST['email']);

	if(!$user) {
		$errors[] = lang("errors.login_auth.email", $lang);
		redirectOnError("/$lang", 'loginForm', $errors, $_POST);
	}

	$pass = sha1($_POST['password'] . Config::instance()->get('APP_KEY'));

	if($user['password'] !== $pass) {
		$errors[] = lang("errors.login_auth.password", $lang);
		redirectOnError("/$lang", 'loginForm', $errors, $_POST);
	} else {
		$_SESSION['user'] = $user['id'];
		redirect("/$lang/user/".$user['id']);
	}

});

/**
 * Регистрация юзера
 */
Router::post("/register", function() {
	$errors = array();

	if (preg_match("/^ru|en$/", $_POST['lang'])) {
		$lang = $_POST['lang'];
	} else {
		throw new HttpException("Bad request", 400);
	}
	

	if (!preg_match("/^\w+@\w+\.\w+$/", $_POST['email'])) {
		$errors[] = lang("errors.register_validation.email", $lang);
	}

	if (!preg_match("/^\w{5,30}$/", $_POST['nickname'])) {
		$errors[] = lang("errors.register_validation.nickname", $lang);
	}

	if (!preg_match("/^\w{7,35}$/", $_POST['password'])) {
		$errors[] = lang("errors.register_validation.password", $lang);
	}

	if ($_POST['confirmPassword'] !== $_POST['password']) {
		$errors[] = lang("errors.register_validation.confirm_password", $lang);
	}

	/**
	 * Проверка изображения
	 */	
	if(
		(!empty($_FILES["image"])) && 
		($_FILES['image']['error'] == 0)
	) 
	{
		$params = getimagesize($_FILES["image"]['tmp_name']);
		$allowedTypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');

		if (
			$params[0] < 1280 &&
			$params[1] < 768  &&
			in_array($params['mime'] , $allowedTypes)
		)
		{
			$uploaddir = Config::instance()->get("UPLOAD_DIR");
			$ext = explode('/', $params['mime'])[1];
			$filename = time().rand(11,99).".".$ext;
			$fullPath = __DIR__."/../".$uploaddir."/".$filename;

			if (!file_exists($fullPath)) 
			{
				if (!(move_uploaded_file($_FILES['image']['tmp_name'], $fullPath))) 
				{
					$errors[] = lang("errors.register_validation.image.load_fail", $lang);
				}
			} else {
				$errors[] = lang("errors.register_validation.image.load_fail", $lang);
			}
		} else {
			$errors[] = lang("errors.register_validation.image.unsupported_format", $lang);
		}
	} else 
	{
		$errors[] = lang("errors.register_validation.image.not_included", $lang);
	}

	/**
	 * Если массив  $errors пуст, то регистрируем пользователя
	 * и делаем редирект на его профиль, в противном случаем
	 * помещаем $errors в сессию и редиректим на форму регистрации
	 */
	if(count($errors)) 
	{
		redirectOnError("/$lang/register", 'registerForm', $errors, $_POST);
	} 
		else 
	{
		$u = new User(Config::instance());
		$pass = sha1($_POST['password'] . Config::instance()->get('APP_KEY'));

		try {
			$id = $u->storeNew([
					$_POST['nickname'],
					$_POST['email'],
					$filename,
					$pass, 
			]);
		} catch(\PDOException $e) 
		{
			if ($e->getCode() === "23000") 
			{
				// удаляем загруженный файл
				unlink($fullPath);

				// редиректим на форму
				$errors[] = lang("errors.register_validation.email_exists", $lang);
				redirectOnError("/$lang/register", 'registerForm', $errors, $_POST);
			}
		}

		if (isset($id) && $id) 
		{
			$_SESSION['user'] = $id;
			redirect("/$lang/user/$id");
		} 
			else 
		{
			throw new HttpException(lang("errors.registration_fail", $lang), 500);
		}
	}
});

