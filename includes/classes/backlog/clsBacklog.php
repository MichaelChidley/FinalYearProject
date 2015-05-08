<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsBacklog.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle backlog information
-----------------------------------------------------------------------------------------------------------
History:
07/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/
class Backlog extends Sprint
{
	private $API;

	private $backlogItem;
	private $backlogMoscow;
	private $backlogComment;
	private $backlogPP;


	public function Backlog($API)
	{
		$this->API = $API;
	}


	public function createBacklogItem()
	{
		$this->API->handleAPICall(array("backlogItem" => $this->backlogItem, "backlogMoscow" => $this->backlogMoscow, "backlogComment" => $this->backlogComment,
		 "backlogPP" => $this->backlogPP),"backlog","createBacklogItem");
		return $this->API->getAPIResponse();
	}


	public function getNewBacklogID()
	{
		$this->API->handleAPICall(array(),"backlog","getNewBacklogID");

		return $this->API->getAPIResponse();
	}

	public function createLinkProjectBacklog()
	{
		$newBacklogID = $this->API->convertJsonArrayToArray($this->getNewBacklogID());
		$strNewBacklogID = $newBacklogID['response'];

		$objProject = new Project($this->API);
		$strNewProjectID = $this->API->convertJsonArrayToArray($objProject->getNewProjectID());
		$strNewProjectID = $strNewProjectID['response'];

		$this->API->handleAPICall(array("projectID" => $strNewProjectID, "backlogID" => $strNewBacklogID), "backlog", "createLinkProjectBacklog");
		return $this->API->getAPIResponse();
	}


	public function getBacklogItemByProjectID($intID)
	{
		$this->API->handleAPICall(array(),"backlog","getBacklogItemByProjectID", $intID);
		return $this->API->getAPIResponse();
	}


	public function getSingleBacklogItem($intBacklogID)
	{
		$this->API->handleAPICall(array(),"backlog","getSingleBacklogItem", $intBacklogID);
		return $this->API->getAPIResponse();
	}




	public function setBacklogItem($itemname)
	{
		$this->backlogItem = $itemname;

		return true;
	}

	public function setBacklogMoscow($moscow)
	{
		$this->backlogMoscow = $moscow;

		return true;
	}

	public function setBacklogComment($comment)
	{
		$this->backlogComment = $comment;

		return true;
	}


	public function setBacklogPP($value)
	{
		$this->backlogPP = $value;

		return true;
	}
}