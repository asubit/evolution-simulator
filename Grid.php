<?php

class Grid {
  private $x;
  private $y;
  public $grid;

  public function __construct(int $x = 100, int $y = 100) {
    $this->x = $x;
    $this->y = $y;
  }

  public function build() : array {
    $grid = [];
    for ($x = 1; $x <= $this->x; $x++) {
      for ($y = 1; $y <= $this->y; $y++) { 
        $grid[$x][$y] = 0;
      }
    }
    $this->grid = $grid;
    return $grid;
  }

  public function appendFood(int $food = 1) : array {
    // Reset old food.
    $this->build();
    // Get grid structure.
    $grid = $this->getGrid();
    // Append a food in grid cell if no food already inside.
    for ($f = 0 ; $f < $food ; $f++) {
      $cell_x = rand(0, $this->x);
      $cell_y = rand(0, $this->y);
      while ($grid[$cell_x][$cell_y] !== 0) {
        $cell_x = rand(0, $this->x);
        $cell_y = rand(0, $this->y);
      }
      $grid[$cell_x][$cell_y] = 1;
    }
    // Save the grid.
    $this->setGrid($grid);
    return $grid;
  }

  public function setGrid(array $grid) {
    $this->grid = $grid;
  }

  public function getGrid() : array {
    return $this->grid;
  }

  public function getX() : int {
    return $this->x;
  }

  public function getY() : int {
    return $this->y;
  }
}
