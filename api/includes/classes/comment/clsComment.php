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

Class Comment
{

	private $ActivityID;
	private $ActivityOwner;
	private $ActivityDescription;
	private $ActivityProject;

		/*----------------------------------------------------------------------------------
	  	Function:	init
	  	Overview:	Function to initialize the request method for this module

	  	In:      $operation         String          Method
	  			 $intID 			int 			Integer of value to edit, used for post
	  			 $arrActivityInformation	array 	Array of post information

	  	Out:	 object response
		----------------------------------------------------------------------------------*/
        public function init($operation,$intID=0,$arrActivityInformation=array())
        {

			$objFeedback = new Feedback();

			if(count($arrActivityInformation)<1)
			{
				switch($operation)
				{
					case "returnAllComments":
						return $this->returnAllComments();
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

		/*----------------------------------------------------------------------------------
	  	Function:	returnAllComments
	  	Overview:	Function to return all comments from database

	  	In:

	  	Out:	 array 		array of comments
		----------------------------------------------------------------------------------*/
		public function returnAllComments()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("comments");
		}

}



?>