<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class ConfigurationNotFoundException extends \InvalidArgumentException
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $message = sprintf('Configuration for cdn with name "%s" not found.', $name);
        parent::__construct($message);
    }
}
