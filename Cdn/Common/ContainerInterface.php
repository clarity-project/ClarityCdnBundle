<?php

namespace Clarity\CdnBundle\Cdn\Common;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
interface ContainerInterface
{
    /**
     * @param  string $name
     * @return \Clarity\CdnBundle\Cdn\Common\ObjectInterface
     */
    public function get($name);

    /**
     * @param  string $name
     * @return boolean
     */
    public function remove($name);

    /**
     * @param UploadedFile $file
     * @param string $name custom file name
     * @return \Clarity\CdnBundle\Cdn\Common\ObjectInterface
     */
    public function touch(UploadedFile $file, $name = null);
}
