<?php

Class Project
{

	private $API;

	private $ownerID;
	private $title;
	private $description;
	private $startDate;
	private $finishDate;
	private $importance;
	private $projectTeam;

	public function Project($API)
	{
		$this->API = $API;
	}

	public function getAllProjects()
	{
		$this->API->handleAPICall(array(),"project","returnAllProjects");
		return $this->API->getAPIResponse();
	}

	public function getProjectByID($intID)
	{
		$this->API->handleAPICall(array(),"project","returnSingleProject",$intID);
		return $this->API->getAPIResponse();
	}


	public function getProjectUsers($intProjectID)
	{
		$this->API->handleAPICall(array(),"project","getProjectUsers",$intProjectID);
		return $this->API->getAPIResponse();
	}


	public function returnProjectImportanceType($intImportance)
	{
		switch($intImportance)
		{
			case 1:
				return "High";
			break;

			case 2:
				return "Medium";
			break;

			case 3:
				return "Low";
			break;
		}

		return false;
	}



	public function getNewProjectID()
	{
		$this->API->handleAPICall(array(),"project","getNewProjectID");

		return $this->API->getAPIResponse();
	}



	public function createProject()
	{
		$this->API->handleAPICall(array("projectOwner" => $this->ownerID, "projectTitle" => $this->title, "projectDescription" => $this->description, "projectStart" => $this->startDate,
			"projectFinish" => $this->finishDate, "projectImportance" => $this->importance, "projectTeam" => $this->projectTeam),"project","createProject");
		return $this->API->getAPIResponse();
	}


	public function deleteProject($intProjectID)
	{
		$this->API->handleAPICall(array(),"project","deleteProject",$intProjectID);
		return $this->API->getAPIResponse();
	}

	public function setProjectOwner($ownerID)
	{
		$this->ownerID = $ownerID;

		return true;
	}

	public function setProjectTitle($title)
	{
		$this->title = $title;

		return true;
	}

	public function setProjectDescription($description)
	{
		$this->description = $description;

		return true;
	}

	public function setProjectStart($startDate)
	{
		$this->startDate = $startDate;

		return true;
	}

	public function setProjectFinish($finishDate)
	{
		$this->finishDate = $finishDate;

		return true;
	}

	public function setProjectImportance($importance)
	{
		$this->importance = $importance;

		return true;
	}


	public function setProjectTeam($strTeam)
	{
		$this->projectTeam = $strTeam;

		return true;
	}


}
?>