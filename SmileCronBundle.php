<?php

namespace Smile\CronBundle;

use Smile\CronBundle\DependencyInjection\Compiler\CronPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SmileCronBundle
 *
 * @package Smile\CronBundle
 */
class SmileCronBundle extends Bundle
{
    /**
     * Build bundle
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CronPass());
    }
}
