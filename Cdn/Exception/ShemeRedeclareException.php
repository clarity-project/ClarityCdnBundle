<?php

namespace Clarity\CdnBundle\Cdn\Exception;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class ShemeRedeclareException extends \InvalidArgumentException
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $message = sprintf('Scheme with name "%s" are already added to cdn registry.', $name);
        parent::__construct($message);
    }
}
