<?php //functions and such
session_start();
require_once "pdo.php";
global $tryarray;


class check {

  function flash_messages() {
    if ( isset($_SESSION['error']) ) {
      echo "<p style=color:red>" . htmlentities($_SESSION['error']) . "</p>\n";
      unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
      echo "<p style=color:green>" . htmlentities($_SESSION['success']) . "</p>\n";
      unset($_SESSION['success']);
    }

  }

  function cancel() {
    if ( isset($_POST['cancel']) ) {
      header("Location: index.php");
      exit;
    }
  }

  function not_logged_in() {
    if ( ! isset($_SESSION['user_id']) ) {
      die("ACCESS DENIED");
    }
  }
}

class movements {

  function view_db_call($table) {
    global $pdo;
    global $table_data;
    $table_data = array();
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE workout_id = :wid");
    $stmt->execute(array(':wid' => htmlentities($_GET['workout_id'])));
    while ( $util_row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      array_push($table_data, $util_row);
    }
    return $table_data;
  }
// sorry for the big mess here Future Pat
  function build_table($movement, $sets, $reps) {
      echo "<tr><td>&nbsp";
      echo $movement;
      echo "</td><td>&nbsp";
      echo $sets; 
      echo "</td><td>&nbsp";
      echo $reps;
      echo "</td></tr>";
    //print_r($tryarray);
    //echo $tryarray[0]['sets'];
  }

  function view_labels($label1, $label2, $label3) {
    //echo "<p>--<b>$label1</b>: " . $movement . " --<b>$label2</b>: " . $sets . " --<b>$label3</b>: " . $reps . "</p>";
    echo "<table border='1'>";
    echo "<tr><td>";
    echo "<b>$label1 &nbsp</b>";
    echo "</td><td>";
    echo "<b>$label2 &nbsp</b>";
    echo "</td><td>";
    echo "<b>$label3 &nbsp</b>";
    echo "</td></tr>";
  }
}
?>
