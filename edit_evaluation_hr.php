<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM daily_tasks where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'new_task_hr.php';
?>