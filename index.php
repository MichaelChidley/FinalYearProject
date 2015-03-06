<?php

include_once("includes/config.php");


//INCLUDE ALL THE CLASSES HERE
//EVERY PAGE IS REWRITTEN TO USE THIS SINGLE PAGE
//THEREFORE, ONLY NEED TO INCLUDE CLASSES THE ONCE
//PREVENTS PROBLEMS WHEN IN DIFFERENCE DIRCTORIES
//TRYING TO INCLUDE CLASSES ETC

include_once("includes/classes/page/clsPage.php");

$objPage = new Page();
$strRequestedPage = $objPage->getRequestedPage();

?>

<html>

	<head>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="<?=$styleArray['BOOTSTRAP_JS']; ?>"></script>
		<script src="<?=$styleArray['MAIN_JS']; ?>"></script>

		<link rel='stylesheet' type='text/css' href="<?= $styleArray['BOOTSTRAP_CSS']; ?>" />
		<link rel='stylesheet' type='text/css' href="<?= $styleArray['MAIN_CSS']; ?>" />

	</head>

	<body>

		<div id='container'>


			<div id='menu'>
				<div id='menuLogo'></div>
				<div class='menuLeftMargin'></div>
				<div class='menuItem' id='menuItemSelected'>HOME</div>
				<div class='menuItem'>HOME</div>
			</div>

			<div id='pageContent'>
				<?php
					if($strRequestedPage)
					{
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
				THIS IS THE FOOTER..
			</div>

		</div>

	</body>

</html>
