<?php


$objTeam = new Team($API);
$arrTeams = $API->convertJsonArrayToArray($objTeam->getAllTeams());

$arrTeams = array_reverse($arrTeams['response']);

//print_r($arrTeams);



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
}

?>
