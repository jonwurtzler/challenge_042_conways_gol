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

use GameOfLife\GameOfLife;

require_once __DIR__ . '/vendor/autoload.php';

$width  = (string) isset($argv[1]) ? $argv[1] : 100;
$height = (string) isset($argv[2]) ? $argv[2] : 100;

echo ("Done!\n");
