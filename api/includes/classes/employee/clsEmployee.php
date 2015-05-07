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


		/*----------------------------------------------------------------------------------
	  	Function:	init
	  	Overview:	Function to initialize the request method for this module

	  	In:      $operation         String          Method
	  			 $intID 			int 			Integer of value to edit, used for post
	  			 $arrEmployeeInformation	array 	Array of post information

	  	Out:	 object response
		----------------------------------------------------------------------------------*/
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


					case "returnAllAccountTypes":
						return $this->returnAllAccountTypes();
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

		/*----------------------------------------------------------------------------------
	  	Function:	deleteEmployee
	  	Overview:	Function to delete the employee

	  	In:      $id         int          Employee id

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/
		public function deleteEmployee($id)
		{
			$objDatabase = new Database();
			return $objDatabase->delete("employees", "employeeID", $id);
		}

		/*----------------------------------------------------------------------------------
	  	Function:	returnEmployeeAccountTypeName
	  	Overview:	Function to return the client account type

	  	In:      $id         int          account type id

	  	Out:	 string 	account name
		----------------------------------------------------------------------------------*/
		public function returnEmployeeAccountTypeName($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnSingleData("accountType","accounttype", "accounttypeID", $id);
		}

		/*----------------------------------------------------------------------------------
	  	Function:	returnAllEmployees
	  	Overview:	Function to return all employees

	  	In:

	  	Out:	 array 	array of employees
		----------------------------------------------------------------------------------*/
		public function returnAllEmployees()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("employees");
		}


		public function returnAllAccountTypes()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("accounttype");
		}


		/*----------------------------------------------------------------------------------
	  	Function:	getSingleEmployee
	  	Overview:	Function returns a single employee

	  	In:      $id         Int          employee id

	  	Out:	 array 	array of employee information
		----------------------------------------------------------------------------------*/
		public function getSingleEmployee($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("employees","employeeID",$id);
		}

		/*----------------------------------------------------------------------------------
	  	Function:	getEmployeeByEmail
	  	Overview:	Function to return an employee by their email

	  	In:      $id         Int          Employee id

	  	Out:	 array employe information
		----------------------------------------------------------------------------------*/
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