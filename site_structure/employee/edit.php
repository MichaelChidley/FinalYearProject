<?php

$objTeam = new Team($API);
$arrTeams = $API->convertJsonArrayToArray($objTeam->getAllTeams());
$arrTeams = $arrTeams['response'];

$arrUserDetails = $API->convertJsonArrayToArray($objEmployee->getSingleEmployee($intGetID));
$arrUserDetails = $arrUserDetails['response'];


//print_r($arrUserDetails);
?>

<div class='headingBlock'>Edit Employee</div>
<div class="row-fluid contentOffsetTop">


	<form id='eddEmployeeForm' name='editEmployee' onsubmit="return false;">

		<table class="table eddEmployeeTable">

			<tr>
				<td><div class="fourthLevelHeading">Firstname</div></td>
				<td><input type='text' name='employeeFirstname' value=<?=$arrUserDetails['firstname'];?>></td>

				<td><div class="fourthLevelHeading">Lastname</div></td>
				<td><input name='employeeLastname' value=<?=$arrUserDetails['lastname'];?>></td>
			</tr>


			<tr>
				<td><div class="fourthLevelHeading">Email</div></td>
				<td><input type='text' name='employeeEmail' value=<?=$arrUserDetails['email'];?>></td>

				<td><div class="fourthLevelHeading">Password</div></td>
				<td><input type='password' name='employeePassword'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">DOB</div></td>
				<td><input type='text' name='employeeDOB' value=<?=$arrUserDetails['dob'];?>></td>

				<td><div class="fourthLevelHeading">Home Number</div></td>
				<td><input type='text' name='employeeHomeNumber' value=<?=$arrUserDetails['homenumber'];?>></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">Mobile Number</div></td>
				<td><input type='text' name='employeeMobileNumber' value=<?=$arrUserDetails['mobilenumber'];?>></td>
<!--
				<td><div class="fourthLevelHeading">Team</div></td>
				<td>
				<select name='employeeTeam'>
					<?php
						foreach($arrTeams as $arrIndTeams)
						{
							//echo "<option ";
							//if($arrIndTeamname=".$arrIndTeams['teamID'].">".$arrIndTeams['teamTitle']."</option>";
						}
					?>
				</select>
				</td>
				-->
			</tr>

		</table>

	</form>

	<div style='margin-top: 20px;float: left;'><button class="btn btn-primary" id='updateEmployee'>Update Employee</button></div>



	<div class='clear'></div>
</div>