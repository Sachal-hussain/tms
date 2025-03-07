<?php
// Include database connection
include "db_connect.php";

$output = '';
$status = '';
$i = 0;

date_default_timezone_set('Asia/Karachi');

// Check if the form data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $page_id = $_POST['page_id'];
    $department_id = $_POST['department_id'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    // Construct the SQL query to fetch filtered tasks
  $sql = "SELECT t.*, 
    CONCAT(e.firstname) AS name, 
    p.pagename, 
    d.department,
    CASE 
        WHEN t.assigned_by IN (SELECT id FROM users) THEN CONCAT(admin.firstname)
        WHEN t.assigned_by IN (SELECT id FROM employee_list) THEN (SELECT CONCAT(emp.firstname) FROM employee_list emp WHERE emp.id = t.assigned_by)
    END AS assigned_by_name, 
    COUNT(CASE WHEN i.file_type IN ('jpg', 'jpeg') THEN 1 END) AS post_count,
    COUNT(CASE WHEN i.file_type = 'mp4' THEN 1 END) AS story_count
    FROM task_list t 
    LEFT JOIN employee_list e ON e.id = t.employee_id 
    LEFT JOIN pages p ON p.id = t.page_id 
    LEFT JOIN department_list d ON d.id = e.department_id 
    LEFT JOIN tb_img i ON i.task_id = t.id
    LEFT JOIN users admin ON admin.id = t.assigned_by
    WHERE 1";





// Add conditions based on selected employee and department
if (!empty($page_id)) {
        $sql .= " AND t.page_id = $page_id";
    }
    if (!empty($department_id)) {
        $sql .= " AND e.department_id = $department_id";
    }


// Add conditions based on selected date range
if (!empty($date_from) && !empty($date_to)) {
    $sql .= " AND DATE(t.date_created) BETWEEN '$date_from' AND '$date_to'";
}

// Group by task columns to get counts per task
$sql .= " GROUP BY t.id";


    // Execute the query
    $result = $conn->query($sql);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Start building the output HTML
        $output .= '<tr>';

        // Loop through the rows and display task data
        while ($row = $result->fetch_assoc()) {
            $i++;
            $id = $i;
            $pagename = $row['pagename'];
            $takt = $row['task'];
            $dateCreated = date('F j, Y g:i A', strtotime($row['date_created']));
            $assigned_to = $row['name'];
            $assigned_by = $row['assigned_by_name'];
            
            // Check task status and set corresponding badge
            if ($row['status'] == 0) {
                $status = "<span class='badge badge-info'>Pending</span>";
            } elseif ($row['status'] == 1) {
                $status = "<span class='badge badge-primary'>On-Progress</span>";
            } elseif ($row['status'] == 2) {
                $status = "<span class='badge badge-success'>Complete</span>";
            }
            
            // Check if task is overdue and add Over Due badge
            $overdue = '';
            $currentDateTime = time(); // Current timestamp
            $dueDateTime = strtotime($row['due_date']); // Due date timestamp

            // Calculate 24 hours after the due date
            $dueDateTimePlus24Hours = $dueDateTime + (24 * 60 * 60);

            if ($currentDateTime > $dueDateTime && $row['status'] != 2) {
                $overdue = "<span class='badge badge-danger mx-1'>Over Due</span>";
            }


            // Build the output HTML for this row
            $output .= '<td>' . $id . '</td>';
            $output .= '<td>';
            if ($department_id == '8' || $department_id == '6') {
                $output .= '<a href="edit_image.php?task_id=' . $row['id'] . '" target="_blank">' . $pagename . '</a>';
            } else {
                $output .= $pagename;
            }
            $output .= '</td>';
            $output .= '<td>' . $takt . '</td>';
            $output .= '<td>' . $dateCreated . '</td>';
            $output .= '<td>' . $assigned_to . '</td>';
            $output .= '<td>' . $assigned_by . '</td>';
            $output .= '<td>' . $status . ' ' . $overdue . '</td>';
            if ($department_id == '8' || $department_id == '6') {
                $output .= '<td>' . $row['post_count'] . '</td>';
                $output .= '<td>' . $row['story_count'] . '</td>';
            }
            $output .= '</tr>';
        }
        
        // Output the generated HTML
        echo $output;
    } else {
        // No tasks found with the given filters
        echo "<tr><td colspan='8' class='text-center'>No tasks found.</td></tr>";
    }
} else {
    // If the request method is not POST, return an error
    echo "Error: Invalid request method.";
}
?>
