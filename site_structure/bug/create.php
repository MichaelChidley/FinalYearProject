<?php


?>

<div class='headingBlock'>Create Bug</div>
<div class="row-fluid contentOffsetTop">


	<form id='createBugForm' name='createBug' onsubmit="return false;">

		<table class="table createBugTable">

			<tr>
				<td><div class="fourthLevelHeading">Title</div></td>
				<td><input type='text' name='bugTitle'></td>

				<td><div class="fourthLevelHeading">Description</div></td>
				<td><textarea name='bugDescription'></textarea></td>
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
				<td><input type='text' name='bugLine'></td>


			</tr>

		</table>

	</form>

	<button id='btnCreateBug'>Create</button>


	<div class='clear'></div>
</div>