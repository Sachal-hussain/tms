<?php
$date_created = date("Y-m-d H:i:s");
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_evaluation">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
			<input type="hidden" name="created_at" value="<?php echo isset($date_created) ? $date_created : ''; ?>">
				<div class="row justify-content-center">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">Employee</label>
							<select name="employee_id" id="employee_id" class="form-control form-control-sm select2">
								<option value=""></option>
								<?php 
								$employees = $conn->query("SELECT *,concat(firstname) as name 
									FROM employee_list  
									order by concat(firstname) asc");
								while($row=$employees->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($employee_id) && $employee_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
							<td>
    <p><b>
        <?php
        // Split page IDs into an array
        $page_ids = explode(",", $row['page_id']);

        // Initialize an array to store page info with links
        $page_info = [];

        // Loop through each page ID
        foreach ($page_ids as $page_id) {
            // Ensure each ID is an integer to prevent SQL injection
            $page_id = intval($page_id);

            // Skip invalid or non-positive page IDs
            if ($page_id <= 0) {
                continue;
            }

            // Query to get the page name
            $query = "SELECT pagename FROM pages WHERE id = $page_id";
            $result = $conn->query($query);

            // If the query is successful
            if ($result) {
                if ($page_row = $result->fetch_assoc()) {
                    // Store the page name with a clickable link to edit_image.php
                    $page_info[] = '<a href="edit_image.php?task_id=' . $row['id'] . '">'
                        . ucwords($page_row['pagename']) . '</a>';
                }
            } else {
                // If the query fails, display error and break the loop
                echo "Query failed: " . $conn->error;
                break; // Exit the loop on query failure
            }
        }

        // Display the page names, separated by commas
        echo implode(', ', $page_info);
        ?>
    </b></p>
</td>
						<div class="form-group">
							<label for="" class="control-label">Task</label>
							
							<input type="text" class="form-control " name="task" value="<?php echo isset($task) ? $task : '' ?>" required>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Date</label>
							
							<input type="date" class="form-control" name="date" required>
						</div>
						
						
					</div>
					
				</div>
			
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=daily_task_csr'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div id="clone_progress" class="d-none">
	<div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm avatar" src="" alt="user image">
                <span class="username">
                  <a href="#" class="nf"></a>
                </span>
                <span class="description">
                	<span class="fa fa-calendar-day"></span>
                	<span><b class="date"></b></span>
            	</span>
              </div>
              <div class="pdesc">
              
              </div>

              <p>
              </p>
        </div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
	#post-field{
		max-height: 70vh;
		overflow: auto;
	}
</style>
<script>

	$('#manage_evaluation').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$.ajax({
			url:'ajax.php?action=save_evaluation',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
			    
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=daily_task_csr')
					},750)
				}
			}
		})
	})
</script>