<?php //echo $_SESSION['login_department_id']?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_evaluator">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
                   <?php
                    $firstname= $_SESSION["login_firstname"];
                    $department_id= $_SESSION["login_department_id"];
                    if($_SESSION["login_firstname"]=='Muhammad Arham')
                    {?>
                    
                    <div>
                            
                        <label>1. Making Hourly Update:</label>
                        <input type="radio" name="hourlyUpdate" value="yes"> Yes
                        <input type="radio" name="hourlyUpdate" value="no"> No
                    </div>
                    <div>
                        <label>2. Shift End Update:</label>
                        <input type="radio" name="shiftEndUpdate" value="yes"> Yes
                        <input type="radio" name="shiftEndUpdate" value="no"> No
                    </div>
                    <div>
                        <label>3. Keeping record of Attendance:</label>
                        <input type="radio" name="recordAttendance" value="yes"> Yes
                        <input type="radio" name="recordAttendance" value="no"> No
                    </div>
                    <div>
                        <label>4. Making Schedule of agents:</label>
                        <input type="radio" name="scheduleAgents" value="yes"> Yes
                        <input type="radio" name="scheduleAgents" value="no"> No
                    </div>
                    <div>
                        <label>5. Dealing with client issues:</label>
                        <input type="radio" name="clientIssues" value="yes"> Yes
                        <input type="radio" name="clientIssues" value="no"> No
                    </div>
                    <div>
                        <label>6. Checking chats and comments:</label>
                        <input type="radio" name="chatsComments" value="yes"> Yes
                        <input type="radio" name="chatsComments" value="no"> No
                    </div>
                    <div>
                        <label>7. Making salaries of agents:</label>
                        <input type="radio" name="salariesAgents" value="yes"> Yes
                        <input type="radio" name="salariesAgents" value="no"> No
                    </div>
                    <div>
                        <label>8. Making coordination with the IT team for floor issues:</label>
                        <input type="radio" name="itCoordination" value="yes"> Yes
                        <input type="radio" name="itCoordination" value="no"> No
                    </div>
                    <div>
                        <label>9. Solving agents issues related to works, salaries, and schedule:</label>
                        <input type="radio" name="agentsIssues" value="yes"> Yes
                        <input type="radio" name="agentsIssues" value="no"> No
                    </div>
                    <div>
                        <label>10. Solving issues related to redeem department (cashapp login etc):</label>
                        <input type="radio" name="redeemIssues" value="yes"> Yes
                        <input type="radio" name="redeemIssues" value="no"> No
                    </div>
                    <div>
                        <label>11. Checking page EOD.s and Updates:</label>
                        <input type="radio" name="pageEODs" value="yes"> Yes
                        <input type="radio" name="pageEODs" value="no"> No
                    </div>
                
                    <?php }
                   elseif($_SESSION["login_firstname"]=='Nouman Shahid')
                   {?>
                        <div>
                        <label>1. Attendance:</label>
                        <input type="radio" name="attendance" value="yes"> Yes
                        <input type="radio" name="attendance" value="no"> No
                    </div>
                    <div>
                        <label>2. Hourly updates :</label>
                        <input type="radio" name="updates" value="yes"> Yes
                        <input type="radio" name="updates" value="no"> No
                    </div>
                    <div>
                        <label>3. Comments:</label>
                        <input type="radio" name="comments" value="yes"> Yes
                        <input type="radio" name="comments" value="no"> No
                    </div>
                    <div>
                        <label>4. Shift end shift start update :</label>
                        <input type="radio" name="shiftupdate" value="yes"> Yes
                        <input type="radio" name="shiftupdate" value="no"> No
                    </div>
                    <div>
                        <label>5. Clients calls :</label>
                        <input type="radio" name="calls" value="yes"> Yes
                        <input type="radio" name="calls" value="no"> No
                    </div>
                    <div>
                        <label>6. Qc issues :</label>
                        <input type="radio" name="Qcissues" value="yes"> Yes
                        <input type="radio" name="Qcissues" value="no"> No
                    </div>
                    <div>
                        <label>7. Shift issues :</label>
                        <input type="radio" name="shiftissues" value="yes"> Yes
                        <input type="radio" name="shiftissues" value="no"> No
                    </div>
                    <div>
                        <label>8. Salary:</label>
                        <input type="radio" name="salary" value="yes"> Yes
                        <input type="radio" name="salary" value="no"> No
                    </div>
                    <div>
                        <label>9. Off days manage :</label>
                        <input type="radio" name="offdays" value="yes"> Yes
                        <input type="radio" name="offdays" value="no"> No
                    </div>
                    <div>
                        <label>10. All pages EOD's:</label>
                        <input type="radio" name="pageEODs" value="yes"> Yes
                        <input type="radio" name="pageEODs" value="no"> No
                    </div>
                
                   <?php }
                   elseif($_SESSION["login_firstname"]=='Muhammad Ahad')
                   {?>  
                         
                         
                
			
			<hr>

								
			<div>
                <label>1. Send hourly shift updates:</label>
                <input type="radio" name="shiftupdate" value="yes"> Yes
                <input type="radio" name="shiftupdate" value="no"> No
            </div>
			<div>
                <label>2. Update unprocessed redeems of the shift:</label>
                <input type="radio" name="redeem" value="yes"> Yes
                <input type="radio" name="redeem" value="no"> No
            </div>
			<div>
                <label>3. Handle Client issues:</label>
                <input type="radio" name="client" value="yes"> Yes
                <input type="radio" name="client" value="no"> No
            </div>
			<div>
                <label>4. Handle redeems issues:</label>
                <input type="radio" name="handleissues" value="yes"> Yes
                <input type="radio" name="handleissues" value="no"> No
            </div>
			<div>
                <label>5. Handle QC issues:</label>
                <input type="radio" name="qcissues" value="yes"> Yes
                <input type="radio" name="qcissues" value="no"> No
            </div>
			<div>
                <label>6. Handle agent issues:</label>
                <input type="radio" name="agentissues" value="yes"> Yes
                <input type="radio" name="agentissues" value="no"> No
            </div>
			<div>
                <label>7. Clear comments on each page hourly:</label>
                <input type="radio" name="pagehourly" value="yes"> Yes
                <input type="radio" name="pagehourly" value="no"> No
            </div>
			<div>
                <label>8. Check with the Graphic Designer if there is any request from the client:</label>
                <input type="radio" name="clientcheck" value="yes"> Yes
                <input type="radio" name="clientcheck" value="no"> No
            </div>
			<div>
                <label>9. Send shift end EOD:</label>
                <input type="radio" name="pageEODs" value="yes"> Yes
                <input type="radio" name="pageEODs" value="no"> No
            </div>
			<hr>
            <?php }
                   elseif($_SESSION["login_firstname"]=='Muhammad Mubashir')
                   {?>  
			<div>
                <label>1. Did backup of lucky penny, Horn play and danny's :</label>
                <input type="radio" name="backup" value="yes"> Yes
                <input type="radio" name="backup" value="no"> No
            </div>
			<div>
                <label>2. Did cashouts for Danny's:</label>
                <input type="radio" name="cashout" value="yes"> Yes
                <input type="radio" name="cashout" value="no"> No
            </div>
			<div>
                <label>3. Did cashouts for Shakoor:</label>
                <input type="radio" name="shakoor" value="yes"> Yes
                <input type="radio" name="shakoor" value="no"> No
            </div>
			<div>
                <label>4. Paid redeems of other pages:</label>
                <input type="radio" name="redeem" value="yes"> Yes
                <input type="radio" name="redeem" value="no"> No
            </div>
			<hr>
            <?php }
                   elseif($_SESSION["login_firstname"]=='Sobia Rehman')
                   {?>
			<div>
                <label>1. Updating sheets:</label>
                <input type="radio" name="updatesheet" value="yes"> Yes
                <input type="radio" name="updatesheet" value="no"> No
           </div>
		   <div>
                <label>2. Maintain Coordination among the team:</label>
                <input type="radio" name="team" value="yes"> Yes
                <input type="radio" name="team" value="no"> No
           </div>
		   <div>
                <label>3. Resolving conflicts:</label>
                <input type="radio" name="conflict" value="yes"> Yes
                <input type="radio" name="conflict" value="no"> No
           </div>
		   <div>
                <label>4. Hiring Platforms:</label>
                <input type="radio" name="platform" value="yes"> Yes
                <input type="radio" name="platform" value="no"> No
           </div>
		   <div>
                <label>5. Scheduling meetings:</label>
                <input type="radio" name="meeting" value="yes"> Yes
                <input type="radio" name="meeting" value="no"> No
           </div>
		   <div>
                <label>6. Answering messages and emails:</label>
                <input type="radio" name="emails" value="yes"> Yes
                <input type="radio" name="emails" value="no"> No
           </div>
		   <div>
                <label>7. Maintaing office decorum:</label>
                <input type="radio" name="decorum" value="yes"> Yes
                <input type="radio" name="decorum" value="no"> No
           </div>
		
				
				</div>
				<hr>
                <?php }
                   elseif($_SESSION["login_firstname"]=='Mujtaba Habib')
                   {?>
						<div class="col-md-6">
						
			<div>
                <label>1. Agents Issues regarding shift and regarding work:</label>
                <input type="radio" name="issues" value="yes"> Yes
                <input type="radio" name="issues" value="no"> No
           </div>
		   <div>
                <label>2. Agent Attendance issues:</label>
                <input type="radio" name="agent" value="yes"> Yes
                <input type="radio" name="agent" value="no"> No
           </div>
		   <div>
                <label>3. Client Handling (Client issues, calls, cashouts, cashapp issues):</label>
                <input type="radio" name="cashup" value="yes"> Yes
                <input type="radio" name="cashup" value="no"> No
           </div>
		   <div>
                <label>4. System issues:</label>
                <input type="radio" name="systemissues" value="yes"> Yes
                <input type="radio" name="systemissues" value="no"> No
           </div>
		   <div>
                <label>5. Internet Issues:</label>
                <input type="radio" name="internetissues" value="yes"> Yes
                <input type="radio" name="internetissues" value="no"> No
           </div>
		   <div>
                <label>6. Floor management:</label>
                <input type="radio" name="floor" value="yes"> Yes
                <input type="radio" name="floor" value="no"> No
           </div>
		   <div>
                <label>7. Weekly schedule (weekly offs):</label>
                <input type="radio" name="weeklyschedule" value="yes"> Yes
                <input type="radio" name="weeklyschedule" value="no"> No
           </div>
		   <div>
                <label>8. Customer issues:</label>
                <input type="radio" name="customer" value="yes"> Yes
                <input type="radio" name="customer" value="no"> No
           </div>
		   <div>
                <label>9. Verify Customer game play:</label>
                <input type="radio" name="gameplay" value="yes"> Yes
                <input type="radio" name="gameplay" value="no"> No
           </div>
		   <div>
                <label>10. Verify customer deposit issues:</label>
                <input type="radio" name="deposit" value="yes"> Yes
                <input type="radio" name="deposit" value="no"> No
           </div>
		   <div>
                <label>11. Bonus approval for customers:</label>
                <input type="radio" name="bonus" value="yes"> Yes
                <input type="radio" name="bonus" value="no"> No
           </div>
		   <div>
                <label>12. Double check Agents updates and EOD’s:</label>
                <input type="radio" name="pageEODs" value="yes"> Yes
                <input type="radio" name="pageEODs" value="no"> No
           </div>
		   <div>
                <label>13. Facebook comments:</label>
                <input type="radio" name="facebook" value="yes"> Yes
                <input type="radio" name="facebook" value="no"> No
           </div>
		   
		   <div>
                <label>14. Final redeem approval:</label>
                <input type="radio" name="finalredeem" value="yes"> Yes
                <input type="radio" name="finalredeem" value="no"> No
           </div>
		   <div>
                <label>15. Agents shuffling on systems:</label>
                <input type="radio" name="shuffleagent" value="yes"> Yes
                <input type="radio" name="shuffleagent" value="no"> No
           </div>
		   <div>
                <label>16. Bonus Messages in Facebook groups for different pages:</label>
                <input type="radio" name="pages" value="yes"> Yes
                <input type="radio" name="pages" value="no"> No
           </div>
		   <div>
                <label>17. Agents and Customers chats issue from (QC department):</label>
                <input type="radio" name="chatissue" value="yes"> Yes
                <input type="radio" name="chatissue" value="no"> No
           </div>
		   <div>
                <label>18. Agents and Customers redeems issues:</label>
                <input type="radio" name="agent" value="yes"> Yes
                <input type="radio" name="agent" value="no"> No
           </div>
		   <hr>
           <?php }
                   elseif($_SESSION["login_firstname"]=='Pervaiz')
                   {?>
		   <div>
                <label>1. System Installation , Configuration & Troubleshooting of Network:</label>
                <input type="radio" name="network" value="yes"> Yes
                <input type="radio" name="network" value="no"> No
           </div>
		   <div>
                <label>2. Provide users with technical support for computer problems:</label>
                <input type="radio" name="problem" value="yes"> Yes
                <input type="radio" name="problem" value="no"> No
           </div>
		   <div>
                <label>3. Install and configure software and hardware:</label>
                <input type="radio" name="installation" value="yes"> Yes
                <input type="radio" name="installation" value="no"> No
           </div>
		   <div>
                <label>4. Install and support LANs, WANs, network segments, Internet, and intranet systems:</label>
                <input type="radio" name="LAN" value="yes"> Yes
                <input type="radio" name="LAN" value="no"> No
           </div>
		   <div>
                <label>5. Manage Networking (Routing,Switching and Access Point):</label>
                <input type="radio" name="manage" value="yes"> Yes
                <input type="radio" name="manage" value="no"> No
           </div>
		   <div>
                <label>6. Monitor performance and maintain systems according to requirements:</label>
                <input type="radio" name="performance" value="yes"> Yes
                <input type="radio" name="performance" value="no"> No
           </div>
		   <hr>
           <?php }
                   elseif($_SESSION["login_firstname"]=='Mudassir Waseem')
                   {?>
		   <div>
                <label>1. Handling android ,anydesk issues :</label>
                <input type="radio" name="anydesk" value="yes"> Yes
                <input type="radio" name="anydesk" value="no"> No
           </div>
		   <div>
                <label>2. Handling all client issues :</label>
                <input type="radio" name="clients" value="yes"> Yes
                <input type="radio" name="clients" value="no"> No
           </div>

		   <div>
                <label>3. Managing redeem team:</label>
                <input type="radio" name="redeem" value="yes"> Yes
                <input type="radio" name="redeem" value="no"> No
           </div>

		   <div>
                <label>4. Cashapp purchasing:</label>
                <input type="radio" name="cashapp" value="yes"> Yes
                <input type="radio" name="cashapp" value="no"> No
           </div>
		   
		   <div>
                <label>5. Cashapps security (pins,mails):</label>
                <input type="radio" name="mail" value="yes"> Yes
                <input type="radio" name="mail" value="no"> No
           </div>
		   <div>
                <label>6. Doing cashouts for clients:</label>
                <input type="radio" name="cashout" value="yes"> Yes
                <input type="radio" name="cashout" value="no"> No
           </div>
		   <div>
                <label>7. Helping out ahad in handling the shift:</label>
                <input type="radio" name="handling" value="yes"> Yes
                <input type="radio" name="handling" value="no"> No
           </div>
		   <hr>
           <?php }
                   elseif($_SESSION["login_firstname"]=='Aqib Safdar')
                   {?>
		   <div>
                <label>1. Managing Managers daily issues:</label>
                <input type="radio" name="dailyissue" value="yes"> Yes
                <input type="radio" name="dailyissue" value="no"> No
           </div>
		   <div>
                <label>2. Managing all three shifts chat issues and agents:</label>
                <input type="radio" name="chatissue" value="yes"> Yes
                <input type="radio" name="chatissue" value="no"> No
           </div>
		   <div>
                <label>3. Client issues handling:</label>
                <input type="radio" name="pageEODs" value="yes"> Yes
                <input type="radio" name="pageEODs" value="no"> No
           </div>
		   <hr>
           <?php }
                   elseif($_SESSION["login_firstname"]=='Asad Ali')
                   {?>
		   <div>
                <label>1. Trainings:</label>
                <input type="radio" name="training" value="yes"> Yes
                <input type="radio" name="training" value="no"> No
           </div>
		   <div>
                <label>2. Taking care of software development:</label>
                <input type="radio" name="development" value="yes"> Yes
                <input type="radio" name="development" value="no"> No
           </div>
		   <div>
                <label>3. Reporting:</label>
                <input type="radio" name="reporting" value="yes"> Yes
                <input type="radio" name="reporting" value="no"> No
           </div>
		   <div>
                <label>4. Looking into department issues:</label>
                <input type="radio" name="department" value="yes"> Yes
                <input type="radio" name="department" value="no"> No
           </div>
		   </div>
           <?php }?>
		   <div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=evaluator_list'">Cancel</button>
				</div>

		   
		   
			
				
			</form>
			

			
		</div>
	</div>
</div>
<style>
	{
	font-family: Arial, sans-serif;
            margin: 20px;
        }
        .task {
            margin-bottom: 15px;
        }
        .task label {
            margin-right: 10px;
        }
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_evaluator').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('[name="password"]').val() != '' && $('[name="cpass"]').val() != ''){
			if($('#pass_match').attr('data-status') != 1){
				if($("[name='password']").val() !=''){
					$('[name="password"],[name="cpass"]').addClass("border-danger")
					end_load()
					return false;
				}
			}
		}
		$.ajax({
			url:'ajax.php?action=save_evaluator',
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
						location.replace('index.php?page=evaluator_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>