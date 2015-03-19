<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsLogin.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle login operation
-----------------------------------------------------------------------------------------------------------
History:
06/03/2015		1.0 MJC Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Login
{

	private $pusername;
	private $ppassword;

	/*----------------------------------------------------------------------------------
      	Function:	init
      	Overview:	Function to initialize object attributes

      	In:      $operation      String          Operation(create,delete,update)
                 $arrLoginInfo     Array           Array of login information


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
    public function init($operation,$arrLoginInfo)
    {
            $objFeedback = new Feedback();

            $arrLogin = $arrLoginInfo['login'];

            foreach($arrLogin as $arrIndLogin)
            {
                    $bFormFailed = false;

                    (isset($arrIndLogin['username'])) ? $this->setUsername($arrIndLogin['username']) : $bFormFailed = true;
                    (isset($arrIndLogin['password'])) ? $this->setPassword($arrIndLogin['password']) : $bFormFailed = true;

                    if($bFormFailed)
                    {
                            return $objFeedback->setFeedback("Operation Failed - Form Fields Not Valid");
                    }

                    switch($operation)
                    {

                            case 'login':
                                    return $this->authenticateLogin();
                            break;
                    }

            }

    }

    private function setUsername($strUsername)
    {
    	$this->pusername = $strUsername;

    	return true;
    }


    private function setPassword($strPassword)
    {
    	$this->ppassword = $strPassword;

    	return true;
    }


	/*----------------------------------------------------------------------------------
	Function:   authenticateLogin
	Overview:   Authenticates a user

	In:		$username 	String 	String containing the username
			$password   String 	String containing the password

	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
	public function authenticateLogin()
	{
		$objDatabase = new Database();

		$username = $objDatabase->returnSingleData("email", "employees", "email", $this->pusername);
		$password = $objDatabase->returnSingleData("password", "employees", "password", $this->ppassword);

		if(($this->pusername == $username) && ($this->ppassword == $password))
		{
			return true;
		}
		return false;
	}

}


?>