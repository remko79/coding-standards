<?php

namespace DrupalProject\composer;

use Composer\Script\Event;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Allows creation of the pre-commit git hook.
 */
class CodingStandards {

  /**
   * Set the pre-commit git hooks by symlinking it to the 'pre-commit' file.
   *
   * @param \Composer\Script\Event $event
   *   The event.
   *
   * @throws \Exception
   */
  public static function setGitHooks(Event $event) {
    $fs = new Filesystem();
    $root = getcwd();
    if ($fs->exists($root . '/.git')) {
      $sourceFile = $root . '/vendor/remko79/coding-standards/pre-commit';
      $destFile = $root . '/.git/hooks/pre-commit';
      if (!$fs->exists($sourceFile)) {
        throw new Exception('File doesn\'t exist: ' . $sourceFile);
      }

      if (!$fs->exists($destFile)) {
        $fs->symlink($sourceFile, $destFile, FALSE);
      }
      elseif (is_link($destFile) && readlink($destFile) === $sourceFile) {
        // Do nothing, link already exists.
      }
      else {
        throw new Exception('File already exists: ' . $destFile);
      }
    }
  }

}
