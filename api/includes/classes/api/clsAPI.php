<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsAPI.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle the API operations
-----------------------------------------------------------------------------------------------------------
History:
01/12/2014      1.0 MJC Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/


Class API
{
				private $method;
				private $response;

				private $receivedAPIKey;

				private $location = "/Uni/FinalYearProject/api/";


				private $objFeedback;


				/*----------------------------------------------------------------------------------
				Function: API
				Overview: Contstrutor function to create private feedback object

				In:


				Out:     $this->objFeedback      Object      Object instance
				----------------------------------------------------------------------------------*/
				public function API()
				{
						return $this->objFeedback = new Feedback();
				}


				/*----------------------------------------------------------------------------------
				Function: APIResponse
				Overview: Function to set the private response variable

				In:      $response    Mixed              Response data


				Out:     $this->response      String      Set variable value
				----------------------------------------------------------------------------------*/
				private function APIResponse()
				{
						return $this->response = $this->objFeedback->packageInformation($this->objFeedback->getFeedback());

				}


				/*----------------------------------------------------------------------------------
				Function: keyExists
				Overview: Function to check if a key exists in a given array

				In:      $array    Array               Array of data
								 $key      Mixed               Key to check in array of data


				Out:     true/false      bool
				----------------------------------------------------------------------------------*/
				private function keyExists($array, $key)
				{
						if(isset($array[$key]))
						{
								return true;
						}
						else
						{
								return false;
						}
				}


				/*----------------------------------------------------------------------------------
				Function: handleAPIGetCall
				Overview: Function to handle GET calls

				In:

				Out:
				----------------------------------------------------------------------------------*/
				private function handleAPIGetCall()
				{

								$requestedPage = $_SERVER["REQUEST_URI"];

								$requestedPage = str_replace($this->location, '', $requestedPage);

								$arrPages = explode('/',$requestedPage);


								//***URL ELEMENTS
								//0 - API KEY
								//1 - REQUESTED MODULE
								//2 - ID

								if(count($arrPages)>=2)
								{
										$apikey = $arrPages[0];

										$this->receivedAPIKey = $apikey;
										$this->requestedFeature = $arrPages[1];

										if($this->checkKeyValidation())
										{
												$requestedModule = $arrPages[1];

												$requestedMethod = $arrPages[2];
												if(isset($arrPages[3]))
												{
														$id = $arrPages[3];
												}


												//$this->objFeedback->setFeedback($requestedMethod);
												//return $this->APIResponse();

												switch($requestedModule)
												{
														case 'bug':
																		$objBug = new Bug();
																		$this->objFeedback->setFeedback($objBug->init($requestedMethod, $id));
																		return $this->APIResponse();
														break;

														case 'user':
																		$objUser = new User();
																		$this->objFeedback->setFeedback($objUser->getUser($id));
																		return $this->APIResponse();
														break;


														case "team":
																		$objTeam = new Team();
																		$this->objFeedback->setFeedback($objTeam->init($requestedMethod, $id));
																		return $this->APIResponse();
														break;


														case "project":
																		$objProject = new Project();
																		$this->objFeedback->setFeedback($objProject->init($requestedMethod, $id));
																		return $this->APIResponse();
														break;


														case "activity":
																		$objActivity = new Activity();
																		$this->objFeedback->setFeedback($objActivity->init($requestedMethod,$id));
																		return $this->APIResponse();
														break;

														case "employee":
																		$objEmployee = new Employee();
																		$this->objFeedback->setFeedback($objEmployee->init($requestedMethod,$id));
																		return $this->APIResponse();
														break;

														case "comments":
																		$objComment = new Comment();
																		$this->objFeedback->setFeedback($objComment->init($requestedMethod,$id));
																		return $this->APIResponse();
														break;


														case "client":

																		$objClient = new Client();
																		$this->objFeedback->setFeedback($objClient->init($requestedMethod,$id));
																		return $this->APIResponse();

														case "sprint":

																		$objSprint = new Sprint();
																		$this->objFeedback->setFeedback($objSprint->init($requestedMethod,$id));
																		return $this->APIResponse();

														case "backlog":

																		$objBacklog = new Backlog();
																		$this->objFeedback->setFeedback($objBacklog->init($requestedMethod,$id));
																		return $this->APIResponse();

														default:
																		$this->objFeedback->setFeedback("Invalid get method type");
																		return $this->APIResponse();
														break;
												}
										}
										else
										{
												$this->objFeedback->setFeedback("API Key Is Not Valid Or Is Unable To Access This Module");
												return $this->APIResponse();
										}


								}
								else
								{
										$this->objFeedback->setFeedback("Insufficient Parameters, refer to documentation for correct usage");
										return $this->APIResponse();
								}

				}


				/*----------------------------------------------------------------------------------
				Function: handleAPIDeleteCall
				Overview: Function to handle DELETE calls

				In:

				Out:
				----------------------------------------------------------------------------------*/
				private function handleAPIDeleteCall()
				{
						$this->APIResponse("Handling Delete Request...");
				}


				/*----------------------------------------------------------------------------------
				Function: handleAPIPostCall
				Overview: Function to handle POST calls

				In:

				Out:
				----------------------------------------------------------------------------------*/
				private function handleAPIPostCall()
				{
						$objSecurity = new Security();
						$_POST = $objSecurity->decryptInformation($_POST['data']);
						if(is_array($_POST))
						{


								//**POST ELEMENTS
								//APIKEY - API KEY
								//MODULE - MODULE
								//DATA - ARRAY OF INFO

								if(isset($_POST['APIKey']))
								{
										if(strlen($_POST['APIKey']) == 64)
										{
												$this->receivedAPIKey = $_POST['APIKey'];
												$this->requestedFeature = $_POST['module'];
												$this->method = $_POST['method'];
//$this->objFeedback->setFeedback($_POST);
//																return $this->APIResponse();

												if($this->checkKeyValidation())
												{

														 //if((isset($this->requestedFeature))
														// {

																switch($_POST['module'])
																{
																		case 'bug':
																				$objBug = new Bug();
																				$this->objFeedback->setFeedback($objBug->init($_POST['operation'],$_POST['data']));
																				return $this->APIResponse();
																		break;

																		case 'user':
																				$objUser = new User();
																				$this->objFeedback->setFeedback($objUser->init($_POST['operation'],$_POST['data']));
																				return $this->APIResponse();
																		break;

																		case 'team':
																				$objTeam = new Team();
																				$this->objFeedback->setFeedback($objTeam->init($_POST['operation'],$_POST['data']));
																				return $this->APIResponse();
																		break;


																		case 'login':
																				$objLogin = new Login();
																				$this->objFeedback->setFeedback($objLogin->init($_POST['operation'],$_POST['data']));
																				return $this->APIResponse();
																		break;

																		case 'client':
																			$objClient = new Client();
																				$this->objFeedback->setFeedback($objClient->init($this->method,0,$_POST));
																			return $this->APIResponse();


																		case 'project':
																			$objProject = new Project();
																				$this->objFeedback->setFeedback($objProject->init($this->method,0,$_POST));
																			return $this->APIResponse();


																		case 'sprint':
																			$objSprint = new Sprint();
																				$this->objFeedback->setFeedback($objSprint->init($this->method,0,$_POST));
																			return $this->APIResponse();

																		case 'backlog':
																			$objBacklog = new Backlog();
																				$this->objFeedback->setFeedback($objBacklog->init($this->method,0,$_POST));
																			return $this->APIResponse();


																		default:
																				$this->objFeedback->setFeedback("Invalid post method type");
																				return $this->APIResponse();
																		break;
																}

														 /*}
														 else
														 {
																$this->objFeedback->setFeedback("Action Is Not Defined");
																return $this->APIResponse();
														 }*/
												}
												else
												{
														$this->objFeedback->setFeedback("API Key Is Not Valid Or Is Unable To Access This Module");
														return $this->APIResponse();
												}
										}
										else
										{
												 $this->objFeedback->setFeedback("API Key Is An Invalid Length");
												return $this->APIResponse();
										}
								}
								else
								{
										//$this->objFeedback->setFeedback("API Key not set");
										$this->objFeedback->setFeedback($_POST);
										return $this->APIResponse();
								}

						}
				}


				/*----------------------------------------------------------------------------------
				Function: checkKeyValidation
				Overview: Function to check the validity of the given API key

				In:

				Out:     true/false      bool
				----------------------------------------------------------------------------------*/
				private function checkKeyValidation()
				{
								$objSecurity = new Security();

								if($objSecurity->checkKey($this->receivedAPIKey,$this->requestedFeature))
								{
												return true;
								}
								else
								{
												return false;
								}
				}


				/*----------------------------------------------------------------------------------
				Function: setMethod
				Overview: Function to set the requested API method

				In:      $strMethod      String          Method type

				Out:     true/false      bool
				----------------------------------------------------------------------------------*/
				public function setMethod($strMethod)
				{
						switch($strMethod)
						{
								case "GET":
										$strMethod = "GET";
										$this->handleAPIGetCall();
								break;


								case "POST":
										$strMethod = "POST";
										$this->handleAPIPostCall();
								break;


								case "PUT":
										$strMethod = "PUT";
								break;


								case "DELETE":
										$strMethod = "DELETE";
										$this->handleAPIDeleteCall();
								break;


								default:
										$strMethod = "NULL";
										$this->objFeedback->setFeedback("Invalid Operation");
										return $this->APIResponse();
								break;
						}
						if($this->method = $strMethod)
						{
								return true;
						}
						return false;
				}

				/*----------------------------------------------------------------------------------
				Function: getMethod
				Overview: Function to return the defined method

				In:

				Out:     $this->method   String  Method type
				----------------------------------------------------------------------------------*/
				public function getMethod()
				{
						return $this->method;
				}


				/*----------------------------------------------------------------------------------
				Function: getAPIResponse
				Overview: Function to return the result of the API

				In:

				Out:     $this->response         Mixed           API response
				----------------------------------------------------------------------------------*/
				public function getAPIResponse()
				{
						return $this->response;
				}


				/*----------------------------------------------------------------------------------
				Function: setRequestedByURL
				Overview: Function to set the requestedByURL private variable

				In:      $strURL         String          URL

				Out:     $this->requestedByURL   String  Set private variable
				----------------------------------------------------------------------------------*/
				public function setRequestedByURL($strURL)
				{
						$this->requestedByURL = $strURL;
				}


}


?>