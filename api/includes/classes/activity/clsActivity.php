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

	private $ActivityID;
	private $ActivityOwner;
	private $ActivityDescription;
	private $ActivityProject;

        public function init($operation,$intID=0,$arrActivityInformation=array())
        {


			$objFeedback = new Feedback();

			if(count($arrActivityInformation)<1)
			{
				switch($operation)
				{
					case "returnAllActivity":
						return $this->returnAllActivity();
					break;


					case "returnSingleActivity":
						return $this->getSingleActivity($intID);
					break;
				}
			}

			$arrActivity = $arrActivityInformation['Activity'];

			foreach($arrActivity as $arrIndActivity)
			{
					$bFormFailed = false;

					(isset($arrIndActivity['ID'])) ? $this->setActivityID($arrIndActivity['ID']) : '';

					(isset($arrIndActivity['ActivityOwner'])) ? $this->setActivityOwner($arrIndActivity['ActivityOwner']) : $bFormFailed = true;
					(isset($arrIndActivity['ActivityDescription'])) ? $this->setActivityDescription($arrIndActivity['ActivityDescription']) : $bFormFailed = true;
					(isset($arrIndActivity['ActivityProject'])) ? $this->setActivityTitle($arrIndActivity['ActivityTitle']) : $bFormFailed = true;



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


		public function returnAllActivity()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("activity");
		}

		public function getSingleActivity($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("activity","activityID",$id);
		}



		public function setActivityID($intActivityID)
		{
			return $this->ActivityID = $intActivityID;
		}

		public function setActivityOwner($intActivityOwnerID)
		{
			return $this->ActivityOwner = $intActivityOwnerID;
		}

		public function setActivityDescription($setActivityDescription)
		{
			return $this->ActivityDescription = $setActivityDescription;
		}
		public function setActivityProject($setActivityProject)
		{
			return $this->ActivityProject = $setActivityProject;
		}


}



?>