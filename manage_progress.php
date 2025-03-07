	<?php 
	include 'db_connect.php';
	session_start();
    // print_r($_SESSION['login_department_id']);
    // exit;
	$login_id = '';
	$depart_id = '';
	$assigned_by = '';
	if(isset($_SESSION['login_id'])){
		$login_id = $_SESSION['login_id'];
		$depart_id =$_SESSION['login_department_id'];
		
	}

	$date_created = date("Y-m-d H:i:s");
	$assigned_by_id = '';
	$status = '';
	$id = isset($_GET['tid']) ? $_GET['tid'] : '';

	if($id){
		$query = mysqli_query($conn, " SELECT * FROM task_list
			WHERE id='$id'");
		if(mysqli_num_rows($query) > 0){
			while($row=mysqli_fetch_array($query)){
				$assigned_by=$row['assigned_by'];
				$status=$row['status'];
                   // echo "<pre>";
                   //  print_r($row); 
			}
		}
		
		
		
	}
	?>

	<div class="container-fluid">

		<form action="" id="manage-progress">

			<input type="hidden" name="employee_id" value="<?php echo isset($login_id) ? $login_id : ''; ?>">

			<input type="hidden" name="date_created" value="<?php echo isset($date_created) ? $date_created : ''; ?>">

			<!-- <input type="hidden" name="id" value="<?php //echo isset($id) ? $id : ''; ?>"> -->

			<input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : ''; ?>">



			<div class="col-lg-12">

				<div class="row">

					<div class="form-group">

						<label for="">Progress Description</label>

						<textarea name="progress" id="progress" cols="30" rows="10" class="summernote form-control" required=""><?php echo isset($progress) ? $progress : '' ?></textarea>

					</div>

				</div>

				<?php
        // Task Completed checkbox condition
        if($assigned_by == $login_id && ($status == '4' || $status == '1')): // Ensure status comparison is correct
        ?>
        <div class="form-group clearfix">
        	<div class="icheck-primary d-inline">
        		<input type="checkbox" name="is_onprogress" value="1" class="is_onprogress" id="is_onprogress" data-id="<?php echo $id;?>">
        		<label for="is_onprogress">
        			On Progress
        		</label>
        	</div>
        </div>
        <?php if ($depart_id==8):?>
        <div class="form-group clearfix">
        	<div class="icheck-primary d-inline">
        		<input type="checkbox" name="is_complete" value="1" class="is_complete" id="is_complete" data-id="<?php echo $id;?>">
        		<label for="is_complete">
        			Task Completed
        		</label>
        	</div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if($status == '4'): // Ensure status comparison is correct
        ?> 
        <label for="is_approved">

        	<span class='badge badge-info'>Approved</span>

        </label>
    <?php endif; ?>        



    <?php
        // Approved checkbox condition, shown to everyone except who assigned the task
    if($assigned_by != $login_id && $status != 4):
	?>
	<div class="form-group clearfix">
		<div class="icheck-primary d-inline">
			<input type="checkbox" name="is_approved" value="1" class="is_approved" id="is_approved" data-id="<?php echo $id;?>">
			<label for="is_approved">
				Approved 
			</label>
		</div>
	</div>
	<div class="form-group clearfix">
		<div class="icheck-primary d-inline">
			<input type="checkbox" name="is_pending"  value="1" class="is_pending" id="is_pending" data-id="<?php echo $id;?>">
			<label for="is_pending">
				Pending 
			</label>
		</div>
	</div>
	<?php endif;?>
    <?php if($depart_id!=8):?>
        
        <div class="form-group clearfix">
        	<div class="icheck-primary d-inline">
        		<input type="checkbox" name="is_complete" value="1" class="is_complete" id="is_complete" data-id="<?php echo $id;?>">
        		<label for="is_complete">
        			Task Completed
        		</label>
        	</div>
        </div>
    <?php endif;?>
    </div>

</div>

</div>
<!-- <span id="approvalBadge" class="badge badge-info" style="display: none;">Approved</span> -->
</form>

</div>



<script>

	$(document).ready(function(){
	    $('.is_approved, .is_complete, .is_pending').change(function() {
            var approved = $('.is_approved').prop('checked');
            var complete = $('.is_complete').prop('checked');
            var pending = $('.is_pending').prop('checked');
            var onprogress = $('.is_onprogress').prop('checked');
            
            if (approved || complete || pending || onprogress) {
                $("#submit").prop("disabled", false);
            } else {
                $("#submit").prop("disabled", true);
            }
        });
		// $('#is_approved').change(function(){
		// 	if(this.checked){
		// 		$('#approvalBadge').show();
		// 		$(this).closest('.form-group').hide();
		// 	}
		// });
        
		$('.summernote').summernote({

			height: 200,

			toolbar: [

				[ 'style', [ 'style' ] ],

				[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],

				[ 'fontname', [ 'fontname' ] ],

				[ 'fontsize', [ 'fontsize' ] ],

				[ 'color', [ 'color' ] ],

				[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],

				[ 'table', [ 'table' ] ],

				[ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]

				],

			callbacks: {

				onPaste: function (e) {

					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');



            // Remove any HTML formatting from the pasted text

					e.preventDefault();

					document.execCommand('insertText', false, bufferText);

				}

			}

		})

		$('.select2').select2({

			placeholder:"Please select here",

			width: "100%"

		});

	})

	$('#manage-progress').submit(function(e){

		e.preventDefault()

		start_load()

		if($('#progress').val() == ''){

			alert_toast("Please fill the progress description first",'error');

			end_load();

			return false;

		}
        var approved = $('.is_approved').prop('checked');
        var complete = $('.is_complete').prop('checked');
        var pending = $('.is_pending').prop('checked');
        var onprogress = $('.is_onprogress').prop('checked');
        
        
        
		$.ajax({

			url:'add_progress.php',

			data: new FormData($(this)[0]),

			cache: false,

			contentType: false,

			processData: false,

			method: 'POST',

			type: 'POST',

			success:function(resp){

				if(resp == 1){
				   
                    if (approved) {
                        var taskid = $('.is_approved').data('id');
                        $('#onprogress-'+taskid).text('Approved').addClass('badge badge-info');
                        $('#pending-'+taskid).text('Approved').addClass('badge badge-info');
                        
                      
                    }
                    else if (complete) 
                    {
                        var id = $('.is_complete').data('id');
                        // $('#approved-'+id).text('Completed').addClass('badge badge-success');
                        $('#approved-'+id).text('Completed').removeClass('badge badge-info').addClass('badge badge-success');
                        $('#pending-'+id).text('Completed').removeClass('badge badge-info').addClass('badge badge-success');
                        $('#overdue-'+id).remove();
                        $('#countdown_'+id).remove();
                    }
                    else if (pending) 
                    {
                       
                        var taskid = $('.is_pending').data('id');
                        
                       
                       $('#onprogress-'+taskid).text('Pending').removeClass('badge badge-info').addClass('badge badge-primary');
                    }
                    else if (onprogress) 
                    {
                       
                        var taskid = $('.is_onprogress').data('id');
                        
                       
                       $('#pending-'+taskid).text('On Progress').removeClass('badge badge-primary').addClass('badge badge-info');
                    }
					alert_toast('Data successfully saved',"success");

					setTimeout(function(){
					     $('#preloader2').fadeOut('fast', function() {
                	        $(this).remove();
                	      })
                	      
                	      $('#uni_modal').modal('hide');

				// 		location.reload()

					},1500)

				}

			}

		})

	})

</script>
