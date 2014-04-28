<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class ContainerAccessException extends \InvalidArgumentException
{
    /**
     * @param string $name
     * @param string $path
     */
    public function __construct($name, $path)
    {
        $message = sprintf('Container folder "%s" in the "%s" does not exists or not writable.', $name, $path);
        parent::__construct($message);
    }
}
