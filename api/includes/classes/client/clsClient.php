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


		public function getNewClientID()
		{
			$objDatabase = new Database();
			return $objDatabase->getHighestIDOnTable("clientID", "clients");
		}

		public function getAllClients()
		{
			$objDatabase = new Database();
			$arrClients = $objDatabase->returnAllRows("clients");

			return $arrClients;
		}


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



		public function setClientTitle($title)
		{
			$this->title = $title;

			return true;
		}

		public function setClientFirstname($firstname)
		{
			$this->firstname = $firstname;

			return true;
		}


		public function setClientLastname($lastname)
		{
			$this->lastname = $lastname;

			return true;
		}

		public function setClientEmail($email)
		{
			$this->email = $email;

			return true;
		}

		public function setClientContact($contact)
		{
			$this->contact = $contact;

			return true;
		}


}



?>