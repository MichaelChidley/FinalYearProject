<?php

	$objTeam = new Team($API);

?>

<div class='headingBlock'>Create Project</div>
<div class="row-fluid contentOffsetTop">


	<div class='createProjectBlocks'>Step 1: Inital Project Information <span class='fright' id='createProjectToggleBlockOne'>V</span></div>

	<form id='createProjectForm' name='createProject' onsubmit="return false;">
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
				<td><div class="fourthLevelHeading">New Client?</div><input type='checkbox' name='projectCreateNewClientCb'></td>
				<td>
					<select name='projectClient'>
					<option value='default'>Select An Existing Client</option>
					<?php
					$objClient = new Client($API);
					$arrClients = $API->convertJsonArrayToArray($objClient->getAllClients());
					$arrClients = $arrClients['response'];


					foreach($arrClients as $arrIndClients)
					{

						echo "<option value='".$arrIndClients['clientID']."'>".$arrIndClients['clientTitle']." ".$arrIndClients['clientFirstname']." ".$arrIndClients['clientLastname']."</option>";
					}

					?>
					</select>
				</td>

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
					<select name='projectOwnerTitle' skipvalidation="true">
						<option value='Mr'>Mr</option>
						<option value='Mrs'>Mrs</option>
						<option value='Miss'>Miss</option>
					</select>
				</td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Firstname</td>
				<td><input type='text' name='projectOwnerFirstname' skipvalidation="true"></td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Lastname</td>
				<td><input type='text' name='projectOwnerLastname' skipvalidation="true"></td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Email</td>
				<td><input type='text' name='projectOwnerEmail' skipvalidation="true"></td>
			</tr>

			<tr class='projectOwnerDetails'>
				<td>Phone</td>
				<td><input type='text' name='projectOwnerContact' skipvalidation="true"></td>
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
							echo "<option id=".$arrIndTeams['teamID']." value='".$arrIndTeams['teamTitle']."'>".$arrIndTeams['teamTitle']."</option>";
						}
					?>Z

					</select>
				</td>


				<td><div class="fourthLevelHeading">Importance</div></td>
				<td>
					<select name='projectImportance'>
						<option value='3'>Low</option>
						<option value='2'>Medium</option>
						<option value='1'>High</option>

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








		<div class='createProjectBlocks'>Step 2: Sprint Planning <span class='fright' id='createProjectToggleBlockTwo'>V</span></div>


		<div class='createProjectBlockContent table-responsive' id='createProjectBlockTwo'>

		<table class="table createSprintInfoDetails">

			<tr>
				<td><div class="fourthLevelHeading">Total Project Days: <span id='createSprintInfoTotalPrjDays'></span></div></td>
				<td><div class="fourthLevelHeading">Total Sprints: <span id='createSprintInfoTotalSprints'></span></div></td>
				<td><div class="fourthLevelHeading">Days Per Sprint <small>(Est)</small> : <span id='createSprintInfoTotalSprintDays'></span></div></td>

			</tr>

			<tr class='createSprintInfoSprintGoal createSprintInfoSprintGoal_1'>
				<td><div class="fourthLevelHeading createSprintInfoSprintGoalText">Sprint 1 Goal: </div></td>
				<td><textarea class='createSprintInfoSprintDesc_1' name='createSprintInfoSprintDesc_1'></textarea></td>

				<td>Start: <span class='createSprintInfoSprintStart createSprintInfoSprintStart_1' name='createSprintInfoSprintStart_1'></span></td>
				<td>Finish: <span class='createSprintInfoSprintFinish createSprintInfoSprintFinish_1' name='createSprintInfoSprintFinish_1'></span></td>
			</tr>

		</table>


		<table class="table createSprintInfo">

			<tr>
				<th><div class="fourthLevelHeading">Backlog Item</div></th>
				<th><div class="fourthLevelHeading">MoSCoW</div></th>
				<th><div class="fourthLevelHeading">Comment</div></th>
				<th><div class='fourthLevelHeading'>Planning Poker Value</div></th>
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


				<td>
					<select name='createSprintInfoSprintPokerVal_1'>
						<option value='0'>0</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='5'>5</option>
						<option value='8'>8</option>
						<option value='13'>13</option>
						<option value='20'>20</option>
						<option value='40'>40</option>
						<option value='100'>100</option>


					</select>

				</td>

			</tr>

		</table>


		<table class="table createSprintInfoAdd">

			<tr>
				<td><button id='createSprintInfoAddBacklogItem'>Add</button></td>
			</tr>

			<tr>
				<td><button id='createProjectNextStepTwo'>Proceed To Next Step</button></td>
			</tr>

		</table>


		</div>








		<div class='createProjectBlocks'>Step 3: Agile <span class='fright' id='createProjectToggleBlockThree'>V</span></div>


		<div class='createProjectBlockContent table-responsive' id='createProjectBlockThree'>

			<table class="table createSprintInfoUseXP">
				<tr>
					<td><div class="fourthLevelHeading">Use XP Methodologies? <input type='checkbox' name='createProjectUseXP'></div></td>
				</tr>

			</table>


			<table class="table createSprintInfoXP PPusers">
				<tr class='createPP'>
					<td><div class="fourthLevelHeading">Pair Programming</div></td>
				</tr>



			</table>


<!--
			<table class="table createUnitTesting">
				<tr>
					<td><div class="fourthLevelHeading">Unit Testing <input type='checkbox' name='createUnitTesting'></div></td>
				</tr>
-->


			</table>


		</div>

		</form>

		<button id='create'>Create</button>


		<div class='clear'></div>
	</div>
</div>