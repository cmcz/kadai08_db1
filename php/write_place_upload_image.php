<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'util/db_connect.php';

// Handle place data submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["location-name"])) {
    // 1. POSTデータ取得
    $loc_name = $_POST["location-name"];
    $address = $_POST["address"];
    $lat = $_POST["lat"]; 
    $lon = $_POST["lon"]; 
    $description = $_POST["description"];
    $loc_photo = $_POST["new-user-icon"]; 
    $website = $_POST["website"]; 
    $category = $_POST["category"];

    // 2. データ登録SQL作成
    $sql = "INSERT INTO place_table(`loc-name`, `address`, `lat`, `lon`, `description`, `loc-photo`, `website`, `category`) VALUES (:loc_name, :address, :lat, :lon, :description, :loc_photo, :website, :category);";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':loc_name', $loc_name, PDO::PARAM_STR);  
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);  
    $stmt->bindValue(':lat', $lat, PDO::PARAM_STR);  
    $stmt->bindValue(':lon', $lon, PDO::PARAM_STR);  
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);  
    $stmt->bindValue(':loc_photo', $loc_photo, PDO::PARAM_STR); 
    $stmt->bindValue(':website', $website, PDO::PARAM_STR); 
    $stmt->bindValue(':category', $category, PDO::PARAM_STR); 

    $status = $stmt->execute(); // true or false

    // 3. データ登録処理後
    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("SQL_INSERT_ERROR:".$error[2]);
    } else {
        $place_id = $pdo->lastInsertId(); // Get the last inserted ID
        $errorMessages = []; // Initialize an array to collect error messages
        $successMessages = []; // Initialize an array to collect success messages
        $current_time = time(); // Get current timestamp

        // Handle image uploads
        if (isset($_FILES['images'])) {
            var_dump($_FILES['images']);
            $target_dir = __DIR__ . "/../uploads/";
            $save_dir = "uploads/";

            foreach ($_FILES['images']['name'] as $key => $value) {

                $imageFileType = strtolower(pathinfo($_FILES["images"]["name"][$key], PATHINFO_EXTENSION));
                $new_filename = $place_id . "_" . $current_time . "_" . $key . "." . $imageFileType;
                $target_file = $target_dir . $new_filename;
                $save_file = $save_dir . $new_filename;

                // Check for upload errors
                if ($_FILES["images"]["error"][$key] !== UPLOAD_ERR_OK) {

                    $message = '';
                    switch ($_FILES["images"]["error"][$key]) {
                        case UPLOAD_ERR_INI_SIZE:
                            $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $message = "The uploaded file was only partially uploaded";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $message = "No file was uploaded";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $message = "Missing a temporary folder";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $message = "Failed to write file to disk";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $message = "File upload stopped by extension";
                            break;
                        default:
                            $message = "Unknown upload error";
                            break;
                    }
                    $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " cannot be uploaded: " . $message; // Collect error message
                    continue; // Skip to the next file
                }

                // Skip empty files
                if (empty($_FILES['images']['name'][$key]) || $_FILES['images']['size'][$key] === 0) {
                    $errorMessages[] = "[Warning]File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " is empty.";
                    continue; // Skip to the next file
                }

                // Check if the file is an actual image
                $check = getimagesize($_FILES["images"]["tmp_name"][$key]);
                if ($check == false) {
                    $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " is not an image: " . $check["mime"];
                    continue;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " already exists.";
                    continue;
                }

                // Allow certain file formats (JPEG, PNG, GIF)
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " 's format is not supported (JPG, JPEG, PNG & GIF).";
                    continue;
                }

                // Check file size (e.g., limit to 20MB)
                if ($_FILES["images"]["size"][$key] > 20000000) {
                    $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " is too large.";
                    continue;
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
                    $successMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " has been uploaded.";

                    // Insert the file path and name into the database
                    $filename = basename($_FILES["images"]["name"][$key]);
                    $sql = "INSERT INTO place_image_table (place_id, filename, filepath) VALUES (?, ?, ?)";
                    $stmt = $pdo->prepare($sql);

                    if ($stmt) {
                        $status = $stmt->execute([$place_id, $filename, $save_file]);

                        if ($status) {
                            $successMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . "'s path is saved to the database.";
                        } else {
                            $error = $stmt->errorInfo();
                            $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " - SQL_INSERT_ERROR: " . $error[2];
                        }
                    } else {
                        $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " - SQL_PREPARE_ERROR: " . htmlspecialchars($pdo->errorInfo()[2]);
                    }
                } else {
                    $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " has failed the upload operation.";
                }
            }
        }

        // Display result messages at the end
        if (!empty($successMessages)) {
            echo "<script>console.log('" . implode("\\n", $successMessages) . "');</script>";
        }

        if (!empty($errorMessages)) {
            echo "<script>console.log('" . implode("\\n", $errorMessages) . "');</script>";
        }

        // Redirect to index.php after processing
        echo "<script>
            window.location.href = '../index.php';
            location.reload();
        </script>";
        exit();


    }
}
?>