<?php
namespace Dev\Interfaces;

interface Router 
{
	/**
	 * Register get route
	 * @param  string $pattern
	 * @param  Closure $handler
	 * @return void
	 */
	public static function get($pattern, \Closure $handler);

	/**
	 * Register post route
	 * @param  string $pattern
	 * @param  Closure $handler
	 * @return void
	 */
	public static function post($pattern, \Closure $handler);

	/**
	 * Call an apropriate method or closure
	 * @return void
	 */
	public function execute();
}