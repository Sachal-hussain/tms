<?php require_once("db_connect.php");
session_start();
if(!isset($_SESSION['login_id'])){
header('location:login.php');
}
$id='';
$page_id='';
if (isset($_GET['task_id'])) {
    $id = $_GET['task_id'];
}

include 'header.php' 
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        body {
            background-color: #f1f1f1;
        }

        .form-control {
            width: 100%;
            height: 25px;
            padding: 6px 12px;
            font-size: 14px;
            color: #555;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-primary {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #337ab7;
            color: #fff;
        }

        .btn_del {
            background-color: #FF5733 !important;
        }

        .container {
            margin-left: 30%;
            width: 400px;
            background-color: #fff;
            padding: 10px;
            padding-right: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .container_display {
            margin-left: 10%;
            width: 900px;
            background-color: #fff;
            padding: 10px;
            padding-right: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            font-size: 20px;
            font-weight: 700;
        }

        .success {
            margin: 5px auto;
            border-radius: 5px;
            border: 3px solid #fff;
            background: #33CC00;
            color: #fff;
            font-size: 20px;
            padding: 10px;
            box-shadow: 10px 5px 5px grey;
        }

        .form-control {
            width: 100%;
            height: 44px;
            padding: 6px 12px;
            font-size: 14px;
            color: #555;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">    
 <?php include 'topbar.php' ?>
  <?php include 'sidebar.php' ?>
  <div class="content-wrapper">
<!--<a href="index.php?page=task_list" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>  -->

<?php

if (isset($_POST['form_submit'])) {
    $folder = "assets/uploads/";
    $fileCount = count($_FILES['file']['name']);
    $uploadSuccess = true;
    $errors = [];

    $rand=uniqid();

    for ($i = 0; $i < $fileCount; $i++) {
        $file_name = $_FILES['file']['name'][$i];
        $file_tmp_name = $_FILES['file']['tmp_name'][$i];
        $path = $folder . $file_name;
        $filenamerand=$rand.basename($file_name);
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
            $result = mysqli_query($conn, "INSERT INTO tb_img(task_id, page_id, file_name, file_type) VALUES('$id', '$page_id', '$filenamerand', '$fileType')");
            if (!$result) {
                $uploadSuccess = false;
            }
            if (empty($page_id)) {
                // If `page_id` is not provided, insert only `task_id`.
                $query = "INSERT INTO tb_img(task_id, file_name, file_type) VALUES('$id', '$filenamerand', '$fileType')";
                
            } else {
                // If `page_id` is provided, include it in the insertion.
                $query = "INSERT INTO tb_img(task_id, page_id, file_name, file_type) VALUES('$id', '$page_id', '$filenamerand', '$fileType')";
            }
        }
    }

    if ($uploadSuccess) {
        echo '<div class="success">All files uploaded successfully</div>';
    } else {
        foreach ($errors as $error) {
            echo '<div class="message">' . $error . '</div><br>';
        }
        $result = mysqli_query($conn, $query);
            if (!$result) {
                $uploadSuccess = false;
            }
        }
    }
    

?> 
<div class="container_display">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>File </label>
            <input type="file" name="file[]" class="form-control" required multiple>
        </div>
</br>
        
                </br>
        <button name="form_submit" class="btn-primary">Upload</button>
    </form>
</br>

<?php 
if(isset($_GET['upload_success'])) {
    echo '<div id="success-message" class="success">File Uploaded successfully</div>'; 
}

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action=='saved') {
        echo '<div id="success-message" class="success">Saved </div>'; 
    } elseif($action=='deleted') {
        echo '<div id="success-message" class="success">Image Deleted Successfully ... </div>'; 
    }
}
?>

<script>
// Check if the success message div exists in the DOM
if(document.getElementById('success-message')) {
    // Use setTimeout to delay the execution of the function that hides the message
    setTimeout(function() {
        // Hide the success message after 5 seconds (5000 milliseconds)
        document.getElementById('success-message').style.display = 'none';
    }, 5000);
}
</script>

<table cellpadding="3">
    <thead>
        <tr>
            <th>#</th>
            <th>File</th>
            <th>Created By</th>
            <th>Date/Time</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
       
<?php

if (isset($_GET['task_id'])) {
    $taskid = $_GET['task_id'];
    
    $res=mysqli_query($conn,"SELECT task_list.id,task_list.assigned_by,tb_img.*,employee_list.id,employee_list.firstname,tb_img.id as imgid
        from task_list
         JOIN tb_img on tb_img.task_id=task_list.id
         JOIN employee_list ON task_list.assigned_by=employee_list.id
        WHERE tb_img.task_id='$taskid' ORDER BY tb_img.id DESC");
    $i = 1; // Initialize counter for files
    $html='';
    $file_output='';
    $action='';
    while ($row = mysqli_fetch_array($res)) {
        
            $action=' <a href="edit.php?task_id='. $row['task_id'] . '"> <button class="btn-primary">Edit</button> </a>
                <br><br>
                <a href="delete.php?id=' . $row['imgid'] . '" onClick="return confirm(\'Are you sure you want to delete this file?\')">
                    <button class="btn-primary btn_del">Delete</button>
                </a>';
            
        
        if (in_array($row['file_type'], ['jpg', 'jpeg', 'png', 'gif'])) {
            $file_output='<a href="assets/uploads/' . $row['file_name'] . '" target="_blank"><img src="assets/uploads/' . $row['file_name'] . '" height="200"></a>';
        } 
        elseif (in_array($row['file_type'], ['mp4', 'avi', 'mov'])) {
            $file_output= '<a href="assets/uploads/' . $row['file_name'] . '" target="_blank"><video width="320" height="240" controls><source src="assets/uploads/' . $row['file_name'] . '" type="video/' . $row['file_type'] . '">Your browser does not support the video tag.</video></a>';
        }
        $html.='<tr>
                <td>'.$i.'</td>
                <td>'.$file_output.'</td>
                <td>'.$row['firstname'].'</td>
                <td>'. $row['created_at'].'</td>
                <td>'.$action.'</td>

            </tr>
        ';
        
        $i++; 
    }
    echo $html;
}
?>


    </tbody>
</table>

    </div>
    </div>
		
	
	</div>
	</div>
	</div>
	<?php include 'footer.php' ?>
</body>
</html>