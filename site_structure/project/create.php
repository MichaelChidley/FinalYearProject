<?php

	$objTeam = new Team($API);

?>

<div class='headingBlock'>Create Project</div>
<div class="row-fluid contentOffsetTop">


	<div class='createProjectBlocks'>Step 1 <span class='fright' id='createProjectToggleBlockOne'>V</span></div>

	<div class='createProjectBlockContent table-responsive' id='createProjectBlockOne'>
		<table class="table createProjectTable">

			<tr>
				<td><div class="fourthLevelHeading">Title</div></td>
				<td><input type='text' name='projectTitle'></td>

				<td><div class="fourthLevelHeading">Start Date</div></td>
				<td><input type='text' name='projectStartDate'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">Description</div></td>
				<td><textarea name='projectDescription'></textarea></td>

				<td><div class="fourthLevelHeading">End Date</div></td>
				<td><input type='text' name='projectEndDate'></td>
			</tr>

			<tr>
				<td><div class="fourthLevelHeading">New Client?</div>SELECT CLIENT</td>
				<td><input type='checkbox' name='projectCreateNewClientCb'></td>

				<td><div class="fourthLevelHeading">No. Sprints</div></td>
				<td>
					<select name='projectSprints'>
						<?php
							$x = 1;
							$max = 10;

							while($x <= $max)
							{
								echo "<option value='".$x."'>".$x."</option>";

								$x++;
							}
						?>

					</select>
				</td>
			</tr>


			<tr class='projectOwnerDetails'>
				<td>Title</td>
				<td>
					<select name='projectOwnerTitle'>
						<option value='Mr'>Mr</option>
						<option value='Mrs'>Mrs</option>
						<option value='Miss'>Miss</option>
					</select>
				</td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Firstname</td>
				<td><input type='text' name='projectOwnerFirstname'></td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Lastname</td>
				<td><input type='text' name='projectOwnerLastname'></td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Email</td>
				<td><input type='text' name='projectOwnerEmail'></td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Phone</td>
				<td><input type='text' name='projectOwnerContact'></td>
			</tr>



			<tr>
				<td><div class="fourthLevelHeading">Team</div></td>
				<td>
					<select name='projectTeam'>
					<?php
						$arrTeams = $API->convertJsonArrayToArray($objTeam->getAllTeams());
						$arrTeams = $arrTeams['response'];

						foreach($arrTeams as $arrIndTeams)
						{
							echo "<option value='".$arrIndTeams['teamTitle']."'>".$arrIndTeams['teamTitle']."</option>";
						}
					?>Z

					</select>
				</td>


				<td><div class="fourthLevelHeading">Importance</div></td>
				<td>
					<select name='projectImportance'>
						<option value='low'>Low</option>
						<option value='medium'>Medium</option>
						<option value='high'>High</option>

					</select>
				</td>

			</tr>

			<tr>
				<td>
					<button id='createProjectNextStepOne'>Proceed To Next Step</button>
				</td>
			</tr>

		</table>


		</div>








		<div class='createProjectBlocks'>Step 2 <span class='fright' id='createProjectToggleBlockTwo'>V</span></div>


		<div class='createProjectBlockContent table-responsive' id='createProjectBlockTwo'>

		<table class="table createSprintInfoDetails">

			<tr>
				<td><div class="fourthLevelHeading">Total Project Days: <span id='createSprintInfoTotalPrjDays'></span></div></td>
				<td><div class="fourthLevelHeading">Total Sprints: <span id='createSprintInfoTotalSprints'></span></div></td>
				<td><div class="fourthLevelHeading">Days Per Sprint: <span id='createSprintInfoTotalSprintDays'></span></div></td>

			</tr>

		</table>


		<table class="table createSprintInfo">

			<tr>
				<th><div class="fourthLevelHeading">Backlog Item</div></th>
				<th><div class="fourthLevelHeading">MoSCoW</div></th>
				<th><div class="fourthLevelHeading">Comment</div></th>
			</tr>

			<tr class='createSprintInfoBacklogItem createSprintInfoBacklogItem_1'>
				<td><input type='text' name='backlogItem_1'></td>

				<td>
					<select name='projectSprintMoscow_1'>
						<option value='Must'>Must</option>
						<option value='Should'>Should</option>
						<option value='Could'>Could</option>
						<option value='Wont'>Wont</option>
					</select>
				</td>


				<td><input type='text' name='backlogComment_1'></td>


			</tr>

		</table>


		<table class="table createSprintInfoAdd">

			<tr>
				<td><button id='createSprintInfoAddBacklogItem'>Add</button></td>
			</tr>

		</table>


		</div>


		<div class='clear'></div>
	</div>
</div>