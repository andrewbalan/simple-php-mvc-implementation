<?php
/**
 * Некоторые функции-хелперы
 */

use Dev\Implementations\Exceptions\ViewNotFoundException;
use Dev\Implementations\Lang;

/**
 * Редирект
 * @param  string $url
 * @return void
 */
function redirect( $url) 
{
	header('HTTP/1.1 200 OK');
	header('Location: http://'.$_SERVER['HTTP_HOST'].$url);
	exit();
}

/**
 * Вывод вьюхи
 * @param  string $path
 * @param  string $lang
 * @param  array  $params
 * @return void
 */
function render($path, array $params = null, $lang = 'en')
{
	$path = __DIR__."/Views"."/".$path.".php";
	
	if(file_exists($path))
	{
		require_once $path;
	} 
	else 
	{
		throw new ViewNotFoundException("view not found");
	}
}

/**
 * Хэлпер для перевода
 * @param  string $key 
 * @param  string $lang
 * @return string      
 */
function lang($key, $lang)
{
	return Lang::get($key, $lang);
}


/**
 * Добавляет переданные параметры в сессию 
 * и делает редирект на переданный урл
 * @param  string $url     
 * @param  string $formName
 * @param  array $errors  
 * @param  array $fields  
 * @return void       
 */
function redirectOnError($url, $formName, $errors, $fields)
{
	$_SESSION[$formName] = array();
	$_SESSION[$formName]['errors'] = $errors;
	$_SESSION[$formName]['fields'] = $fields;
	redirect($url);
}