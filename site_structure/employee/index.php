<?php


//$objProject = new Project($API);
//$arrProjects = $API->convertJsonArrayToArray($objProject->getAllProjects());
//$arrProjects = array_reverse($arrProjects['response']);

$objEmployee = new Employee($API);



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
	elseif ($strGetAction == 'delete')
	{
		include_once("delete.php");
	}
	elseif ($strGetAction == 'edit')
	{
		include_once("edit.php");
	}


}

?>
