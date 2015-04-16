<?php

$objProject = new Project($API);
$arrProjects = $API->convertJsonArrayToArray($objProject->getAllProjects());

//print_r($arrProjects);
$arrProjects = array_reverse($arrProjects['response']);

//If no action or id is set, we are on the homepage, show the content.
if((!isset($strGetAction) && (!isset($intGetID))))
{
	include_once("home.php");
}
else
{
	if($strGetAction == 'view')
	{
		include_once("view.php");
	}
	elseif ($strGetAction == 'create')
	{
		include_once("create.php");
	}
}

?>
