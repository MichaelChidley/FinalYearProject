<?php

session_start();

//print_r($_SESSION);
//add check for CSRF too with tokens etc
//print_r($_POST);
if($_POST['data'])
{

	print_r($_POST);
	include_once("../config.php");
	include_once("../classes/security/clsSecurity.php");
	include_once("../classes/api/clsAPI.php");
	include_once("../classes/bug/clsBug.php");
	include_once("../classes/project/clsProject.php");
	include_once("../classes/employee/clsEmployee.php");


	$objSecurity = new Security();
	if(!$objSecurity->CSRFCheck())
	{
		die;
	}

	$API = new API($configArray['API_URL'], $configArray['API_KEY']);

	$data = $_POST['data'];
	$arrData = json_decode($data,true);

	$objEmployee = new Employee($API);

	$strFirstname = $arrData['employeeFirstname'];
	$strLastname = $arrData['employeeLastname'];
	$strEmail = $arrData['employeeEmail'];
	$strPassword = $arrData['employeePassword'];
	$strDOB = $arrData['employeeDOB'];
	$strHomeNumber = $arrData['employeeHomeNumber'];
	$strMobileNumber = $arrData['employeeMobileNumber'];
	$intEmployeeTeam = $arrData['employeeTeam'];;

	$objEmployee->setFirstname($strFirstname);
	$objEmployee->setLastname($strLastname);
	$objEmployee->setEmail($strEmail);
	$objEmployee->setPassword($strPassword);
	$objEmployee->setDOB($strDOB);
	$objEmployee->setHomeNumber($strHomeNumber);
	$objEmployee->setMobileNumber($strMobileNumber);
	$objEmployee->setTeam($intEmployeeTeam);

	echo $objEmployee->addEmployee();

	echo "true";

}

?>