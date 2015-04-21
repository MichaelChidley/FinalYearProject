<div class='headingBlock'>Current Bugs</div>
	<div class="table-responsive">
	  <table class="table projectsTable">

	  <tr>
		<th>Title</th>
		<th>Description</th>
		<th>Reported By</th>
		<th>Project</th>
	  </tr>
	  <?php





	  	//$objTeam = new Team($API);
	  	foreach($arrProjects as $arrIndProjects)
	  	{
	  		$intProjectID = $arrIndProjects['projectID'];
	  		$arrUsersInProject = $API->convertJsonArrayToArray($objProject->getProjectUsers($intProjectID));

	  		//print_r($arrUsersInProject['response']);
	  		if(in_array($_SESSION['authenticationID'], $arrUsersInProject['response']))
	  		{
	  			$arrBugs = $API->convertJsonArrayToArray($objBug->getProjectBugs($intProjectID));
				$arrBugs = $arrBugs['response'];

				if(count($arrBugs)>0)
				{

					foreach($arrBugs as $arrIndBugs)
					{
						$strEmployee = $API->convertJsonArrayToArray($objEmployee->getSingleEmployee($arrIndBugs['bugReportedBy']));
						$strEmployee = $strEmployee['response'];

						$strEmployeeName = $strEmployee['firstname']. " ".$strEmployee['lastname'];
						$strEmployeeEmail = $strEmployee['email'];

						$bBugFixed = $arrIndBugs['bugFixed'];

						$rowStyle = "tblRowRed";
						if($bBugFixed == 1)
						{
							$rowStyle = "tblRowGreen";
						}

						echo "<tr class='bugHomeClick ".$rowStyle."' id='".$arrIndBugs['bugID']."'>";
						echo "<td>".$arrIndBugs['bugTitle']."</td>";
			  			echo "<td>".$arrIndBugs['bugDescription']."</td>";
			  			echo "<td>".$strEmployeeName."</td>";
						echo "<td>".$arrIndProjects['projectTitle']."</td>";
						echo "</tr>";
					}

				}

	  		}
	  	}

	  ?>
	  </table>
	</div>