<?php


Class Employee
{

	private $API;

	public function Employee($API)
	{
		$this->API = $API;
	}

	public function getAllEmployees()
	{
		$this->API->handleAPICall(array(),"employee","returnAllEmployees");
		return $this->API->getAPIResponse();
	}

	public function getSingleEmployee($id)
	{
		$this->API->handleAPICall(array(),"employee","returnSingleEmployee",$id);
		return $this->API->getAPIResponse();
	}

	public function getSingleEmployeeByEmail($email)
	{
		$this->API->handleAPICall(array(),"employee","returnSingleEmployeeByEmail",$email);
		return $this->API->getAPIResponse();
	}

	public function getEmployeeAccountType($id)
	{
		$arrayEmployee = $this->getSingleEmployee($id);
		$arrResponse = $this->API->convertJsonArrayToArray($this->API->getAPIResponse());

		$accountType = $arrResponse['response']['accounttype'];

		return $accountType;

	}


	public function isAdmin($id)
	{
		$intAccountType = $this->getEmployeeAccountType($id);

		if($intAccountType == 1)
		{
			return true;
		}
		return false;
	}


	public function isProjectManager($id)
	{
		$intAccountType = $this->getEmployeeAccountType($id);

		if($intAccountType == 2)
		{
			return true;
		}
		return false;
	}


	public function isDeveloper($id)
	{
		$intAccountType = $this->getEmployeeAccountType($id);

		if($intAccountType == 3)
		{
			return true;
		}
		return false;
	}

	public function isUser($id)
	{
		$intAccountType = $this->getEmployeeAccountType($id);

		if($intAccountType == 4)
		{
			return true;
		}
		return false;
	}






}

?>