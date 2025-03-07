<?php 
session_start();
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}

$query = "SELECT * FROM tb_img ORDER BY image DESC";

$statement-> $onnect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$number_of_rows = $statement->rowCount();

$output = '
table class = "table table-bordered "

'
?>