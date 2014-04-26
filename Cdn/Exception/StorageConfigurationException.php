<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class StorageConfigurationException extends \InvalidArgumentException
{
    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $message = sprintf('Configured class or service "%s" for cdn storage "%s" not found.', $name, $value);
        parent::__construct($message);
    }
}