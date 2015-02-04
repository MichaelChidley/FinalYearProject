<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsUser.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle user management
-----------------------------------------------------------------------------------------------------------
History:
09/12/2014      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class User
{

				private $userID;
				private $userFirstName;
				private $userLastName;
				private $userEmail;
				private $userPassword;
				private $userDOB;
				private $userHomeNumber;
				private $userMobileNumber;


				/*----------------------------------------------------------------------------------
				Function:	init
				Overview:	Function to initialize object attributes

				In:      $operation      String          Operation(create,delete,update)
								 $arrUserInfo     Array           Array of user information


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function init($operation,$arrUserInfo)
				{
								$objFeedback = new Feedback();

								$arrUser = $arrUserInfo['user'];

								foreach($arrUser as $arrIndUser)
								{
												$bFormFailed = false;

												(isset($arrIndUser['ID'])) ? $this->setUserID($arrIndUser['ID']) : '';

												(isset($arrIndUser['firstname'])) ? $this->setUserFirstName($arrIndUser['firstname']) : $bFormFailed = true;
												(isset($arrIndUser['lastname'])) ? $this->setUserLastName($arrIndUser['lastname']) : $bFormFailed = true;
												(isset($arrIndUser['email'])) ? $this->setUserEmail($arrIndUser['email']) : $bFormFailed = true;
												(isset($arrIndUser['password'])) ? $this->setUserPassword($arrIndUser['password']) : $bFormFailed = true;
												(isset($arrIndUser['dob'])) ? $this->setUserDOB($arrIndUser['dob']) : $bFormFailed = true;
												(isset($arrIndUser['homenumber'])) ? $this->setUserHomeNumber($arrIndUser['homenumber']) : $bFormFailed = true;
												(isset($arrIndUser['mobilenumber'])) ? $this->setUserMobileNumber($arrIndUser['mobilenumber']) : $bFormFailed = true;

												if($bFormFailed)
												{
																return false;
												}

												switch($operation)
												{

																case 'create':
																		return $this->createUser();
																break;



																case 'update':
																		return $this->updateUser();
																break;


																case 'delete':
																		return $this->deleteUser();
																break;

																default:
																		return false;
																break;


												}

								}

				}

				/*----------------------------------------------------------------------------------
				Function:	createUser
				Overview:	Function to create a user

				In:


				Out:     true/false      bool
				----------------------------------------------------------------------------------*/
				public function createUser()
				{
								$arrFields = array("firstname","lastname","email","password","dob","homenumber", "mobilenumber");
								$arrValues = array($this->getUserFirstName(),$this->getUserLastName(),$this->getUserEmail(),$this->getUserPassword(),$this->getUserDOB(),$this->getUserHomeNumber(), $this->getUserMobileNumber());

								$objDatabase = new Database();
								$objFeedback = new Feedback();

								if($objDatabase->insert('employees',$arrFields,$arrValues))
								{
												return true;

								}
								return false;

				}


				/*----------------------------------------------------------------------------------
				Function:	updateUser
				Overview:	Function to update attributes of a user

				In:


				Out:     true/false      bool
				----------------------------------------------------------------------------------*/
				public function updateUser()
				{
								$objDatabase = new Database();

								$bUpdateFailed = false;

								($strError = $objDatabase->update("employees","firstname",$this->getUserFirstName(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;
								($objDatabase->update("employees","lastname",$this->getUserLastName(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;
								($objDatabase->update("employees","email",$this->getUserEmail(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;
								($objDatabase->update("employees","password",$this->getUserPassword(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;
								($objDatabase->update("employees","dob",$this->getUserDOB(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;
								($objDatabase->update("employees","homenumber",$this->getUserHomeNumber(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;
								($objDatabase->update("employees","mobilenumber",$this->getUserMobileNumber(),"employeeID",$this->getUserID())) ? '' : $bUpdateFailed = true;

								$objFeedback = new Feedback();

								if($bUpdateFailed)
								{
										return false;
								}
								return true;

				}


				/*----------------------------------------------------------------------------------
				Function:	deleteBug
				Overview:	Function to delete a user from the system

				In:


				Out:     true/false      bool
				----------------------------------------------------------------------------------*/
				public function deleteUser()
				{
						$objDatabase = new Database();
						if($objDatabase->delete("employees","employeeID",$this->getUserID()))
						{
								return true;
						}
						return false;
				}





				/*----------------------------------------------------------------------------------
				Function:	getUser
				Overview:	Function to return user attribute from the database

				In:      $intUserID       Integer         User ID


				Out:     $arrRow         Array           User information
				----------------------------------------------------------------------------------*/
				public function getUser($intUserID)
				{
						$objDatabase = new Database();

						$arrRow = $objDatabase->returnRow('employees','employeeID',$intUserID);

						if(!$arrRow)
						{
										return $objDatabase->getErrors();
						}
						return $arrRow;
				}





				/*----------------------------------------------------------------------------------
				Function:	setUserID
				Overview:	Function to set the user ID attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserID($intUserID)
				{
								return $this->userID = $intUserID;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserID
				Overview:	Function to return the user ID attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserID()
				{
								if(isset($this->userID))
								{
												return $this->userID;
								}
				}

				/*----------------------------------------------------------------------------------
				Function:	setUserFirstName
				Overview:	Function to set the user firstname attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserFirstName($struserTitle)
				{
								return $this->userFirstName = $struserTitle;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserFirstName
				Overview:	Function to return the user firstname attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserFirstName()
				{
								if(isset($this->userFirstName))
								{
												return $this->userFirstName;
								}
				}


				/*----------------------------------------------------------------------------------
				Function:	setUserLastName
				Overview:	Function to set the user lastname attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserLastName($strLastName)
				{
								return $this->userLastName = $strLastName;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserLastName
				Overview:	Function to get the user lastname attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserLastName()
				{
								if(isset($this->userLastName))
								{
												return $this->userLastName;
								}
				}



				/*----------------------------------------------------------------------------------
				Function:	setUserEmail
				Overview:	Function to set the user email attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserEmail($strEmail)
				{
								return $this->userEmail = $strEmail;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserEmail
				Overview:	Function to get the user email attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserEmail()
				{
								if(isset($this->userEmail))
								{
												return $this->userEmail;
								}
				}


				/*----------------------------------------------------------------------------------
				Function:	setUserPassword
				Overview:	Function to set the user password attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserPassword($strUserPassword)
				{
								return $this->userPassword = $strUserPassword;
				}

				/*----------------------------------------------------------------------------------
				Function:	setUserPassword
				Overview:	Function to get the user password attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserPassword()
				{
								if(isset($this->userPassword))
								{
												return $this->userPassword;
								}
				}


				/*----------------------------------------------------------------------------------
				Function:	setUserDOB
				Overview:	Function to set the user DOB attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserDOB($intDOB)
				{
								return $this->userDOB = $intDOB;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserDOB
				Overview:	Function to get the user DOB attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserDOB()
				{
								if(isset($this->userDOB))
								{
												return $this->userDOB;
								}
				}


				/*----------------------------------------------------------------------------------
				Function:	setUserHomeNumber
				Overview:	Function to set the user deleted attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserHomeNumber($intHomeNumber)
				{
								return $this->userHomeNumber = $intHomeNumber;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserHomeNumber
				Overview:	Function to get the user deleted attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserHomeNumber()
				{
								if(isset($this->userHomeNumber))
								{
												return $this->userHomeNumber;
								}
				}



				/*----------------------------------------------------------------------------------
				Function:	setUserMobileNumber
				Overview:	Function to set the user deleted attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function setUserMobileNumber($intMobileNumber)
				{
								return $this->userMobileNumber = $intMobileNumber;
				}

				/*----------------------------------------------------------------------------------
				Function:	getUserMobileNumber
				Overview:	Function to get the user deleted attribute

				In:


				Out:     true/false      bool
	----------------------------------------------------------------------------------*/
				public function getUserMobileNumber()
				{
								if(isset($this->userMobileNumber))
								{
												return $this->userMobileNumber;
								}
				}


}

?>