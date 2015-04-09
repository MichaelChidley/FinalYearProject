<?php


/*
-----------------------------------------------------------------------------------------------------------
File: projectpolling.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview:       Handler for the project polling action
-----------------------------------------------------------------------------------------------------------
History:
09/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

session_start();

include_once("../config.php");
include_once("../classes/security/clsSecurity.php");
include_once("../classes/api/clsAPI.php");
include_once("../classes/project/clsProject.php");
include_once("../classes/activity/clsActivity.php");

if((isset($_POST['projectID'])))
{
        $API = new API($configArray['API_URL'], $configArray['API_KEY']);

        $objActivity = new Activity($API);

        $arrActivity = $API->convertJsonArrayToArray($objActivity->getAllActivity());
        $arrActivity = array_reverse($arrActivity['response']);

        $intLimit = 3;
        $intCounter = 0;

        foreach($arrActivity as $arrIndActivities)
        {
                if($intCounter < $intLimit)
                {
                        echo "<div class='activityContent'>".$arrIndActivities['activityDescription']."</div>";
                        $intCounter++;
                }
        }


}



?>