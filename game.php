<?php
/**
 * Challenge Yourselph - 042
 * Recreate Conway's Game of Life
 *
 * Usage: php game.php
 *
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 * @date 03/09/2016
 */

use GameOfLife\GridAnimator;

require_once __DIR__ . '/vendor/autoload.php';

$config = (string) isset($argv[1]) ? $argv[1] : 0;

$animator = new GridAnimator($config);

for ($i = 0; $i < 100; $i++) {
  $animator->animate();
}
