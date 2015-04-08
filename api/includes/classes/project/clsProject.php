<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsProject.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle project operations
-----------------------------------------------------------------------------------------------------------
History:
09/12/2014      1.0	MJC	Created
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Project
{
		private $projectID;
		private $projectOwner;
		private $projectTitle;
		private $projectDescription;
		private $projectStart;
		private $projectFinish;
		private $projectImportance;


        public function init($operation,$intID=0,$arrProjectInformation=array())
        {


			$objFeedback = new Feedback();

			if(count($arrProjectInformation)<1)
			{
				switch($operation)
				{
					case "returnAllProjects":
						return $this->returnAllProjects();
					break;



					case "returnSingleProject":
						return $this->returnSingleProject($intID);
					break;
				}
			}

			$arrProject = $arrProjectInformation['project'];

			foreach($arrProject as $arrIndProject)
			{
							$bFormFailed = false;

							(isset($arrIndProject['ID'])) ? $this->setProjectID($arrIndProject['ID']) : '';

							(isset($arrIndProject['projectOwner'])) ? $this->setProjectOwner($arrIndProject['projectOwner']) : $bFormFailed = true;
							(isset($arrIndProject['projectTitle'])) ? $this->setProjectTitle($arrIndProject['projectTitle']) : $bFormFailed = true;
							(isset($arrIndProject['projectDescription'])) ? $this->setProjectDescription($arrIndProject['projectDescription']) : $bFormFailed = true;
							(isset($arrIndProject['projectStart'])) ? $this->setProjectStart($arrIndProject['projectStart']) : $bFormFailed = true;
							(isset($arrIndProject['projectFinish'])) ? $this->setProjectFinish($arrIndProject['projectFinish']) : $bFormFailed = true;
							(isset($arrIndProject['projectImportance'])) ? $this->setProjectImportance($arrIndProject['projectImportance']) : $bFormFailed = true;


							if($bFormFailed)
							{
									return false;
							}

							switch($operation)
							{

								case 'getAllProjects':
									return $this->returnAllProjects();
								break;

							}

			}
		}


		public function returnAllProjects()
		{
			$objDatabase = new Database();
			return $objDatabase->returnAllRows("projects");
		}


		public function returnSingleProject($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("projects","projectID",$id);
		}


		public function setProjectID($intProjectID)
		{
			return $this->projectID = $intProjectID;
		}

		public function setProjectOwner($intProjectOwnerID)
		{
			return $this->projectOwner = $intProjectOwnerID;
		}

		public function setProjectTitle($strProjectTitle)
		{
			return $this->projectTitle = $strProjectTitle;
		}
		public function setProjectDescription($setProjectDescription)
		{
			return $this->projectDescription = $setProjectDescription;
		}
		public function setProjectStart($strProjectStart)
		{
			return $this->projectStart = $strProjectStart;
		}
		public function setProjectFinish($strProjectFinish)
		{
			return $this->projectFinish = $strProjectFinish;
		}


}



?>