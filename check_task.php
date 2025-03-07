<?php
// Database connection
include 'db_connect.php';

$id = intval($_POST['id']);

// Check if the task exists in the task_list table
$query = "SELECT COUNT(*) AS count FROM task_list WHERE daily_task = $id";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $response = array('exists' => $row['count'] > 0);
} else {
    $response = array('exists' => false);
}

echo json_encode($response);
?>
