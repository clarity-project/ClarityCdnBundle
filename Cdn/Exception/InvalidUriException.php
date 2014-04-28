<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class InvalidUriException extends \InvalidArgumentException
{
    /**
     * @param string $uri
     */
    public function __construct($uri)
    {
        $message = sprintf('Uri "%s" is not valid and can not be parsed.', $uri);
        parent::__construct($message);
    }
}
