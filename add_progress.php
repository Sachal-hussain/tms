<?php


ini_set('display_errors', 1);
include 'admin_class.php';
$crud = new Action();

if(isset($_POST['employee_id'])){
    $save = $crud->save_progress();
    if($save){
        echo $save;
    }
   
    
    

}


?>
