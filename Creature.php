<?php

class Creature {
  public $id;
  public $hasEat = FALSE;
  public $age = 1;
  public $size;
  public $speed;
  public $range;
  public $age_of_death;
  public $energy;
  public $position = ['x' => 0, 'y' => 0];

  public function __construct($id, $size, $speed, $range, $energy) {
    $this->id = $id;
    $this->size = $size;
    $this->speed = $speed;
    $this->range = $range;
    $this->energy = $energy;
  }

  public function loseEnergy() {
    $range = $this->getRange();
    $size = $this->getSize();
    $speed = $this->getSpeed();
    $lost = $range + ($size * $size * $size) * ($speed * $speed);
    $this->setEnergy($this->getEnergy() - $lost);
  }

  public function move($grid) {
    $position = $this->position;
    $x = $this->position['x'];
    $y = $this->position['y'];
    // While the creature has energy and has not found food.
    while ($this->getEnergy() > 0 && $grid[$this->position['x']][$this->position['y']] !== 1) {
      // It moves until find food.
      $newPosition = $this->getNewPosition($this->position['x'], $this->position['y'], $grid);
      $this->setPosition($newPosition);
      // But it lose energy.
      $this->loseEnergy();
    }
  }

  public function getNewPosition($x, $y, $grid) {
    $directions = [
      0 => 'top',
      1 => 'right'
      2 => 'bottom',
      3 => 'left',
    ];
    // Can't go left.
    if ($x == 1) {
      unset($directions[3]);
    }
    // Can't go right.
    if ($x == $grid->x) {
      unset($directions[1]);
    }
    // Can't go bottom.
    if ($y == 1) {
      unset($directions[2]);
    }
    // Can't go top.
    if ($y == $grid->y) {
      unset($directions[0]);
    }
    $count = count($directions);
    $direction = $directions[rand(0, $count)];
    if ($direction == 'left') {
      return ['x' => $x-1, 'y' => $y]
    }
    if ($direction == 'right') {
      return ['x' => $x+1, 'y' => $y]
    }
    if ($direction == 'top') {
      return ['x' => $x, 'y' => $y+1]
    }
    if ($direction == 'bottom') {
      return ['x' => $x, 'y' => $y-1]
    }
  }

  public function survive() {
    if ($this->hasEat === FALSE) {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  public function getSpeed() : int {
    return $this->speed;
  }

  public function setSpeed(int $speed) {
    $this->speed = $speed;
  }

  public function getSize() : int {
    return $this->size;
  }

  public function setSize(int $size) {
    $this->size = $size;
  }

  public function getRange() : int {
    return $this->range;
  }

  public function setRange(int $range) {
    $this->range = $range;
  }

  public function getEnergy() : int {
    return $this->energy;
  }

  public function setEnergy(int $energy) {
    $this->energy = $energy;
  }

  public function hasEat() : bool {
    return $this->hasEat;
  }

  public function eat() {
    $this->hasEat = TRUE;
  }

  public function getPosition() : array {
    return $this->position;
  }

  public function setPosition(array $position) {
    $this->position = $position;
  }
}
