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


	public function returnTeamMembersByProjectID($intProjectID)
	{
		$this->API->handleAPICall(array(),"team","returnTeamMembersByProjectID", $intProjectID);
		return $this->API->getAPIResponse();
	}


	public function getAllTeams()
	{
		$this->API->handleAPICall(array(),"team","returnAllTeams");
		return $this->API->getAPIResponse();
	}

	public function getTeamIDByName($strTeamName)
	{
		$this->API->handleAPICall(array(),"team","returnTeamIDByName", $strTeamName);
		return $this->API->getAPIResponse();
	}


	public function createTeam()
	{
		$this->API->handleAPICall(array("teamTitle" => $this->teamTitle, "teamDescription" => $this->teamDescription),"team","create");
		return $this->API->getAPIResponse();
	}

	public function setTeamTitle($teamTitle)
	{
		$this->teamTitle = $teamTitle;

		return true;
	}



	public function setTeamDescription($teamDesc)
	{
		$this->teamDescription = $teamDesc;

		return true;
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