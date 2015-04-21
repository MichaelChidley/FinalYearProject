<?php

Class Bug
{

	private $API;

	private $bugTitle;
	private $bugDescription;
	private $bugProject;
	private $bugLine;

	public function Bug($API)
	{
		$this->API = $API;
	}

	public function getProjectBugs($intProjectID)
	{
		$this->API->handleAPICall(array(),"bug","returnProjectBugs", $intProjectID);
		return $this->API->getAPIResponse();
	}

	public function getSingleBug($intBugID)
	{
		$this->API->handleAPICall(array(),"bug","returnSingleBug", $intBugID);
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

	public function markBugAsFixed($intBugID)
	{
		$this->API->handleAPICall(array(),"bug","markBugAsFixed", $intBugID);
		return $this->API->getAPIResponse();
	}

	public function markBugAsUnfix($intBugID)
	{
		$this->API->handleAPICall(array(),"bug","markBugAsUnfix", $intBugID);
		return $this->API->getAPIResponse();
	}


	public function createBug()
	{

		$this->API->handleAPICall(array("bugTitle" => $this->bugTitle, "bugDescription" => $this->bugDescription, "bugLine" => $this->bugLine,
			"projectID" => $this->bugProject, "bugReportedBy" => $this->reportedBy, "bugFixed" => $this->bugFixed,
			 "bugDeleted" => $this->bugDeleted),"bug","createBug");
		return $this->API->getAPIResponse();
	}


	public function setBugTitle($title)
	{
		$this->bugTitle = $title;
		return true;
	}

	public function setBugDescription($description)
	{
		$this->bugDescription = $description;
		return true;
	}

	public function setBugProject($projectname)
	{
		$this->bugProject = $projectname;
		return true;
	}

	public function setBugLine($line)
	{
		$this->bugLine = $line;
		return true;
	}

	public function setBugReportedBy($strUserID)
	{
		$this->reportedBy = $strUserID;
		return true;
	}

	public function setBugFixed($bFixed)
	{
		$this->bugFixed = $bFixed;
		return true;
	}

	public function setBugDeleted($bDeleted)
	{
		$this->bugDeleted = $bDeleted;
		return true;
	}

}
?>