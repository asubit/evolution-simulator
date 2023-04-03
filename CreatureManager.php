<?php

require './Grid.php';
require './Creature.php';

class CreatureManager {

  public function createPopulation($population, $size, $speed, $range, $energy) : array {
    for ($id = 1; $id <= $population; $id++) { 
      $creatures[$id] = new Creature($id, $size, $speed, $range, $energy);
    }
    return $creatures;
  }

  public function runEvolution(Grid $grid, array $creatures) : array {
    // Futur generation.
    $survirors = [];
    // Get grid properties.
    $x = $grid->getX();
    $y = $grid->getY();
    foreach ($creatures as $id => $creature) {
      // Append creature in a grid cell.
      $creature->setPosition(['x' => rand(1, $x), 'y' => rand(1, $y)]);
      // Move creature.
      $creature->move($grid);
      // Check if creature survive.
      if ($creature->survive() === FALSE) {
        $survirors[$id] = $creature;
      }
    }
    return $survirors;
  }

  public function getAverage(string $property = 'size', array $creatures) : int {
    $count = count($creatures);
    $cumul = 0;
    foreach ($creatures as $id => $creature) {
      $cumul += $creature->$property;
    }
    return $cumul / $count;
  }
}
