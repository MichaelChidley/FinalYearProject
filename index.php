<?php

session_start();

include_once("includes/config.php");


//INCLUDE ALL THE CLASSES HERE
//EVERY PAGE IS REWRITTEN TO USE THIS SINGLE PAGE
//THEREFORE, ONLY NEED TO INCLUDE CLASSES THE ONCE
//PREVENTS PROBLEMS WHEN IN DIFFERENCE DIRCTORIES
//TRYING TO INCLUDE CLASSES ETC

include_once("includes/classes/page/clsPage.php");
include_once("includes/classes/security/clsSecurity.php");
include_once("includes/classes/api/clsAPI.php");

//Create a new instance of the security object and check for CSRF
$objSecurity = new Security();
$objSecurity->secureUrl();
if(!$objSecurity->CSRFCheck())
{
	die;
}
$_SESSION['CSRF_CHECK'] = mt_rand();

//Create a new instance of the API object and pass in the required configuration
$API = new API($configArray['API_URL'], $configArray['API_KEY']);

//Create new instance of the page object and determine the requested page
$objPage = new Page();
$strRequestedPage = $objPage->getRequestedPage();

//Return the page title
$strRequestedPageTitle = $objPage->getPageTitle($strRequestedPage);

//INCLUDE MODULES
include_once("includes/classes/project/clsProject.php");
include_once("includes/classes/activity/clsActivity.php");
include_once("includes/classes/employee/clsEmployee.php");
include_once("includes/classes/comment/clsComment.php");
include_once("includes/classes/team/clsTeam.php");
include_once("includes/classes/bug/clsBug.php");
include_once("includes/classes/client/clsClient.php");
include_once("includes/classes/agile/clsAgile.php");
include_once("includes/classes/sprint/clsSprint.php");
include_once("includes/classes/backlog/clsBacklog.php");




//testing gets work
//$API->handleAPICall(array(),"bug","1");	//working
//echo $API->getAPIResponse();				//working

//post to create bug, working.
//$array = array("module"=>"bug","operation"=>"create","data" => array("bug" => array( array("title"=>"title","description"=>"desc","line"=>"101","reportedby"=>"MJC","fixed"=>"0","deleted"=>"0"))),"APIKey"=>$configArray['API_KEY']);

//$encrypted = $objSecurity->encryptInformation($array);		//works!
//$decrypted = $objSecurity->decryptInformation($encrypted);	//works"
//echo $encrypted;
//print_r($decrypted);

//$API->handleAPICall($array);		//works
//echo $API->getAPIResponse();		//works


//LOGIN FUNCTIONALITY WORKING
//$array = $API->buildAPIRequest("login","login",array("login" => array( array("username"=>"joe.bloggs@gmail.com","password"=>"password"))));
//$API->handleAPICall($array);
//if($API->isSuccessful($API->getAPIResponse()))
//{
//	echo "Log in stuff";
//}

//unset($_SESSION['postcheck']);
//unset($_SESSION['username']);
//unset($_SESSION['authentication']);

//print_r($_SESSION);

?>

<html>

	<head>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="<?=$styleArray['BOOTSTRAP_JS']; ?>"></script>
		<script src="<?=$styleArray['MAIN_JS']; ?>"></script>

		<link rel='stylesheet' type='text/css' href="<?= $styleArray['BOOTSTRAP_CSS']; ?>" />
		<link rel='stylesheet' type='text/css' href="<?= $styleArray['MAIN_CSS']; ?>" />
		<link rel="stylesheet" href="layout\animatedprogressbar\css\progress.css">


		<script src="layout\animatedprogressbar\src\jquery-asPieProgress.js"></script>


		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

		<title><?=$strRequestedPageTitle;?></title>
	</head>

	<body>

		<div id='container-fluid'>

		<div class='messageBox'>MESSAGE</div>

		<?php

			if(!isset($_SESSION['authentication']))
			{
				?>

				<div id='loginBox'>


					<div id='loginContent'>
						<div id='loginLogo'></div>

						<div id='loginCredentials'>
							<div><input type='text' name='username' id='loginUser' value='USERNAME'></div>
							<div><input type='password' name='password' id='loginPass' value='PASSWORD'></div>
							<div id='loginresultholder'></div>
						</div>
					</div>


				</div>
				<?php
				die;
			}


		?>


      		<nav class="navbar navbar-default">
				  <div class="navbarStyle">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
				      	</button>
				      	<a class="navbar-brand" href="#">Project Management Console</a>
				    </div>

      				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">

							<?php

								$objEmployee = new Employee($API);
								$accountType = $objEmployee->getEmployeeAccountType($_SESSION['authenticationID']);

								//echo "ttest".$accountType;

								echo "<li ";
								if($strRequestedPage == "")
								{
									echo " class='active'";
								}
								echo "><a href=".$configArray['SITE_URL'].">Home</a></li>";


								//if(($objEmployee->isProjectManager($_SESSION['authenticationID']) || ($objEmployee->isAdmin($_SESSION['authenticationID']))))
								//{
									echo "<li ";
									if(strpos($strRequestedPage, "project") !== false)
									{
										echo " class='active'";
									}
									echo "><a href=".$configArray['SITE_URL']."project/>Projects</a></li>";
								//}

								echo "<li ";
								if(strpos($strRequestedPage, "bug") !== false)
								{
									echo " class='active'";
								}
								echo "><a href=".$configArray['SITE_URL']."bug/>Bug</a></li>";

								if($objEmployee->isAdmin($_SESSION['authenticationID']))
								{
									echo "<li ";
									if(strpos($strRequestedPage, "employee") !== false)
									{
										echo " class='active'";
									}
									echo "><a href=".$configArray['SITE_URL']."employee/>Employee</a></li>";
								}

								echo "<li ";
								if(strpos($strRequestedPage, "team") !== false)
								{
									echo " class='active'";
								}
								echo "><a href=".$configArray['SITE_URL']."team/>Team</a></li>";


								echo "<li><a href=".$configArray['SITE_URL']."logout/index.php>Logout</a></li>";
							?>

							<?php
								//$objEmployee = new Employee($API);
								//$accountType = $objEmployee->getEmployeeAccountType($_SESSION['authenticationID']);
								//if($objEmployee->isAdmin($accountType))
								//{
								//	echo "ADMIN";
								//}
							?>
						</ul>
					</div>
				</div>
			</nav>

			<div id='pageContent' class='span12'>
				<?php

					//Determine the requested page and include the content to this location
					if($strRequestedPage)
					{
						$arrUrlExp = explode("/",$strRequestedPage);

						(!empty($arrUrlExp[1])) ? $strRequestedPage = $arrUrlExp[0] : '';
						(!empty($arrUrlExp[1])) ? $strGetAction = $arrUrlExp[1] : '';
						(!empty($arrUrlExp[2])) ? $intGetID = $arrUrlExp[2] : '';


						$strRequestedPage = str_replace("/",'',$strRequestedPage);

						if(in_array($strRequestedPage, $configPages))
						{
							include("site_structure/".$strRequestedPage."/index.php");
						}
						else
						{
							die(header("Location: ".$configArray['FALL_BACK']));
						}
					}
					else
					{
						include("site_structure/home/index.php");
					}

				?>
			</div>

			<div id='footer'>
				<div class='fleft'>&copy; Project Management Console <?=date('Y');?></div>
				<div class='fright'>Michael Chidley</div>
				<div class='clear'></div>
			</div>

		</div>

	</body>

</html>
