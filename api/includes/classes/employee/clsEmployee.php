<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsEmployee.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle employee information
-----------------------------------------------------------------------------------------------------------
History:
09/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Employee
{

	private $EmployeeID;
	private $EmployeeOwner;
	private $EmployeeDescription;
	private $EmployeeProject;

        public function init($operation,$intID=0,$arrEmployeeInformation=array())
        {

			$objFeedback = new Feedback();

			if(count($arrEmployeeInformation)<1)
			{
				switch($operation)
				{
					case "returnAllEmployees":
						return $this->returnAllEmployees();
					break;


					case "returnSingleEmployee":
						return $this->getSingleEmployee($intID);
					break;


					case "returnSingleEmployeeByEmail":
						return $this->getEmployeeByEmail($intID);
					break;

					case "returnEmployeeAccountTypeName":
						return $this->returnEmployeeAccountTypeName($intID);
					break;

					case "deleteEmployee":
						return $this->deleteEmployee($intID);
					break;
				}
			}

			$arrEmployee = $arrEmployeeInformation['Employee'];

			foreach($arrEmployee as $arrIndEmployee)
			{
					$bFormFailed = false;

					(isset($arrIndEmployee['ID'])) ? $this->setEmployeeID($arrIndEmployee['ID']) : '';

					(isset($arrIndEmployee['EmployeeOwner'])) ? $this->setEmployeeOwner($arrIndEmployee['EmployeeOwner']) : $bFormFailed = true;
					(isset($arrIndEmployee['EmployeeDescription'])) ? $this->setEmployeeDescription($arrIndEmployee['EmployeeDescription']) : $bFormFailed = true;
					(isset($arrIndEmployee['EmployeeProject'])) ? $this->setEmployeeTitle($arrIndEmployee['EmployeeTitle']) : $bFormFailed = true;



					if($bFormFailed)
					{
							return false;
					}

					switch($operation)
					{

						case 'getAllEmployees':
							return $this->returnAllEmployees();
						break;

						case "createEmployee":
							return $this->createEmployee();
						break;

					}

			}
		}

		public function deleteEmployee($id)
		{
			$objDatabase = new Database();
			return $objDatabase->delete("employees", "employeeID", $id);
		}

		public function returnEmployeeAccountTypeName($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnSingleData("accountType","accounttype", "accounttypeID", $id);
		}

		public function returnAllEmployees()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("employees");
		}

		public function getSingleEmployee($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("employees","employeeID",$id);
		}


		public function getEmployeeByEmail($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("employees","email",$id);
		}



		public function setEmployeeID($intEmployeeID)
		{
			return $this->EmployeeID = $intEmployeeID;
		}

		public function setEmployeeOwner($intEmployeeOwnerID)
		{
			return $this->EmployeeOwner = $intEmployeeOwnerID;
		}

		public function setEmployeeDescription($setEmployeeDescription)
		{
			return $this->EmployeeDescription = $setEmployeeDescription;
		}
		public function setEmployeeProject($setEmployeeProject)
		{
			return $this->EmployeeProject = $setEmployeeProject;
		}


}



?>