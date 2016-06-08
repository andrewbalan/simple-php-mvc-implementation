<?php
namespace Dev\Implementations;

use Dev\Interfaces\Router as RouterInterface;
use Dev\Implementations\Exceptions\HttpException;

/**
 * Реализация роутера
 */
class Router implements RouterInterface
{
	private static $_handlers = array();
	private static $_getRoutes = array();
	private static $_postRoutes = array();
	private static $_instance = null;
	
	/**
	 * Закрываем возможность явного вызова конструктора
	 */
	private function __construct() {}
	
	/**
	 * Вернуть эксемпляр класса
	 * @return Dev\Implementations\Router 
	 */
	public static function instance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Router();
		}
		return self::$_instance;        
	}

	/**
	 * Зарегистрировать get роут
	 * @param  string   $pattern
	 * @param  \Closure $handler
	 * @return void
	 */
	public static function get($pattern, \Closure $handler)
	{
		self::$_getRoutes[$pattern] = $handler;
	}

	/**
	 * Зарегистрировать post роут
	 * @param  string   $pattern
	 * @param  \Closure $handler
	 * @return void
	 */
	public static function post($pattern, \Closure $handler)
	{
		self::$_postRoutes[$pattern] = $handler;
	}

	/**
	 * Обработать запрос
	 */
	public function execute()
	{
		$requestType = $_SERVER['REQUEST_METHOD'];
		$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		$args = array();
		
		// Найти среди зарегистрированных роутов соответствующий запросу
		switch ($requestType) 
		{
			case "GET":
				$handler = $this->getHandler($uri, self::$_getRoutes, $args);
				break;
			case "POST":
				$handler = $this->getHandler($uri, self::$_postRoutes, $args);
				break;
			default:
				throw new HttpException("Bad Request", 400);
		}

		if($handler) 
		{
			call_user_func_array($handler, $args);
		} 
			else throw new HttpException("Not Found", 404);
	}

	/**
	 * Ищет соответствующий запросу обработчик,
	 * разбирает аргументы и  передаёт в массив $args
	 * Если обработчик не найден то возвращает false
	 * @param  string $route
	 * @param  array $array
	 * @param  array $args
	 * @return Closure|bool       
	 */
	private function getHandler($route, array $array, array &$args) {
		$routeParts = explode("/", $route);
		
		foreach ($array as $pattern => $handler) 
		{	
			$patternParts = explode("/", $pattern);


			if (count($routeParts) == count($patternParts)) 
			{
				$isEqual = true;
				$pattern = '/^\{\w*\}$/';
				$arguments = array();

				for ($i=0; $i < count($routeParts); $i++) 
				{ 
					if (preg_match($pattern, $patternParts[$i])) 
					{
						$text = strip_tags($routeParts[$i]);
						$text = htmlspecialchars($text);
						
						$arguments[] = $routeParts[$i];
					} 
						else if ($patternParts[$i] !== $routeParts[$i]) 
					{
						$isEqual = false;
					}
				}

				if ($isEqual) 
				{
					$args = $arguments;
					return $handler;
				} 
			}
		}
		return false;
	}
}