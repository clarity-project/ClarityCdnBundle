<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class StorageNotFoundException extends \InvalidArgumentException
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $message = sprintf('Storage with name "%s" not registered in cdn registry.', $name);
        parent::__construct($message);
    }
}