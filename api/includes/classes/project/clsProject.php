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

					case "getProjectUsers":
						return $this->returnProjectUsers($intID);
					break;


					case "getNewProjectID":
						return $this->getNewProjectID();
					break;


					default:
						return "METHOD NOT DEFINED IN GET clsProject.php API Side";
					break;
				}
			}

			//$arrProject = $arrProjectInformation['project'];

			//foreach($arrProject as $arrIndProject)
			//{
							$bFormFailed = false;
//return $arrProjectInformation;

							(isset($arrProjectInformation['ID'])) ? $this->setProjectID($arrProjectInformation['ID']) : '';

							(isset($arrProjectInformation['projectOwner'])) ? $this->setProjectOwner($arrProjectInformation['projectOwner']) : $bFormFailed = true;
							(isset($arrProjectInformation['projectTitle'])) ? $this->setProjectTitle($arrProjectInformation['projectTitle']) : $bFormFailed = true;
							(isset($arrProjectInformation['projectDescription'])) ? $this->setProjectDescription($arrProjectInformation['projectDescription']) : $bFormFailed = true;
							(isset($arrProjectInformation['projectStart'])) ? $this->setProjectStart($arrProjectInformation['projectStart']) : $bFormFailed = true;
							(isset($arrProjectInformation['projectFinish'])) ? $this->setProjectFinish($arrProjectInformation['projectFinish']) : $bFormFailed = true;
							(isset($arrProjectInformation['projectImportance'])) ? $this->setProjectImportance($arrProjectInformation['projectImportance']) : $bFormFailed = true;


							if($bFormFailed)
							{

									return false;
							}

							switch($operation)
							{
								case 'createProject':

									return $this->createProject();
								break;


								case 'getAllProjects':
									return $this->returnAllProjects();
								break;

							}

			//}
		}

		public function createProject()
		{
			$arrFields = array("projectOwner","projectTitle","projectDescription","projectStart","projectFinish","projectImportance");
            $arrValues = array($this->projectOwner, $this->projectTitle, $this->projectDescription, $this->projectStart, $this->projectFinish, $this->projectImportance);


            $objDatabase = new Database();
            $objFeedback = new Feedback();

            if($objDatabase->insert('projects',$arrFields,$arrValues))
            {
                    return true;
            }
            return false;
		}

		public function returnAllProjects()
		{
			$objDatabase = new Database();

		}


		public function returnSingleProject($id)
		{
			$objDatabase = new Database();
			return $objDatabase->returnRow("projects","projectID",$id);
		}



		public function getNewProjectID()
		{
			$objDatabase = new Database();
			return $objDatabase->getHighestIDOnTable("projectID", "projects");
		}


		public function returnProjectUsers($id)
		{
			$objDatabase = new Database();
			$query = "SELECT projectteam.projectID, projectteam.teamID, employeeteams.employeeID
						FROM projectteam
						INNER JOIN employeeteams
						ON projectteam.teamID=employeeteams.teamID
						WHERE projectteam.projectID = '".$id."'";
			$dbSet = $objDatabase->result($query);


			$arrProjectUsers = array();
			if($objDatabase->exists($dbSet))
			{
				while($row = mysqli_fetch_array($dbSet, MYSQL_ASSOC))
				{
                	array_push($arrProjectUsers, $row['employeeID']);
				}

                return $arrProjectUsers;
			}

			return false;
		}


		public function setProjectID($intProjectID)
		{
			return $this->projectID = $intProjectID;

			return true;
		}

		public function setProjectOwner($intProjectOwnerID)
		{
			return $this->projectOwner = $intProjectOwnerID;
			return true;
		}

		public function setProjectTitle($strProjectTitle)
		{
			return $this->projectTitle = $strProjectTitle;
			return true;
		}
		public function setProjectDescription($setProjectDescription)
		{
			return $this->projectDescription = $setProjectDescription;
			return true;
		}
		public function setProjectStart($strProjectStart)
		{
			return $this->projectStart = $strProjectStart;
			return true;
		}
		public function setProjectFinish($strProjectFinish)
		{
			return $this->projectFinish = $strProjectFinish;
			return true;
		}
		public function setProjectImportance($strImportance)
		{
			return $this->projectImportance = $strImportance;
			return true;
		}


}



?>