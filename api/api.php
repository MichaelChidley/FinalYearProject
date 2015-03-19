<?php

/*
-----------------------------------------------------------------------------------------------------------
File: api.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Handler for API calls. Pages request this file/location for API methods
-----------------------------------------------------------------------------------------------------------
History:
01/12/2014      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/


/*
Include all the required classes into
this base file
*/

include("includes/classes/feedback/clsFeedback.php");
include("includes/classes/database/clsDatabase.php");
include("includes/classes/api/clsAPI.php");

include("includes/classes/security/clsSecurity.php");




//////// INCLUDE MODULE CLASSES /////////
include("includes/classes/bug/clsBug.php");
include("includes/classes/user/clsUser.php");
include("includes/classes/team/clsTeam.php");
include("includes/classes/login/clsLogin.php");





//Obtain the requested message sent via HTTP (GET/POST/PUT/DELETE)
$strRequestMethod = $_SERVER['REQUEST_METHOD'];

//Create a new instance of the API class
$API = new API();
$API->setMethod($strRequestMethod);


$objSecurity = new Security();
//Return the response to the page
echo $objSecurity->encryptInformation($API->getAPIResponse());


?>