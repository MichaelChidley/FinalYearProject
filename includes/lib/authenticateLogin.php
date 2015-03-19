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

if((isset($_POST['user'])) && (isset($_POST['pass'])))
{
        $API = new API($configArray['API_URL'], $configArray['API_KEY']);

        $array = $API->buildAPIRequest("login","login",array("login" => array( array("username"=>$_POST['user'],"password"=>$_POST['pass']))));
        $API->handleAPICall($array);

        if($API->isSuccessful($API->getAPIResponse()))
        {
                $_SESSION['authentication'] = $_POST['user'];
                echo "true";
        }

}



?>