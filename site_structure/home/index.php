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

</div>