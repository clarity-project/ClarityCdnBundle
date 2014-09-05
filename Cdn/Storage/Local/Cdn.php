<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Clarity\CdnBundle\Cdn\Storage\AbstractCdnStorage;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class Cdn extends AbstractCdnStorage
{
    /**
     * {@inheritDoc}
     */
    public function container($name)
    {
        return new Container($name, $this->fullPath, $this->schemaPrefix, $this->webPath);
    }
}
