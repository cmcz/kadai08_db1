<?php

include 'util/db_connect.php';

$sql = "SELECT * FROM place_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if($status==false) {
  $error = $stmt->errorInfo();
  exit("SQL_SELECT_ERROR:".$error[2]);
}

$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); 

foreach($values as $value){

    $location_name = $value["loc-name"];
    $place_id = $value["id"];
    $h = '';
    $h .= '<div>';
    $h .= '<li class="topic-item cursor-pointer" place_id="' . $place_id . '" currTopic="' . $location_name . '">';
    $h .= $location_name;
    $h .= '</li>';
    $h .= '</div>';
    echo $h;
  }
?>



