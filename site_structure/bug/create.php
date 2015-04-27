<?php

if(($objEmployee->isProjectManager($accountType) || ($objEmployee->isAdmin($accountType)) || ($objEmployee->isDeveloper($accountType))))
	{

?>

<div class='headingBlock'>Create Bug</div>
<div class="row-fluid contentOffsetTop">


	<form id='createBugForm' name='createBug' onsubmit="return false;">

		<table class="table createBugTable">

			<tr>
				<td><div class="fourthLevelHeading">Title</div></td>
				<td><input type='text' name='bugTitle' formMaxLength='50'></td>

				<td><div class="fourthLevelHeading">Description</div></td>
				<td><textarea name='bugDescription' formMaxLength='200'></textarea></td>
			</tr>


			<tr>
				<td><div class="fourthLevelHeading">Project</div></td>
				<td>
					<select name="bugProjectID">
						<?php

							foreach($arrProjects as $arrIndProjects)
							{
								echo "<option name=".$arrIndProjects['projectID'].">".$arrIndProjects['projectTitle']."</option>";
							}

						?>
					</select>
				</td>

				<td><div class="fourthLevelHeading">Bug Line</div></td>
				<td><input type='text' name='bugLine' formDataType="number" formMaxLength='100000000'></td>


			</tr>

		</table>

	</form>

	<button id='btnCreateBug'>Create</button>


	<div class='clear'></div>
</div>

<?php
}
else
{
	die(header("Location: ".$configArray['FALL_BACK']));
}