<?php
date_default_timezone_set("Asia/Karachi");
session_start();

ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;


Class Action {

    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

  function login() {
    extract($_POST);
    $type = array("employee_list", "evaluator_list", "users");
    
    // Query to check credentials and account status
    $qry = $this->db->query("SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM {$type[$login]} WHERE email = '".$email."' AND password = '".md5($password)."' ");

    if ($qry->num_rows > 0) {
        // Fetch user data and store it in session
        foreach ($qry->fetch_array() as $key => $value) {
            if ($key != 'password' && !is_numeric($key)) {
                $_SESSION['login_'.$key] = $value;
            }
        }
        
        $_SESSION['login_type'] = $login;

        // Update online status based on login type
        if ($login == 0) { // Assuming 0 is Employee
            $update_status_query = "UPDATE employee_list SET online = 'active' WHERE email = '".$email."'";
        } elseif ($login == 2) { // Assuming 2 is User
            $update_status_query = "UPDATE users SET online = 'active' WHERE email = '".$email."'";
        }
        
        $this->db->query($update_status_query);

        return 1; // Login successful
    } else {
        return 3; // Account is deactivated or login failed
    }
}

function logout() {
    if (isset($_SESSION['login_type']) && isset($_SESSION['login_email'])) {
        $loginType = $_SESSION['login_type'];
        $email = $_SESSION['login_email'];

        // Update online status based on login type
        if ($loginType == 0) { // Assuming 0 is Employee
            $update_status_query = "UPDATE employee_list SET online = 'inactive' WHERE email = '".$email."'";
        } elseif ($loginType == 2) { // Assuming 2 is User
            $update_status_query = "UPDATE users SET online = 'inactive' WHERE email = '".$email."'";
        }

        $this->db->query($update_status_query);

        // Clear session data
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session

        // Redirect to login page
        header("Location: login.php");
        exit(); // Ensure the script stops after redirection
    }
}




	function login2(){

		extract($_POST);

		$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM students where student_code = '".$student_code."' ");

		if($qry->num_rows > 0){

			foreach ($qry->fetch_array() as $key => $value) {

				if($key != 'password' && !is_numeric($key))

					$_SESSION['rs_'.$key] = $value;

			}

			return 1;

		}else{

			return 3;

		}

	}

	function save_user(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}

		if(!empty($password)){

			$data .= ", password=md5('$password') ";



		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;

		if($check > 0){

			return 2;

			exit;

		}

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){

			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];

			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);

			$data .= ", avatar = '$fname' ";



		}

		if(empty($id)){

			if(!isset($_FILES['img']) || (isset($_FILES['img']) && $_FILES['img']['tmp_name'] == '')){	

				$data .= ", avatar = 'no-image-available.png' ";

			}

			$save = $this->db->query("INSERT INTO users set $data");

		}else{

			$save = $this->db->query("UPDATE users set $data where id = $id");

		}



		if($save){

			return 1;

		}

	}

	function signup(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){

				if($k =='password'){

					if(empty($v))

						continue;

					$v = md5($v);



				}

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}



		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;

		if($check > 0){

			return 2;

			exit;

		}

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){

			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];

			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);

			$data .= ", avatar = '$fname' ";



		}

		if(empty($id)){

			if(!isset($_FILES['img']) || (isset($_FILES['img']) && $_FILES['img']['tmp_name'] == '')){	

				$data .= ", avatar = 'no-image-available.png' ";

			}

			$save = $this->db->query("INSERT INTO users set $data");



		}else{

			$save = $this->db->query("UPDATE users set $data where id = $id");

		}



		if($save){

			if(empty($id))

				$id = $this->db->insert_id;

			foreach ($_POST as $key => $value) {

				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))

					$_SESSION['login_'.$key] = $value;

			}

			$_SESSION['login_id'] = $id;

			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))

				$_SESSION['login_avatar'] = $fname;

			return 1;

		}

	}



	function update_user(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){

				

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}

		$type = array("employee_list","evaluator_list","users");

		$check = $this->db->query("SELECT * FROM {$type[$_SESSION['login_type']]} where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;

		if($check > 0){

			return 2;

			exit;

		}

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){

			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];

			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);

			$data .= ", avatar = '$fname' ";



		}

		if(!empty($password))

			$data .= " ,password=md5('$password') ";

		if(empty($id)){

			if(!isset($_FILES['img']) || (isset($_FILES['img']) && $_FILES['img']['tmp_name'] == '')){	

				$data .= ", avatar = 'no-image-available.png' ";

			}

			$save = $this->db->query("INSERT INTO {$type[$_SESSION['login_type']]} set $data");

		}else{

			$save = $this->db->query("UPDATE {$type[$_SESSION['login_type']]} set $data where id = $id");

		}



		if($save){

			foreach ($_POST as $key => $value) {

				if($key != 'password' && !is_numeric($key))

					$_SESSION['login_'.$key] = $value;

			}

			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))

				$_SESSION['login_avatar'] = $fname;

			return 1;

		}

	}

	function delete_user(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM users where id = ".$id);

		if($delete)

			return 1;

	}

	function save_system_settings(){

		extract($_POST);

		$data = '';

		foreach($_POST as $k => $v){

			if(!is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}

		if($_FILES['cover']['tmp_name'] != ''){

			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];

			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);

			$data .= ", cover_img = '$fname' ";



		}

		$chk = $this->db->query("SELECT * FROM system_settings");

		if($chk->num_rows > 0){

			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);

		}else{

			$save = $this->db->query("INSERT INTO system_settings set $data");

		}

		if($save){

			foreach($_POST as $k => $v){

				if(!is_numeric($k)){

					$_SESSION['system'][$k] = $v;

				}

			}

			if($_FILES['cover']['tmp_name'] != ''){

				$_SESSION['system']['cover_img'] = $fname;

			}

			return 1;

		}

	}

	function save_image(){

		extract($_FILES['file']);

		if(!empty($tmp_name)){

			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));

			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);

			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

			$hostName = $_SERVER['HTTP_HOST'];

			$path =explode('/',$_SERVER['PHP_SELF']);

			$currentPath = '/'.$path[1]; 

			if($move){

				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;

			}

		}

	}

	function save_department(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}

		$chk = $this->db->query("SELECT * FROM department_list where department = '$department' and id != '{$id}' ")->num_rows;

		if($chk > 0){

			return 2;

		}

		if(isset($user_ids)){

			$data .= ", user_ids='".implode(',',$user_ids)."' ";

		}

		if(empty($id)){

			$save = $this->db->query("INSERT INTO department_list set $data");

		}else{

			$save = $this->db->query("UPDATE department_list set $data where id = $id");

		}

		if($save){

			return 1;

		}

	}

	function delete_department(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM department_list where id = $id");

		if($delete){

			return 1;

		}

	}

	function save_designation(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}

		$chk = $this->db->query("SELECT * FROM designation_list where designation = '$designation' and id != '{$id}' ")->num_rows;

		if($chk > 0){

			return 2;

		}

		if(isset($user_ids)){

			$data .= ", user_ids='".implode(',',$user_ids)."' ";

		}

		if(empty($id)){

			$save = $this->db->query("INSERT INTO designation_list set $data");

		}else{

			$save = $this->db->query("UPDATE designation_list set $data where id = $id");

		}

		if($save){

			return 1;

		}

	}

	function delete_designation(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM designation_list where id = $id");

		if($delete){

			return 1;

		}

	}

	function save_employee(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";
					// print_r($data);
					// exit();

				}

			}

		}

		if(!empty($password)){

			$data .= ", password=md5('$password') ";



		}

		$check = $this->db->query("SELECT * FROM employee_list where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;

		if($check > 0){

			return 2;

			exit;

		}

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){

			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];

			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);

			$data .= ", avatar = '$fname' ";



		}

		if(empty($id)){

			if(!isset($_FILES['img']) || (isset($_FILES['img']) && $_FILES['img']['tmp_name'] == '')){	

				$data .= ", avatar = 'no-image-available.png' ";

			}

			$save = $this->db->query("INSERT INTO employee_list set $data");

		}else{

			$save = $this->db->query("UPDATE employee_list set $data where id = $id");

		}



		if($save){

			return 1;

		}

	}

	function delete_employee(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM employee_list where id = ".$id);

		if($delete)

			return 1;

	}

	function save_evaluator(){

		extract($_POST);

		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}

		if(!empty($password)){

			$data .= ", password=md5('$password') ";



		}

		$check = $this->db->query("SELECT * FROM evaluator_list where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;

		if($check > 0){

			return 2;

			exit;

		}

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){

			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];

			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);

			$data .= ", avatar = '$fname' ";



		}

		if(empty($id)){

			if(!isset($_FILES['img']) || (isset($_FILES['img']) && $_FILES['img']['tmp_name'] == '')){	

				$data .= ", avatar = 'no-image-available.png' ";

			}

			$save = $this->db->query("INSERT INTO evaluator_list set $data");

		}else{

			$save = $this->db->query("UPDATE evaluator_list set $data where id = $id");

		}



		if($save){

			return 1;

		}

	}

	function delete_evaluator(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM evaluator_list where id = ".$id);

		if($delete)

			return 1;

	}
    // function save_task() {
    //     // Extract POST data
    //     extract($_POST);
         
    //     // Initialize variables
    //     $data = '';
    //     $employee_ids = '';
    // 	$page_ids = '';
    //     // Construct data string
    //     foreach ($_POST as $k => $v) {
    //         if ($k == 'employee_id' && is_array($v)) {
    //             $employee_ids = implode(',', $v);

    //         } elseif ($k == 'page_id' && is_array($v)) {
    //         // Handle page_id array
    //         $page_ids = implode(',', $v);
    //     }
    //         elseif ($k !== 'id' && !is_numeric($k)) {
    //             if ($k == 'description') {
    //                 $v = str_replace("'", "&#x2019;", $v);  // Replace single quote with HTML entity
				// 	$v = htmlentities($v, ENT_NOQUOTES, 'UTF-8', false);  // Convert other special characters, but preserve spaces

    //             }
    //             if (empty($data)) {
    //                 $data .= " $k='$v' ";
    //             } else {
    //                 $data .= ", $k='$v' ";
    //             }
    //         }
    //     }


    
    //     // Add employee_id to $data string if it's not empty
    //     if (!empty($employee_ids)) {
    //         if (empty($data)) {
    //             $data .= "employee_id='$employee_ids'";
    //         } else {
    //             $data .= ", employee_id='$employee_ids'";
    //         }
    //     }

    //      // Add page_id to $data string if it's not empty
    // if (!empty($page_ids)) {
    //     if (empty($data)) {
    //         $data .= "page_id='$page_ids'";
    //     } else {
    //         $data .= ", page_id='$page_ids'";
    //     }
    // }
        
    //      // Ensure daily_task is included in the data string with a default value of 0
    //     if (!isset($_POST['daily_task'])) {
    //         if (empty($data)) {
    //             $data .= "daily_task='0'";
    //         } else {
    //             $data .= ", daily_task='0'";
    //         }
    //     }
    
    //     // Determine whether to insert or update
    //     if (isset($id) && !empty($id)) {
    //         // Update existing task
    //         $query = "UPDATE task_list SET $data WHERE id = $id";
    //     } else {
    //         // Insert new task
    //         $query = "INSERT INTO task_list SET $data";
    
    //     }
    
    //     // Execute the query
    //     $save = $this->db->query($query);
    
    //     // Check if the operation was successful
    //     if ($save) {
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }
	
	function save_task() {
    // Extract POST data
    extract($_POST);

    // Initialize variables
    $data = '';
    $employee_ids = '';
    $page_ids = '';

    // Construct data string
    foreach ($_POST as $k => $v) {
        if ($k == 'employee_id' && is_array($v)) {
            $employee_ids = implode(',', $v);
        } elseif ($k == 'page_id' && is_array($v)) {
            $page_ids = implode(',', $v);
        } elseif ($k !== 'id' && !is_numeric($k)) {
            if ($k == 'description') {
                // Replace single quote with HTML entity
                $v = str_replace("'", "&#x2019;", $v);
                // Convert other special characters, but preserve spaces
                $v = htmlentities($v, ENT_NOQUOTES, 'UTF-8', false);
            }
            $data .= empty($data) ? "$k='$v'" : ", $k='$v'";
        }
    }

    // Add employee_id and page_id to $data string if not empty
    if (!empty($employee_ids)) $data .= empty($data) ? "employee_id='$employee_ids'" : ", employee_id='$employee_ids'";
    if (!empty($page_ids)) $data .= empty($data) ? "page_id='$page_ids'" : ", page_id='$page_ids'";

    // Ensure daily_task is included in the data string with a default value of 0
    if (!isset($_POST['daily_task'])) $data .= empty($data) ? "daily_task='0'" : ", daily_task='0'";

    // Determine whether to insert or update
    if (isset($id) && !empty($id)) {
        $query = "UPDATE task_list SET $data WHERE id = $id";
    } else {
        $query = "INSERT INTO task_list SET $data";
    }

    // Execute the query
  $save = $this->db->query($query);

    // Check if the operation was successful
    if ($save) {
        $action = isset($id) ? 'assigned' : 'created';  // Define the action (created or updated)

        // Check if multiple employees are selected and split into an array
        $employee_ids = !empty($employee_ids) ? explode(',', $employee_ids) : [];  // Ensure $employee_ids is an array

        // Check if the resulting array is not empty before proceeding
        if (!empty($employee_ids)) {
            
            foreach ($employee_ids as $employee_id) {
                $employee_id = trim($employee_id);  // Trim any whitespace around the employee ID

                // Query to fetch email from employee_list table
                $sql = "SELECT email FROM employee_list WHERE id = $employee_id";
                $result = $this->db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $recipient_email = $row['email'];  // Use the fetched employee email

                    // Send email notification
                    require_once "PHPMailer/PHPMailer.php";
                    require_once "PHPMailer/SMTP.php";
                    require_once "PHPMailer/Exception.php";
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host = 'mail.itschatters.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'webmaster@itschatters.com';
                        $mail->Password = 'Webmaster@itschatter';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;

                        // Recipients
                        $mail->setFrom('webmaster@itschatters.com', 'TMS');
                        $mail->addAddress($recipient_email);  // Add the employee's email address here

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = "Task {$action} Notification";
                        $mail->Body = '<html>
                            <head>
                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        line-height: 1.6;
                                        color: #333;
                                    }
                                    .email-container {
                                        max-width: 600px;
                                        margin: 0 auto;
                                        padding: 20px;
                                        border: 1px solid #ddd;
                                        border-radius: 5px;
                                        background-color: #f9f9f9;
                                    }
                                    .email-header {
                                        font-size: 24px;
                                        font-weight: bold;
                                        margin-bottom: 10px;
                                        color: #0056b3;
                                    }
                                    .email-content {
                                        margin-bottom: 20px;
                                    }
                                    .email-footer {
                                        font-size: 12px;
                                        color: #777;
                                    }
                                    .signature {
                                        margin-top: 20px;
                                        font-size: 14px;
                                        color: #555;
                                    }
                                    .signature img {
                                        width: 100px;
                                        margin-top: 10px;
                                    }
                                    .email-logo {
                                        width: 100px;
                                        margin-bottom: 20px;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="email-container">
                                    <img src="https://shjinternational.com/wp-content/uploads/2022/10/AWSA-GLOBAL-BW-01-2-1.png" alt="Company Logo" class="email-logo">
                                    <div class="email-header">Task Assigned Notification</div>
                                    <div class="email-content">
                                        <strong>Assigned By:</strong> ' . $_SESSION["login_firstname"] . '<br>
                                        <strong>Due Date:</strong> ' . $due_date . '<br>
                                        <strong>Task:</strong> ' . $task . '<br>
                                        <strong>Description:</strong> ' . $description . '<br><br>
                                    </div>
                                    <div class="signature">
                                        Best Regards,<br>
                                        Admin<br>
                                        <img src="https://shjinternational.com/wp-content/uploads/2022/10/AWSA-GLOBAL-BW-01-2-1.png" alt="Signature">
                                    </div>
                                    <div class="email-footer">
                                        Please Acknowledge.
                                    </div>
                                </div>
                            </body>
                        </html>';

                        // Send the email
                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                    }
                }
            }


            return 1;
        } else {
            return 0;  // Handle case where there are no employee IDs
        }
    }
}

	function delete_task(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM task_list where id = ".$id);

		if($delete){

			return 1;

		} else {

			return 0; // Or you can return an error message

		}

	}

	

	

	function save_progress(){

		extract($_POST);
       
		$data = "";

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id')) && !is_numeric($k)){

				 // $v = mysqli_real_escape_string($conn, $v);

				if($k == 'progress')

				$v = str_replace("'", "&#x2019;", $v);  // Replace single quote with HTML entity
				$v = htmlentities($v, ENT_NOQUOTES, 'UTF-8', false);  // Convert other special characters, but preserve spaces

				if(empty($data)){

					$data .= " $k='$v' ";

				}else{

					$data .= ", $k='$v' ";

				}

			}

		}
           
		if(!isset($is_complete))
			$data .= ", is_complete=0 ";
		
		if(!isset($is_approved))
			$data .= ", is_approved=0 ";
		if(!isset($is_pending))
		    $data .= ", is_pending=0 ";	
		if(!isset($is_onprogress))
		    $data .= ", is_onprogress=0 ";

		if(empty($id)){

			$save = $this->db->query("INSERT INTO task_progress set $data");
		} else {
			$save = $this->db->query("UPDATE task_progress set $data where id = $id");
			// print_r($data);
			// exit();
		}


		
		if($save){
			if(!isset($is_approved) && !isset($is_complete) && !isset($is_onprogress))
				$status = 1;
			elseif(isset($is_approved) && !isset($is_complete) && !isset($is_onprogress))
				$status = 4;
			elseif(!isset($is_approved) && isset($is_complete) && !isset($is_onprogress))
				$status = 2;
			elseif(isset($is_onprogress))
			    $status = 0;
			
			$this->db->query("UPDATE task_list set status = $status where id = $task_id ");
			return 1;
}


	}

	function delete_progress(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM task_progress where id = $id");

		if($delete){

			return 1;

		}

	}

	function save_evaluation(){

		extract($_POST);

		$data = "";

		

		foreach($_POST as $k => $v){

			if(!in_array($k, array('id')) && !is_numeric($k)){

				if(empty($data)){

					$data .= " $k='$v' ";
				// 	print_r($data);

				}else{

					$data .= ", $k='$v' ";
					
					
					
				}

			}

		}

			

		if(empty($id)){
           
			$save = $this->db->query("INSERT INTO daily_tasks set $data");

		}else{

			$save = $this->db->query("UPDATE daily_tasks set $data where id = $id");

		}

		if($save){

			
			return 1;

		}

	}

	function delete_evaluation(){

		extract($_POST);

		$delete = $this->db->query("DELETE FROM daily_tasks where id = $id");

		if($delete){

			return 1;

		}

	}

	function update_status() {
    $updated_at = date('Y-m-d H:i:s');
    $id = intval($_POST['id']); // Ensure $id is an integer to prevent SQL injection

    // Check if the task exists in the task_list table
    $task_check_query = "SELECT * FROM task_list WHERE daily_task = $id";
    $task_check_result = $this->db->query($task_check_query);

    if ($task_check_result && $task_check_result->num_rows > 0) {
        // Task exists in task_list, now check if it's in the daily_tasks table
        $task_exists_query = "SELECT * FROM daily_tasks WHERE id = $id";
        $task_exists_result = $this->db->query($task_exists_query);

        if ($task_exists_result && $task_exists_result->num_rows > 0) {
            // Task exists, update its status
            $update_query = "UPDATE daily_tasks SET status = 1, updated_at = '$updated_at' WHERE id = $id";
            $update = $this->db->query($update_query);

            if ($update) {
                return 1; // Status updated successfully
            } else {
                return 'Error updating status: ' . $this->db->error; // Error updating status
            }
        } else {
            // Task does not exist in daily_tasks table
            return 'Task does not exist in daily_tasks';
        }
    } else {
        // Task does not exist in task_list
        return 'Please create the task first';
    }
}





	function get_emp_tasks(){

		extract($_POST);

		if(!isset($task_id))

			$get = $this->db->query("SELECT * FROM task_list where employee_id = $employee_id and status = 2 and id not in (SELECT task_id FROM ratings) ");

		else

			$get = $this->db->query("SELECT * FROM task_list where employee_id = $employee_id and status = 2 and id not in (SELECT task_id FROM ratings where task_id !='$task_id') ");

		$data = array();

		while($row=$get->fetch_assoc()){

			$data[] = $row;

		}

		return json_encode($data);

	}

	function get_progress(){

		extract($_POST);

		$get = $this->db->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar FROM task_progress p inner join task_list t on t.id = p.task_id inner join employee_list u on u.id = t.employee_id where p.task_id = $task_id order by unix_timestamp(p.date_created) desc ");

		$data = array();

		while($row=$get->fetch_assoc()){

			$row['uname'] = ucwords($row['uname']);

			$row['progress'] = html_entity_decode($row['progress']);

			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));

			$data[] = $row;

		}

		return json_encode($data);

	}

	function get_report(){

		extract($_POST);

		$data = array();

		$get = $this->db->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where date(t.date_created) between '$date_from' and '$date_to' order by unix_timestamp(t.date_created) desc ");

		while($row= $get->fetch_assoc()){

			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));

			$row['name'] = ucwords($row['name']);

			$row['adult_price'] = number_format($row['adult_price'],2);

			$row['child_price'] = number_format($row['child_price'],2);

			$row['amount'] = number_format($row['amount'],2);

			$data[]=$row;

		}

		return json_encode($data);



	}

}



function save_page(){

	extract($_POST);

	$data = "";



	foreach($_POST as $k => $v){

		if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){

			if(empty($data)){

				$data .= " $k='$v' ";

			}else{

				$data .= ", $k='$v' ";

			}

		}

	}

	$chk = $this->db->query("SELECT * FROM pages where page = '$page' and id != '{$id}' ")->num_rows;



	if($chk > 0){

		return 2;

	}

	if(isset($user_ids)){

		$data .= ", user_ids='".implode(',',$user_ids)."' ";

	}

	if(empty($id)){

		$save = $this->db->query("INSERT INTO pages SET $data");

	}else{

		$save = $this->db->query("UPDATE pages SET $data WHERE id = $id");

	}

	if($save){

		return 1;

	}

}



function delete_page(){

	extract($_POST);

	$delete = $this->db->query("DELETE FROM pages WHERE id = $id");

	if($delete){

		return 1;

	}

}



