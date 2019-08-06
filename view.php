<?php
require_once "pdo.php";
include "util.php";

$check = new check;
$move = new movements;

$check->not_logged_in();

$sql = "SELECT * FROM Workouts JOIN Style ON
Workouts.style_id=Style.style_id LEFT JOIN Location ON
Workouts.location_id=Location.location_id WHERE workout_id = :wid";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':wid' => htmlentities($_GET['workout_id'])));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$date = $row['date'];
$loc = $row['name'];
$style = $row['style_name'];

?><!DOCTYPE html>
<html>
  <head><title>View a Workout</title>
    <?php include "head.php"; ?>
  </head>
  <body>
    <h1>Workout for <?= $date; ?></h1>
    <p><b>Location</b>: <?= $loc; ?></p>
    <p><b>Style</b>: <?= $style; ?></p>
    <?php
     global $pdo;
     global $table_data;
     if ( $row['strength_id'] ) {
       $move->view_labels('Movement', 'Sets', 'Reps');
       $move->view_db_call('Strength');
       for ($i=0; $i<count($table_data); $i++) {
         $td = $table_data[$i]; // for brevity
         $move->build_table($td['strength_movement'], $td['sets'], $td['reps']);
       }
     }
      else if ( $row['cardio_id'] ) {
        $move->view_labels('Movement', 'Minutes', 'Intensity');
        $move->view_db_call('Cardio');
        for ($i=0; $i<count($table_data); $i++) {
          $td = $table_data[$i];
          $move->build_table($td['cardio_movement'], $td['minutes'], $td['intensity']);
        }
      }
      else if ( $row['sports_id'] ) {
        $move->view_labels('Sport', 'Minutes', ' ');
        $move->view_db_call('Sports');
        for ($i=0; $i<count($table_data); $i++) {
          $td = $table_data[$i];
          $move->build_table($td['sport'], $td['minutes'], '');
        }
      }
    echo "</table>";
    ?>
    <!-- Notes section eventually -->
    <p><a style='text-decoration:none' href='form.php?workout_id=--workout_id--'>Edit </a>
    /<a style='text-decoration:none' href='index.php'> Done</a></p>
  </body>
</html>
