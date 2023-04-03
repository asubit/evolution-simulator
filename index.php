<?php

require './Grid.php';
require './Creature.php';
require './CreatureManager.php';

/*
 * Parameters.
 */
$p = $_POST['parameters'];
// Environment.
$days = $p['days'] ?? 50;
$food = $p['food'] ?? 50;
$grid_x = $p['grid_x'] ?? 100;
$grid_y = $p['grid_y'] ?? 100;
// Creature.
$population = $p['population'] ?? 20;
$energy = $p['energy'] ?? 500;
$range = $p['range'] ?? 20;
$speed = $p['speed'] ?? 10;
$size = $p['size'] ?? 10;
// Mutation.
$trait_speed = $p['trait_speed'] ?? 0.5;
$trait_size = $p['trait_size'] ?? 0.5;
$trait_range = $p['trait_range'] ?? 0.5;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Evolution simulator</title>
  </head>
  <body>
    <div class="container">
      <h1>Evolution simulator</h1>
      <h2>Settings</h2>
      <form action="" method="post">
        <h3>Environement</h3>
        <div class="row mb-3">
          <label for="inputDays" class="col-sm-2 col-form-label">Days</label>
          <div class="col-sm-10">
            <input value="<?php echo $days; ?>"
              name="days"
              type="number"
              class="form-control"
              id="inputDays">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputFood" class="col-sm-2 col-form-label">Food</label>
          <div class="col-sm-10">
            <input value="<?php echo $food; ?>"
              name="food"
              type="number"
              class="form-control"
              id="inputFood">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputFood" class="col-sm-2 col-form-label">Grid size X</label>
          <div class="col-sm-10">
            <input value="<?php echo $grid_x; ?>"
              name="grid_x"
              type="number"
              class="form-control"
              id="inputFood">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputFood" class="col-sm-2 col-form-label">Grid size Y</label>
          <div class="col-sm-10">
            <input value="<?php echo $grid_y; ?>"
              name="grid_y"
              type="number"
              class="form-control"
              id="inputFood">
          </div>
        </div>
        <h3>Creature</h3>
        <div class="row mb-3">
          <label for="inputPopulation" class="col-sm-2 col-form-label">Population</label>
          <div class="col-sm-10">
            <input value="<?php echo $population; ?>"
              name="population"
              type="number"
              class="form-control"
              id="inputPopulation">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputEnergy" class="col-sm-2 col-form-label">Energy</label>
          <div class="col-sm-10">
            <input value="<?php echo $energy; ?>"
              name="energy"
              type="number"
              class="form-control"
              id="inputEnergy">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputSpeed" class="col-sm-2 col-form-label">Speed</label>
          <div class="col-sm-10">
            <input value="<?php echo $speed; ?>"
              name="speed"
              type="number"
              class="form-control"
              id="inputSpeed">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputSize" class="col-sm-2 col-form-label">Size</label>
          <div class="col-sm-10">
            <input value="<?php echo $size; ?>"
              name="size"
              type="number"
              class="form-control"
              id="inputSize">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputRange" class="col-sm-2 col-form-label">Range</label>
          <div class="col-sm-10">
            <input value="<?php echo $range; ?>"
              name="range"
              type="number"
              class="form-control"
              id="inputRange">
          </div>
        </div>
        <h3>Evolution</h3>
        <div class="row mb-3">
          <label for="inputTraitSpeed" class="col-sm-2 col-form-label">σ² Speed</label>
          <div class="col-sm-10">
            <input value="<?php echo $trait_speed; ?>"
              name="trait_speed"
              type="number"
              class="form-control"
              id="inputTraitSpeed">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputTraitSize" class="col-sm-2 col-form-label">σ² Size</label>
          <div class="col-sm-10">
            <input value="<?php echo $trait_size; ?>"
              name="trait_size"
              type="number"
              class="form-control"
              id="inputTraitSize">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputTraitRange" class="col-sm-2 col-form-label">σ² Range</label>
          <div class="col-sm-10">
            <input value="<?php echo $trait_range; ?>"
              name="trait_range"
              type="number"
              class="form-control"
              id="inputTraitRange">
          </div>
        </div>
      </form>
      

<?php

// ======================
// Build the environment.
// ======================
$grid = new Grid($grid_x, $grid_y);
$grid->build();

// ====================
// Build the creatures.
// ====================
$creatureManager = new CreatureManager();
$creatures = $creatureManager->createPopulation($population, $size, $speed, $range, $energy);

// ==============
// Run evolution.
// ==============
$generations = [];
for ($day = 1; $day < $days; $day++) { 
  $generations[$day] = [
    'day' => $day,
    'creatures' => count($creatures),
    'size' => $creatureManager->getAverage('size', $creatures),
    'speed' => $creatureManager->getAverage('speed', $creatures),
    'range' => $creatureManager->getAverage('range', $creatures),
  ];
  $grid->appendFood($food);
  $creatures = $creatureManager->runEvolution($grid, $creatures);
}

?>
      <h2>Report</h2>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Day</th>
            <th>Creature alive</th>
            <th>Average size</th>
            <th>Average speed</th>
            <th>Average range</th>
        </thead>
      </table>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </div>
  </body>
</html>
