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


}
?>