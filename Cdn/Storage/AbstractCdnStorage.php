<?php

namespace Clarity\CdnBundle\Cdn\Storage;

use Clarity\CdnBundle\Cdn\Common\CdnInterface;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
abstract class AbstractCdnStorage implements CdnInterface
{
    /**
     * @var string full path to uploads
     */
    protected $fullPath;

    /**
     * @var string
     */
    protected $schemaPrefix;

    /**
     * @var string web path to uploads
     */
    protected $webPath;

    /**
     * {@inheritDoc}
     */
    public function setFullPath($fullPath)
    {
        $this->fullPath = $fullPath;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setSchemaPrefix($schemaPrefix)
    {
        $this->schemaPrefix = $schemaPrefix;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;

        return $this;
    }
}
