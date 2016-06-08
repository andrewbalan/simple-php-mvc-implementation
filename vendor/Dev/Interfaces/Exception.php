<?php 
namespace Dev\Interfaces;
use Dev\Interfaces\Config as ConfigInterface;

interface Exception {
	/**
	 * Do something like log info,render view
	 * @return void
	 */
	public function handle(ConfigInterface $config);
}