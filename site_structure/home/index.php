 <?php

//$objProject = new Project($API);
//$arrProjects = $objProject->getAllProjects();


//
//print_r($_SESSION);
$objActivity = new Activity($API);
$objProject = new Project($API);

$arrActivites = $API->convertJsonArrayToArray($objActivity->getAllActivity());

$intLimit = 5;
$intCounter = 0;


?>
<div class="row-fluid">

	<div class='headingBlock'>Recent Activity</div>
		<div class='blockContent'>
			<?php

			if(is_array($arrActivites))
			{
				if(count($arrActivites)>0)
				{
					$arrActivites = array_reverse($arrActivites['response']);

					foreach($arrActivites as $arrIndActivites)
					{
						if($intCounter < $intLimit)
						{
							$arrProject = $API->convertJsonArrayToArray($objProject->getProjectByID($arrIndActivites['activityProject']));
							$arrProject = $arrProject['response'];

							echo "<div class='activityContent'>".$arrIndActivites['activityDescription']."  <span class='recentActivityProjTitle'>Project: ". $arrProject['projectTitle']."</span></div>";
							echo "<div class='clear'></div>";
							$intCounter++;
						}

					}
				}
			}

			?>
		</div>
	</div>

	<div class='contentLargeOffset'></div>


	<div class='col-sm-4'>
		<div class='headingBlock'>Project Overview</div>

		<?php

			$objProject = new Project($API);
			$arrProjects = $API->convertJsonArrayToArray($objProject->getAllProjects());
			$arrProjects = $arrProjects['response'];

			$arrProjectContainer = array();
			foreach($arrProjects as $arrIndProjects)
			{
				$arr = array("projectID" => $arrIndProjects['projectID'], "projectTitle" => $arrIndProjects['projectTitle'], "projectProgress" => $arrIndProjects['projectProgress']);

				array_push($arrProjectContainer,$arr);
			}


		?>

		<div>


		<?php

		$intCounter = 1;

		foreach($arrProjectContainer as $arrIndProjects)
		{
			$intProjectProgress = $arrIndProjects['projectProgress'];

			$style = "none";
			if($intCounter == 1)
			{
				$style = "block";
			}

			echo "<div id='".$intCounter."' class='pie_progress projectProgress' role='progressbar' data-goal='".$intProjectProgress."' style='margin-top:60px;margin-bottom:60px;display:".$style."'>
				<div class='pie_progress__number'>0%</div>
	  			<div class='pie_progress__label'>Project Completion</div>

			</div>";





			$intCounter++;
		}

		?>

		</div>

	</div>


	<div class='col-sm-4'>
		<div class='headingBlock'>Sprint Overview</div>
		<div>

		<!--<div class='fleft'>Progress On Backlog Item 1</div>
		<div class='homepageSprintProgress fleft'>
			<div class="homepageSprintProgressForeground fleft" style="background-color:4096EE;">&nbsp;</div>
		</div>
		<div class='clear'></div>-->
		<?php

			$arrProjectBacklogProject = $arrProjectContainer;

			$objBacklog = new Backlog($API);

			$intCounter = 1;
			foreach($arrProjectBacklogProject as $arrIndProjectBacklog)
			{
				$intProjectID = $arrIndProjectBacklog['projectID'];
				$arrGetBacklogItems = $API->convertJsonArrayToArray($objBacklog->getBacklogItemByProjectID($intProjectID));
				$arrGetBacklogItems = $arrGetBacklogItems['response'];


				$style = "none";
				if($intCounter == 1)
				{
					$style = "block";
				}


				if($intCounter <=5)
				{
					echo "<div class='projectBacklogProgress' id='".$intCounter."' style='display: ".$style."'>";
						if(is_array($arrGetBacklogItems))
						{
							foreach($arrGetBacklogItems as $arrIndBacklogItem)
							{
								echo "<div class='' id='' style='display: block'>
									".$arrIndBacklogItem['desc']."
								</div>";

								echo "<div class='homepageSprintProgress fleft'>
									<div class=\"homepageSprintProgressForeground fleft\" style=\"background-color:4096EE;width:".$arrIndBacklogItem['progress']."%\">".$arrIndBacklogItem['progress']."%</div>
								</div>
								<div class='clear'></div>";
							}
						}
					echo "</div>";
				}

				$intCounter++;

			}
			?>

<!--
			SHOWS SPRINT OVERVIEW SUCH AS CURRENT PROGRESS UPON EACH SPRINT IN BAR CHARTS
			PERHAPS SHOW THE BACKLOG ITEMS FOR EACH SPRINT AND PROGRESS BAR SHOWING HOW
			CLOSE THEY ARE TO BEING COMPLETED
			BACKLOG ITEMS ARE DISPLAYED WITHIN THE BAR THEMSELVES?-->
		</div>

	</div>


	<div class='col-sm-4'>
		<div class='headingBlock'>Bug Overview</div>
		<div>

		<?php
			$arrProjectToMatchBugsTo = $arrProjectContainer;

			$objBug = new Bug($API);

			$intCounter = 1;
			foreach($arrProjectToMatchBugsTo as $arrIndProjectBugs)
			{
				$intProjectID = $arrIndProjectBugs['projectID'];
				$arrFixedBugs = $API->convertJsonArrayToArray($objBug->getFixedBugsByProjectID($intProjectID));
				$arrFixedBugs = $arrFixedBugs['response'];

				$arrUnfixedBugs = $API->convertJsonArrayToArray($objBug->getUnfixedBugsByProject($intProjectID));
				$arrUnfixedBugs = $arrUnfixedBugs['response'];

				$intTotalBugs = $arrFixedBugs + $arrUnfixedBugs;
				if($intTotalBugs == 0)
				{
					$intTotalBugs = 1;
				}

				$dblFixedBugs = $arrFixedBugs / $intTotalBugs;
				$dblFixedBugs = $dblFixedBugs * 100;

				if($dblFixedBugs == 0)
				{
					$dblFixedBugs = 100;
				}

				$style = "none";
				if($intCounter == 1)
				{
					$style = "block";
				}
				echo "<div id='".$intCounter."' class='pie_progress bugProgress' role='progressbar' data-goal='".$dblFixedBugs."' style='margin-top:60px;margin-bottom:60px;display:".$style."'>
					<div class='pie_progress__number'>0%</div>
		  			<div class='pie_progress__label'>Bugs Fixed</div>
				</div>";

				$intCounter++;
			}

		?>


			<!--BUG OVERVIEW INFORMATION SHOWING THE CURRENT UNFIXED BUGS WITHIN THE SYSTEM AND
			INFORMATION STATING HOW LONG AGO THE BUG WAS SUBMITTED
			<HR>
			TEXT UNDER EACH CHART/LOADING NUMBER THING SHOWING THE BASIC TEXT FOR IT-->
		</div>

	</div>


	<div class='clear'></div>
</div>