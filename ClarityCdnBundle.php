<?php

namespace Clarity\CdnBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Clarity\CdnBundle\DependencyInjection\Compiler\SchemePass;
use Clarity\CdnBundle\DependencyInjection\Compiler\RegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class ClarityCdnBundle extends Bundle
{   
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SchemePass());
    }
}
