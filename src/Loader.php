<?php

namespace GrumphpPhpcbf;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class Loader
 *
 * @package GrumphpPhpcbf
 */
class Loader implements ExtensionInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function load(ContainerBuilder $container)
    {
        $container->register('task.phpcbf', Phpcbf::class)
            ->addArgument(new Reference('config'))
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['config' => 'phpcbf']);
        $container->register('task.git_add', GitAdd::class)
            ->addArgument(new Reference('config'))
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['config' => 'git_add']);
    }
}
