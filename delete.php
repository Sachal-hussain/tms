<?php
require_once("db_connect.php");

// Check if the file ID is provided
if (!isset($_GET['id'])) {
    echo "File ID is required.";
    exit;
}

$file_id = $_GET['id'];

// Fetch file details
$fileDetailsQuery = "SELECT * FROM tb_img WHERE id = '$file_id'";
$fileDetailsResult = mysqli_query($conn, $fileDetailsQuery);

if (!$fileDetailsResult || mysqli_num_rows($fileDetailsResult) == 0) {
    echo "File not found.";
    exit;
}

$fileDetails = mysqli_fetch_assoc($fileDetailsResult);

// Delete file from database and file system
$deleteQuery = "DELETE FROM tb_img WHERE id = '$file_id'";
if (mysqli_query($conn, $deleteQuery)) {
    // Delete file from file system
    $file_path = "assets/uploads/" . $fileDetails['file_name'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    // Redirect to the previous page with a success message
    header("Location: edit_image.php?task_id=" . $fileDetails['task_id'] . "&action=deleted");
    exit;
} else {
    echo "Failed to delete file.";
}
?>
