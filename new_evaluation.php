<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_evaluation">
			
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
							<div class="form-group">
							<label for="" class="control-label"> Pages</label>
							<select name="page_id" id="page_id" class="form-control form-control-sm" required="">
								<option value=""></option>
								<?php 
								$pages = $conn->query("SELECT *,concat(pagename) as name FROM pages ORDER BY concat(pagename) ASC");
								while($row=$pages->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($page_id) && $page_id == $row['id'] ? 'selected' : ''; ?>>
									<?php echo $row['pagename'] ?>
								</option>
								<?php endwhile; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Task</label>
							
								<input type="text" class="form-control" name="task">
						</div>

						<div class="form-group">
							<label for="" class="control-label">Date</label>
							
							<input type="date" class="form-control" name="date" required>
						</div>
						
						
					</div>
					
				</div>
			
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=daily_task'">Cancel</button>
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
						location.replace('index.php?page=daily_task')
					},750)
				}
			}
		})
	})
</script>