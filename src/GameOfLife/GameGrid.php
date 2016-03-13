<?php

namespace GameOfLife;

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
   * @param int $row
   * @param int $col
   *
   * @return $this
   */
  public function setPoint($row, $col)
  {


    return $this;
  }

}
