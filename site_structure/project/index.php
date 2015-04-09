<?php

$objProject = new Project($API);
$arrProjects = $API->convertJsonArrayToArray($objProject->getAllProjects());

$arrProjects = array_reverse($arrProjects['response']);

//If no action or id is set, we are on the homepage, show the content.
if((!isset($strGetAction) && (!isset($intGetID))))
{

?>


	<div class='headingBlock'>Your Projects</div>
	<div class="table-responsive">
	  <table class="table projectsTable">

	  <tr>
		<th>Title</th>
		<th>Description</th>
		<th>Importance</th>
		<th>Progress</th>
	  </tr>
	  <?php
	  //print_r($arrProjects);
	  	foreach($arrProjects as $arrIndProjects)
	  	{
	  		$intProjectID = $arrIndProjects['projectID'];

	  		$arrUsersInProject = $API->convertJsonArrayToArray($objProject->getProjectUsers($intProjectID));

	  		if(in_array($_SESSION['authenticationID'], $arrUsersInProject['response']))
	  		{
	  			echo "<tr>";
		  			echo "<td>".$arrIndProjects['projectTitle']."</td>";
		  			echo "<td>".$arrIndProjects['projectDescription']."</td>";
		  			echo "<td>".$objProject->returnProjectImportanceType($arrIndProjects['projectImportance'])."</td>";


		  			switch($arrIndProjects['projectProgress'])
		  			{
		  				case $arrIndProjects['projectProgress'] <= 25:
		  					$tableDataStyle = "low";
		  				break;

		  				case $arrIndProjects['projectProgress'] <= 75:
		  					$tableDataStyle = "medium";
		  				break;

		  				case $arrIndProjects['projectProgress'] > 75:
		  					$tableDataStyle = "high";
		  				break;


		  				default:
		  					$tableDataStyle = "low";
		  				break;
		  			}


		  			echo "<td class='".$tableDataStyle."'>".$arrIndProjects['projectProgress']."%</td>";
	  			echo "</tr>";
	  			//IF THE LOGGED IN USER IS LISTED ONTO THE CURRENT PROJECT, OUTPUT INFORMATION!!!

	  		}
	  	}

	  ?>
	  </table>
	</div>

<?php

}
else
{
	$arrProject =  $API->convertJsonArrayToArray($objProject->getProjectByID($intGetID));
	$arrProject = $arrProject['response'];
	//print_r($arrProject);
	if(count($arrProject)>1)
	{

		$arrUsersInProject = $API->convertJsonArrayToArray($objProject->getProjectUsers($intGetID));

  		if(in_array($_SESSION['authenticationID'], $arrProject))
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
		  				<div class="secondLevelHeading">Activity</div>
		  				<div id='projectPageActivityPolling'></div>
		  			</div>

		  			<div class='clear'></div>
		  		</div>



		  		<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Comments</div>

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




		  			</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Bugs</div>


		  			</div>

		  			<div class='clear'></div>
		  		</div>



	  		<?php
	  	}
	}
}

?>
