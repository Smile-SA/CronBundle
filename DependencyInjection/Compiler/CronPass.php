<?php

namespace Smile\CronBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CronPass
 *
 * @package Smile\CronBundle\DependencyInjection\Compiler
 */
class CronPass implements CompilerPassInterface
{
    /**
     * Fetch all cron by tag smile:cron
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('smile.cron.handler')) {
            return;
        }

        $definition = $container->findDefinition('smile.cron.handler');
        $taggedServices = $container->findTaggedServiceIds('smile.cron');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addCron', array(
                    new Reference($id),
                    $attributes['alias'],
                    !isset($attributes['priority']) ? 0 : (int)$attributes['priority'],
                    !isset($attributes['arguments']) ? '': $attributes['arguments']
                ));
            }
        }
    }
}
