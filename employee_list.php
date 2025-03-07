<?php
include 'db_connect.php';

$onlineFilter = isset($_GET['online']) ? $_GET['online'] : '';

// Construct the query based on the filter
$query = "SELECT *, CONCAT(firstname, ' ', lastname, ' ', middlename) AS name FROM employee_list";
if ($onlineFilter === 'active') {
    $query .= " WHERE online = 'active'";
}
$query .= " ORDER BY CONCAT(lastname, ', ', firstname, ' ', middlename) ASC";

// Execute the query
$result = $conn->query($query);
?>

<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <!--<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_employee"><i class="fa fa-plus"></i> Add New Employee</a>-->
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $designations = $conn->query("SELECT * FROM designation_list ");
                    while ($row = $designations->fetch_assoc()) {
                        // $design_arr[$row['id']] = $row['designation'];
                    }
                    $departments = $conn->query("SELECT * FROM department_list ");
                    $dept_arr[0] = "Unset";
                    while ($row = $departments->fetch_assoc()) {
                        $dept_arr[$row['id']] = $row['department'];
                    }

                    // Fetch and display the filtered results
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <th class="text-center"><?php echo $i++ ?></th>
                            <td><b><?php echo ucwords($row['name']) ?></b></td>
                            <td><b><?php echo $row['email'] ?></b></td>
                            <td><b><?php echo isset($dept_arr[$row['department_id']]) ? $dept_arr[$row['department_id']] : 'Unknown Department' ?></b></td>
                            <td><b><?php echo $row['online'] ?></b></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item view_employee" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./index.php?page=edit_employee&id=<?php echo $row['id'] ?>">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_employee" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
        $(document).on('click', '.view_employee', function(){
            uni_modal("<i class='fa fa-id-card'></i> Employee Details", "view_employee.php?id=" + $(this).attr('data-id'));
        });
        $(document).on('click', '.delete_employee', function(){
            _conf("Are you sure to delete this Employee?", "delete_employee", [$(this).attr('data-id')]);
        });
    });

    function delete_employee($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_employee',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
