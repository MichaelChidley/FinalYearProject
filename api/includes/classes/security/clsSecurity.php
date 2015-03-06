<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsSecurity.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle security aspects
-----------------------------------------------------------------------------------------------------------
History:
01/12/2014      1.0 MJC Created
06/03/2015		1.0 MJC Added information encryption/decryption
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Security
{
	private $apiKey;
	private $apiRequestedFeature;


	/*----------------------------------------------------------------------------------
	Function:   checkKeyFeatureAccess
	Overview:   Function to check if the API key is registered to use the
				requested module

	In:


	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
	private function checkKeyFeatureAccess()
	{
		$objDatabase = new Database();
		$apiKeyID = $objDatabase->returnSingleData("apiKeyID", "apisecurity", "apiKey", $this->apiKey);

		$getFeatureID = $objDatabase->returnSingleData("featureID", "apifeatures", "featureName", $this->apiRequestedFeature);

		$strQry = "SELECT * FROM `apifeatureaccess` WHERE `apiFeatureID` = '".$getFeatureID."' AND `apiKeyID` = '".$apiKeyID."'";

		if($objDatabase->exists($objDatabase->result($strQry)))
		{
			return true;
		}
		return false;
	}


	/*----------------------------------------------------------------------------------
	Function:   checkKey
	Overview:   Function to check the API key

	In:      $key    			String          	API Key
			 $requestedModule 	String 				Module API requests to access


	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
	public function checkKey($key,$requestedModule)
	{
		$objFeedback = new Feedback();
		$this->apiKey = $key;
		$this->apiRequestedFeature = $requestedModule;
		$objDatabase = new Database();

		if($objDatabase->returnSingleData("apiKey","apisecurity","apiKey",$key) == $key)
		{
			if($this->checkKeyFeatureAccess())
			{
				return true;
			}
			return false;
		}
		else
		{
			return false;
		}

	}


	/*----------------------------------------------------------------------------------
	Function:   createAPIKey
	Overview:   Function to create an API key

	In:      $strKey    String          Random string to encrypt against the key


	Out:     $ciphertext_base64      String          API Key
	----------------------------------------------------------------------------------*/
	public function createAPIKey($strKey)
	{
		$key = "fsdka52fmafasafDAda2Cf";

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
		$strKey, MCRYPT_MODE_CBC, $iv);

		$ciphertext = $iv . $ciphertext;

		$ciphertext_base64 = base64_encode($ciphertext);

		$ciphertext_base64 = str_replace('/','-',$ciphertext_base64);

		return $ciphertext_base64;

	}


	/*----------------------------------------------------------------------------------
	Function:   decryptAPIKey
	Overview:   Function to decrypt an API key

	In:      $strKey    String               API Key


	Out:     $plaintext_dec      String      Decrypted key
	----------------------------------------------------------------------------------*/
	public function decryptAPIKey($strKey)
	{
		$ciphertext_dec = base64_decode($strKey);

		$key = "fsdka52fmafasafDAda2Cf";
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);

		$ciphertext_dec = substr($ciphertext_dec, $iv_size);

		$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
		$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

		return $plaintext_dec;
	}



	/*----------------------------------------------------------------------------------
	Function: encryptInformation
	Overview: Function to encrypt array data so if stolen over network transfer, the
				contents is still safe

	In:      $arrayInformation    Array       Information stored into an array


	Out:     $ciphertext_base64	  String      Base64 encoded string to ensure safe network transfer
	----------------------------------------------------------------------------------*/
	public function encryptInformation($arrayInformation)
	{
		$serialized = serialize($arrayInformation);

		$key = "jdjfAjfnfruj5eAfjed3DK";

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
		$serialized, MCRYPT_MODE_CBC, $iv);

		$ciphertext = $iv . $ciphertext;

		$ciphertext_base64 = base64_encode($ciphertext);


		return $ciphertext_base64;

	}


	/*----------------------------------------------------------------------------------
	Function:   decryptInformation
	Overview:   Function to decrypt information sent over the API HTTP protocol

	In:      $strInformation    String        String of encrypted information

	Out:     $arrInformation    Array      Array of information
	----------------------------------------------------------------------------------*/
	public function decryptInformation($strInformation)
	{

		$ciphertext_dec = base64_decode($strInformation);

		$key = "jdjfAjfnfruj5eAfjed3DK";
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);

		$ciphertext_dec = substr($ciphertext_dec, $iv_size);

		$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
		$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

		$arrInformation = unserialize($plaintext_dec);

		return $arrInformation;
	}


	/*----------------------------------------------------------------------------------
	Function:   cleanInput
	Overview:   Function to clean text input for safety

	In:      $strInput    String               Input string


	Out:     $strInput      String      Safe version of the string
	----------------------------------------------------------------------------------*/
	public function cleanInput($strInput)
	{
		return htmlspecialchars($strInput);
	}


	/*----------------------------------------------------------------------------------
	Function:   encryptString
	Overview:   Function to encrypt a string using custom encryption

	In:      $strInput    String               Input string


	Out:     $string      String      Encrypted string
	----------------------------------------------------------------------------------*/
	public function encryptString($strInput)
	{
		$encString = sha1(md5(strrev($strInput)));

		return $encString;
	}

}



?>