<?php

Class Project
{

	private $API;

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

}
?>