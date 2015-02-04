<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsFeedback.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle feedback
-----------------------------------------------------------------------------------------------------------
History:
01/12/2014      1.0	MJC	Created
09/12/2014      1.1     MJC     Added JSON functions, modified feedback handler
-----------------------------------------------------------------------------------------------------------
Uses:

*/


Class Feedback
{

        private $arrFeedback = array();


        /*----------------------------------------------------------------------------------
      	Function:	setFeedback
      	Overview:	Function to set feedback for error handling

      	In:      $strFeedback    String     Error string


      	Out:     $this->feedback Attribute set   Result of setting attribute
	----------------------------------------------------------------------------------*/
        public function setFeedback($mFeedback)
        {

                if($mFeedback === false)
                {
                        $this->arrFeedback['response'] = "Operation Failed";
                        return $this->arrFeedback;
                }
                if(is_array($mFeedback))
                {
                        $this->arrFeedback['response'] = $mFeedback;
                        return $this->arrFeedback;
                }
                if(is_string($mFeedback))
                {
                        $this->arrFeedback['response'] = $mFeedback;
                        return $this->arrFeedback;
                }
                else
                {
                        if($mFeedback == true)
                        {
                                //If a return of a method is true it is 1
                                //Therefore, can assume operation is successful

                                $this->arrFeedback['response'] = "Operation Successful";
                                return $this->arrFeedback;
                        }
                        else
                        {

                        }
                }
                return $mFeedback;
        }


        /*----------------------------------------------------------------------------------
      	Function:	getFeedback
      	Overview:	Function to get feedback

      	In:


      	Out:     $this   String  Feedback message
	----------------------------------------------------------------------------------*/
        public function getFeedback()
        {
                return $this->arrFeedback;
        }




        /*----------------------------------------------------------------------------------
      	Function:	packageInformation
      	Overview:	Function to package information into JSON

      	In:      $arrInfo    Array               Array of data


      	Out:     json_encode     JSON            JSON formatted array
	----------------------------------------------------------------------------------*/
        public function packageInformation($arrInfo)
        {
                return json_encode($arrInfo);
        }


        /*----------------------------------------------------------------------------------
      	Function:	decompressInformation
      	Overview:	Function to decompress information into JSON

      	In:      $jsonInfo    JSON               JSON formatted array


      	Out:     json_decode     Array            Array formatted data
	----------------------------------------------------------------------------------*/
        private function decompressInformation($jsonInfo)
        {
                return json_decode($jsonInfo, true);
        }
}


?>