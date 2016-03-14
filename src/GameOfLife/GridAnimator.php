<?php

namespace GameOfLife;

class GridAnimator
{
  /**
   * @var string
   */
  protected $configName = "";

  /**
   * @var int
   */
  protected $currentGrid = 0;

  /**
   * @var array
   */
  protected $grids;

  /**
   * @var GameGrid
   */
  protected $grid1;

  /**
   * @var GameGrid
   */
  protected $grid2;

  /**
   * @var array
   */
  protected $startingGrids;

  /**
   * GridAnimator constructor.
   *
   * @param int $preset
   */
  public function __construct($preset = 0)
  {
    // Load our preset grids
    $this->loadPresets();
    $grid = $this->startingGrids[$preset];
    $this->configName = $grid->name;

    // Create factory
    $gridFactory = new GameGridFactory();

    // Create grids to use
    $this->grid1 = $gridFactory->makeGrid($grid->width, $grid->height);
    $this->grid2 = $gridFactory->makeGrid($grid->width, $grid->height);

    // Populate initial grids with starting configuration
    $this->grid1->populateGrid($grid->starting_points);
    $this->grid2->setGrid($this->grid1->getGrid());

    // Setup grids array
    $this->grids[] = $this->grid1;
    $this->grids[] = $this->grid2;

    // Display first grid.
    $this->displayGrid($this->grid1);
  }

  /**
   * Animate next state from the given grids.
   */
  public function animate()
  {
    $grids        = $this->getCurrentGridOrder();
    /** @var GameGrid $startingGrid */
    $startingGrid = $grids[0];
    /** @var GameGrid $targetGrid */
    $targetGrid   = $grids[1];

    $width  = $startingGrid->getWidth();
    $height = $startingGrid->getHeight();

    // Run through each point and pass the value to the target grid.
    for ($row = 1; $row <= $height; $row++) {
      for ($col = 1; $col <= $width; $col++) {
        $newPointValue = $startingGrid->determineNewPointState($row, $col);
        if ($newPointValue) {
          $targetGrid->setPoint($row, $col, $newPointValue);
        }
      }
    }

    // Display next state
    $this->displayGrid($targetGrid);

    // Make sure to set the starting grid to the new grid as well.
    $startingGrid->setGrid($targetGrid->getGrid());
  }

  /**
   * Load the preset grids from JSON file.
   */
  private function loadPresets()
  {
    $jsonGrids = file_get_contents("src/data/grids.json");
    $this->startingGrids = json_decode($jsonGrids);
  }

  /**
   * Get the order the grids should be in.
   *
   * @return array
   */
  private function getCurrentGridOrder()
  {
    if (0 === $this->currentGrid) {
      $this->currentGrid = 1;

      return [$this->grids[0], $this->grids[1]];
    } else {
      $this->currentGrid = 0;

      return [$this->grids[1], $this->grids[0]];
    }
  }

  /**
   * @param GameGrid $gameGrid
   *
   * @return void
   */
  private function displayGrid($gameGrid)
  {
    $grid = $gameGrid->getGrid();
    system("clear");
    echo $this->configName . "\n";
    echo chunk_split($grid, $gameGrid->getWidth(), "\n");
    echo "\n\n";
    //echo "\033[H";
    usleep(50000);
  }

}
