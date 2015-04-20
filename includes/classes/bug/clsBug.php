<?php

Class Bug
{

	private $API;

	public function Bug($API)
	{
		$this->API = $API;
	}

	public function getProjectBugs($intProjectID)
	{
		$this->API->handleAPICall(array(),"bug","returnProjectBugs", $intProjectID);
		return $this->API->getAPIResponse();
	}

	public function getFixedBugsByProjectID($intProjectID)
	{
		$this->API->handleAPICall(array(),"bug","getFixedBugsByProject", $intProjectID);
		return $this->API->getAPIResponse();
	}

	public function getUnfixedBugsByProject($intProjectID)
	{
		$this->API->handleAPICall(array(),"bug","getUnfixedBugsByProject", $intProjectID);
		return $this->API->getAPIResponse();
	}

}
?>