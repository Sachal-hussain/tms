<?php
require_once("db_connect.php");

if (!isset($_GET['task_id'])) {
    echo "Task ID is required.";
    exit;
}

$id = $_GET['task_id'];

$fileDetailsQuery = "SELECT * FROM tb_img WHERE task_id = '$id'";
$fileDetailsResult = mysqli_query($conn, $fileDetailsQuery);

if (!$fileDetailsResult || mysqli_num_rows($fileDetailsResult) == 0) {
    echo "File not found.";
    exit;
}

$fileDetails = mysqli_fetch_assoc($fileDetailsResult);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page_id = $_POST['page_id'] ?? '';
    $errors = [];
    $uploadSuccess = false;

    if (!empty($_FILES['file']['name'])) {
        $folder = "assets/uploads/";
        $file_name = $_FILES['file']['name'];
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $target_file = $folder . basename($file_name);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Additional validations for file (size, type, etc.) go here
    
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            $updateQuery = "UPDATE tb_img SET page_id = ?, file_name = ?, file_type = ? WHERE task_id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ssss", $page_id, $file_name, $fileType, $id);
    
            if (mysqli_stmt_execute($stmt)) {
                $uploadSuccess = true;
                $successMessage = "File updated successfully";
                
                // Redirect to index.php after successful upload
                header("Location: edit_image.php?task_id=" . $id); // Changed from $row['task_id'] to $id
                exit();

            } else {
                $errors[] = "Failed to update the database.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "Failed to upload file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
body{
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
.container 
{ 
margin-left: 30%;
width: 400px ;
background-color: #fff;
padding: 10px;
padding-right: 40px;
    border: 1px solid #ccc;
    border-radius: 4px;
 }
 .container_display
{ 
margin-left: 10%;
width: 900px ;
background-color: #fff;
padding: 10px;
padding-right: 40px;
    border: 1px solid #ccc;
    border-radius: 4px;
 }

label   {
	font-size: 20px;
    font-weight: 700;
}
.success 
{ 
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
</style>

<body>
<div class="container">
    <form action="" method="POST" enctype="multipart/form-data"> <!-- Changed action to empty string to submit form to same page -->
        <input type="hidden" name="task_id" value="<?php echo $id; ?>"> <!-- Add hidden input field to pass task_id -->
        <div class="form-group">
            <label>File </label>
            <input type="file" name="file" class="form-control">
        </div>
        
        <button name="form_submit" class="btn-primary">Update</button>
    </form>
</div>
</body>
</html>
