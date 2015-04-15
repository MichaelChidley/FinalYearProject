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
class Sprint extends Agile
{
	private $API;

	private $sprintStart;
	private $sprintFinish;


	public function Sprint($API)
	{
		$this->API = $API;
	}


	public function createSprintDates()
	{
		$objProject = new Project($this->API);
		$id = $this->API->convertJsonArrayToArray($objProject->getNewProjectID());
		$id = $id['response'];

		$this->API->handleAPICall(array("startdate" => $this->sprintStart, "enddate" => $this->sprintFinish, "projectID" => $id),"sprint","createSprintDates");
		return $this->API->getAPIResponse();
	}


	public function setSprintStart($start)
	{
		$this->sprintStart = $start;

		return true;
	}

	public function setSprintFinish($finish)
	{
		$this->sprintFinish = $finish;

		return true;
	}
}