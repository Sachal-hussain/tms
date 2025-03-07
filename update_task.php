<?php 
session_start();
include 'db_connect.php';
$date_created = date('Y-m-d H:i:s');
if(isset($_GET['id'])){

    $qry = $conn->query("SELECT * FROM daily_tasks where id = ".$_GET['id'])->fetch_array();
    foreach($qry as $k => $v){
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-task">
        
        <input type="hidden" name="assigned_by" value="<?php echo $_SESSION['login_id'] ?>">
        <input type="hidden" name="daily_task" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="date_created" value="<?php echo $date_created; ?>">
        

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Task</label>
                        <input type="text" class="form-control form-control-sm" name="task" value="<?php echo isset($task) ? $task : '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="employee_id">Assign To</label>
                        <select name="employee_id[]" id="employee_id" class="form-control form-control-sm" multiple required="">
                            <option value=""></option>
                            <?php 
                            // $employee_id = is_array($employee_id) ? $employee_id : explode(',', $employee_id);
                            if (!is_array($employee_id)) {
                                $employee_id = explode(',', $employee_id);
                            }

                            $employees = $conn->query("SELECT *,firstname as name FROM employee_list order by firstname asc");
                            while($row=$employees->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['id'] ?>" <?php //echo isset($employee_id) && in_array($row['id'], $employee_id) ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>

                        </select>
                    </div>
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
                    
                    <div class="form-group">
                        <label for="">Due Date</label>
                        <input type="date" class="form-control form-control-sm" name="due_date" value="<?php echo isset($due_date) ? $due_date : date("Y-m-d") ?>" required>
                    </div>
                </div>
                

                <div class="col-md-7">
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
                            <?php echo isset($description) ? $description : '' ?>
                        </textarea>
                    </div>
                    
                </div>
                
            </div>
        </div>
        
        
    </form>
</div>
<script>
    $(document).ready(function(){

        $('#employee_id').select2({
            placeholder:'Please Employee',
            width:'100%'
        })

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
    })
    
    $('#manage-task').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_task',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp == 1){
                    alert_toast('Data successfully saved',"success");
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    })
</script>