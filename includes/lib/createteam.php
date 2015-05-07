<?php

session_start();

//print_r($_SESSION);
//add check for CSRF too with tokens etc
if($_POST['data'])
{

	//print_r($_POST);
	include_once("../config.php");
	include_once("../classes/security/clsSecurity.php");
	include_once("../classes/api/clsAPI.php");
	include_once("../classes/team/clsTeam.php");


	$objSecurity = new Security();
	if(!$objSecurity->CSRFCheck())
	{
		die;
	}

	$API = new API($configArray['API_URL'], $configArray['API_KEY']);

	$data = $_POST['data'];
	$arrData = json_decode($data,true);


	$objTeam = new Team($API);

	$objTeam->setTeamTitle($arrData['teamTitle']);
	$objTeam->setTeamDescription($arrData['teamDescription']);

	echo $objTeam->createTeam();

	echo "true";

}

?>