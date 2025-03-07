<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
    $where = " where d.id = {$_GET['id']}";
    $qry = $conn->query("SELECT d.id,d.employee_id,d.page_id,d.task,d.date,d.status,e.id as employeeid,e.firstname,p.id as pageid,p.pagename
                        FROM daily_tasks d
                        INNER JOIN employee_list e
                        ON e.id=d.employee_id
                        INNER JOIN pages p
                        ON p.id=d.page_id $where ORDER BY id DESC");
    if ($qry->num_rows > 0){
        while($row= $qry->fetch_assoc()){
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-6">
                <dl>
                    <dt><b class="border-bottom border-primary">Task</b></dt>
                    <dd><?php echo $row['task'] ?></dd>
                </dl>
				<dl>
					<dt><b class="border-bottom border-primary">Page Name</b></dt>
					<dd><?php echo $row['pagename'] ?></dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Employee</b></dt>
					<dd><?php echo $row['firstname'] ?></dd>
				</dl>

				<dl>
					<dt><b class="border-bottom border-primary">Date</b></dt>
					<dd><?php echo $row['date'] ?></dd>
				</dl>
            </div>
        </div>
    </div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
	#post-field{
		max-height: 70vh;
		overflow: auto;
	}
</style>
<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<?php
        }
    }
}
?>
