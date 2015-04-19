<?php


Class PairProgramming
{
	private $API;

	private $programmerOne;
	private $programmerTwo;


	public function PairProgramming($API)
	{
		$this->API = $API;
	}



	public function createPairProgrammingPair()
	{
		$this->API->handleAPICall(array("pairprogrammerone" => $this->programmerOne, "pairprogrammertwo" => $this->programmerTwo),"pairprogramming","createPairProgrammingPair");

		return $this->API->getAPIResponse();
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