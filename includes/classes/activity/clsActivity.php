<?php


Class Activity
{

	private $API;

	public function Activity($API)
	{
		$this->API = $API;
	}

	public function getAllActivity()
	{
		$this->API->handleAPICall(array(),"activity","returnAllActivity");
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

	public function getActivitiesRelatingToUser()
	{
		//Create the initial database query using inner joins to join the required tables together
        //        $qry = "SELECT customerbikes.bikeID, bikes.bikeMake, bikes.bikeModel, bikes.bikeRegistration FROM customerbikes
        //        INNER JOIN bikes
        //        ON customerbikes.bikeID = bikes.bikeID
        //        WHERE customerbikes.customerID = '".$intCustomerID."'";
	}

}

?>