<?php


Class UnitTesting
{
	private $API;

	private $programmerOne;
	private $programmerTwo;



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


	public function setPairProgrammerOne($intID)
	{
		$this->programmerOne = $intID;
		return true;
	}


	public function setPairProgrammerTwo($intID)
	{
		$this->programmerTwo = $intID;
		return true;
	}

}


?>