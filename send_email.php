<?php
// Include database connection and PHPMailer
include 'db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json');

// Get the current time
$currentTime = date('Y-m-d H:i:s');
$i = 0;

// Query to fetch task data where status is not 2 and not 4
$query = "
    SELECT t.*, 
           p.pagename, 
           CONCAT(COALESCE(a.firstname, u.firstname), ' ', COALESCE(a.lastname, '')) AS assigned_by,
           (SELECT GROUP_CONCAT(CONCAT(e.firstname, ' ', e.lastname, ' ', e.middlename) SEPARATOR ', ') 
            FROM employee_list e 
            WHERE FIND_IN_SET(e.id, t.employee_id) > 0) AS aggregated_names
    FROM task_list t 
    LEFT JOIN employee_list a ON t.assigned_by = a.id 
    LEFT JOIN users u ON t.assigned_by = u.id 
    LEFT JOIN pages p ON p.id = t.page_id
    WHERE t.status != 2 AND t.status != 4;
";


// Initialize the HTML table with inline CSS for borders
$htmlTable = '
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="border: 1px solid black;">#</th>
            <th style="border: 1px solid black;">Page Name</th>
            <th style="border: 1px solid black;">Task</th>
            <th style="border: 1px solid black;">Due Date</th>
            <th style="border: 1px solid black;">Assigned To (Department)</th>
            <th style="border: 1px solid black;">Assigned By</th>
            <th style="border: 1px solid black;">Created At</th>
            <th style="border: 1px solid black;">Status</th>
        </tr>
    </thead>
    <tbody>';

$response = [];

// Execute the query
$result = $conn->query($query);
if (!$result) {
    die('Error executing query: ' . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fetch and prepare page names
        $page_ids = explode(",", $row['page_id']);
        $page_info = [];

        foreach ($page_ids as $page_id) {
            $page_id = intval($page_id); // Ensure it's an integer
            if ($page_id <= 0) continue;

            // Query to get the page name
            $page_query = "SELECT pagename FROM pages WHERE id = $page_id";
            $page_result = $conn->query($page_query);

            if ($page_result && $page_result->num_rows > 0) {
                $page_row = $page_result->fetch_assoc();
                $page_info[] = '<a href="edit_image.php?task_id=' . $row['id'] . '" target="_blank">' . ucwords($page_row['pagename']) . '</a>';
            }
        }

        // Prepare the table row
        $htmlTable .= '
        <tr>
            <td style="border: 1px solid black; text-align: center;">' . ++$i . '</td>
            <td style="border: 1px solid black; text-align: center;">' . (empty($page_info) ? 'No pages available' : implode(', ', $page_info)) . '</td>
            <td style="border: 1px solid black;">' . $row['task'] . '</td>
            <td style="border: 1px solid black;">' . $row['due_date'] . '</td>
            <td style="border: 1px solid black;">';

        // Process assigned employees
        $employee_ids = explode(",", $row['employee_id']);
        $employee_info = [];

        foreach ($employee_ids as $employee_id) {
            $employee_id = intval($employee_id);
            if ($employee_id <= 0) continue;

            $emp_query = "SELECT el.firstname, dl.department FROM employee_list el
                          JOIN department_list dl ON el.department_id = dl.id
                          WHERE el.id = $employee_id";
            $emp_result = $conn->query($emp_query);

            if ($emp_result) {
                if ($employee_row = $emp_result->fetch_assoc()) {
                    $employee_info[] = $employee_row['firstname'] . ' (' . $employee_row['department'] . ')';
                }
            }
        }

        // Add employee info to the table
        $htmlTable .= implode(', ', $employee_info);
        $htmlTable .= '</td>
            <td style="border: 1px solid black;">' . $row['assigned_by'] . '</td>
            <td style="border: 1px solid black;">' . $row['date_created'] . '</td>
            <td style="border: 1px solid black;">' . getStatusName($row['status']) . '</td>
        </tr>';

        // Prepare the response array
        $response[] = [
            'id' => $row['id'],
            'page_id' => $row['page_id'],
            'task' => $row['task'],
            'due_date' => $row['due_date'],
            'employee_id' => $row['employee_id'],
            'assigned_by' => $row['assigned_by'],
            'date_created' => $row['date_created'],
            'status' => $row['status']
        ];
    }

    $htmlTable .= '</tbody></table>';
} else {
    $htmlTable .= '<tr><td colspan="8" style="border: 1px solid black; text-align: center;">No records found</td></tr></tbody></table>';
}

// Function to convert status codes to readable names
function getStatusName($status) {
    switch ($status) {
        case 0: return 'Pending';
        case 1: return 'On Progress';
        case 2: return 'Completed';
        case 3: return 'Approved';
        case 4: return 'Cancelled';
        default: return 'Unknown';
    }
}

// Send email if records are found
if ($result->num_rows > 0) {
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';

    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'mail.itschatters.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'webmaster@itschatters.com'; // Replace with your SMTP username
        $mail->Password = 'Webmaster@itschatter'; // Replace with your SMTP password
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';

        $mail->isHTML(true);
        $mail->setFrom('webmaster@itschatters.com', 'TMS');
        $mail->addAddress('aqibsafder2742@gmail.com');
        $mail->addCC('kiranshj786@gmail.com');

        $mail->Subject = 'Pending Tasks';
        $mail->Body = $htmlTable;

        if (!$mail->send()) {
            echo json_encode(['error' => 'Mail not sent: ' . $mail->ErrorInfo]);
        } else {
            echo json_encode(['success' => 'Email sent successfully.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Mail Error: ' . $mail->ErrorInfo]);
    }
}

// Close the connection
$conn->close();

// Send the JSON response
echo json_encode($response);
?>
