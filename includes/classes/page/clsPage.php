<?php

class Page
{
	public function getRequestedPage()
	{
		global $configArray;

		$requestedPage = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$requestedPage = str_replace($configArray['SITE_URL'],'',$requestedPage);

		if($requestedPage !== '')
		{
			return $requestedPage;
		}
		return false;
	}


	public function getPageTitle($pageName)
	{
		global $configArray;

		$pageName = explode("/",$pageName);

		$pageName = $pageName[0];

		if($pageName !== "")
		{
			return $configArray[$pageName]['title'];
		}
		return $configArray['default']['title'];

	}
}

?>