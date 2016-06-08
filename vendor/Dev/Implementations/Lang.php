<?php
namespace Dev\Implementations;

use Dev\Interfaces\Lang as LangInterface;

/**
* Класс lang служит для реализации локализаций.
* Файлы локализаций содержаться в папке resources/localizations
*/
class Lang implements LangInterface
{
	private function __construct() {}

	/**
	 * Возвращает строку перевод соответствующую ключу.
	 * Ключ должен передаваться в формате 
	 * "имяфайлалокализации.алиас1.алиасN.,...,.ключ"
	 * @param  string $key
	 * @param  string $lang
	 * @return string|false
	 */
	public static function get($key, $lang) 
	{
		$parts = explode('.', $key);
		$filename = $parts[0];

		$arr = require __DIR__.'/../../../resources/localizations/'.$filename.'.php';
		
		$parts[0] = $lang;

		/**
		 * Проходим вглубь по массиву локализации
		 * до конечного значения
		 */
		foreach ($parts as $v) {
			if (isset($arr[$v])) {
				$arr = $arr[$v];
			} else {
				return false;
			}
		}

		return $arr;
	}
}