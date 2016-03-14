<?php

namespace GameOfLife;

use InvalidArgumentException;

/**
 * GameGrid - A grid containing a given state within the game.
 */
class GameGrid
{
  const CHAR_DEAD = ".";
  const CHAR_LIVE = "X";

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

    $this->grid = str_pad("", $width * $height, self::CHAR_DEAD);
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
   * @return string
   */
  public function getGrid()
  {
    return $this->grid;
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
   * Quick way to reset the grid.  Used for setting between animations.
   *
   * @param string $grid
   *
   * @return $this
   */
  public function setGrid($grid)
  {
    $this->grid = $grid;

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
   * Populate grid with passed points.
   *
   * @param array $points
   */
  public function populateGrid($points)
  {
    foreach ($points as $point) {
      $this->setPoint($point[0], $point[1], self::CHAR_LIVE);
    }
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
  public function validatePoint($row, $col)
  {
    if (
      $row < 0
      || $col < 0
      || $row > $this->height
      || $col > $this->width
    ) {
      throw new InvalidArgumentException(
        "Target Point Out of Bounds for Point: " . $row . ", " . $col .
        " Grid: " . $this->width . "x" . $this->height

      );
    }

    return true;
  }

  /**
   * Based on a given point, determine what it's new value should be based on it's current.
   *
   * @param int $row
   * @param int $col
   *
   * @return bool|string
   */
  public function determineNewPointState($row, $col)
  {
    $state     = false;
    $gridIndex = $this->pointToGridIndex($row, $col);

    // Check if a corner
    if (($corner = array_search($gridIndex, $this->corners)) > -1) {
      $state = $this->processCorner($corner, $row, $col);
    } elseif (array_search($gridIndex, $this->rowFirst) > -1) {
      $state = $this->processSide("top", $row, $col);
    } elseif (array_search($gridIndex, $this->rowLast) > -1) {
      $state = $this->processSide("bottom", $row, $col);
    } elseif (array_search($gridIndex, $this->colFirst) > -1) {
      $state = $this->processSide("left", $row, $col);
    } elseif (array_search($gridIndex, $this->colLast) > -1) {
      $state = $this->processSide("right", $row, $col);
    } else {
      $state = $this->processCenterPoint($row, $col);
    }

    return $state;
  }

  /**
   * Process a corner node.
   *
   * @param int $cornerIndex
   * @param $row
   * @param $col
   *
   * @return bool|string
   */
  private function processCorner($cornerIndex, $row, $col)
  {
    $points = [];

    switch ($cornerIndex) {
      // Top Left
      case 0:
        $points[] = [$row, $col + 1];
        $points[] = [$row + 1, $col];
        $points[] = [$row + 1, $col + 1];
        break;

      // Top Right
      case 1:
        $points[] = [$row, $col - 1];
        $points[] = [$row + 1, $col - 1];
        $points[] = [$row + 1, $col];
        break;

      // Bottom Left
      case 2:
        $points[] = [$row, $col + 1];
        $points[] = [$row - 1, $col];
        $points[] = [$row - 1, $col + 1];
        break;

      // Bottom Right
      case 3:
        $points[] = [$row, $col - 1];
        $points[] = [$row - 1, $col - 1];
        $points[] = [$row - 1, $col];
        break;
      default:
        return false;
    }

    return $this->processPoints($points);
  }

  /**
   * Process a side point.
   *
   * @param string $side
   * @param int    $row
   * @param int    $col
   *
   * @return bool|string
   */
  private function processSide($side, $row, $col)
  {
    $points = [];

    switch ($side) {
      case "top":
        $points[] = [$row, $col - 1];
        $points[] = [$row + 1, $col - 1];
        $points[] = [$row + 1, $col];
        $points[] = [$row + 1, $col + 1];
        $points[] = [$row, $col + 1];
        break;
      case "bottom":
        $points[] = [$row, $col - 1];
        $points[] = [$row - 1, $col - 1];
        $points[] = [$row - 1, $col];
        $points[] = [$row - 1, $col + 1];
        $points[] = [$row, $col + 1];
        break;
      case "left":
        $points[] = [$row + 1, $col];
        $points[] = [$row + 1, $col + 1];
        $points[] = [$row, $col + 1];
        $points[] = [$row - 1, $col + 1];
        $points[] = [$row - 1, $col];
        break;
      case "right":
        $points[] = [$row + 1, $col];
        $points[] = [$row + 1, $col - 1];
        $points[] = [$row, $col - 1];
        $points[] = [$row - 1, $col - 1];
        $points[] = [$row - 1, $col];
        break;
      default:
        return false;
    }

    return $this->processPoints($points);
  }

  /**
   * Process a point not a corner or side.
   *
   * @param int $row
   * @param int $col
   *
   * @return bool|string
   */
  private function processCenterPoint($row, $col)
  {
    $processPoints = [
      [$row + 1, $col + 1],
      [$row + 1, $col],
      [$row + 1, $col - 1],
      [$row, $col + 1],
      [$row, $col - 1],
      [$row - 1, $col + 1],
      [$row - 1, $col],
      [$row - 1, $col -1],
    ];

    return $this->processPoints($processPoints);
  }

  /**
   * Grab each of the needed points to determine new state.
   *
   * @param array $points
   *
   * @return bool|string
   */
  private function processPoints($points)
  {
    $aliveCount = 0;

    foreach ($points as $point) {
      $point = $this->getPoint($point[0], $point[1]);
      if (self::CHAR_LIVE === $point) {
        $aliveCount++;
      }
    }

    return $this->determineState($aliveCount);
  }

  /**
   * Based on how many 'live' nodes we have around the given, pass the new state.
   *
   * @param int $aliveCount
   *
   * @return bool|string
   */
  private function determineState($aliveCount)
  {
    switch ($aliveCount) {
      // Underpopulation
      case 0:
      case 1:
        return self::CHAR_DEAD;
        break;
      // Status Quo
      case 2:
        return false;
        break;
      // Reproduction
      case 3:
        return self::CHAR_LIVE;
        break;
      // Overpopulation
      default:
        return self::CHAR_DEAD;
        break;
    }
  }

}
