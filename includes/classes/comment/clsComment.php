<?php


Class Comment
{

	private $API;

	public function Comment($API)
	{
		$this->API = $API;
	}

	public function getAllComments()
	{
		$this->API->handleAPICall(array(),"comments","returnAllComments");
		return $this->API->getAPIResponse();
	}


	public function getSingleActivity($id)
	{
		$this->API->handleAPICall(array(),"activity","returnSingleActivity",$id);
		return $this->API->getAPIResponse();
	}

	public function getActivityByProjectID($id)
	{
		$this->API->handleAPICall(array(),"activity","returnSingleActivityByPrjID",$id);
		return $this->API->getAPIResponse();
	}



}

?>