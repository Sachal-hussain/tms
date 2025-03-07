<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 2): ?>
  <div class="row">
    
    <div class="col-12 col-sm-6 col-md-4">
  <a href="./index.php?page=employee_list&online=active" class="nav-link nav-task_list">
    <div class="small-box bg-blue shadow-sm border" style="line-height: 0.5rem;">
      <div class="inner">
        <?php
          // Count active employees
          $resultEmployees = $conn->query("SELECT COUNT(*) AS count_active FROM employee_list WHERE online = 'active';");
          $countActiveEmployees = 0;
          if ($resultEmployees) {
            $rowEmployees = $resultEmployees->fetch_assoc();
            $countActiveEmployees = $rowEmployees['count_active'];
          }

          // Count active users
          $resultUsers = $conn->query("SELECT COUNT(*) AS count_active FROM users WHERE online = 'active';");
          $countActiveUsers = 0;
          if ($resultUsers) {
            $rowUsers = $resultUsers->fetch_assoc();
            $countActiveUsers = $rowUsers['count_active'];
          }

          // Total active users and employees
          $totalActive = $countActiveEmployees + $countActiveUsers;
        ?>
        <h3><?php echo $totalActive; ?></h3>
        <p>Online Users</p>
        
        <p>
          <span style="font-size: 1.5em; font-weight: bold;">
            <?php 
              // Get total employee count
              $employeeCount = $conn->query("SELECT COUNT(*) AS total_employees FROM employee_list")->fetch_assoc()['total_employees'];
              
              // Add 4 to the employee count
              $total = $employeeCount + 4;

              // Display the result
              echo $total;
            ?>
          </span>
          <span>Total Users</span>
        </p>
      </div>
      <div class="icon">
        <i class="fa fa-user-tie"></i>
      </div>
    </div>
  </a>
</div>

<div class="col-12 col-sm-6 col-md-4">
    <a href="./index.php?page=employee_list" class="nav-link nav-task_list">
       <div class="small-box bg-gradient-teal shadow-sm border" style="line-height: 2.25rem;">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM employee_list")->num_rows; ?></h3>
          
          <p>Total Employees</p>
          
        </div>
        <div class="icon">
          <i class="fa fa-user-friends"></i>
        </div>
      </div>
    </a>
  </div>
  
  
   <div class="col-12 col-sm-6 col-md-4">
    <a href="./index.php?page=task_list" class="nav-link nav-task_list">
       <div class="small-box bg-black bg-gradient-yellow" style="line-height: 2.25rem;">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM task_list")->num_rows; ?></h3>
          
          <p>All Tasks</p>
          
        </div>
        <div class="icon">
          <i class="fa fa-tasks"></i>
        </div>
      </div>
    </a>
  </div>
  
  <div class="col-12 col-sm-6 col-md-4">
     <a href="./index.php?page=task_list&status=completed" class="nav-link nav-task_list">
      <div class="small-box bg-gradient-cyan shadow-sm border" style="line-height: 2.25rem;">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM task_list WHERE status = '2' ")->num_rows; ?></h3>
          
          
          <p>Completed Tasks</p>
        </div>

        <div class="icon">
          <i class="fa fa-check-square"></i>

        </div>
      </div>
    </a>
  </div>
  
   <div class="col-12 col-sm-6 col-md-4">
    <a href="./index.php?page=task_list&status=approved" class="nav-link nav-task_list"> 
       <div class="small-box bg-gradient-green shadow-sm border" style="line-height: 2.25rem;">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM task_list WHERE status = '4' ")->num_rows; ?></h3>               
          
          <p>Approved Tasks</p>
        </div>

        <div class="icon">
         <i class="fa fa-list-alt"></i>

        </div>
      </div>
    </a>
  </div>


    <div class="col-12 col-sm-6 col-md-4">
      <a href="./index.php?page=task_list&status=pending" class="nav-link nav-task_list">
        <div class="small-box bg-gradient-red shadow-sm border" style="line-height: 2.25rem;">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT * FROM task_list WHERE status = '1' ")->num_rows; ?></h3>
            <p>Pending Tasks</p>
          </div>
          <div class="icon">
            <i class="fa fa-th-list"></i>
          </div>
        </div>
      </a>
    </div>
    
    
    

    
  
  <div class="col-12 col-sm-6 col-md-4">
    <a href="./index.php?page=task_list&status=on-progress" class="nav-link nav-task_list"> 
      <div class="small-box bg-gradient-pink shadow-sm border" style="line-height: 2.25rem;">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM task_list WHERE status = '0' ")->num_rows; ?></h3>               
          
          <p>Tasks On-Progress</p>
        </div>

        <div class="icon">
          <i class="fa fa-hourglass-half"></i>



        </div>
      </div>
    </a>
  </div>

 


<?php
// Define the current date and the start/end of the month
$currentDate = date('Y-m-d');
$startOfMonth = date('Y-m-01');
$endOfMonth = date('Y-m-t');

// Prepare the query
$query = "
    SELECT * 
    FROM daily_tasks 
    WHERE status = '0'
    AND date < '$currentDate'
    AND date BETWEEN '$startOfMonth' AND '$endOfMonth'
";

// Execute the query and get the count
$result = $conn->query($query);
$count = $result->num_rows;
?>
<div class="col-12 col-sm-6 col-md-4">
    <a href="./index.php?page=overdue_task&status=pending" class="nav-link nav-task_list"> 
       <div class="small-box bg-gradient-purple shadow-sm border" style="line-height: 2.25rem;">
        <div class="inner">
          <h3><?php echo $count; ?></h3>                
          
          <p>OverDue Daily Tasks</p>
        </div>

        <div class="icon">
         <i class="fa fa-list-alt fa-list-ol"></i>

        </div>
      </div>
    </a>
  </div>
 





 
  
  <div class="col-12 col-sm-6 col-md-4">
            <!-- <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM task_list")->num_rows; ?></h3>

                <p>Total Tasks</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
            </div> -->
          </div>
        </div>

      <?php else: ?>
       <div class="col-12">
        <div class="card">
          <div class="card-body">
            Welcome <?php echo $_SESSION['login_name'] ?>!
          </div>
        </div>
      </div>
      
    <?php endif; ?>
