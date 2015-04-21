<?php

include_once("../config.php");
include_once("../classes/security/clsSecurity.php");
include_once("../classes/api/clsAPI.php");
include_once("../classes/bug/clsBug.php");

$API = new API($configArray['API_URL'], $configArray['API_KEY']);
$objBug = new Bug($API);

if($_POST)
{

	switch($_POST['method'])
	{
		case "fixed":
			$objBug->markBugAsFixed($_POST['id']);
		break;


		case "unfix":
			$objBug->markBugAsUnfix($_POST['id']);
		break;
	}

	echo "true";
}

?>