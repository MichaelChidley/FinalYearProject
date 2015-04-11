<?php

Class Team
{

	private $API;

	public function Team($API)
	{
		$this->API = $API;
	}

	public function getSingleTeamMembers($intProjectID)
	{
		$this->API->handleAPICall(array(),"team","returnSingleTeamMembers", $intProjectID);
		return $this->API->getAPIResponse();
	}


	public function getAllTeams()
	{
		$this->API->handleAPICall(array(),"team","returnAllTeams");
		return $this->API->getAPIResponse();
	}

	/*
	public function getTeamMembersByTeamID($intTeamID)
	{
		$this->API->handleAPICall(array(),"team","returnTeamMembersByTeamID", $intTeamID);
		return $this->API->getAPIResponse();
	}
	*/
}
?>