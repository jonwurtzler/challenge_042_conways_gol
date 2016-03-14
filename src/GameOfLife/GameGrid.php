<?php

namespace GameOfLife;

use InvalidArgumentException;

/**
 * GameGrid - A grid containing a given state within the game.
 */
class GameGrid
{
  /**
   * @var int
   */
  protected $height;

  /**
   * @var int
   */
  protected $width;

  /**
   * @var string
   */
  protected $grid;

  /**
   * @var array
   */
  protected $colFirst;

  /**
   * @var array
   */
  protected $colLast;

  /**
   * @var array
   */
  protected $corners;

  /**
   * @var array
   */
  protected $rowFirst;

  /**
   * @var array
   */
  protected $rowLast;

  /**
   * GameGrid constructor.
   *
   * @param int $width
   * @param int $height
   */
  public function __construct($width, $height)
  {
    $this->height = $height;
    $this->width  = $width;

    $this->grid = str_pad("", $width * $height, 0);
  }

  /**
   * @return array
   */
  public function getColFirst()
  {
    return $this->colFirst;
  }

  /**
   * @return array
   */
  public function getColLast()
  {
    return $this->colLast;
  }

  /**
   * @return array
   */
  public function getCorners()
  {
    return $this->corners;
  }

  /**
   * @return int
   */
  public function getHeight()
  {
    return $this->height;
  }

  /**
   * Return the value at a given point.
   *
   * @param int $row
   * @param int $col
   *
   * @return int
   */
  public function getPoint($row, $col)
  {
    $gridIndex = $this->pointToGridIndex($row, $col);

    return $this->grid[$gridIndex];
  }

  /**
   * @return array
   */
  public function getRowFirst()
  {
    return $this->rowFirst;
  }

  /**
   * @return array
   */
  public function getRowLast()
  {
    return $this->rowLast;
  }

  /**
   * @return int
   */
  public function getWidth()
  {
    return $this->width;
  }

  /**
   * @param array $colFirst
   *
   * @return $this
   */
  public function setColFirst($colFirst)
  {
    $this->colFirst = $colFirst;

    return $this;
  }

  /**
   * @param array $colLast
   *
   * @return $this
   */
  public function setColLast($colLast)
  {
    $this->colLast = $colLast;

    return $this;
  }

  /**
   * @param array $corners
   *
   * @return $this
   */
  public function setCorners($corners)
  {
    $this->corners = $corners;

    return $this;
  }

  /**
   * @param array $rowFirst
   *
   * @return $this
   */
  public function setRowFirst($rowFirst)
  {
    $this->rowFirst = $rowFirst;

    return $this;
  }

  /**
   * @param array $rowLast
   *
   * @return $this
   */
  public function setRowLast($rowLast)
  {
    $this->rowLast = $rowLast;

    return $this;
  }

  /**
   * Set the value at a given point.
   *
   * @param int $row
   * @param int $col
   * @param int $value
   *
   * @return $this
   */
  public function setPoint($row, $col, $value)
  {
    if (1 !== strlen($value)) {
      throw new InvalidArgumentException("Values can only be a single digit/letter/etc.  Larger will throw off array length of grid");
    }

    $gridIndex = $this->pointToGridIndex($row, $col);

    $this->grid[$gridIndex] = $value;

    return $this;
  }

  /**
   * We will pass points for a grid as normal row 1, col 2.
   *   Validate that we don't pass a point outside the bounds of our grid.
   *   Convert the point to an array position.
   *
   * @param int $row
   * @param int $col
   *
   * @return int
   */
  public function pointToGridIndex($row, $col)
  {
    // Make sure point is valid
    $this->validatePoint(--$row, --$col);

    return ($row * $this->width) + $col;
  }

  /**
   * Ensure that the point provided is within the range of the given grid.
   *
   * @param int $row
   * @param int $col
   *
   * @return bool
   * @throws InvalidArgumentException
   */
  private function validatePoint($row, $col)
  {
    if (
      $row < 0
      || $col < 0
      || $row > $this->height
      || $col > $this->width
    ) {
      throw new InvalidArgumentException("Target Point Out of Bounds for grid: " . $this->width . "x" . $this->height);
    }

    return true;
  }

}
