<?php

include 'util/db_connect.php';

$place_id = 1;
$errorMessages = []; // Initialize an array to collect error messages
$successMessages = []; // Fixed missing semicolon here
$current_time = time(); // Get current timestamp outside the loop

if (isset($_FILES['images'])) {

    // Folder where images will be stored
    $target_dir = "uploads/";
    $uploadOk = 2;

    // Loop through all uploaded files
    foreach ($_FILES['images']['name'] as $key => $value) {
        // Define target file for each image
        $imageFileType = strtolower(pathinfo($_FILES["images"]["name"][$key], PATHINFO_EXTENSION)); // Get the file extension

        // Construct new filename
        $new_filename = $place_id . "_" . $current_time . "_" . $key . "." . $imageFileType; // New filename format
        $target_file = $target_dir . $new_filename; // Update target file path

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
                $status = $stmt->execute([$place_id, $filename, $target_file]);

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
            $errorMessages[] = "File " . htmlspecialchars(basename($_FILES["images"]["name"][$key])) . " has failed the upload operation."; // Fixed unclosed string
        }
    }
}

// Display result messages at the end
if (!empty($successMessages)) {
    foreach ($successMessages as $success) {
        echo "<li>" . $success . "</li>";
    }
}

if (!empty($errorMessages)) {
    foreach ($errorMessages as $error) {
        echo "<li>[Error]" . $error . "</li>";
    }
}
?>