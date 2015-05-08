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


	/*----------------------------------------------------------------------------------
  	Function:	init
  	Overview:	Function to initialize the request method for this module

  	In:      $operation         String          Method
  			 $intID 			int 			Integer of value to edit, used for post
  			 $arrBacklogInformation	array 	Array of post information

  	Out:	 object response
	----------------------------------------------------------------------------------*/
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


					case "getSingleBacklogItem":
						return $this->getSingleBacklogItem($intID);
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

	/*----------------------------------------------------------------------------------
  	Function:	getBacklogItemByProjectID
  	Overview:	Function that returns backlog item by project id

  	In:      $id         int          Project id

  	Out:	 array $arrBacklogItems
	----------------------------------------------------------------------------------*/
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
            	array_push($arrBacklogItems, array("id" => $row['backlogID'], "desc" => $row['backlogItemDesc'], "progress" => $row['backlogProgress']));
			}

            return $arrBacklogItems;
		}

		return false;

	}

	public function getSingleBacklogItem($intID)
	{
		$objDatabase = new Database();

		return $objDatabase->returnRow("backlog", "backlogID", $intID);
	}


	/*----------------------------------------------------------------------------------
  	Function:	createBacklogItem
  	Overview:	Function to enter backlog items into the database

  	In:

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
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

	/*----------------------------------------------------------------------------------
  	Function:	createLinkProjectBacklog
  	Overview:	Function to link projects with backlog items

  	In:

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
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

	/*----------------------------------------------------------------------------------
  	Function:	getNewBacklogID
  	Overview:	Function to get newest backlog item id

  	In:

  	Out:	 int new backlog id
	----------------------------------------------------------------------------------*/
	public function getNewBacklogID()
	{
		$objDatabase = new Database();
		return $objDatabase->getHighestIDOnTable("backlogID", "backlog");
	}


	/*----------------------------------------------------------------------------------
  	Function:	setProjectJoinID
  	Overview:	Function to set project join id

  	In:		$intID 	int 	project join id

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setProjectJoinID($intID)
	{
		$this->projectJoinID = $intID;

		return true;
	}


	/*----------------------------------------------------------------------------------
  	Function:	setBacklogID
  	Overview:	Function to set the backlog id

  	In:	$intID 	int 	backlog id

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setBacklogID($intID)
	{
		$this->backlogID = $intID;

		return true;
	}

	/*----------------------------------------------------------------------------------
  	Function:	setBacklogJoinID
  	Overview:	Function to set backlog join id

  	In:	$intID 	int 	backlog join id

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setBacklogJoinID($intID)
	{
		$this->backlogJoinID = $intID;

		return true;
	}

	/*----------------------------------------------------------------------------------
  	Function:	setBacklogItem
  	Overview:	Function to set the backlog item

  	In:		$itemname 	string 	backlog item name

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setBacklogItem($itemname)
	{
		$this->backlogItem = $itemname;

		return true;
	}

	/*----------------------------------------------------------------------------------
  	Function:	setBacklogMoscow
  	Overview:	Function to set moscow value for backlog item

  	In:		$moscow 	string 		moscow value

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setBacklogMoscow($moscow)
	{
		$this->backlogMoscow = $moscow;

		return true;
	}

	/*----------------------------------------------------------------------------------
  	Function:	setBacklogComment
  	Overview:	Function to set backlog comment

  	In:		$comment  	string  	backlog comment

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setBacklogComment($comment)
	{
		$this->backlogComment = $comment;

		return true;
	}

	/*----------------------------------------------------------------------------------
  	Function:	setBacklogPP
  	Overview:	Function to set pair programming ID

  	In:		$value    id   	pair programming id

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setBacklogPP($value)
	{
		$this->backlogPP = $value;

		return true;
	}
}