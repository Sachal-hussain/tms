<?php include'db_connect.php' ?>

<div class="col-lg-12">
	<?php if ($_SESSION['login_type'] == 0): ?>
	<?php
	$sql = "SELECT COUNT(*) AS task_count FROM daily_tasks WHERE DATE(date) < DATE(NOW())
    AND status='0'
    AND employee_id= {$_SESSION['login_id']}";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // Fetch the count
	    $row = $result->fetch_assoc();
	    $task_count = $row["task_count"];

	    echo '<div style="background-color: #007bff; padding: 1px;">';
	    echo '<marquee direction="left" height="50px" style="color: white; font-style: inherit; font-size: 200%;">';
	    echo 'REMINDER : ' . $task_count . ' Pending tasks are left';
	    echo '</marquee>';
	    echo '</div>';

	} else {
	    echo "No tasks with status 0 found.";
	}
	?>
	<?php endif; ?>
</div>

	<div class="card card-outline card-success">

		<div class="card-header">

			<?php if($_SESSION['login_type'] == 2): ?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_task"><i class="fa fa-plus"></i> Add Daily Task</a>
			</div>
			<?php endif; ?>
		</div>


		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Task</th>
						<th>Page Name</th>
						<th>Employee Name</th>
						<th>Date</th>
						<th>Status</th>
						<?php if($_SESSION['login_type'] == 2): ?>
						<th>Action</th> 
					<?php endif ?>

					</tr>
				</thead>
				<tbody>
					<?php
					$current_date = date('Y-m-d');
					$day_of_month = date('d', strtotime($current_date));
					$month_of_year = date('m', strtotime($current_date));
                    
					$i = 1;
					$where = "";
					$btn_status='';
					if($_SESSION['login_type'] == 0)
					
				// 		$where = " where d.employee_id = {$_SESSION['login_id']} AND DAY(d.date) = $day_of_month";
				        $where = " where d.employee_id = {$_SESSION['login_id']} AND DAY(d.date) = $day_of_month AND MONTH(d.date) = $month_of_year";
					    $qry = $conn->query("SELECT 
    d.id,
    d.employee_id,
    d.page_id,
    d.task,
    d.date,
    d.status,
    e.id as employeeid,
    e.firstname,
    p.id as pageid,
    p.pagename
FROM 
    daily_tasks d
INNER JOIN 
    employee_list e ON e.id = d.employee_id
INNER JOIN 
    pages p ON p.id = d.page_id
WHERE 
    e.department_id = 12
ORDER BY 
    d.id ASC;
");
                        if ($qry->num_rows > 0) 
					    while($row= $qry->fetch_assoc()):
					    $date_timestamp = strtotime($row['date']);
					    if($row['status']==1){
					    	$btn_status='<button type="button" class="btn btn-success btn-sm btn-flat" disabled>Completed</button>';
					    }
					    else{
					    	$btn_status='<button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-pending" data-id="'.$row['id'].'" >Pending</button>';
					    }

                        $formatted_date = date("l F j, Y", $date_timestamp);
						?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo ($row['task']) ?></b></td>
							<td><b><?php echo ucwords($row['pagename']) ?></b></td>
							
							<td><b><?php echo ucwords($row['firstname']) ?></b></td>
							
							<td><b><?php echo $formatted_date;?></b></td>
							<td><b><?php echo $btn_status;?></b></td>
							<?php if($_SESSION['login_type'] == 2): ?>
							 <td class="text-center">
								<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									Action
								</button>
								<div class="dropdown-menu" style="">
									<a class="dropdown-item view_evaluation" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./index.php?page=edit_evaluation_redeem&id=<?php echo $row['id'] ?>">Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_evaluation" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
								</div>
							</td> 
							<?php endif; ?>
						</tr>	
					    <?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable({
		    "order":[[0,'asc']]
		})
		$(document).on('click','.view_evaluation',function(){
			uni_modal("Evaluation Details","view_evaluation.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$(document).on('click','.delete_evaluation',function(){
			_conf("Are you sure to delete this task?","delete_evaluation",[$(this).attr('data-id')])
		})

		$(document).on('click','#btn-pending',function(){
			var id=$(this).data('id');

			$.ajax({
			url:'ajax.php?action=update_status',
			method:'POST',
			data:{id:id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})

		})
	})
	function delete_evaluation($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_evaluation',
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