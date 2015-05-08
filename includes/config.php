<?php

	//CONFIGURATION SETTINGS
	$configArray = array();

	$configArray['SITE_URL'] = "http://".$_SERVER['SERVER_NAME']."/Uni/FinalYearProject/";
	$configArray['API_URL'] = "http://".$_SERVER['SERVER_NAME']."/Uni/FinalYearProject/api/";

	$configArray['API_KEY'] = "CxcgOD9E9drJdnemNFbsBB8j2yNftWv+44w+e8PkmylQzsNz2RzPdxdMiE6tjCCB";

	$configArray['FALL_BACK'] = $configArray['SITE_URL'];


	//WEBSITE STYLING SETTINGS: CSS, JS ETC
	$styleArray = array();

	$styleArray['MAIN_CSS'] = $configArray['SITE_URL']."main.css";
	$styleArray['BOOTSTRAP_CSS'] = $configArray['SITE_URL']."theme/bootstrap/css/bootstrap.css";

	$styleArray['MAIN_JS'] = $configArray['SITE_URL']."main.js";
	$styleArray['BOOTSTRAP_JS'] = $configArray['SITE_URL']."theme/bootstrap/js/bootstrap.js";

	//Allowed pages
	$configPages = array("project","bug","employee","team","backlog","logout");


	//Basic array to store page meta information
	$configArray['default']['title'] = "Project Management Console";
	$configArray["project"]['title'] = "Projects | ".$configArray['default']['title'];
	$configArray["bug"]['title'] = "Bugs | ".$configArray['default']['title'];
	$configArray["employee"]['title'] = "Employees | ".$configArray['default']['title'];
	$configArray["team"]['title'] = "Teams | ".$configArray['default']['title'];
	$configArray["backlog"]['title'] = "Backlog | ".$configArray['default']['title'];
	$configArray["logout"]['title'] = "Logout | ".$configArray['default']['title'];

?>