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
        public function init($operation,$arrBugInfo)
        {
                $objFeedback = new Feedback();

                $arrBug = $arrBugInfo['bug'];

                foreach($arrBug as $arrIndBug)
                {
                        $bFormFailed = false;

                        (isset($arrIndBug['ID'])) ? $this->setBugID($arrIndBug['ID']) : '';

                        (isset($arrIndBug['title'])) ? $this->setBugTitle($arrIndBug['title']) : $bFormFailed = true;
                        (isset($arrIndBug['description'])) ? $this->setBugDescription($arrIndBug['description']) : $bFormFailed = true;
                        (isset($arrIndBug['line'])) ? $this->setBugLine($arrIndBug['line']) : $bFormFailed = true;
                        (isset($arrIndBug['reportedby'])) ? $this->setBugReportedBy($arrIndBug['reportedby']) : $bFormFailed = true;
                        (isset($arrIndBug['fixed'])) ? $this->setBugFixed($arrIndBug['fixed']) : $bFormFailed = true;
                        (isset($arrIndBug['deleted'])) ? $this->setBugDeleted($arrIndBug['deleted']) : $bFormFailed = true;

                        if($bFormFailed)
                        {
                                return $objFeedback->setFeedback("Operation Failed - Form Fields Not Valid");
                        }

                        switch($operation)
                        {

                                case 'create':
                                        return $this->createBug();
                                break;


                                case 'update':
                                        return $this->updateBug();
                                break;


                                case 'delete':
                                        return $this->deleteBug();
                                break;

                        }

                }

        }

        /*----------------------------------------------------------------------------------
      	Function:	createBug
      	Overview:	Function to create a bug

      	In:


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function createBug()
        {
                $arrFields = array("bugTitle","bugDescription","bugLine","bugReportedBy","bugFixed","bugDeleted");
                $arrValues = array($this->getBugTitle(),$this->getBugDescription(),$this->getBugLine(),$this->getBugReportedBy(),$this->getBugFixed(),$this->getBugDeleted());

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


}

?>