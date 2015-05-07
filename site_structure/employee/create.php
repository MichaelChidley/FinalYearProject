<?php

$objTeam = new Team($API);
$arrTeams = $API->convertJsonArrayToArray($objTeam->getAllTeams());
$arrTeams = $arrTeams['response'];

$arrAccountLevels = $API->convertJsonArrayToArray($objEmployee->getAllAccountTypes());
$arrAccountLevels = $arrAccountLevels['response'];


if(($objEmployee->isProjectManager($accountType) || ($objEmployee->isAdmin($accountType))))
	{

//print_r($arrTeams);
?>

<div class='headingBlock'>Add Employee</div>
<div class="row-fluid contentOffsetTop">


	<form id='addEmployeeForm' name='addEmployee' onsubmit="return false;">

		<table class="table addEmployeeTable">

			<tr>
				<td><div class="fourthLevelHeading">Firstname</div></td>
				<td><input type='text' formMaxLength='50' name='employeeFirstname'></td>

				<td><div class="fourthLevelHeading">Lastname</div></td>
				<td><input formMaxLength='50' name='employeeLastname'></td>
			</tr>


			<tr>
				<td><div class="fourthLevelHeading">Email</div></td>
				<td><input type='text' formMaxLength='150' formDataType="email" name='employeeEmail'></td>

				<td><div class="fourthLevelHeading">Password</div></td>
				<td><input type='password' formMaxLength='50' name='employeePassword'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">DOB</div></td>
				<td><input type='text' formMaxLength='10' name='employeeDOB'></td>

				<td><div class="fourthLevelHeading">Home Number</div></td>
				<td><input type='text' formMaxLength='25' formDataType="number" name='employeeHomeNumber'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">Mobile Number</div></td>
				<td><input type='text' formMaxLength='25' formDataType="number" name='employeeMobileNumber'></td>

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

			<tr>
				<td><div class="fourthLevelHeading">Account Type</div></td>
				<td>
				<select name='employeeAccountLevel'>
					<?php
						foreach($arrAccountLevels as $arrIndAccountLevels)
						{
							if($arrIndAccountLevels['accounttypeID'] != 1)
							{
								echo "<option name=".$arrIndAccountLevels['accounttypeID'].">".$arrIndAccountLevels['accountType']."</option>";
							}
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

<?php
}
else
{
	die(header("Location: ".$configArray['FALL_BACK']));
}