
<?php

// Connect to the database
include 'util/db_connect.php';
$place_id = $_POST['place_id'];

// Retrieve images from database
$sql_img = "SELECT * FROM place_image_table WHERE place_id = :place_id";
$stmt_img = $pdo->prepare($sql_img);
$stmt_img->bindParam(':place_id', $place_id, PDO::PARAM_INT); // Bind the place_id parameter
$status_img = $stmt_img->execute();

if($status_img==false) {
    $error = $stmt_img->errorInfo();
    exit("SQL_SELECT_ERROR:".$error[2]);
}
$values_img = $stmt_img->fetchAll(PDO::FETCH_ASSOC);
?>


<ul>
<div class="comment-card">

  <!-- The image -->
  <div class="slideshow-container">
    <?php foreach ($values_img as $index => $value_img): ?>
      <div class="mySlides fade">
        <img src="<?= $value_img['filepath'] ?>" alt="<?= $value_img['filename'] ?>" class="fixed-size-image">
      </div>
    <?php endforeach; ?>
  </div>

  <!-- The dots -->
  <div style="text-align:center">
    <?php foreach ($values_img as $index => $value_img): ?>
      <span class="dot" onclick="currentSlide(<?= $index + 1 ?>)"></span>
    <?php endforeach; ?>
  </div>




<?php

// Read Place Info from database
$sql = "SELECT * FROM place_table WHERE id = $place_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if($status==false) {
  $error = $stmt->errorInfo();
  exit("SQL_SELECT_ERROR:".$error[2]);
}

$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); 


if (!empty($values)): 
  $value = $values[0]; // Get the first data point
  $photo = $value["loc-photo"];
  $address = $value["address"];
  $description = $value["description"];
  $lat = $value["lat"];
  $lon = $value["lon"];
?>

  
  <div class="userblock">
      <!-- icon -->
      <img src="<?php echo $photo; ?>" class="w-20 h-auto object-cover border-2 border-transparent rounded-full">
      
      <!-- address -->
      <p class="location-name"><?php echo $address; ?></p>
  </div>

  <!-- Description -->
  <p class="comment-content">
      <?php echo $description; ?>
  </p>
  <p class="location-detail">Coordinate: <?php echo $lat; ?>, <?php echo $lon; ?></p><br>
<?php endif; ?>


</ul>
