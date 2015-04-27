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
	  		//print_r($arrUsersInProject['response']);
	  		if(in_array($_SESSION['authenticationID'], $arrUsersInProject['response']))
	  		{
	  			echo "<tr class='projectHomeClick' id='".$arrIndProjects['projectID']."'>";
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

	  <?php
	  if(($objEmployee->isProjectManager($accountType) || ($objEmployee->isAdmin($accountType))))
	{
		?>
   <div style='margin-top: 20px;float: left;margin-left:10px'><a href="<?=$configArray['SITE_URL'];?>project/create"><button class="btn btn-primary">Create Project</button></a></div>
   <?php
	}
	?>
	</div>

