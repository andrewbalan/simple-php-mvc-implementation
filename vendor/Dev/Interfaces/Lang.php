<?php 
namespace Dev\Interfaces;

interface Lang {
	/**
	 * Get translation string by the key
	 * @param  string $key
	 * @param  string $lang
	 * @return string|boolean
	 */
	public static function get($key, $lang);
}