<?php

namespace Clarity\CdnBundle\Cdn;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class CdnRegistry
{
    /**
     * @param  string $name
     * @return Common\CdnInterface
     */
    public function getCdn($name = null)
    {
        if (null === $name) {
            return $this->getDefaultCdn();
        }
    }

    /**
     * @return CommonCdnInterface
     */
    public function getDefaultCdn()
    {

    }
}