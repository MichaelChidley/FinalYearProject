<?php

if(($objEmployee->isDeveloper($_SESSION['authenticationID']) || ($objEmployee->isAdmin($_SESSION['authenticationID'])) || ($objEmployee->isProjectManager($_SESSION['authenticationID']))))
	  	{

?>

<div class='headingBlock'>Create Team</div>
<div class="row-fluid contentOffsetTop">


	<form id='createTeamForm' name='createTeam' onsubmit="return false;">

		<table class="table createTeamTable">

			<tr>
				<td><div class="fourthLevelHeading">Title</div></td>
				<td><input type='text' name='teamTitle' formMaxLength='50'></td>

				<td><div class="fourthLevelHeading">Description</div></td>
				<td><textarea name='teamDescription' formMaxLength='200'></textarea></td>
			</tr>

		</table>

	</form>

	<button class="btn btn-primary btnCreateTeam">Create Team</button>


	<div class='clear'></div>
</div>

<?php
}
else
{
	die(header("Location: ".$configArray['FALL_BACK']));
}