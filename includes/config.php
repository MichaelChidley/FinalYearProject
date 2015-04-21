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


	$configPages = array("project","bug","employee");

?>