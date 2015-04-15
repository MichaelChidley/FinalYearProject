<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsAPI.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Function to handle core API functionality
-----------------------------------------------------------------------------------------------------------
History:
06/03/2015      1.0 MJC Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

class API
{
	private $APIURL;
	private $APIKEY;

	private $APIResponse;


	/*----------------------------------------------------------------------------------
	Function: API
	Overview: Constructor function to set up initial object variables

	In:      $strAPIURL    String     String containing the API URL address
			 $strAPIKey		String    String containing the API key


	Out:	bool 	true
	----------------------------------------------------------------------------------*/
	public function API($strAPIURL, $strAPIKey)
	{
		$this->APIURL = $strAPIURL;
		$this->APIKEY = $strAPIKey;

		return true;
	}


	/*----------------------------------------------------------------------------------
	Function: handleAPICall
	Overview: Top level method to handle API process calls

	In:      $arrPostInfo	Array 		Array of information, if not empty its a post request
			 $strModule     String     	Module name, if set it is a get request
			 $intID		    int  	 	Integer of the row to return of the module


	Out:	bool 	true
	----------------------------------------------------------------------------------*/
	public function handleAPICall($arrPostInfo=array(),$strModule=0,$method=0,$intID=0)
	{
		if(count($arrPostInfo) > 0)
		{
			//we know if the array has info it is a post method..
			return $this->handleAPIPost($arrPostInfo, $strModule, $method);
		}
		else
		{
			//otherwise it is going to be a get.
			return $this->handleAPIGet($strModule,$method,$intID);
		}
	}


	/*----------------------------------------------------------------------------------
	Function: handleAPIPost
	Overview: Functionality to handle post api calls

	In:      $arrayData	Array 		Array of information, if not empty its a post request

	Out:	bool 	true
	----------------------------------------------------------------------------------*/
	public function handleAPIPost($arrayData, $strModule, $strMethod)
	{
		$objSecurity = new Security();

		$arrayData["APIKey"] = $this->APIKEY;
		$arrayData["module"] = $strModule;
		$arrayData["method"] = $strMethod;

		$arrayData = $objSecurity->encryptInformation($arrayData);

		$curl = curl_init();
		$timeout = 5;



		curl_setopt($curl,CURLOPT_URL, $this->APIURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query(array("data"=>$arrayData)));

		$returnData = curl_exec($curl);



/******* DEBUG TO OUTPUT API INFORMATION USE VARIABLE BELOW!! ***************/
		//echo $returnData;


		curl_close($curl);

		$this->APIResponse = $returnData;

		return true;
	}



	/*----------------------------------------------------------------------------------
	Function: handleAPIGet
	Overview: Functionality to handle post api calls

	In:		 $strModule     String     	Module name, if set it is a get request
			 $intID		    int  	 	Integer of the row to return of the module

	Out:	bool 	true
	----------------------------------------------------------------------------------*/
	public function handleAPIGet($strModule, $strMethod, $intID)
	{

		//using curl to handle requests!
		//url: baseurl/key/module/id

		$curl = curl_init();
		$timeout = 5;


		curl_setopt($curl, CURLOPT_URL, $this->APIURL.$this->APIKEY."/".$strModule."/".$strMethod."/".$intID);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

		$returnData = curl_exec($curl);
		curl_close($curl);

		$this->APIResponse = $returnData;

		return true;

	}


	/*----------------------------------------------------------------------------------
	Function: getAPIResponse
	Overview: Basic method to output the response of the API

	In:

	Out:	$this->APIResponse 	String 	API Response
	----------------------------------------------------------------------------------*/
	public function getAPIResponse()
	{
		$objSecurity = new Security();

		//return $this->convertJsonArrayToArray($objSecurity->decryptInformation($this->APIResponse));
		return $objSecurity->decryptInformation($this->APIResponse);
	}


	public function buildAPIRequest($strModule,$strOperation,$arrData)
	{
		return array("module"=>$strModule,"operation"=>$strOperation,"data" => $arrData,"APIKey"=>$this->APIKEY);
	}

	public function isSuccessful($jsonString)
	{
		if(strpos($jsonString, "Operation Successful") !==false )
		{
			return true;
		}
		return false;
	}


	public function convertJsonArrayToArray($jsonString)
	{
		return json_decode($jsonString, true);
	}

}


?>