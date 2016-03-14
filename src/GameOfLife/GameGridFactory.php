<?php

namespace GameOfLife;

class GameGridFactory
{
  /**
   * @var GameGridProcessor
   */
  protected $gridProcessor;

  /**
   * GameGridFactory constructor.
   */
  public function __construct()
  {
      $this->gridProcessor = new GameGridProcessor();
  }

  /**
   * Create a new grid with the specified width x height.
   *
   * @param int $width
   * @param int $height
   *
   * @return GameGrid
   */
  public function makeGrid($width, $height)
  {
    return $this->gridProcessor->generateGrid($width, $height);
  }

}
