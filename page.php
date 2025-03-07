<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<!-- <a class="btn btn-block btn-sm btn-default btn-flat border-primary new_pagename" href="javascript:void(0)">
					<i class="fa fa-plus"></i> Add New</a> -->
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="30%">
					<col width="45%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>pagename</th>					
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM pages order by pagename asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['pagename'] ?></b></td>
						
						<td class="text-center">
		                    <div class="btn-group">
		                        <!-- <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_pagename">
		                          <i class="fas fa-edit"></i>
		                        </a> -->
		                        <button type="button" class="btn btn-danger btn-flat delete_pagename" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
    $('#list').dataTable();

    // Edit Page Name
    $('.manage_pagename').click(function(){
        var id = $(this).attr('data-id');
        // Assuming 'manage_pagename.php' is your endpoint for fetching and updating page details.
        // You need to ensure this script returns a modal or a form populated with the page's existing details.
        uni_modal("Manage pagename","manage_pagename.php?id=" + id);
    });

    // Delete Page Name
    $('.delete_pagename').click(function(){
        var id = $(this).attr('data-id');
        // Confirm deletion
        if(confirm("Are you sure to delete this pagename?")) {
            delete_pagename(id);
        }
    });
});

// Function to delete pagename
function delete_page(id){
    start_load(); // Assuming this is a function to show loading animation or message
    $.ajax({
        url: 'ajax.php?action=delete_page',
        method: 'POST',
        data: {id: id},
        success: function(resp){
            if(resp == 1){
                alert_toast("Data successfully deleted", 'success');
                setTimeout(function(){
                    location.reload(); // Reload the page to reflect the changes
                }, 1500);
            } else {
                // Handle failure (optionally)
                alert_toast("An error occurred", 'error');
            }
        }
    });
}

// Ensure these functions (uni_modal, start_load, alert_toast) are defined to handle modal displays, loading animations, and toast messages.
</script>
