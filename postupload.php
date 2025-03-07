<?php
require_once("db_connect.php");
date_default_timezone_set("Asia/Karachi");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['task_id']) && $_POST['task_id']!=''){
        // Handle file uploads
        $id = $_POST['task_id'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $folder = "assets/uploads/";
        $fileCount = count($_FILES['file']['name']);
        $uploadSuccess = true;
        $errors = [];
        $rand = uniqid();

        for ($i = 0; $i < $fileCount; $i++) {
            $file_name = $_FILES['file']['name'][$i];
            $file_tmp_name = $_FILES['file']['tmp_name'][$i];
            $path = $folder . $file_name;
            $filenamerand = $rand.basename($file_name);
            $target_file = $folder .$filenamerand ;
            $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Allow only specific file formats
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = 'Sorry, only JPG, JPEG, PNG, GIF, MP4, AVI, and MOV files are allowed.';
                continue;
            }

            // Check file size
            if ($_FILES["file"]["size"][$i] > 50000000) {
                $errors[] = 'Sorry, your file is too large.';
                continue;
            }

            if (!move_uploaded_file($file_tmp_name, $target_file)) {
                $errors[] = "Sorry, there was an error uploading your file: " . $file_name;
                $uploadSuccess = false;
            } else {
                $result = mysqli_query($conn, "INSERT INTO tb_img(task_id, file_name, file_type, created_at, updated_at) VALUES('$id', '$filenamerand', '$fileType', '$created_at', '$updated_at')");
                if (!$result) {
                    $uploadSuccess = false;
                }
            }
        }

        // Handle base64 encoded images
        if(isset($_POST['hdn_imagedata']) && !empty($_POST['hdn_imagedata'])) {
            $images = $_POST['hdn_imagedata'];
            $savedImages = saveRedeemimage($images, $id, $conn);

            if (!empty($savedImages)) {
                echo "<script>alert('Images uploaded successfully!'); window.location.href = './index.php?page=task_list';</script>";
            } else {
                echo "Error saving images.";
            }
        } elseif (!$uploadSuccess) {
            // Handle errors from file uploads
            echo "<script>alert('Error uploading images: " . implode(', ', $errors) . "');</script>";
        }
    }
}

function saveRedeemimage($redeem_images, $task_id, $conn) {
    $images = explode('|', $redeem_images);
    $savedImages = [];

    foreach ($images as $encodedImage) {
        $encodedImage = trim($encodedImage);
        if (!empty($encodedImage)) {
            $result = saveImage($encodedImage, $task_id, $conn);
            if ($result) {
                $savedImages[] = $result;
            } else {
                echo "Failed to save an image.<br>";
            }
        }
    }
    return $savedImages;
}

function saveImage($encodedImage, $task_id, $conn) {
    // Extract base64 data and image type
    $image_parts = explode(";base64,", $encodedImage);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];

    // Convert base64 data to binary
    $imagedata = base64_decode($image_parts[1]);

    // Generate a unique file name
    $filename = uniqid() . '.' . $image_type;

    // Specify the folder to save the images
    $folder = 'assets/uploads/'; // Change to your desired folder path
    $destination = $folder . $filename;

    // Save the image to the folder
    if (file_put_contents($destination, $imagedata) !== false) {
        // Insert the image data into the database
        $created_at = date("Y-m-d H:i:s"); // Current timestamp
        $updated_at = date("Y-m-d H:i:s"); // Current timestamp

        $result = mysqli_query($conn, "INSERT INTO tb_img(task_id, file_name, file_type, created_at, updated_at) VALUES('$task_id', '$filename', '$image_type', '$created_at', '$updated_at')");

        if ($result) {
            return $filename;
        } else {
            echo "Error inserting image data into database: " . mysqli_error($conn);
            return false;
        }
    } else {
        echo "Error: Failed to save the image.<br>";
        return false;
    }
}
?>
