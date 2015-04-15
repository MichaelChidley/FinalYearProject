<?php

class Client
{
	private $API;


	private $title;
	private $firstname;
	private $lastname;
	private $email;
	private $contact;

	public function Client($API)
	{
		$this->API = $API;
	}


	public function createClient()
	{
		$this->API->handleAPICall(array("title" => $this->title, "firstname" => $this->firstname, "lastname" => $this->lastname,
			"email" => $this->email, "contact" => $this->contact),"client","createClient");
		return $this->API->getAPIResponse();
	}


	public function getAllClients()
	{
		$this->API->handleAPICall(array(),"client","getAllClients");
		return $this->API->getAPIResponse();
	}

	public function getNewClientID()
	{

		$this->API->handleAPICall(array(),"client","getNewClientID");

		return $this->API->getAPIResponse();
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