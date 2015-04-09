<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsSecurity.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to security aspects of the system
-----------------------------------------------------------------------------------------------------------
History:
06/03/2015      1.0 MJC Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

class Security
{

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


	public function secureUrl()
	{
		global $configArray;

		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$arrIllegal = array("'",'"');

		foreach($arrIllegal as $arrIndIllegal)
		{
			$pos = strpos($url, $arrIndIllegal);

			if($pos !== false)
			{
				die(header("Location: ".$configArray['FALL_BACK']));
			}
		}

	}
}

?>