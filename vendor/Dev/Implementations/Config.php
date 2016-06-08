<?php
namespace Dev\Implementations;

use Dev\Interfaces\Config as ConfigInterface;

/**
* Класс парсит файл config.env
* и служит для обеспечения удобного
*  доступа к настройкам приложения
*/
class Config implements ConfigInterface
{
	private static $_instance = null;
	private static $_params = array();
	
	private function __construct() 
	{
		$path = __DIR__."/../../../config.env";
		if (file_exists($path)) 
		{
			$strArray = file($path);
			foreach ($strArray as $index => $row) 
			{
				if (preg_match("/\w+/", $row)) {
					$tmp = explode("=", $row);
					self::$_params[$tmp[0]] = trim($tmp[1]);
				}
			}
		} else die("Config file not found");
		
	}

	public static function instance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Config();
		}
		return self::$_instance;        
	}

	/**
	 * Возвращает параметр конфигурации
	 * @param  string $key
	 * @return string|bool     
	 */
	public function get($key)
	{
		if (isset(self::$_params[$key])) {
			return self::$_params[$key];
		}
		return false;
	}
}