<?php

//delete id = intGetID

if(isset($intGetID))
{
	if(($objEmployee->isAdmin($_SESSION['authenticationID'])) || ($objEmployee->isProjectManager($_SESSION['authenticationID'])))
	{
		$bDeleteProject = $objProject->deleteProject($intGetID);


	}
	die(header("Location: ".$configArray['SITE_URL']."project/"));
}

?>