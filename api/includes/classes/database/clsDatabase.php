<?php

/*
-----------------------------------------------------------------------------------------------------------
Class: clsDatabase.php
Version: 1.0
Release Date:
-----------------------------------------------------------------------------------------------------------
Overview: Class to handle database interaction
-----------------------------------------------------------------------------------------------------------
History:
01/12/2014      1.0	MJC	Created
07/12/2014      1.1     MJC     Implemented updateExists, update and delete methods
-----------------------------------------------------------------------------------------------------------
Uses:

*/


Class Database
{

        private $host = "127.0.0.1";
        private $username = "root";
        private $password = "";
        private $dbname = "projectmanagementsystem";

        private $database;

        private $arrErrors = array();


        /*----------------------------------------------------------------------------------
      	Function:	Database
      	Overview:	Constructor function that sets up the connection to the database

      	In:

      	Out:
	----------------------------------------------------------------------------------*/
        public function Database()
        {
                return $this->database = mysqli_connect($this->host,$this->username,$this->password,$this->dbname);
        }


        /*----------------------------------------------------------------------------------
      	Function:	query
      	Overview:	Function that handles SQL queiers and executes them

      	In:      $strQry         String          SQL Statement

      	Out:	 true/false      bool
	----------------------------------------------------------------------------------*/
        public function query($strQry)
        {
                //if($this->exists($strQry))
                //{
                        if(mysqli_query($this->database, $strQry))
                        {
                                return true;
                        }
                        return false;
                //}
        }


        /*----------------------------------------------------------------------------------
      	Function:	exists
      	Overview:	Function to determine if a row exists in the database

      	In:      $strQry         String          SQL Statement

      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function exists($strQry)
        {
                if(mysqli_num_rows($strQry)>=1)
                {
                        return true;
                }
                $this->setError(__METHOD__. " - Row Does Not Exist");
                return false;
        }


        /*----------------------------------------------------------------------------------
      	Function:	specificExists
      	Overview:	Function to check whether the row exists before updating

      	In:      $strTable              String          Table name
                 $strFieldWhere         String          Field to check
                 $strFieldWhereValue    String          Field value to check

      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function specificExists($strTable, $strFieldWhere, $strFieldWhereValue)
        {
                $strQry = "SELECT * FROM ".$strTable." WHERE ".$strFieldWhere." = '".$strFieldWhereValue."'";

                $rsQry = $this->result($strQry);
                if(mysqli_num_rows($rsQry)>=1)
                {
                        return true;
                }
                $this->setError(__METHOD__. " - Row Does Not Exist");
                return false;

        }


        /*----------------------------------------------------------------------------------
      	Function:	result
      	Overview:	Function to return the resultset of a database operation to the
                        function call

      	In:      $strQry         String          SQL Statement

      	Out:     $resultSet      ResultSet       Results from statement
	----------------------------------------------------------------------------------*/
        public function result($strQry)
        {
                $resultSet = mysqli_query($this->database, $strQry);

                return $resultSet;
        }


        /*----------------------------------------------------------------------------------
      	Function:	returnRow
      	Overview:	Function to return specific row information in an associative array
                        with relative key values

      	In:      $strTable              String          Table name
                 $strFieldWhere         String          Field to check
                 $strFieldWhereValue    String          Field value to check

      	Out:     $arrInfo               Array           Array of information
	     ----------------------------------------------------------------------------------*/
        public function returnRow($strTable, $strFieldWhere, $strFieldWhereValue)
        {
                $strQry = "SELECT * FROM ".$strTable." WHERE ".$strFieldWhere." = '".$strFieldWhereValue."'";

                if($this->specificExists($strTable,$strFieldWhere,$strFieldWhereValue))
                {
                        $resultset = $this->result($strQry);

                        $row = mysqli_fetch_array($resultset, MYSQL_ASSOC);

                        $arrInfo = array();
                        foreach($row as $field => $val)
                        {
                                $arrInfo[$field] = $val;
                        }

                        return $arrInfo;
                }
                return false;
        }


        public function returnAllRows($strTable)
        {
            //return "IN THE API SIDE, DATABASE CLASS. RETURN ALL ROWS METHOD NOT WORKING!!";
            $strQry = "SELECT * FROM ".$strTable;
            //return $strQry;
            $result = $this->result($strQry);

            $info = array();

            while($row = mysqli_fetch_array($result, MYSQL_ASSOC))
            {
                $tempArray = array();
                foreach($row as $field => $value)
                {
                  $tempArray[$field] = $value;
                  //array_push($tempArray, array($field => $value));
                }
                array_push($info, $tempArray);
            }

            return $info;


        }


        public function returnAllRowsWhere($strTable, $strFieldWhere, $strFieldWhereValue)
        {
            //return "IN THE API SIDE, DATABASE CLASS. RETURN ALL ROWS METHOD NOT WORKING!!";
            $strQry = "SELECT * FROM ".$strTable." WHERE ".$strFieldWhere." = '".$strFieldWhereValue."'";
            //return $strQry;
            $result = $this->result($strQry);

            $info = array();

            while($row = mysqli_fetch_array($result, MYSQL_ASSOC))
            {
                $tempArray = array();
                foreach($row as $field => $value)
                {
                  $tempArray[$field] = $value;
                  //array_push($tempArray, array($field => $value));
                }
                array_push($info, $tempArray);
            }

            return $info;


        }



        /*----------------------------------------------------------------------------------
      	Function:	returnSingleData
      	Overview:	Function to return a single cell from the specified table

      	In:      $strField       String          Field name
                 $strTable       String          Table name
                 $strWhere       String          Column name
                 $strValue       String          Column value

      	Out:     $row[$strfield] Mixed           Cell data
	----------------------------------------------------------------------------------*/
        public function returnSingleData($strField,$strTable,$strWhere,$strValue)
        {
                $strQuery = "SELECT ".$strField." FROM ".$strTable." WHERE ".$strWhere." = '".$strValue."'";


                $resultset = $this->result($strQuery);

                while($row = mysqli_fetch_array($resultset))
                {
                        return $row[$strField];
                }
                $this->setError(__METHOD__. " - Unable To Get Data");
                return false;

        }


        /*----------------------------------------------------------------------------------
      	Function:	insert
      	Overview:	Function to insert data into a specified table using array data

      	In:      $strTable       String          Table name
                 $arrFields      Array           Array of fields
                 $arrValues      Array           Array of values


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function insert($strTable,$arrFields,$arrValues)
        {
                $strQuery = "INSERT INTO `".$strTable."` (";

                $intCount = 1;
                foreach($arrFields as $indFields)
                {
                        $strQuery .= $indFields;

                        if($intCount != count($arrFields))
                        {
                                $strQuery .= ", ";
                        }

                        $intCount++;

                }

                $strQuery .= ") VALUES (";

                $intCount = 1;
                foreach($arrValues as $indValues)
                {
                        $strQuery .= "'".$indValues."'";
                        if($intCount != count($arrFields))
                        {
                                $strQuery .= ", ";
                        }

                        $intCount++;
                }

                $strQuery .= ")";

                if($this->query($strQuery))
                {
                        return true;
                }
                $this->setError(__METHOD__. " - Unable To Execute Query");
                return false;
        }


        /*----------------------------------------------------------------------------------
      	Function:	update
      	Overview:	Function to update a specific field in the database

      	In:      $strTable              String          Table name
                 $strField              String          Field to update
                 $strValue              String          New field value
                 $strFieldWhere         String          Where field
                 $strFieldWhereValue    String          Where field value


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function update($strTable, $strField, $strValue, $strFieldWhere, $strFieldWhereValue)
        {
                $strQuery = "UPDATE ".$strTable. " SET ".$strField." = '".$strValue."' WHERE ".$strFieldWhere." = '".$strFieldWhereValue."'";

                if($this->specificExists($strTable,$strFieldWhere,$strFieldWhereValue))
                {
                        if($this->query($strQuery))
                        {
                                return true;
                        }
                        return false;
                }
                return false;

        }


        /*----------------------------------------------------------------------------------
      	Function:	delete
      	Overview:	Function to delete a specific field in the database

      	In:      $strTable              String          Table name
                 $strField              String          Field to delete
                 $strValue              String          Field to check


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function delete($strTable, $strWhere, $strValue)
        {
                $strQuery = "DELETE FROM ".$strTable." WHERE ".$strWhere." = '".$strValue."'";

                if($this->specificExists($strTable,$strWhere,$strValue))
                {
                        if($this->query($strQuery))
                        {
                                return true;
                        }
                        return false;
                }
                return false;

        }



        public function getHighestIDOnTable($id, $strTable)
        {

            $strQuery = "SELECT MAX(".$id.") FROM ".$strTable;

                  $resultset = $this->result($strQuery);

                while($row = mysqli_fetch_array($resultset))
                {
                        return $row[0];
                }
                $this->setError(__METHOD__. " - Unable To Get Data");
                return false;
        }


        public function countSpecificRows($field, $table, $where, $value, $secondWhere, $secondValue)
        {
          $strQuery = "SELECT COUNT(".$field.") FROM ".$table." WHERE ".$where." = '".$value."' AND ".$secondWhere." = '".$secondValue."'";
          $resultset = $this->result($strQuery);

          while($row = mysqli_fetch_array($resultset))
          {
                  return $row[0];
          }
        }


        /*----------------------------------------------------------------------------------
      	Function:	setError
      	Overview:	Function to set errors

      	In:      $error          Mixed           Error


      	Out:     true/false      bool
	----------------------------------------------------------------------------------*/
        public function setError($error)
        {
                if(!in_array($error, $this->arrErrors))
                {
                        $this->arrErrors['error'] = $error;
                }

        }

        /*----------------------------------------------------------------------------------
      	Function:	getErrors
      	Overview:	Function to return errors

      	In:


      	Out:     $this->arrErrors        Array           Errors
	----------------------------------------------------------------------------------*/
        public function getErrors()
        {
                return $this->arrErrors;
        }

}


?>