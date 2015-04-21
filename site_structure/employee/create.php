<?php

$objTeam = new Team($API);
$arrTeams = $API->convertJsonArrayToArray($objTeam->getAllTeams());
$arrTeams = $arrTeams['response'];


//print_r($arrTeams);
?>

<div class='headingBlock'>Add Employee</div>
<div class="row-fluid contentOffsetTop">


	<form id='addEmployeeForm' name='addEmployee' onsubmit="return false;">

		<table class="table addEmployeeTable">

			<tr>
				<td><div class="fourthLevelHeading">Firstname</div></td>
				<td><input type='text' name='employeeFirstname'></td>

				<td><div class="fourthLevelHeading">Lastname</div></td>
				<td><input name='employeeLastname'></td>
			</tr>


			<tr>
				<td><div class="fourthLevelHeading">Email</div></td>
				<td><input type='text' name='employeeEmail'></td>

				<td><div class="fourthLevelHeading">Password</div></td>
				<td><input type='password' name='employeePassword'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">DOB</div></td>
				<td><input type='text' name='employeeDOB'></td>

				<td><div class="fourthLevelHeading">Home Number</div></td>
				<td><input type='text' name='employeeHomeNumber'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">Mobile Number</div></td>
				<td><input type='text' name='employeeMobileNumber'></td>

				<td><div class="fourthLevelHeading">Team</div></td>
				<td>
				<select name='employeeTeam'>
					<?php
						foreach($arrTeams as $arrIndTeams)
						{
							echo "<option name=".$arrIndTeams['teamID'].">".$arrIndTeams['teamTitle']."</option>";
						}
					?>
				</select>
				</td>
			</tr>

		</table>

	</form>

	<div style='margin-top: 20px;float: left;'><button class="btn btn-primary" id='addEmployee'>Add Employee</button></div>



	<div class='clear'></div>
</div>