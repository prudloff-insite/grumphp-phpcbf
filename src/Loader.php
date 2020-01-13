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
class Loader implements ExtensionInterface {

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
   */
  public function load(ContainerBuilder $container) {
    $container->register('task.phpcbf', Phpcbf::class)
      ->addArgument(new Reference('config'))
      ->addArgument(new Reference('process_builder'))
      ->addArgument(new Reference('formatter.phpcsfixer'))
      ->addTag('grumphp.task', ['config' => 'phpcbf']);
  }
}
