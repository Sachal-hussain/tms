  
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
    <a href="./" class="brand-link">
        <?php if($_SESSION['login_type'] == 2): ?>
        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
        
         <?php else: ?>
        <h3 class="text-center p-0 m-0"><b>Employee</b></h3>
        <?php endif; ?>

    </a>
      
    </div>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> 
          <li class="nav-item dropdown">
            <a href="./index.php?page=task_list" class="nav-link nav-task_list">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                All Tasks
              </p>
            </a>
          </li>

          
          <?php if($_SESSION['login_type'] == 2): ?>
          <li class="nav-item dropdown">
            <a href="./index.php?page=department" class="nav-link nav-department">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Departments
              </p>
            </a>
          </li> 
          
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_employee">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Employees
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_employee" class="nav-link nav-new_employee tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=employee_list" class="nav-link nav-employee_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a href="./index.php?page=report" class="nav-link nav-designation">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>Reports</p>
            </a>
          </li> 
          
          <?php endif?>
          <?php if($_SESSION['login_type'] == 4): ?>
          <li class="nav-item dropdown">
            <a href="./index.php?page=page" class="nav-link nav-designation">
              <i class="nav-icon fas fa-file-alt"></i>

              <p>Pages</p>
            </a>
          </li> 
        <?php endif ?>
        
        <?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>

           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_live">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                 Live Chat Support
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_csr" class="nav-link nav-new_livechat tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_csr"class="nav-link nav-livechat_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
           <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check

  $allowed_ids = [10, 48, 149, 13];  // Allowed login IDs
if (in_array($_SESSION['login_id'], $allowed_ids) && $_SESSION['login_type'] == 0) { 
?>
    <li class="nav-item">
        <a href="#" class="nav-link nav-edit_designer">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
               Live Chat Support 
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./index.php?page=task_list_csr" class="nav-link nav-new_designer tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
        </ul>
    </li>
<?php
}
?>


<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_redeem">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Redeem Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_redeem" class="nav-link nav-new_redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_redeem"class="nav-link nav-redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
           <?php endif; ?>
        </ul>
    </li>
<?php
}  $allowed_ids = [10, 48, 149, 13, 29, 30, 49];  // Allowed login IDs
if (in_array($_SESSION['login_id'], $allowed_ids) && $_SESSION['login_type'] == 0) { 
?>
    <li class="nav-item">
            <a href="#" class="nav-link nav-edit_redeem">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Redeem Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_redeem" class="nav-link nav-new_redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
        </ul>
    </li>
<?php
}
?>

<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_redeem">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                QC Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_qc" class="nav-link nav-new_redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_qc"class="nav-link nav-redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
           <?php endif; ?>
        </ul>
    </li>
<?php
} 
$allowed_ids = [10, 48, 149, 13];  // Allowed login IDs
if (in_array($_SESSION['login_id'], $allowed_ids) && $_SESSION['login_type'] == 0) { 
?>
    <li class="nav-item">
            <a href="#" class="nav-link nav-edit_redeem">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                QC Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_qc" class="nav-link nav-new_redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
        </ul>
    </li>
<?php
}
?>

<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_redeem">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Developers Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_developer" class="nav-link nav-new_redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_developer"class="nav-link nav-redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
           <?php endif; ?>
        </ul>
    </li>
<?php
}  $allowed_ids = [50, 148, 147];  // Allowed login IDs
if (in_array($_SESSION['login_id'], $allowed_ids) && $_SESSION['login_type'] == 0) { 
?>
    <li class="nav-item">
            <a href="#" class="nav-link nav-edit_redeem">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Developers Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_developer" class="nav-link nav-new_redeem tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
        </ul>
    </li>
<?php
}
?>

      <?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
    <li class="nav-item">
        <a href="#" class="nav-link nav-edit_designer">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                Graphic Designing 
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
           
            <li class="nav-item">
                <a href="./index.php?page=task_list_designer" class="nav-link nav-new_designer tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
            <?php if ($show_daily_tasks): ?>
            <li class="nav-item">
                <a href="./index.php?page=daily_task_designer" class="nav-link nav-designer_list tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Daily Tasks</p>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check
if ($_SESSION['login_id'] == 143 && $_SESSION['login_type'] == 0) { 
?>

    <li class="nav-item">
        <a href="#" class="nav-link nav-edit_designer">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                Graphic Designing 
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./index.php?page=task_list_designer" class="nav-link nav-new_designer tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="./index.php?page=daily_task_designer" class="nav-link nav-designer_list tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Daily Tasks</p>
                </a>
            </li>
        </ul>
    </li>
    
    
    <?php
} // end if login_type check
if ($_SESSION['login_id'] == 147 && $_SESSION['login_type'] == 0) { 
?>

    <li class="nav-item">
        <a href="#" class="nav-link nav-edit_designer">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                Graphic Designing 
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./index.php?page=task_list_designer" class="nav-link nav-new_designer tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
        </ul>
    </li>
    
    <?php
} // end if login_type check
if ($_SESSION['login_id'] == 148 && $_SESSION['login_type'] == 0) { 
?>

    <li class="nav-item">
        <a href="#" class="nav-link nav-edit_designer">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                Graphic Designing 
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./index.php?page=task_list_designer" class="nav-link nav-new_designer tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
        </ul>
    </li>

<?php
} // end if for login_id = 31 and login_type = 0
?>

<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>

    <li class="nav-item">
        <a href="#" class="nav-link nav-edit_it">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                IT Department
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./index.php?page=task_list_it" class="nav-link nav-new_it tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>
            <?php if ($show_daily_tasks): ?>
            <li class="nav-item">
                <a href="./index.php?page=daily_task_it" class="nav-link nav-it_list tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Daily Tasks</p>
                </a>
            </li>
       <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check
if ($_SESSION['login_id'] == 16 && $_SESSION['login_type'] == 0) {
?>

<li class="nav-item">
        <a href="#" class="nav-link nav-edit_it">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                IT Department
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./index.php?page=task_list_it" class="nav-link nav-new_it tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>All Tasks</p>
                </a>
            </li>

<?php
} // end if for login_id = 16 and login_type = 0
?>




<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>

          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_hr">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                HR Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_hr" class="nav-link nav-new_hr tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_hr"class="nav-link nav-hr_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>

           <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check
?>




<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_admin">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Admin Department
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_admin" class="nav-link nav-new_admin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_admin"class="nav-link nav-admin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
            <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check
?>

<?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_admin">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
               Marketing Department 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_marketing" class="nav-link nav-new_admin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_marketing"class="nav-link nav-admin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
            <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check
?>
    <?php
if ($_SESSION['login_type'] == 2) { // Assuming login_type is stored in session and equals 2
    $login_firstname = $_SESSION['login_firstname']; // Assuming login_firstname is stored in session

    // Determine if the current user should see the Daily Tasks option
    $show_daily_tasks = ($login_firstname != 'Sachal');

?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_admin">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
               CEO Assistant 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=task_list_CEO assistant" class="nav-link nav-new_admin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <?php if ($show_daily_tasks): ?>
              <li class="nav-item">
                <a href="./index.php?page=daily_task_CEO Assistant"class="nav-link nav-admin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Daily Tasks</p>
                </a>
              </li>
            <?php endif; ?>
        </ul>
    </li>
<?php
} // end if login_type check
?>        
          <?php //endif; ?>

           <?php if($_SESSION['login_type'] == 0): ?> 

          <li class="nav-item dropdown">
            <a href="./index.php?page=daily_task" class="nav-link nav-evaluation">
             <i class="nav-icon fas fa-list-ul"></i>
              <p>
                Daily Task
              </p>
            </a>
          </li>
          <?php endif; ?>

           <?php if($_SESSION['login_type'] == 4): ?> 

          
          <li class="nav-item">
             <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a> 
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
       <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
     
    })
  </script>