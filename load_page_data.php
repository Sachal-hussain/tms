<?php
require_once("db_connect.php"); // Ensure database connection is available

if (isset($_POST['page_id'])) {
    $pageId = $conn->real_escape_string($_POST['page_id']);

    // Fetch all posts (images) including the created_at column
    $postsQuery = "SELECT file_name, created_at FROM tb_img WHERE page_id = '$pageId' AND (file_type = 'jpg' OR file_type = 'jpeg')";
    $postsResult = $conn->query($postsQuery);
    $postsCount = $postsResult->num_rows; // Get the count of posts

    // Fetch all stories (videos) including the created_at column
    $storiesQuery = "SELECT file_name, created_at FROM tb_img WHERE page_id = '$pageId' AND file_type = 'mp4'";
    $storiesResult = $conn->query($storiesQuery);
    $storiesCount = $storiesResult->num_rows; // Get the count of stories

    if ($postsCount > 0 || $storiesCount > 0) {
        if ($postsCount > 0) {
            echo "<h2>Posts: $postsCount</h2>";
            while ($row = $postsResult->fetch_assoc()) {
                // Display each post with a clickable link and its creation date
                echo "File Name: <a href='assets/uploads/" . htmlspecialchars($row['file_name']) . "' target='_blank'>" . htmlspecialchars($row['file_name']) . "</a>";
                echo " - Created At: " . htmlspecialchars($row['created_at']) . "<br>";
            }
        }

        if ($storiesCount > 0) {
            echo "<h2>Stories: $storiesCount</h2>";
            while ($row = $storiesResult->fetch_assoc()) {
                // Display each story with a clickable link and its creation date
                echo "File Name: <a href='assets/uploads/" . htmlspecialchars($row['file_name']) . "' target='_blank'>" . htmlspecialchars($row['file_name']) . "</a>";
                echo " - Created At: " . htmlspecialchars($row['created_at']) . "<br>";
            }
        }
    } else {
        echo "No entries found for the selected page.";
    }
} else {
    echo "Page ID not specified.";
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#mediaTable').DataTable({
            // DataTables options here
        });
    });
</script>

</head>
<body>

<!-- Your PHP script output here -->

</body>
</html>

