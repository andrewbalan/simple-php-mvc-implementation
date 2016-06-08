<?php
namespace Dev\Implementations\Exceptions;

use Dev\Implementations\Exceptions\BaseException;
use Dev\Interfaces\Config as ConfigInterface;


class ViewNotFoundException extends BaseException
{
	function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	public function handle(ConfigInterface $config) {
		if ($config->get('DEBUG') === "true") 
		{
			render("error", array(
				'picture' => 'server',
				'code' => 500,
				'description' => "View not found",
				'trace' => $this->getTrace()
			));
		} else if ($config->get('DEBUG') === "false")
		{
			render("error", array(
				'picture' => 'server',
				'code' => 500,
				'description' => "Internal server error"
			));
		}
	}
}