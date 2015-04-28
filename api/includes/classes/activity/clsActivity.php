<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsActivity.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle activity information
-----------------------------------------------------------------------------------------------------------
History:
07/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Activity
{

	//initialize private variables
	private $ActivityID;
	private $ActivityOwner;
	private $ActivityDescription;
	private $ActivityProject;


		/*----------------------------------------------------------------------------------
      	Function:	init
      	Overview:	Function to initialize the request method for this module

      	In:      $operation         String          Method
      			 $intID 			int 			Integer of value to edit, used for post
      			 $arrAvtivityInformation	array 	Array of post information

      	Out:	 object response
		----------------------------------------------------------------------------------*/
        public function init($operation,$intID=0,$arrActivityInformation=array())
        {

			$objFeedback = new Feedback();

			if(count($arrActivityInformation)<1)
			{
				//route the request to the correct method
				switch($operation)
				{
					case "returnAllActivity":
						return $this->returnAllActivity();
					break;


					case "returnSingleActivity":
						return $this->getSingleActivity($intID);
					break;


					case "returnSingleActivityByPrjID":
						return $this->getSingleActivityByPrjID($intID);
					break;
				}
			}

			$arrActivity = $arrActivityInformation['Activity'];

			//loop through all posted fields and set the private variables
			foreach($arrActivity as $arrIndActivity)
			{
					$bFormFailed = false;

					(isset($arrIndActivity['ID'])) ? $this->setActivityID($arrIndActivity['ID']) : '';

					(isset($arrIndActivity['ActivityOwner'])) ? $this->setActivityOwner($arrIndActivity['ActivityOwner']) : $bFormFailed = true;
					(isset($arrIndActivity['ActivityDescription'])) ? $this->setActivityDescription($arrIndActivity['ActivityDescription']) : $bFormFailed = true;
					(isset($arrIndActivity['ActivityProject'])) ? $this->setActivityTitle($arrIndActivity['ActivityTitle']) : $bFormFailed = true;


					//if a value is not set, return false
					if($bFormFailed)
					{
							return false;
					}

					switch($operation)
					{

						case 'getAllActivitys':
							return $this->returnAllActivitys();
						break;

					}

			}
		}


		/*----------------------------------------------------------------------------------
      	Function:	returnAllActivity
      	Overview:	Return all activities to the function call

      	In:

      	Out:	 array response
		----------------------------------------------------------------------------------*/
		public function returnAllActivity()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("activity");
		}

		/*----------------------------------------------------------------------------------
      	Function:	getSingleActivity
      	Overview:	Return a single activity to the function call

      	In:	$id 	int 	id of activity to return

      	Out:	 array response
		----------------------------------------------------------------------------------*/
		public function getSingleActivity($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("activity","activityID",$id);
		}

		/*----------------------------------------------------------------------------------
      	Function:	getSingleActivityByPrjID
      	Overview:	Return a single activity by project id

      	In:	$id 	int 	id of project

      	Out:	 array response
		----------------------------------------------------------------------------------*/
		public function getSingleActivityByPrjID($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("activity","activityProject",$id);
		}


		/*----------------------------------------------------------------------------------
      	Function:	setActivityID
      	Overview:	Set activity id

      	In:	$intActivityID 	int 	id of activity

      	Out:	 bool
		----------------------------------------------------------------------------------*/
		public function setActivityID($intActivityID)
		{
			return $this->ActivityID = $intActivityID;
		}

		/*----------------------------------------------------------------------------------
      	Function:	setActivityOwner
      	Overview:	Set activity owner

      	In:	$intActivityOwnerID 	int 	id of activity owner

      	Out:	 bool
		----------------------------------------------------------------------------------*/
		public function setActivityOwner($intActivityOwnerID)
		{
			return $this->ActivityOwner = $intActivityOwnerID;
		}

		/*----------------------------------------------------------------------------------
      	Function:	setActivityDescription
      	Overview:	Set activity description

      	In:	$setActivityDescription 	string 	string containing activity description

      	Out:	 bool
		----------------------------------------------------------------------------------*/
		public function setActivityDescription($setActivityDescription)
		{
			return $this->ActivityDescription = $setActivityDescription;
		}

		/*----------------------------------------------------------------------------------
      	Function:	setActivityProject
      	Overview:	Set activity project

      	In:	$setActivityProject 	int 	id of project

      	Out:	 bool
		----------------------------------------------------------------------------------*/
		public function setActivityProject($setActivityProject)
		{
			return $this->ActivityProject = $setActivityProject;
		}


}



?>