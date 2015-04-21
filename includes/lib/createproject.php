<?php

//add check for CSRF too with tokens etc
if($_POST['data'])
{


	//print_r($_POST);
	include_once("../config.php");
	include_once("../classes/security/clsSecurity.php");
	include_once("../classes/api/clsAPI.php");
	include_once("../classes/agile/clsAgile.php");
	include_once("../classes/sprint/clsSprint.php");
	include_once("../classes/backlog/clsBacklog.php");
	include_once("../classes/client/clsClient.php");
	include_once("../classes/team/clsTeam.php");
	include_once("../classes/project/clsProject.php");
	include_once("../classes/agile/xp/pairprogramming/clsPairProgramming.php");
	include_once("../classes/agile/xp/unittesting/clsUnitTesting.php");



	$API = new API($configArray['API_URL'], $configArray['API_KEY']);

	$data = $_POST['data'];
	$arrData = json_decode($data,true);

	//print_r($arrData);


	$strProjectTitle = $arrData['projectTitle'];
	$strStartDate = $arrData['projectStartDate'];
	$strEndDate = $arrData['projectEndDate'];
	$strProjectDescription = $arrData['projectDescription'];

	$bCreateNewClient = $arrData['projectCreateNewClientCb'];

	$strProjectOwnerID = $arrData['projectClient'];

	$strProjectOwnerTitle = $arrData['projectOwnerTitle'];
	$strProjectOwnerFirstname = $arrData['projectOwnerFirstname'];
	$strProjectOwnerLastname = $arrData['projectOwnerLastname'];
	$strProjectOwnerEmail = $arrData['projectOwnerEmail'];
	$strProjectOwnerContact = $arrData['projectOwnerContact'];

	$strProjectTeam = $arrData['teamID'];
	$strProjectImportance = $arrData['projectImportance'];

	$boolProjectUseXP = $arrData['createProjectUseXP'];

	$intProjectSprints = $arrData['projectSprints'];
	$intProjectDays = $arrData['totalProjectDays'];
	$intDaysPerSprint = $arrData['totalDaysPerSprint'];

	(isset($arrData['useXP'])) ? $bUseXP = true : '';
	(isset($arrData['useUnitTesting'])) ? $bUseUnitTesting = true : '';

	//sprint date information

	$intStart = 1;
	$intMax = $intProjectSprints;
	$arrSprintInfoDates = array();

	for($intStart; $intStart <= $intMax; $intStart++)
	{
		$sprintStart = $arrData['createSprintInfoSprintStart_'.$intStart];
		$sprintFinish = $arrData['createSprintInfoSprintFinish_'.$intStart];
		$sprintGoal = $arrData['createSprintInfoSprintDesc_'.$intStart];

		$array = array("start" => $sprintStart, "finish" => $sprintFinish, "goal" => $sprintGoal);

		array_push($arrSprintInfoDates, $array);
	}


	//print_r($arrSprintInfoDates);

	//die;


	$strSprintInfoDesc = "createSprintInfoSprintDesc";
	$arrSprintInfoItems = array();


	$strBacklogItemsDesc = "backlogItem";
	$arrBacklogItems = array();


	$strMoscowItemDesc = "projectSprintMoscow";
	$arrMoscowItems = array();


	$strBacklogComment = "backlogComment";
	$arrBacklogComments = array();

	$strPokerValueDesc = "createSprintInfoSprintPokerVal";
	$arrPokerValues = array();


	$strPairProgrammingUsers = "PPUsers_";
	$arrPairProgrammingUsers = array();


	//loop through the array of data to make it easier handle multiple
	//piece of information that a same type but different
	//example: sprintInfoDescription
	foreach($arrData as $intKey => $value)
	{
		$sprintInfoDescpos = strpos($intKey,$strSprintInfoDesc);
		if($sprintInfoDescpos !== false)
		{
			$arrSprintInfo = explode("_", $intKey);
			$strNumber = $arrSprintInfo[1];
			$arrSprintInfoItems[$strNumber] = $value;
		}


		$backlogCommentpos = strpos($intKey,$strBacklogComment);
		if($backlogCommentpos !== false)
		{
			$arrBacklogCommentInfo = explode("_", $intKey);
			$strNumber = $arrBacklogCommentInfo[1];
			$arrBacklogComments[$strNumber] = $value;
		}



		$backlogItempos = strpos($intKey,$strBacklogItemsDesc);
		if($backlogItempos !== false)
		{
			$arrBacklogInfo = explode("_", $intKey);
			$strNumber = $arrBacklogInfo[1];
			$arrBacklogItems[$strNumber] = $value;
		}


		$moscowItempos = strpos($intKey,$strMoscowItemDesc);
		if($moscowItempos !== false)
		{
			$strMoscowItems = explode("_", $intKey);
			$strNumber = $strMoscowItems[1];
			$arrMoscowItems[$strNumber] = $value;
		}


		$pokerValuepos = strpos($intKey,$strPokerValueDesc);
		if($pokerValuepos !== false)
		{
			$strPokerItems = explode("_", $intKey);
			$strNumber = $strPokerItems[1];
			$arrPokerValues[$strNumber] = $value;
		}


		$PairProgrammingValuepos = strpos($intKey,$strPairProgrammingUsers);
		if($PairProgrammingValuepos !== false)
		{
			$strPPUserItems = explode("_", $intKey);
			$strNumber = $strPPUserItems[1];
			$arrPairProgrammingUsers[$strNumber] = $value;
		}
	}

	//print_r($arrPairProgrammingUsers);
	//print_r($arrSprintInfoItems);
	//print_r($arrBacklogItems);
	//print_r($arrMoscowItems);
	//print_r($arrPokerValues);
	//print_r($arrBacklogComments);


	//create owner first if they dont already exist so can link to table etc
	//itterate through the rest of the info, inputting in the right places.
	//finalise with joining tables joining it all together!!



	$objProject = new Project($API);

	//check if new client details have been provided, if they have, create a new client
	if(($strProjectOwnerTitle != "") && ($strProjectOwnerFirstname != "") && ($strProjectOwnerLastname != "") && ($strProjectOwnerEmail != "") && ($strProjectOwnerContact != ""))
	{
		$objClient = new Client($API);
		$objClient->setClientTitle($strProjectOwnerTitle);
		$objClient->setClientFirstname($strProjectOwnerFirstname);
		$objClient->setClientLastname($strProjectOwnerLastname);
		$objClient->setClientEmail($strProjectOwnerEmail);
		$objClient->setClientContact($strProjectOwnerContact);

		$bCreateClient = $objClient->createClient();

		$arrResponse = $API->convertJsonArrayToArray($objClient->getNewClientID());
		$arrID = $arrResponse['response'];

		$objProject->setProjectOwner($arrID);
	}



	if($bUseXP)
	{
		//print_r($arrPairProgrammingUsers);

		$objPairProgramming = new PairProgramming($API);
		//handle creation of XP - PP - Unit testing handler

		$intUserPPOneID = $arrPairProgrammingUsers[1];
		$intUserPPTwoID = $arrPairProgrammingUsers[2];

		$objPairProgramming->setPairProgrammerOne($intUserPPOneID);
		$objPairProgramming->setPairProgrammerTwo($intUserPPTwoID);

		echo $objPairProgramming->createPairProgrammingPair();



		if($bUseUnitTesting)
		{
			//add stuff to the unit testing table to create a link between stuff
			//insert into agile_unittesting_xp
			//insert into agile_xp(PPID, unitTesting_xp_ID)
			$objUnitTesting = new UnitTesting($API);


		}
	}


	if($strProjectOwnerID != "default")
	{
		$objProject->setProjectOwner($strProjectOwnerID);
	}
	$objProject->setProjectTitle($strProjectTitle);
	$objProject->setProjectDescription($strProjectDescription);
	$objProject->setProjectStart($strStartDate);
	$objProject->setProjectFinish($strEndDate);
	$objProject->setProjectImportance($strProjectImportance);
	$objProject->setProjectTeam($strProjectTeam);

	$bCreateProject = $objProject->createProject();


	echo $bCreateProject;


	$objSprint = new Sprint($API);
	$arrSprintDateID = array();


	foreach($arrSprintInfoDates as $arrSprintIndDates)
	{
		$strLoopStartDate = $arrSprintIndDates["start"];
		$strLoopFinishDate = $arrSprintIndDates["finish"];
		$strLoopGoal = $arrSprintIndDates["goal"];

		$objSprint->setSprintStart($strLoopStartDate);
		$objSprint->setSprintFinish($strLoopFinishDate);
		$objSprint->setSprintGoal($strLoopGoal);

		$objSprint->createSprintDates();
	}


	$intStart = 1;
	$intMax = count($arrBacklogItems);

	$objBacklog = new Backlog($API);

	for($intStart; $intStart<=$intMax; $intStart++)
	{
		$strIndBacklogItem = $arrBacklogItems[$intStart];
		$strIndMoscowVal = $arrMoscowItems[$intStart];
		$strIndBacklogComments = $arrBacklogComments[$intStart];
		$strIndBacklogPP = $arrPokerValues[$intStart];


		$objBacklog->setBacklogItem($strIndBacklogItem);
		$objBacklog->setBacklogMoscow($strIndMoscowVal);
		$objBacklog->setBacklogComment($strIndBacklogComments);
		$objBacklog->setBacklogPP($strIndBacklogPP);

		$objBacklog->createBacklogItem();
		$objBacklog->createLinkProjectBacklog();

	}

	echo "true";

}

?>