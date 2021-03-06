<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsBug.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle bug management
-----------------------------------------------------------------------------------------------------------
History:
06/12/2014      1.0	MJC	Created
07/12/2014      1.1     MJC     Finished main methods
-----------------------------------------------------------------------------------------------------------
Uses:

*/

Class Bug
{
        private $bugID;
        private $bugTitle;
        private $bugDescription;
        private $bugLine;
        private $bugReportedBy;
        private $bugFixed;
        private $bugDeleted;


        /*----------------------------------------------------------------------------------
      	Function:	init
      	Overview:	Function to initialize object attributes

      	In:      $operation      String          Operation(create,delete,update)
                 $arrBugInfo     Array           Array of bug information


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function init($operation,$intID=0,$arrBugInformation=array())
        {


            $objFeedback = new Feedback();

            if(count($arrBugInformation)<1)
            {
              switch($operation)
              {
                case "returnProjectBugs":
                  return $this->returnBugsByProjectID($intID);
                break;

                case "getFixedBugsByProject":
                  return $this->getFixedBugsByProject($intID);
                break;

                case "getUnfixedBugsByProject":
                  return $this->getUnfixedBugsByProject($intID);
                break;


                case "returnSingleBug":
                  return $this->getSingleBug($intID);
                break;

                case "markBugAsFixed":
                  return $this->markBugAsFixed($intID);
                break;

                case "markBugAsUnfix":
                  return $this->markBugAsUnfix($intID);
                break;

              }
            }


                //$arrBug = $arrBugnformation['bug'];

                //foreach($arrBug as $arrIndBug)
                //{
                        $bFormFailed = false;

                        (isset($arrBugInformation['ID'])) ? $this->setBugID($arrBugInformation['ID']) : '';

                        (isset($arrBugInformation['bugTitle'])) ? $this->setBugTitle($arrBugInformation['bugTitle']) : $bFormFailed = true;
                        (isset($arrBugInformation['bugDescription'])) ? $this->setBugDescription($arrBugInformation['bugDescription']) : $bFormFailed = true;
                        (isset($arrBugInformation['bugLine'])) ? $this->setBugLine($arrBugInformation['bugLine']) : $bFormFailed = true;
                        (isset($arrBugInformation['bugReportedBy'])) ? $this->setBugReportedBy($arrBugInformation['bugReportedBy']) : $bFormFailed = true;
                        (isset($arrBugInformation['bugFixed'])) ? $this->setBugFixed($arrBugInformation['bugFixed']) : $bFormFailed = true;
                        (isset($arrBugInformation['bugDeleted'])) ? $this->setBugDeleted($arrBugInformation['bugDeleted']) : $bFormFailed = true;
                        (isset($arrBugInformation['projectID'])) ? $this->setBugProject($arrBugInformation['projectID']) : $bFormFailed = true;


                        if($bFormFailed)
                        {
                                return $objFeedback->setFeedback("Operation Failed - Form Fields Not Valid");
                        }

                        switch($operation)
                        {

                                case 'createBug':
                                        return $this->createBug();
                                break;


                                case 'update':
                                        return $this->updateBug();
                                break;


                                case 'delete':
                                        return $this->deleteBug();
                                break;

                        }

                //}

        }

        /*----------------------------------------------------------------------------------
          Function: markBugAsFixed
          Overview: Function to mark bug as fixed

          In:      $id         int          Bug id

          Out:   true/false      bool
        ----------------------------------------------------------------------------------*/
        public function markBugAsFixed($id)
        {
          $objDatabase = new Database();
          return $objDatabase->update("bugs", "bugFixed", 1, "bugID", $id);
        }

        /*----------------------------------------------------------------------------------
          Function: markBugAsUnfix
          Overview: Function to mark bug as unfixed

          In:      $id         int          Bug id

          Out:   true/false      bool
        ----------------------------------------------------------------------------------*/
        public function markBugAsUnfix($id)
        {
          $objDatabase = new Database();
          return $objDatabase->update("bugs", "bugFixed", 0, "bugID", $id);
        }

        /*----------------------------------------------------------------------------------
          Function: getSingleBug
          Overview: Function to return bug information by its id

          In:      $id         int          Bug id

          Out:   array
        ----------------------------------------------------------------------------------*/
        public function getSingleBug($id)
        {
          $objDatabase = new Database();
          return $objDatabase->returnRow("bugs", "bugID", $id);
        }

        /*----------------------------------------------------------------------------------
          Function: getFixedBugsByProject
          Overview: Function to return fixed bugs by project id

          In:      $id         int          project id

          Out:   int  total rows
        ----------------------------------------------------------------------------------*/
        public function getFixedBugsByProject($id)
        {
          $objDatabase = new Database();
          return $objDatabase->countSpecificRows("bugID", "bugs","projectID",$id,"bugFixed",1);
        }


        /*----------------------------------------------------------------------------------
          Function: getUnfixedBugsByProject
          Overview: Function to return total number of unfixed bugs in the system

          In:      $id         int          project id

          Out:   true/false      bool
        ----------------------------------------------------------------------------------*/
        public function getUnfixedBugsByProject($id)
        {
          $objDatabase = new Database();
          return $objDatabase->countSpecificRows("bugID", "bugs","projectID",$id,"bugFixed",0);
        }

        /*----------------------------------------------------------------------------------
          Function: returnBugsByProjectID
          Overview: Function to return bugs by project id

          In:      $id         int          project id

          Out:   true/false      bool
        ----------------------------------------------------------------------------------*/
        public function returnBugsByProjectID($id)
        {
          $objDatabase = new Database();
          return $objDatabase->returnAllRowsWhere("bugs","projectID",$id);
        }

        /*----------------------------------------------------------------------------------
      	Function:	createBug
      	Overview:	Function to create a bug

      	In:


      	Out:     true/false      bool
	     ----------------------------------------------------------------------------------*/
        public function createBug()
        {
                $arrFields = array("bugTitle","bugDescription","bugLine","bugReportedBy","bugFixed","bugDeleted", "projectID");
                $arrValues = array($this->getBugTitle(),$this->getBugDescription(),$this->getBugLine(),$this->getBugReportedBy(),$this->getBugFixed(),$this->getBugDeleted(), $this->bugProjectID);

                $objDatabase = new Database();
                $objFeedback = new Feedback();

                if($objDatabase->insert('bugs',$arrFields,$arrValues))
                {
                        return true;
                }
                return false;
        }


        /*----------------------------------------------------------------------------------
      	Function:	updateBug
      	Overview:	Function to update attributes of a bug

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function updateBug()
        {
                $objDatabase = new Database();

                $bUpdateFailed = false;

                ($strError = $objDatabase->update("bugs","bugTitle",$this->getBugTitle(),"bugID",$this->getBugID())) ? '' : $bUpdateFailed = true;
                ($objDatabase->update("bugs","bugDescription",$this->getBugDescription(),"bugID",$this->getBugID())) ? '' : $bUpdateFailed = true;
                ($objDatabase->update("bugs","bugLine",$this->getBugLine(),"bugID",$this->getBugID())) ? '' : $bUpdateFailed = true;
                ($objDatabase->update("bugs","bugReportedBy",$this->getBugReportedBy(),"bugID",$this->getBugID())) ? '' : $bUpdateFailed = true;
                ($objDatabase->update("bugs","bugFixed",$this->getBugFixed(),"bugID",$this->getBugID())) ? '' : $bUpdateFailed = true;
                ($objDatabase->update("bugs","bugDeleted",$this->getBugDeleted(),"bugID",$this->getBugID())) ? '' : $bUpdateFailed = true;


                $objFeedback = new Feedback();

                if($bUpdateFailed)
                {
                        return false;
                }
                return true;
        }


        /*----------------------------------------------------------------------------------
      	Function:	deleteBug
      	Overview:	Function to delete a bug from the system

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function deleteBug()
        {
                $objDatabase = new Database();
                $objFeedback = new Feedback();

                if($objDatabase->update("bugs","bugDeleted",1,"bugID",$this->getBugID()))
                {
                        return true;
                }
                return false;
        }





        /*----------------------------------------------------------------------------------
      	Function:	getBug
      	Overview:	Function to return bug attribute from the database

      	In:      $intBugID       Integer         Bug ID


      	Out:     $arrRow         Array           Bug information
	----------------------------------------------------------------------------------*/
        public function getBug($intBugID)
        {
                $objDatabase = new Database();

                $arrRow = $objDatabase->returnRow('bugs','bugID',$intBugID);

                if(!$arrRow)
                {
                        return $objDatabase->getErrors();
                }
                return $arrRow;
        }





        /*----------------------------------------------------------------------------------
      	Function:	setBugID
      	Overview:	Function to set the bug ID attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugID($intBugID)
        {
                return $this->bugID = $intBugID;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugID
      	Overview:	Function to return the bug ID attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugID()
        {
                if(isset($this->bugID))
                {
                        return $this->bugID;
                }
        }

        /*----------------------------------------------------------------------------------
      	Function:	setBugTitle
      	Overview:	Function to set the bug title attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugTitle($strBugTitle)
        {
                return $this->bugTitle = $strBugTitle;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugTitle
      	Overview:	Function to return the bug title attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugTitle()
        {
                if(isset($this->bugTitle))
                {
                        return $this->bugTitle;
                }
        }


        /*----------------------------------------------------------------------------------
      	Function:	setBugDescription
      	Overview:	Function to set the bug description attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugDescription($strBugDescription)
        {
                return $this->bugDescription = $strBugDescription;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugDescription
      	Overview:	Function to get the bug description attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugDescription()
        {
                if(isset($this->bugDescription))
                {
                        return $this->bugDescription;
                }
        }



        /*----------------------------------------------------------------------------------
      	Function:	setBugLine
      	Overview:	Function to set the bug line attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugLine($intBugLine)
        {
                return $this->bugLine = $intBugLine;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugLine
      	Overview:	Function to get the bug line attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugLine()
        {
                if(isset($this->bugLine))
                {
                        return $this->bugLine;
                }
        }


        /*----------------------------------------------------------------------------------
      	Function:	setBugReportedBy
      	Overview:	Function to set the bug reportedby attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugReportedBy($strBugReportedBy)
        {
                return $this->bugReportedBy = $strBugReportedBy;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugReportedBy
      	Overview:	Function to get the bug reportedby attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugReportedBy()
        {
                if(isset($this->bugReportedBy))
                {
                        return $this->bugReportedBy;
                }
        }


        /*----------------------------------------------------------------------------------
      	Function:	setBugFixed
      	Overview:	Function to set the bug fixed attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugFixed($bBugFixed)
        {
                return $this->bugFixed = $bBugFixed;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugFixed
      	Overview:	Function to get the bug fixed attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugFixed()
        {
                if(isset($this->bugFixed))
                {
                        return $this->bugFixed;
                }
        }


        /*----------------------------------------------------------------------------------
      	Function:	setBugDeleted
      	Overview:	Function to set the bug deleted attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setBugDeleted($bBugDeleted)
        {
                return $this->bugDeleted = $bBugDeleted;
        }

        /*----------------------------------------------------------------------------------
      	Function:	getBugDeleted
      	Overview:	Function to get the bug deleted attribute

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function getBugDeleted()
        {
                if(isset($this->bugDeleted))
                {
                        return $this->bugDeleted;
                }
        }


        /*----------------------------------------------------------------------------------
          Function: setBugProject
          Overview: Set bug's project id

          In:      $id         int          project id

          Out:   true/false      bool
        ----------------------------------------------------------------------------------*/
        public function setBugProject($id)
        {
          $this->bugProjectID = $id;
          return true;
        }


}

?>