<?php

namespace GameOfLife;

class GameGridProcessor
{

  /**
   * @var GameGrid;
   */
  protected $grid;

  /**
   * Create and populate the grid with needed information.
   *
   * @param int $width
   * @param int $height
   *
   * @return GameGrid
   */
  public function generateGrid($width, $height)
  {
    $this->grid = new GameGrid($width, $height);

    $this->setCorners()
      ->setColFirst()
      ->setColLast()
      ->setRowFist()
      ->setRowLast();

    return $this->grid;
  }

  /**
   * Calculate the corner locations.
   *
   * @return $this
   */
  private function setCorners()
  {
    // Top Left
    $corners   = [0];

    // Top Right
    $corners[] = $this->grid->getWidth() - 1;

    // Bottom Left
    $corners[] = ($this->grid->getHeight() - 1) * $this->grid->getWidth();

    // Bottom Right
    $corners[] = ($this->grid->getWidth() * $this->grid->getHeight()) - 1;

    $this->grid->setCorners($corners);

    return $this;
  }

  /**
   * Set what points are in the first column.
   *
   * @return $this
   */
  private function setColFirst()
  {
    $totalPointRange = ($this->grid->getWidth() * $this->grid->getHeight()) - $this->grid->getWidth();

    $this->grid->setColFirst(range(0, $totalPointRange, $this->grid->getWidth()));

    return $this;
  }

  /**
   * Set what points are in the last column.
   *
   * @return $this
   */
  private function setColLast()
  {
    $totalPointRange = ($this->grid->getWidth() * $this->grid->getHeight());

    $this->grid->setColLast(range($this->grid->getWidth() - 1, $totalPointRange, $this->grid->getWidth()));

    return $this;
  }

  /**
   * Set points in the first row.
   *
   * @return $this
   */
  private function setRowFist()
  {
    $this->grid->setRowFirst(range(0, $this->grid->getWidth() - 1));

    return $this;
  }

  /**
   * Set Points in the last row.
   *
   * @return $this
   */
  private function setRowLast()
  {
    $lastRowEndingPoint   = $this->grid->getWidth() * $this->grid->getHeight() - 1;
    $lastRowStartingPoint = $lastRowEndingPoint - $this->grid->getWidth() + 1;

    $this->grid->setRowLast(range($lastRowStartingPoint, $lastRowEndingPoint));

    return $this;
  }

}
