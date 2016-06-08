<?php
namespace Dev\Implementations\Exceptions;

use Dev\Interfaces\Exception as ExceptionInterface;
use Dev\Interfaces\Config as ConfigInterface;

/**
* Реализация исключения
*/
class BaseException extends \Exception implements ExceptionInterface
{
	function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		
		$this->code = $code;
		$this->message = $message;
	}

	public function handle(ConfigInterface $config) {}
}