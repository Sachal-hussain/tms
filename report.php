
    <?php include "db_connect.php" ?>



   <div class="col-lg-12">
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active tab-style" id="tab1" data-toggle="tab" href="#tab-content1">OverAll Search</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-style" id="tab2" data-toggle="tab" href="#tab-content2">Search By Employee</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-style" id="tab3" data-toggle="tab" href="#tab-content3">Page Wise Report</a>
        </li>
    </ul>
    <div class="tab-content">
        <!-- Tab 1 Content -->
        <div class="tab-pane fade show active" id="tab-content1">
            <div class="card">
                <div class="card-body">
                    <form action="" id="manage_employee">
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                        <div class="row">
                            <div class="col-md-6 border-right">  
                                <div class="form-group">
                                    <label for="">Select Pages</label>
                                    <select name="page_id" id="page_id" class="form-control form-control-sm" required="">
                                        <option value=""></option>
                                        <?php 
                                        $pages = $conn->query("SELECT *,concat(pagename) as name FROM pages ORDER BY concat(pagename) ASC");
                                        while ($row = $pages->fetch_assoc()):
                                            ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($page_id) && $page_id == $row['id'] ? 'selected' : ''; ?>>
                                                <?php echo $row['pagename'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group" >
                                    <label for="">Select Department</label>
                                    <select name="department_id" id="department_id" class="form-control form-control-sm " required="">
                                        <option value=""></option>
                                        <?php 
                                        $departments = $conn->query("SELECT * FROM department_list order by department asc");
                                        while($row=$departments->fetch_assoc()):
                                            ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['department'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">  
                                <div class="form-group" >
                                    <label for="date_from">Date From</label>
                                    <input type="date" id="date_from" name="date_from" class="form-control form-control-sm">
                                </div>
                                <div class="form-group">
                                    <label for="date_to">Date To</label>
                                    <input type="date" id="date_to" name="date_to" class="form-control form-control-sm">
                                </div>
                                <div class="form-group" style="text-align: center; margin-top: 20px;">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-outline card-success">
                                    <div class="card-body">
                                        <table class="table table-hover table-condensed" id="list">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Page Name</th>
                                                    <th>Task</th>
                                                    <th>Last Update</th>
                                                    <th>Assigned To</th>
                                                    <th>Assigned By</th>
                                                    <th>Status</th>
                                                    <th>Posts</th>
                                                    <th>Stories</th>
                                                </tr>
                                            </thead>
                                            <tbody id="search_lists">
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tab 2 Content -->
        <div class="tab-pane fade" id="tab-content2">
            <div class="card">
                <div class="card-body">
                    <form action="" id="fetch_employee">
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                        <div class="row">
                            <div class="col-md-6 border-right">  
                                <div class="form-group">
                                    <label for="">Select Employee</label>
                                    <select name="employee_id" id="employee_id" class="form-control form-control-sm" required>
                                        <option value=""></option>
                                        <?php 
                                        $employees = $conn->query("SELECT *,concat(firstname) as name FROM employee_list order by concat(firstname) asc");
                                        while($row=$employees->fetch_assoc()):
                                            ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($employee_id) && $employee_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">  
                                <div class="form-group" >
                                    <label for="date_from">Date From</label>
                                    <input type="date" id="date_from" name="date_from" class="form-control form-control-sm">
                                </div>
                                <div class="form-group">
                                    <label for="date_to">Date To</label>
                                    <input type="date" id="date_to" name="date_to" class="form-control form-control-sm">
                                </div>
                                <div class="form-group" style="text-align: center; margin-top: 20px;">
                                    <button type="button" class="btn btn-secondary">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-outline card-success">
                                    <div class="card-body">
                                        <table class="table table-hover table-condensed" id="Data">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Page Name</th>
                                                    <th>Task</th>
                                                    <th>Last Update</th>
                                                    <th>Assigned To</th>
                                                    <th>Assigned By</th>
                                                    <th>Status</th>
                                                    <th>Posts</th>
                                                    <th>Stories</th>
                                                </tr>
                                            </thead>
                                            <tbody id="search_tasks">
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tab 3 Content -->
        <div class="tab-pane fade" id="tab-content3">
            <div class="card">
                <div class="card-body">
                    <form action="" id="manage_pages">
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                        <div class="row">
                            <div class="col-md-6">  
                                <div class="form-group">
                                    <label for="">Select Pages</label>
                                    <select name="page_id" id="page_id" class="form-control form-control-sm" required="">
                                        <option value=""></option>
                                        <?php 
                                        $pages = $conn->query("SELECT *,concat(pagename) as name FROM pages ORDER BY concat(pagename) ASC");
                                        while ($row = $pages->fetch_assoc()):
                                            ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($page_id) && $page_id == $row['id'] ? 'selected' : ''; ?>>
                                                <?php echo $row['pagename'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group" style="text-align: center; margin-top: 20px;">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-outline card-success">
                                    <div class="card-body">
                                        <table class="table table-hover table-condensed" id="pagelist">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Page Name</th>
                                                    <th>Task</th>
                                                    <th>Last Update</th>
                                                    <th>Assigned To</th>
                                                    <th>Assigned By</th>
                                                    <th>Status</th>
                                                    <th>Posts</th>
                                                    <th>Stories</th>
                                                </tr>
                                            </thead>
                                          
                                            <tbody id="search_data">
                                                <!-- Data will be dynamically inserted here by the PHP script -->
                                            </tbody>

                                                 <tfoot>
                                                    <tr>
                                                        <th colspan="7" class="text-right">Total:</th>
                                                        <th id="totalPosts">0</th>
                                                        <th id="totalStories">0</th>
                                                    </tr>
                                                </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
        /* Custom CSS for rectangular-shaped tabs with hover effect */
        .nav-tabs .nav-item .nav-link.tab-style {
            border-radius: 0;
            border-color: transparent;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease;
            font-size: 15px; /* Set font size to 20px */
            font-weight: bold; /* Make text bold */
            padding: 10px 20px; /* Add padding for spacing */
        }

        .nav-tabs .nav-item .nav-link.tab-style:hover {
            background-color: #21252; /* Change background color to black on hover */
            color: white; /* Change text color to white on hover */
        }

        .nav-tabs .nav-item .nav-link.active.tab-style {
            background-color: #21252; /* Change background color to black when active */
            color: white; /* Change text color to white when active */
        }

        /* Adjust margin between tabs */
        .nav-tabs .nav-item {
            margin-right: 10px; /* Adjust as needed */
        }
    </style>
    <style>
        img#cimg {
            height: 15vh;
            width: 15vh;
            object-fit: cover;
            border-radius: 100% 100%;
        }
    </style>

    
 <script>
$(document).ready(function() {
    // Tab 1 form submission
    $('#manage_employee').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'filter_tasks.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if ($.fn.DataTable.isDataTable('#list')) {
                    $('#list').DataTable().clear().destroy();
                }
                $('#search_lists').html(response);

                // Initialize DataTable
                $('#list').DataTable({
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();
                        var totalPosts = api.column(7).data().reduce(function(a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);
                        var totalStories = api.column(8).data().reduce(function(a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);
                        $(api.column(7).footer()).html(totalPosts);
                        $(api.column(8).footer()).html(totalStories);
                    }
                });
            },
            error: function() {
                console.error('Error retrieving data for Tab 1.');
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    // Tab 2 button click
    $('.btn-secondary').on('click', function(e) {
        e.preventDefault();
        if ($('#fetch_employee')[0].checkValidity()) {
            var formData = $('#fetch_employee').serialize();

            $.ajax({
                url: 'display_tasks.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('#Data')) {
                        $('#Data').DataTable().clear().destroy();
                    }
                    $('#search_tasks').html(response);

                    // Initialize DataTable
                    $('#Data').DataTable();
                },
                error: function() {
                    console.error('Error retrieving data for Tab 2.');
                }
            });
        } else {
            $('#fetch_employee')[0].reportValidity();
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('#manage_pages').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'fetch_data.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() != '') {
                    // If DataTable is already initialized, destroy it
                    if ($.fn.DataTable.isDataTable('#pagelist')) {
                        $('#pagelist').DataTable().clear().destroy();
                    }
                    
                    // Populate the table with new data
                    $('#search_data').html(response);

                    // Initialize DataTable
                    $('#pagelist').DataTable({
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api();

                            // Calculate the total posts and stories
                            var totalPosts = api.column(7).data().reduce(function(a, b) {
                                return parseInt(a) + parseInt(b);
                            }, 0);
                            var totalStories = api.column(8).data().reduce(function(a, b) {
                                return parseInt(a) + parseInt(b);
                            }, 0);

                            // Update the footer with the totals
                            $(api.column(7).footer()).html(totalPosts);
                            $(api.column(8).footer()).html(totalStories);
                        }
                    });
                } else {
                    $("#search_data").html("<tr><td colspan='9' class='text-center'>No tasks found.</td></tr>");
                }
            },
            error: function() {
                alert('Error retrieving data for Tab 3.');
            }
        });
    });

    $('#page_id').on('change', function() {
        var page_id = $(this).val();

        $.ajax({
            url: 'fetch_data.php',
            type: 'POST',
            data: { page_id: page_id },
            success: function(response) {
                $('#search_data').html(response);

                if ($.fn.DataTable.isDataTable('#pagelist')) {
                    $('#pagelist').DataTable().clear().destroy();
                }

                // Initialize DataTable
                $('#pagelist').DataTable({
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();

                        // Calculate the total posts and stories
                        var totalPosts = api.column(7).data().reduce(function(a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);
                        var totalStories = api.column(8).data().reduce(function(a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);

                        // Update the footer with the totals
                        $(api.column(7).footer()).html(totalPosts);
                        $(api.column(8).footer()).html(totalStories);
                    }
                });
            },
            error: function() {
                alert('Error retrieving data for Tab 3.');
            }
        });
    });
});

</script>





    </body>
    <html>








