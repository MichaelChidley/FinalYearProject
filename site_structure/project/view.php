<?php

		$arrProject =  $API->convertJsonArrayToArray($objProject->getProjectByID($intGetID));

		$arrProject = $arrProject['response'];
		//print_r($arrProject);
		if(count($arrProject)>1)
		{

			$arrUsersInProject = $API->convertJsonArrayToArray($objProject->getProjectUsers($intGetID));
			$arrUsersInProject = $arrUsersInProject['response'];

	  		if(in_array($_SESSION['authenticationID'], $arrUsersInProject))
	  		{

			?>
				<div class='headingBlock'>Project: <?=$arrProject['projectTitle'];?></div>
					<span class='hidden' id='projectID'><?=$arrProject['projectID'];?></span>
					<div class="row-fluid contentOffsetTop">

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Description</div>
			  				<div><?=$arrProject['projectDescription'];?></div>
			  			</div>

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Activity <span class='linksmall'><a href="<?=$configArray['SITE_URL'];?>activity/create/<?=$arrProject['projectID'];?>">(Add)</a></span></div>
			  				<div id='projectPageActivityPolling'></div>
			  			</div>

			  			<div class='clear'></div>
			  		</div>



			  		<div class="row-fluid contentOffsetTop">

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Comments <span class='linksmall'><a href="<?=$configArray['SITE_URL'];?>comment/create/<?=$arrProject['projectID'];?>">(Add)</a></span></div>

			  				<?php

			  					$objComments = new Comment($API);
			  					$arrComments = $API->convertJsonArrayToArray($objComments->getAllComments());
			  					$arrComments = $arrComments['response'];

			  					$objEmployee = new Employee($API);

			  					$intMax = 5;
			  					$intCounter = 0;
			  					foreach($arrComments as $arrIndComments)
			  					{
			  						if($intCounter <= $intMax)
			  						{
				  						if($arrIndComments['projectID'] == $arrProject['projectID'])
				  						{
				  							$arrCommentOwner = $API->convertJsonArrayToArray($objEmployee->getSingleEmployee($arrIndComments['employeeID']));
				  							$arrCommentOwner = $arrCommentOwner['response'];

				  							$strCommentOwner = $arrCommentOwner['firstname']." ".$arrCommentOwner['lastname'];


				  							echo "<div class='projectComment'>".$arrIndComments['comment']." <span class='projectCommentOwner'>- <a href='".$configArray['SITE_URL']."employee/view/".$arrCommentOwner['employeeID']."'>".$strCommentOwner."</a></span></div>";

				  							$intCounter++;
				  						}
			  						}
			  					}


			  				?>


			  			</div>

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Progress</div>
			  				<div class='projectProgressBackground'>
			  				<?php
			  				switch($arrProject['projectProgress'])
			  				{
			  					case $arrProject['projectProgress'] <= 25:
				  					$tableDataStyle = "low";
				  				break;

				  				case $arrProject['projectProgress'] <= 75:
				  					$tableDataStyle = "medium";
				  				break;

				  				case $arrProject['projectProgress'] > 75:
				  					$tableDataStyle = "high";
				  				break;
			  				}
			  				?>
			  					<div class="projectProgressForeground <?=$tableDataStyle;?>" style="width:<?=$arrProject['projectProgress'];?>%"><?=$arrProject['projectProgress'];?>%</div>
			  				</div>

			  			</div>

			  			<div class='clear'></div>
			  		</div>





			  		<div class="row-fluid contentOffsetTop">

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Team</div>
			  				<?php

			  					$objTeam = new Team($API);
			  					$arrGetSingleTeamMembers = $API->convertJsonArrayToArray($objTeam->returnTeamMembersByProjectID($arrProject['projectID']));
			  					$arrGetSingleTeamMembers = $arrGetSingleTeamMembers['response'];
			  					//print_r($arrGetSingleTeamMembers);
			  					$arrEmailHolder = array();

			  					if(count($arrGetSingleTeamMembers)>1)
			  					{
				  					foreach($arrGetSingleTeamMembers as $arrIndGetSingleTeamMembers)
				  					{
				  						array_push($arrEmailHolder,$arrIndGetSingleTeamMembers['email']);
				  						echo "<div>".$arrIndGetSingleTeamMembers['firstname']. " ".$arrIndGetSingleTeamMembers['lastname']." - <a href='mailto:".$arrIndGetSingleTeamMembers['email']."?Subject=Regarding PMC Project: ".$arrProject['projectTitle']."'>".$arrIndGetSingleTeamMembers['email']."</a></div>";
				  					}


				  					echo "<div><a href='mailto:";
				  					foreach($arrEmailHolder as $arrIndEmailHolder)
				  					{
				  						echo $arrIndEmailHolder.";";
				  					}
				  					echo "?Subject=Regarding PMC Project: ".$arrProject['projectTitle']."'>Email All Team Members </a></div>";
			  					}

			  				?>



			  			</div>

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Bugs <span class='linksmall'><a href="<?=$configArray['SITE_URL'];?>bug/create/">(Add)</a></span></div>
			  				<?php

			  					$objBug = new Bug($API);
			  					$arrProjectBugs = $API->convertJsonArrayToArray($objBug->getProjectBugs($arrProject['projectID']));
			  					$arrProjectBugs = array_reverse($arrProjectBugs['response']);


			  					if(count($arrProjectBugs)>=1)
			  					{
				  					foreach($arrProjectBugs as $arrProjectIndBugs)
				  					{
				  						$style = 'green';
				  						$text = "Fixed";
				  						if($arrProjectIndBugs['bugFixed'] == 0)
				  						{
				  							$style = 'red';
				  							$text = "Not Fixed";
				  						}

				  						echo "<div class='projectBugs'><span class='".$style."'>".$text."</span> <a href='".$configArray['SITE_URL']."bug/view/".$arrProjectIndBugs['bugID']."'>".$arrProjectIndBugs['bugTitle']."</a></div>";
				  					}
			  					}

			  				?>

			  			</div>

			  			<div class='clear'></div>


			  			<div class="row-fluid contentOffsetTop">

				  			<div class="col-sm-6">
				  				<div class="secondLevelHeading">Sprints</div>

				  				<div class='table-responsive'>
									<table class="table sprintTable">
									<tr>
										<th>Start</th>
										<th>Finish</th>
										<th>Goal</th>
										<th></th>
									</tr>
					  				<?php

					  					$objSprint = new Sprint($API);
					  					$arrSprints = $API->convertJsonArrayToArray($objSprint->getSprintsByProjectID($intGetID));
					  					$arrSprints = $arrSprints['response'];
					  					//print_r($arrSprints);
					  					foreach($arrSprints as $arrIndSprints)
					  					{
					  						echo "<tr>";
					  							echo "<td>".$arrIndSprints['sprintStart']."</td>";
					  							echo "<td>".$arrIndSprints['sprintFinish']."</td>";
					  							echo "<td>".$arrIndSprints['sprintGoal']."</td>";
					  							echo "<td><a href='".$configArray['SITE_URL']."sprint/view/".$arrIndSprints['sprintID']."'>View</a></td>";
					  						echo "</tr>";
					  					}


					  				?>

					  				</table>
				  				</div>



				  			</div>

			  			</div>

			  			<div class='clear'></div>


			  		</div>


			  		<?php
			  		if(($objEmployee->isAdmin($_SESSION['authenticationID'])) || ($objEmployee->isProjectManager($_SESSION['authenticationID'])))
					{
			  			?>
			  			<div style='margin-top: 20px;float: left;margin-left:10px'><a href="<?=$configArray['SITE_URL'];?>project/delete/<?=$arrProject['projectID'];?>"><button class="btn btn-danger deleteProject">Delete</button></a></div>
			  			<?php
			  		}
			  		?>
<!--
			  		<div class="row-fluid contentOffsetTop">

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">>> DEPLOY XP / SPRINT REVIEWS ETC</div>

			  			</div>



			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">XXX</div>

			  			</div>

			  			<div class='clear'></div>
			  		</div>


-->


		  		<?php
		  	}
		}

	?>