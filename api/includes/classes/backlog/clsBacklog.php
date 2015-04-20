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

	private $backlogID;
	private $backlogItem;
	private $backlogMoscow;
	private $backlogComment;
	private $backlogPP;

	private $projectJoinID;
	private $backlogJoinID;


	public function init($operation,$intID=0,$arrBacklogInformation=array())
        {

			$objFeedback = new Feedback();

			if(count($arrBacklogInformation)<1)
			{

				switch($operation)
				{
					//get operations
					case "getNewBacklogID":
						return $this->getNewBacklogID();
					break;

					case "getBacklogItemByProjectID":
						return $this->getBacklogItemByProjectID($intID);
					break;

				}
			}



			$bFormFailed = false;

			(isset($arrBacklogInformation['projectID'])) ? $this->setProjectJoinID($arrBacklogInformation['projectID']) : '';
			(isset($arrBacklogInformation['backlogID'])) ? $this->setBacklogJoinID($arrBacklogInformation['backlogID']) : '';

			if(!isset($this->projectJoinID))
			{
				(isset($arrBacklogInformation['backlogID'])) ? $this->setBacklogID($arrBacklogInformation['backlogID']) : '';

				(isset($arrBacklogInformation['backlogItem'])) ? $this->setBacklogItem($arrBacklogInformation['backlogItem']) : $bFormFailed = true;
				(isset($arrBacklogInformation['backlogMoscow'])) ? $this->setBacklogMoscow($arrBacklogInformation['backlogMoscow']) : $bFormFailed = true;
				(isset($arrBacklogInformation['backlogComment'])) ? $this->setBacklogComment($arrBacklogInformation['backlogComment']) : $bFormFailed = true;
				(isset($arrBacklogInformation['backlogPP'])) ? $this->setBacklogPP($arrBacklogInformation['backlogPP']) : $bFormFailed = true;
			}

			if($bFormFailed)
			{
					return false;
			}

			switch($operation)
			{

				case 'createBacklogItem':
					return $this->createBacklogItem();
				break;

				case 'createLinkProjectBacklog':
					return $this->createLinkProjectBacklog();
				break;


			}
		}


	public function getBacklogItemByProjectID($id)
	{
		$strQry = "SELECT projectbacklog.projectID, projectbacklog.backlogID, backlog.backlogID, backlog.backlogItemDesc, backlog.backlogProgress FROM projectbacklog INNER JOIN backlog ON projectbacklog.backlogID=backlog.backlogID WHERE projectbacklog.projectID = ".$id;

		$objDatabase = new Database();
		$dbSet = $objDatabase->result($strQry);

		$arrBacklogItems = array();

		if($objDatabase->exists($dbSet))
		{

			while($row = mysqli_fetch_array($dbSet, MYSQL_ASSOC))
			{
            	array_push($arrBacklogItems, array("desc" => $row['backlogItemDesc'], "progress" => $row['backlogProgress']));
			}

            return $arrBacklogItems;
		}

		return false;

	}

	public function createBacklogItem()
	{
		$arrFields = array("backlogItemDesc","moscow","backlogComment","planningPoker");
		$arrValues = array($this->backlogItem, $this->backlogMoscow, $this->backlogComment, $this->backlogPP);

		$objDatabase = new Database();
        $objFeedback = new Feedback();

        if($objDatabase->insert('backlog',$arrFields,$arrValues))
        {
                return true;
        }
        return false;
	}

	public function createLinkProjectBacklog()
	{
		$arrFields = array("projectID", "backlogID");
		$arrValues = array($this->projectJoinID, $this->backlogJoinID);

		$objDatabase = new Database();
        $objFeedback = new Feedback();

        if($objDatabase->insert('projectbacklog',$arrFields,$arrValues))
        {
                return true;
        }
        return false;

	}

	public function getNewBacklogID()
	{
		$objDatabase = new Database();
		return $objDatabase->getHighestIDOnTable("backlogID", "backlog");
	}


	public function setProjectJoinID($intID)
	{
		$this->projectJoinID = $intID;

		return true;
	}



	public function setBacklogID($intID)
	{
		$this->backlogID = $intID;

		return true;
	}
	public function setBacklogJoinID($intID)
	{
		$this->backlogJoinID = $intID;

		return true;
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