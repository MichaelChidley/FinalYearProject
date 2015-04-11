<?php


/*
-----------------------------------------------------------------------------------------------------------
File: projectreturnteammembers.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview:       Handler for the returning team members
-----------------------------------------------------------------------------------------------------------
History:
11/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

session_start();

include_once("../config.php");
include_once("../classes/security/clsSecurity.php");
include_once("../classes/api/clsAPI.php");
include_once("../classes/project/clsProject.php");
include_once("../classes/team/clsTeam.php");

$API = new API($configArray['API_URL'], $configArray['API_KEY']);
$objTeam = new Team($API);

$arrTeamMembers = $API->convertJsonArrayToArray($objTeam->getSingleTeamMembers($_POST['teamID']));
$arrTeamMembers = $arrTeamMembers['response'];

print_r($arrTeamMembers);

$count = 1;
foreach($arrTeamMembers as $arrIndTeamMembers)
{
	//make it email them konwing they have been assigned?!?
	echo "<tr><td><input name=\"createSprintInfoXPPP_".$count."\" type='checkbox' id='".$arrIndTeamMembers['employeeID']."'> ".$arrIndTeamMembers['firstname']." ".$arrIndTeamMembers['lastname']."</td></tr>";

	$count++;
}


?>