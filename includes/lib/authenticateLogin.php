<?php


/*
-----------------------------------------------------------------------------------------------------------
File: authenticateLogin.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview:       Handler for the login action
-----------------------------------------------------------------------------------------------------------
History:
19/03/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

session_start();

include_once("../config.php");
include_once("../classes/security/clsSecurity.php");
include_once("../classes/api/clsAPI.php");
include_once("../classes/employee/clsEmployee.php");

if((isset($_POST['user'])) && (isset($_POST['pass'])))
{
        $objSecurity = new Security();
        if(!$objSecurity->CSRFCheck())
        {
                die;
        }

        $API = new API($configArray['API_URL'], $configArray['API_KEY']);

        //$this->API->handleAPICall(array("pairprogrammerone" => $this->programmerOne, "pairprogrammertwo" => $this->programmerTwo),"pairprogramming","createPairProgrammingPair");

        $API->handleAPICall(array("username"=>$_POST['user'],"password"=>$_POST['pass']), "login", "login");
        $API->getAPIResponse();


        if($API->isSuccessful($API->getAPIResponse()))
        {
        		//get userID from database and set it as a session.
        		$objEmployee = new Employee($API);
        		$arrEmployee = $API->convertJsonArrayToArray($objEmployee->getSingleEmployeeByEmail($_POST['user']));

        		$intEmployeeID = $arrEmployee['response']['employeeID'];

        		$_SESSION['authenticationID'] = $intEmployeeID;
                $_SESSION['authentication'] = $_POST['user'];
                echo "true";
        }

}



?>