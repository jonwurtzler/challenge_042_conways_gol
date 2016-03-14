<?php

use GameOfLife\GameGrid;
use GameOfLife\GameGridFactory;

/**
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 */
class GameOfLifeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var GameGridFactory
     */
    protected $gridFactory;

    /**
     * @var GameGrid
     */
    protected $grid100x100;

    /**
     * @var GameGrid
     */
    protected $grid100x50;

    /**
     * @var GameGrid
     */
    protected $grid50x100;

    public function setUp()
    {
        $this->gridFactory = new GameGridFactory();
        $this->grid100x100 = $this->gridFactory->makeGrid(100, 100);
        $this->grid100x50  = $this->gridFactory->makeGrid(100, 50);
        $this->grid50x100  = $this->gridFactory->makeGrid(50, 100);
    }

    public function tearDown()
    {
        $this->gridFactory = null;
        $this->grid100x100 = null;
        $this->grid100x50  = null;
        $this->grid50x100  = null;
    }

    public function testPointSetGet()
    {
      $this->grid100x100->setPoint(1, 20, 1);
      $this->assertEquals(1, $this->grid100x100->getPoint(1, 20));
    }

    /** ---------------------------------------------------------------
     * Square Grid - 100 x 100 grid
     * ------------------------------------------------------------- */

    public function testSquareOriginPoint()
    {
        $point = $this->grid100x100->pointToGridIndex(1, 1);
        $this->assertEquals(0, $point);
    }

    public function testSquareCenterPoint()
    {
        $point = $this->grid100x100->pointToGridIndex(50, 50);
        $this->assertEquals(4949, $point);
    }

    public function testSquareFinalPoint()
    {
        $point = $this->grid100x100->pointToGridIndex(100, 100);
        $this->assertEquals(9999, $point);
    }

    /** ---------------------------------------------------------------
     * Wide Grid - 100 x 50 grid
     * ------------------------------------------------------------- */

    public function testWideOriginPoint()
    {
        $point = $this->grid100x50->pointToGridIndex(1, 1);
        $this->assertEquals(0, $point);
    }

    public function testWideCenterPoint()
    {
        $point = $this->grid100x50->pointToGridIndex(25, 50);
        $this->assertEquals(2449, $point);
    }

    public function testWideFinalPoint()
    {
        $point = $this->grid100x50->pointToGridIndex(50, 100);
        $this->assertEquals(4999, $point);
    }

    /** ---------------------------------------------------------------
     * Tall Grid - 50 x 100 grid
     * ------------------------------------------------------------- */

    public function testTallOriginPoint()
    {
      $point = $this->grid50x100->pointToGridIndex(1, 1);
      $this->assertEquals(0, $point);
    }

    public function testTallCenterPoint()
    {
      $point = $this->grid50x100->pointToGridIndex(50, 25);
      $this->assertEquals(2474, $point);
    }

    public function testTallFinalPoint()
    {
      $point = $this->grid50x100->pointToGridIndex(100, 50);
      $this->assertEquals(4999, $point);
    }

    /** ---------------------------------------------------------------
     * Testing Known reasons to throw Exceptions
     * -------------------------------------------------------------
     */

    /**
     * @expectedException Exception
     */
    public function testLargerValueSet()
    {
      $this->grid100x100->setPoint(2, 2, 10);
    }

    /**
     * @expectedException Exception
     */
    public function testSmallerValueSet()
    {
      $this->grid100x100->setPoint(2, 2, "");
    }

    /**
     * @expectedException Exception
     */
    public function testOutOfBoundsNegativeRow()
    {
        $this->grid100x100->getPoint(-2, 2);
    }

    /**
     * @expectedException Exception
     */
    public function testOutOfBoundsNegativeCol()
    {
        $this->grid100x100->getPoint(2, -2);
    }

    /**
     * @expectedException Exception
     */
    public function testOutOfBoundsGreaterRow()
    {
        $this->grid100x100->getPoint(2000, 2);
    }

    /**
     * @expectedException Exception
     */
    public function testOutOfBoundsGreaterCol()
    {
        $this->grid100x100->getPoint(2, 2000);
    }

}
