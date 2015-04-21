<?php

		$arrEmployees = $API->convertJsonArrayToArray($objEmployee->getSingleEmployee($intGetID));
	  	$arrEmployees = $arrEmployees['response'];
		//print_r($arrEmployees);

		if(count($arrEmployees)>1)
		{
			$strAccountType = $API->convertJsonArrayToArray($objEmployee->returnEmployeeAccountTypeName($arrEmployees['accounttype']));
			$strAccountType = $strAccountType['response'];

			?>
			<div class='headingBlock'>Employee: <?=$arrEmployees['firstname'];?> <?=$arrEmployees['lastname'];?></div>
				<span class='hidden' id='bugID'><?=$arrEmployees['employeeID'];?></span>
				<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Job Title</div>
		  				<div><?=$strAccountType;?></div>
		  			</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Email Address</div>
		  				<div><a href="mailto:<?=$arrEmployees['email'];?>"><?=$arrEmployees['email'];?></a></div>
		  			</div>

		  			<div class='clear'></div>
		  		</div>



		  		<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">DOB</div>
		  				<div><?=$arrEmployees['dob'];?></div>
	  				</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Home Number</div>
		  				<div><?=$arrEmployees['homenumber'];?></div>
		  				</div>

	  			</div>

	  			<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Mobile Number</div>
		  				<div><?=$arrEmployees['mobilenumber'];?></div>
	  				</div>


	  			</div>

	  			<div class='clear'></div>


	  			<div style='margin-top: 20px;float: left;'><a href="<?=$configArray['SITE_URL'];?>employee/edit/<?=$arrEmployees['employeeID'];?>"><button class="btn btn-primary editEmployee">Edit Employee</button></a></div>

	  			<div style='margin-top: 20px;float: left;margin-left:10px'><a href="<?=$configArray['SITE_URL'];?>employee/delete/<?=$arrEmployees['employeeID'];?>"><button class="btn btn-danger deleteEmployee">Delete</button></a></div>

	  			<div class='clear'></div>
	  		</div>




	  		<?php

		}

	?>