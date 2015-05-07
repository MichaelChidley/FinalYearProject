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

	public function getAllAccountTypes()
	{
		$this->API->handleAPICall(array(),"employee","returnAllAccountTypes");
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

	public function returnEmployeeAccountTypeName($id)
	{
		$this->API->handleAPICall(array(),"employee","returnEmployeeAccountTypeName",$id);
		return $this->API->getAPIResponse();
	}


	public function deleteEmployee($id)
	{
		$this->API->handleAPICall(array(),"employee","deleteEmployee",$id);
		return $this->API->getAPIResponse();
	}


	public function addEmployee()
	{
		$this->API->handleAPICall(array("firstname" => $this->firstname, "lastname" => $this->lastname, "email" => $this->email,
			"password" => md5($this->password), "dob" => $this->dob, "homenumber" => $this->homenumber, "mobilenumber" => $this->mobilenumber,
			"team" => $this->team, "accountLevel" => $this->accountLevel), "user", "createEmployee");
		return $this->API->getAPIResponse();
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



	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;

		return true;
	}

	public function setLastname($lastname)
	{
		$this->lastname = $lastname;

		return true;
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return true;
	}

	public function setPassword($password)
	{
		$this->password = $password;

		return true;
	}

	public function setDOB($dob)
	{
		$this->dob = $dob;

		return true;
	}

	public function setHomeNumber($homenumber)
	{
		$this->homenumber = $homenumber;

		return true;
	}

	public function setMobileNumber($mobilenumber)
	{
		$this->mobilenumber = $mobilenumber;

		return true;
	}

	public function setTeam($team)
	{
		$this->team = $team;
		return true;
	}

	public function setAccountLevel($accountLevel)
	{
		$this->accountLevel = $accountLevel;
		return true;
	}

}

?>