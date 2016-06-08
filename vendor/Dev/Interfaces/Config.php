<?php 
namespace Dev\Interfaces;

interface Config {
	/**
	 * Get config value by the key
	 * @param  string $key
	 * @return string     
	 */
	public function get($key);
}