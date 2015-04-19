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

			?>
		</div>
	</div>

	<div class='contentLargeOffset'></div>


	<div class='col-sm-4'>
		<div class='headingBlock'>Project Overview</div>
		<div>
			SHOWS PROJECT OVERVIEW, SHOWING THE CURRENT PROJECT PERCENTAGE.
			EACH BLOCK SLIDES/FADES IN SHOWS THE DIFFERENT PROJECTS AT THE SAME TIME
			TEXT DISPLAYED UNDER THE LOADING ICON SHOWING INFORMATION
		</div>

	</div>


	<div class='col-sm-4'>
		<div class='headingBlock'>Sprint Overview</div>
		<div>
			SHOWS SPRINT OVERVIEW SUCH AS CURRENT PROGRESS UPON EACH SPRINT IN BAR CHARTS
			PERHAPS SHOW THE BACKLOG ITEMS FOR EACH SPRINT AND PROGRESS BAR SHOWING HOW
			CLOSE THEY ARE TO BEING COMPLETED
			BACKLOG ITEMS ARE DISPLAYED WITHIN THE BAR THEMSELVES?
		</div>

	</div>


	<div class='col-sm-4'>
		<div class='headingBlock'>Bug Overview</div>
		<div>
			BUG OVERVIEW INFORMATION SHOWING THE CURRENT UNFIXED BUGS WITHIN THE SYSTEM AND
			INFORMATION STATING HOW LONG AGO THE BUG WAS SUBMITTED
			<HR>
			TEXT UNDER EACH CHART/LOADING NUMBER THING SHOWING THE BASIC TEXT FOR IT
		</div>

	</div>


	<div class='clear'></div>
</div>