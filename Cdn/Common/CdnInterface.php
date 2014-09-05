<?php

namespace Clarity\CdnBundle\Cdn\Common;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
interface CdnInterface
{
    /**
     * Returns default or named container
     * 
     * @param string $name
     * @return ContainerInterface
     */
    public function container($name);

    /**
     * @param string $fullPath
     *
     * @return self
     */
    public function setFullPath($fullPath);

    /**
     * @param string $schemaPrefix
     *
     * @return self
     */
    public function setSchemaPrefix($schemaPrefix);

    /**
     * @param string $webPath
     *
     * @return self
     */
    public function setWebPath($webPath);
}
