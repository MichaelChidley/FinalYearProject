<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsPairProgramming.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle pair programming information
-----------------------------------------------------------------------------------------------------------
History:
07/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class PairProgramming
{
	private $API;

	private $programmerOne;
	private $programmerTwo;



	/*----------------------------------------------------------------------------------
      	Function:	init
      	Overview:	Function to initialize the request method for this module

      	In:      $operation         String          Method
      			 $intID 			int 			Integer of value to edit, used for post
      			 $arrPPInformation	array 		Array of post information

      	Out:	 object response
		----------------------------------------------------------------------------------*/
	public function init($operation,$intID=0,$arrPPInformation=array())
    {
//    	return $operation;

		$objFeedback = new Feedback();

		if(count($arrPPInformation)<1)
		{

			switch($operation)
			{
				//get operations
				case "getNewBacklogID":
					return $this->getNewBacklogID();
				break;

			}
		}


		$bFormFailed = false;


		(isset($arrPPInformation['pairprogrammerone'])) ? $this->setPairProgrammerOne($arrPPInformation['pairprogrammerone']) : $bFormFailed = true;
		(isset($arrPPInformation['pairprogrammertwo'])) ? $this->setPairProgrammerTwo($arrPPInformation['pairprogrammertwo']) : $bFormFailed = true;


		if($bFormFailed)
		{
				return false;
		}

		switch($operation)
		{

			case 'createPairProgrammingPair':
				return $this->createPairProgrammingPair();
			break;

			case 'createLinkProjectBacklog':
				return $this->createLinkProjectBacklog();
			break;


		}
	}


	/*----------------------------------------------------------------------------------
  	Function:	createPairProgrammingPair
  	Overview:	Function to link pair programming pair

  	In:

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function createPairProgrammingPair()
	{
		$arrFields = array("useroneID","usertwoID");
        $arrValues = array($this->programmerOne, $this->programmerTwo);


        $objDatabase = new Database();
        $objFeedback = new Feedback();

        if($objDatabase->insert('agile_pp',$arrFields,$arrValues))
        {
        	return true;
        }

        return false;
	}


	/*----------------------------------------------------------------------------------
  	Function:	setPairProgrammerOne
  	Overview:	Set ID of pair programming person 1

  	In:      $intID         int          ID of user

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setPairProgrammerOne($intID)
	{
		$this->programmerOne = $intID;
		return true;
	}

	/*----------------------------------------------------------------------------------
  	Function:	setPairProgrammerTwo
  	Overview:	Set ID of pair programming person 2

  	In:      $intID         int          ID of user

  	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
	public function setPairProgrammerTwo($intID)
	{
		$this->programmerTwo = $intID;
		return true;
	}

}


?>