<?php


Class UnitTesting
{
	private $API;
	private $testname;
	private $testdescription;
	private $testcomplete;
	private $testcomment;


	public function UnitTesting($API)
	{
		$this->API = $API;
	}


	public function createUnitTest()
	{
		$this->API->handleAPICall(array("testname" => $this->testname, "testdescription" => $this->testdescription, "testcomplete" => $this->testcomplete, "testcomment" => $this->testcomment),"unittesting","createUnitTest");

		return $this->API->getAPIResponse();
	}



	public function setTestName($strTestName)
	{
		$this->testname = $strTestName;
		return true;
	}

	public function setTestDescription($strTestDesc)
	{
		$this->testdescription = $strTestDesc;
		return true;
	}

	public function setTestComplete($intTestComplete)
	{
		$this->testcomplete = $intTestComplete;
		return true;
	}

	public function setTestComment($strTestComment)
	{
		$this->testcomment = $strTestComment;
		return true;
	}

}


?>