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

}
?>