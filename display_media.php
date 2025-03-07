<?php
// display_media.php

// Get file_name and file_type from query parameters
$file_name = isset($_GET['file_name']) ? $_GET['file_name'] : '';
$file_type = isset($_GET['file_type']) ? $_GET['file_type'] : '';

// Sanitize the file_name to prevent directory traversal attacks
$file_name = basename($file_name);

// Define the base path to the media files
$base_path = 'assets/uploads/';

// Full path to the file
$file_path = $base_path . $file_name;

// Display the media based on file type
if (in_array($file_type, ['jpg', 'jpeg'])) {
    // Display image
    echo '<img src="' . htmlspecialchars($file_path) . '" alt="Image" style="max-width:100%;">';
} elseif ($file_type === 'mp4') {
    // Display video
    echo '<video width="100%" height="auto" controls>
            <source src="' . htmlspecialchars($file_path) . '" type="video/mp4">
            Your browser does not support the video tag.
          </video>';
} else {
    echo "Invalid file type.";
}
?>
