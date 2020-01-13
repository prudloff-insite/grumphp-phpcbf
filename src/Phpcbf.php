<?php

namespace GrumphpPhpcbf;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Phpcs;
use function count;

/**
 * Class Phpcbf
 *
 * @package GrumphpPhpcbf
 */
class Phpcbf extends Phpcs {

  /**
   * @return string
   */
  public function getName(): string {
    return 'phpcbf';
  }

  /**
   * @param \GrumPHP\Task\Context\ContextInterface $context
   *
   * @return \GrumPHP\Runner\TaskResultInterface
   */
  public function run(ContextInterface $context): TaskResultInterface {
    /** @var array $config */
    $config = $this->getConfiguration();

    /** @var array $whitelistPatterns */
    $whitelistPatterns = $config['whitelist_patterns'];

    /** @var array $extensions */
    $extensions = $config['triggered_by'];

    /** @var \GrumPHP\Collection\FilesCollection $files */
    $files = $context->getFiles();
    if (count($whitelistPatterns)) {
      $files = $files->paths($whitelistPatterns);
    }
    $files = $files->extensions($extensions);

    if (0 === count($files)) {
      return TaskResult::createSkipped($this, $context);
    }

    $arguments = $this->processBuilder->createArgumentsForCommand('phpcbf');
    $arguments = $this->addArgumentsFromConfig($arguments, $config);
    $arguments->addFiles($files);

    $process = $this->processBuilder->buildProcess($arguments);
    $process->run();

    if (!$process->isSuccessful()) {
      $output = $this->formatter->format($process);

      return TaskResult::createNonBlockingFailed($this, $context, $output);
    }

    return TaskResult::createPassed($this, $context);
  }

}