<?php

//delete id = intGetID

if(isset($intGetID))
{
	$bDeleteEmployee = $objEmployee->deleteEmployee($intGetID);

	die(header("Location: ".$configArray['SITE_URL']."employee/"));
}

?>