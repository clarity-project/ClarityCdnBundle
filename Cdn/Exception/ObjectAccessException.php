<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class ObjectAccessException extends \RuntimeException
{
	/**
	 * 
	 * @param string $path
	 */ 
	public function __construct($path)
	{
		$message = sprintf('File "%s" does not exists or not readable. Please verify configuration or file existence.', $path);
		parent::__construct($message);
	}
}