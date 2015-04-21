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
	include_once("../classes/bug/clsBug.php");
	include_once("../classes/project/clsProject.php");

	$objSecurity = new Security();
	if(!$objSecurity->CSRFCheck())
	{
		die;
	}

	$API = new API($configArray['API_URL'], $configArray['API_KEY']);

	$data = $_POST['data'];
	$arrData = json_decode($data,true);


	$strBugTitle = $arrData['bugTitle'];
	$strBugDescription = $arrData['bugDescription'];
	$intProjectID = $arrData['bugProjectID'];
	$intBugLine = $arrData['bugLine'];

	$objBug = new Bug($API);
	$objBug->setBugTitle($strBugTitle);
	$objBug->setBugDescription($strBugDescription);
	$objBug->setBugProject($intProjectID);
	$objBug->setBugLine($intBugLine);
	$objBug->setBugReportedBy($_SESSION['authenticationID']);
	$objBug->setBugFixed(0);
	$objBug->setBugDeleted(0);
	$objBug->createBug();

	echo "true";

}

?>