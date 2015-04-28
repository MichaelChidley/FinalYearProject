<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsClient.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle client information
-----------------------------------------------------------------------------------------------------------
History:
07/04/2015      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Client
{

	private $title;
	private $firstname;
	private $lastname;
	private $email;
	private $contact;

		/*----------------------------------------------------------------------------------
  	Function:	init
  	Overview:	Function to initialize the request method for this module

  	In:      $operation         String          Method
  			 $intID 			int 			Integer of value to edit, used for post
  			 $arrClientInformation	array 	Array of post information

  	Out:	 object response
	----------------------------------------------------------------------------------*/
        public function init($operation,$intID=0,$arrClientInformation=array())
        {

        	//return $arrClientInformation;
			$objFeedback = new Feedback();

			if(count($arrClientInformation)<1)
			{

				switch($operation)
				{
					case "getAllClients":
						return $this->getAllClients();
					break;

					case "getNewClientID":
						return $this->getNewClientID();
					break;

				}
			}




			$bFormFailed = false;

			(isset($arrIndActivity['ID'])) ? $this->setActivityID($arrIndActivity['ID']) : '';

			(isset($arrClientInformation['title'])) ? $this->setClientTitle($arrClientInformation['title']) : $bFormFailed = true;
			(isset($arrClientInformation['firstname'])) ? $this->setClientFirstname($arrClientInformation['firstname']) : $bFormFailed = true;
			(isset($arrClientInformation['lastname'])) ? $this->setClientLastname($arrClientInformation['lastname']) : $bFormFailed = true;
			(isset($arrClientInformation['email'])) ? $this->setClientEmail($arrClientInformation['email']) : $bFormFailed = true;
			(isset($arrClientInformation['contact'])) ? $this->setClientContact($arrClientInformation['contact']) : $bFormFailed = true;



			if($bFormFailed)
			{
					return false;
			}

			switch($operation)
			{

				case 'createClient':
					return $this->createClient();
				break;


			}


		}


		/*----------------------------------------------------------------------------------
  	Function:	getNewClientID
  	Overview:	Function to return the newest clients id

  	In:

  	Out:	 int new client id
	----------------------------------------------------------------------------------*/
		public function getNewClientID()
		{
			$objDatabase = new Database();
			return $objDatabase->getHighestIDOnTable("clientID", "clients");
		}

		/*----------------------------------------------------------------------------------
	  	Function:	getAllClients
	  	Overview:	Function to return all clients

	  	In:

	  	Out:	 array client array
		----------------------------------------------------------------------------------*/
		public function getAllClients()
		{
			$objDatabase = new Database();
			$arrClients = $objDatabase->returnAllRows("clients");

			return $arrClients;
		}

		/*----------------------------------------------------------------------------------
	  	Function:	createClient
	  	Overview:	Function to create a client

	  	In:

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/
		public function createClient()
		{

			$arrFields = array("clientTitle","clientFirstname","clientLastname","clientContactEmail","clientContactPhone");
            $arrValues = array($this->title, $this->firstname, $this->lastname, $this->email, $this->contact);


            $objDatabase = new Database();
            $objFeedback = new Feedback();

            if($objDatabase->insert('clients',$arrFields,$arrValues))
            {
                    return true;
            }
            return false;
		}


		/*----------------------------------------------------------------------------------
	  	Function:	setClientTitle
	  	Overview:	Function to set the client title

	  	In:      $title         String          client title

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/

		public function setClientTitle($title)
		{
			$this->title = $title;

			return true;
		}

		/*----------------------------------------------------------------------------------
	  	Function:	setClientFirstname
	  	Overview:	Function to set the client first name

	  	In:      $firstname         String          client first name

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/

		public function setClientFirstname($firstname)
		{
			$this->firstname = $firstname;

			return true;
		}

		/*----------------------------------------------------------------------------------
	  	Function:	setClientLastname
	  	Overview:	Function to set the client last name

	  	In:      $lastname         String          client lastname

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/

		public function setClientLastname($lastname)
		{
			$this->lastname = $lastname;

			return true;
		}

		/*----------------------------------------------------------------------------------
	  	Function:	setClientEmail
	  	Overview:	Function to set the client email

	  	In:      $email         String          Client email

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/

		public function setClientEmail($email)
		{
			$this->email = $email;

			return true;
		}

		/*----------------------------------------------------------------------------------
	  	Function:	setClientContact
	  	Overview:	Function to set the client contact number

	  	In:      $contact         String          Client contact number

	  	Out:	 true/false      bool
		----------------------------------------------------------------------------------*/

		public function setClientContact($contact)
		{
			$this->contact = $contact;

			return true;
		}


}



?>