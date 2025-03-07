
<script>
    function startCountdown(id, dueDate) {
        var countdownDate = new Date(dueDate).getTime();
        var countdown = setInterval(function() {
            var now = new Date().getTime();
            var distance = countdownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            var countdownElement = document.getElementById('countdown_' + id);
            if (countdownElement) {
                countdownElement.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ';
                if (distance < 0) {
                    clearInterval(countdown);
                    countdownElement.innerHTML = 'EXPIRED';
                }
            }
        }, 1000);
    }
</script>
<?php include 'db_connect.php' ;

$query_status='';

$where_clause='';

if(isset($_GET['status']) && $_GET['status']!=''){

    $query_status=$_GET['status'];

    if($query_status=='pending'){

        $query_status=0;

    }

    if($query_status=='on-progress'){

        $query_status=1;

    }

    if($query_status=='completed'){

        $query_status=2;

    }

    if($query_status=='completed'){

        $query_status=4;

    }

    $where_clause = " WHERE t.status='$query_status'";

}



?>



<div class="col-lg-12">

    <div class="card card-outline card-success">

        <div class="card-header">



            <?php 

            if($_SESSION['login_type'] == 0): ?>

                <div class="card-tools">

                    <button class="btn btn-block btn-sm btn-default btn-flat border-primary" id="new_task"><i class="fa fa-plus"></i> Add New Task</button>

                </div>

            <?php elseif($_SESSION['login_type'] == 2): ?>

                <div class="card-tools">

                    <button class="btn btn-block btn-sm btn-default btn-flat border-primary" id="new_task"><i class="fa fa-plus"></i> Add New Task</button>

                </div>

            <?php endif; ?>

        </div>

        





        <div class="card-body">

            <table class="table table-hover table-condensed table-responsive-sm" id="list">

                <thead>

                    <tr>

                        <th class="text-center">#</th>

                        <th>Page Name</th>

                        <th>Task</th>

                        <th>Due Date</th>

                        <th>Assigned To(Department)</th>

                        <th>Assigned By</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    

                    

                    $i = 1;

                    $where = "";

                    if ($_SESSION['login_type'] == 0) {

    // Assuming the logged-in user's ID is stored in session

                       $where = " WHERE (FIND_IN_SET('{$_SESSION['login_id']}', t.employee_id) OR t.assigned_by = '{$_SESSION['login_id']}')";

                   }



// Construct and execute SQL query

                   $qry = $conn->query("
                    SELECT t.*, 
                    p.pagename, 

                    CONCAT(a.firstname, ' ', a.lastname) AS assigned_by,

                    (SELECT GROUP_CONCAT(CONCAT(e.firstname, ' ', e.lastname, ' ', e.middlename) SEPARATOR ', ') 
                        FROM employee_list e 

                        WHERE FIND_IN_SET(e.id, t.employee_id) > 0) AS aggregated_names

                    FROM task_list t 

                    LEFT JOIN employee_list a ON t.assigned_by = a.id 

                    LEFT JOIN pages p ON p.id = t.page_id 

                    LEFT JOIN department_list d ON d.id IN (SELECT department_id FROM employee_list WHERE FIND_IN_SET(id, t.employee_id) > 0)
                    ".$where_clause."
                    ".$where."
                    GROUP BY t.id
                    ORDER BY UNIX_TIMESTAMP(t.date_created) DESC
                    ");


// Check if query execution failed

                   if (!$qry) {

    // Query execution failed

                    echo "Error: " . $conn->error;

                } else {

    // Query executed successfully

                    while ($row = $qry->fetch_assoc()) {
        // echo "<pre>";
        // print_r($row);
                        
                     $due_date_timestamp = strtotime($row['due_date']);
                     $current_date_timestamp = strtotime(date('Y-m-d'));
                     $due_date_karachi = new DateTime($row['due_date'], new DateTimeZone('Asia/Karachi'));
                     $due_date_karachi->setTime(23, 59, 59);

                     

                     $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);

                     unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);

                     $desc = strtr(html_entity_decode($row['description']), $trans);

                     $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);

                     ?>

                     <tr>

                        <td class="text-center"><?php echo $i++; ?></td>

                        <td>

                            <a href="edit_image.php?task_id=<?php echo $row['id']; ?>"><b><?php echo isset($row['pagename']) ? ucwords($row['pagename']) : 'N/A'; ?></b></a>

                        </td>

                        <td>

                            <p><b><?php echo ucwords($row['task']); ?></b></p>

                            <p class="truncate"><?php echo strip_tags($desc); ?></p>

                        </td>

                        <td><b><?php echo date("M d, Y", strtotime($row['due_date'])); ?></b></td>

                        <td>

                            <p><b>

                                <?php

                                $employee_ids = explode(",", $row['employee_id']);

                                $employee_info = [];



                                foreach ($employee_ids as $employee_id) {

        // Ensure each ID is an integer to prevent SQL injection

                                    $employee_id = intval($employee_id);



        // Skip if $employee_id is not a valid number

                                    if ($employee_id <= 0) {

                                        continue;

                                    }



                                    $query = "SELECT el.firstname, dl.department 

                                    FROM employee_list el

                                    JOIN department_list dl ON el.department_id = dl.id

                                    WHERE el.id = $employee_id";

                                    $result = $conn->query($query);



                                    if ($result) {

                                        if ($employee_row = $result->fetch_assoc()) {

                                            $employee_info[] = $employee_row['firstname'] . ' (' . $employee_row['department'] . ')';

                                        }

                                    } else {

                                        echo "Query failed: " . $conn->error;

            break; // Exit the loop on query failure

        }

    }



    // Display comma-separated first names with departments

    echo implode(', ', $employee_info);

    ?>

</b></p>

</td>

<td><b><?php echo $row['assigned_by'];?></b></td>







<!-- <td><p><b><?php //echo ucwords($row['department']); ?></b></p></td> -->

<td>

    <?php

    if ($row['status'] == 0) {

        echo "<span class='badge badge-info'>Pending</span>";

    } elseif ($row['status'] == 1) {

        echo "<span class='badge badge-primary'>On-Progress</span>";

    } elseif ($row['status'] == 2) {

        echo "<span class='badge badge-success'>Complete</span>";

    } elseif ($row['status'] == 4) {

        echo "<span class='badge badge-success'>Approved</span>";

    }

                            //   if ($due_date_timestamp < $current_date_timestamp && !$row['completed'])  {

                            //         echo "<span class='badge badge-danger mx-1'>Over Due</span>";

                            //     }
    if ($row['status'] != '2') {
        if ($due_date_timestamp >= $current_date_timestamp) {
        // Call the JavaScript function to start the countdown timer
            echo "<div id='countdown_" . $row['id'] . "'></div>";
            echo "<script>startCountdown(" . $row['id'] . ", '" . $due_date_karachi->format('Y-m-d H:i:s') . "');</script>";
        } else {
        // Display "Over Due" if the task is not completed and it is past the due date
            echo "<span class='badge badge-danger mx-1'>Over Due</span>";
        }
    }

    ?>

</td>

<td class="text-center">

    <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

        Action

    </button>

    <div class="dropdown-menu" style="">

        <a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View Task</a>

        

        <?php if ($_SESSION['login_type'] == 2) : ?>

            <?php if ($row['status'] != 2) : ?>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item manage_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>

            <?php endif; ?>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>

        <?php endif; ?>

        

        <?php if($row['status'] != 2): ?>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item new_progress" data-pid='<?php echo isset($row['page_id']) ? $row['page_id'] : ''; ?>' data-tid='<?php echo isset($row['id']) ? $row['id'] : ''; ?>' data-task='<?php echo isset($row['task']) ? ucwords($row['task']) : ''; ?>' href="javascript:void(0)">Add Progress</a>


            

            <?php //endif; ?>

        <?php endif; ?>
        <div class="dropdown-divider"></div>

        <a class="dropdown-item view_progress" data-pid = '<?php echo $row['page_id'] ?>' data-tid = '<?php echo $row['id'] ?>'  data-task = '<?php echo ucwords($row['task']) ?>'  href="javascript:void(0)">View Progress</a>

    </div>



</td>

</tr>

<?php } } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<style>

    table p {

        margin: unset !important;

    }



    table td {

        vertical-align: middle !important;

    }

</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>

    $(document).ready(function(){

      $('#list').dataTable()

      

      $('#new_task').click(function(){

          uni_modal("<i class='fa fa-plus'></i> New Task","manage_task.php",'mid-large')

      })

      $(document).on('click','.view_task',function(){

          uni_modal("View Task","view_task.php?id="+$(this).attr('data-id'),'mid-large')

      })

      $(document).on('click','.manage_task',function(){

        uni_modal("<i class='fa fa-edit'></i> Edit Task","manage_task.php?id="+$(this).attr('data-id'),'mid-large')

    })

      $(document).on('click','.new_progress',function(){

          uni_modal("<i class='fa fa-plus'></i> New Progress for: "+$(this).attr('data-task'),"manage_progress.php?tid="+$(this).attr('data-tid'),'mid-large')

      })

      $(document).on('click','.view_progress',function(){

          uni_modal("Progress for: "+$(this).attr('data-task'),"view_progress.php?id="+$(this).attr('data-tid'),'mid-large')

      })

      $(document).on('click','.delete_task',function(){

       _conf("Are you sure to delete this task?","delete_task",[$(this).attr('data-id')])

   })

  })

    function delete_task($id){

      start_load()

      $.ajax({

         url:'ajax.php?action=delete_task',

         method:'POST',

         data:{id:$id},

         success:function(resp){

            if(resp==1){

               alert_toast("Data successfully deleted",'success')

               setTimeout(function(){

                  location.reload()

              },1500)



           }

       }

   })

  }

</script>
