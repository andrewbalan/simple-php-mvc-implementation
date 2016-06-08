<?php
namespace Dev\Implementations\Exceptions;

use Dev\Implementations\Exceptions\BaseException;
use Dev\Interfaces\Config as ConfigInterface;


class HttpException extends BaseException
{
	function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	public function handle(ConfigInterface $config) {
		header("HTTP/1.0 $this->code $this->message"); 
		header("HTTP/1.1 $this->code $this->message"); 
		header("Status: $this->code $this->message");
		
		if ($config->get('DEBUG') === "true") 
		{
			render("error", array(
				'picture' => 'http',
				'code' => $this->code,
				'description' => $this->message,
				'trace' => $this->getTrace()
			));
		} else if ($config->get('DEBUG') === "false")
		{
			render("error", array(
				'picture' => 'http',
				'code' => $this->code,
				'description' => $this->message
			));
		}
	}
}