<?php

		$arrBug =  $API->convertJsonArrayToArray($objBug->getSingleBug($intGetID));
		//print_r($arrBug);

		$arrBug = $arrBug['response'];
		//print_r($arrProject);
		if(count($arrBug)>1)
		{


			?>
			<div class='headingBlock'>Bug: <?=$arrBug['bugTitle'];?></div>
				<span class='hidden' id='bugID'><?=$arrBug['bugID'];?></span>
				<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Description</div>
		  				<div><?=$arrBug['bugDescription'];?></div>
		  			</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Bug Line</div>
		  				<div><?=$arrBug['bugLine'];?></div>
		  			</div>

		  			<div class='clear'></div>
		  		</div>



		  		<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Reported By</div>
		  				<?php
		  					$strEmployee = $API->convertJsonArrayToArray($objEmployee->getSingleEmployee($arrBug['bugReportedBy']));
							$strEmployee = $strEmployee['response'];

							$strEmployeeName = $strEmployee['firstname']. " ".$strEmployee['lastname'];
							$strEmployeeEmail = $strEmployee['email'];

		  				?>
		  				<div><a href="mailto:<?=$strEmployeeEmail;?>?subject=Regarding PMC Bug: <?=$arrBug['bugTitle'];?>"><?=$strEmployeeName;?></a></div>
	  				</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Status</div>
		  				<?php
		  					$style = 'green';
	  						$text = "Fixed";
	  						if($arrBug['bugFixed'] == 0)
	  						{
	  							$style = 'red';
	  							$text = "Not Fixed";
	  						}

	  						echo "<div class='projectBugsStatus'><span class='".$style."'>".$text."</span></div>";

				  		?>
		  				</div>

		  			</div>

		  			<div class='clear'></div>

		  			<?php

		  			switch($arrBug['bugFixed'])
		  			{
		  				case "1":
		  					$text = "Unfixed";
		  				break;

		  				case "0":
		  					$text = "Fixed";
		  				break;

		  			}

		  			?>
		  			<div style='margin-top: 20px;'><button class="btn btn-primary" id='bugMarkOption'>Mark As <?=$text;?></button></div>
		  		</div>




	  		<?php

		}

	?>