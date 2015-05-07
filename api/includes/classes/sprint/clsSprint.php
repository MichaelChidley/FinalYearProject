<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsSprint.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle sprint information
-----------------------------------------------------------------------------------------------------------
History:
07/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Sprint
{

	private $sprintID;
	private $projectID;
	private $startdate;
	private $enddate;
	private $goal;

        public function init($operation,$intID=0,$arrSprintInformation=array())
        {
			$objFeedback = new Feedback();

			if(count($arrSprintInformation)<1)
			{

				switch($operation)
				{
					//get operations
					case "getSprintsByProjectID":
						return $this->getSprintsByProjectID($intID);
					break;

				}
			}

			$bFormFailed = false;

			(isset($arrSprintInformation['ID'])) ? $this->setSprintID($arrSprintInformation['ID']) : '';

			(isset($arrSprintInformation['startdate'])) ? $this->setStartDate($arrSprintInformation['startdate']) : $bFormFailed = true;
			(isset($arrSprintInformation['enddate'])) ? $this->setEndDate($arrSprintInformation['enddate']) : $bFormFailed = true;
			(isset($arrSprintInformation['projectID'])) ? $this->setProjectID($arrSprintInformation['projectID']) : $bFormFailed = true;
			(isset($arrSprintInformation['goal'])) ? $this->setSprintGoal($arrSprintInformation['goal']) : $bFormFailed = true;

			if($bFormFailed)
			{
					return false;
			}

			switch($operation)
			{


				case 'createSprintDates':
					return $this->createSprintDates();
				break;


			}
		}


		public function getSprintsByProjectID($intID)
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRowsWhere("sprints", "projectID", $intID);
		}


		public function createSprintDates()
		{

			$arrFields = array("sprintStart","sprintFinish","projectID","sprintGoal");
            $arrValues = array($this->startdate, $this->enddate, $this->projectID, $this->goal);


            $objDatabase = new Database();
            $objFeedback = new Feedback();

            if($objDatabase->insert('sprints',$arrFields,$arrValues))
            {
                    return true;
            }
            return false;
		}




		public function setSprintID($id)
		{
			$this->sprintID = $id;

			return true;
		}

		public function setProjectID($id)
		{
			$this->projectID = $id;

			return true;
		}

		public function setStartDate($date)
		{
			$this->startdate = $date;

			return true;
		}

		public function setEndDate($date)
		{
			$this->enddate = $date;

			return true;
		}

		public function setSprintGoal($goal)
		{
			$this->goal = $goal;

			return true;
		}





}



?>