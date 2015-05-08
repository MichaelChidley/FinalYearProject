<?php

		$arrBacklog =  $API->convertJsonArrayToArray($objBacklog->getSingleBacklogItem($intGetID));
		//print_r($arrBacklog);

		$arrBacklog = $arrBacklog['response'];
		//print_r($arrBacklog);
		if(count($arrBacklog)>1)
		{


			?>
			<div class='headingBlock'>Backlog Item</div>
				<span class='hidden' id='bugID'><?=$arrBug['bugID'];?></span>
				<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Description</div>
		  				<div><?=$arrBacklog['backlogItemDesc'];?></div>
		  			</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">MoSCoW</div>
		  				<div><?=$arrBacklog['moscow'];?></div>
		  			</div>

		  			<div class='clear'></div>
		  		</div>



		  		<div class="row-fluid contentOffsetTop">

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Comment</div>

		  				<div><?=$arrBacklog['backlogComment'];?></div>
	  				</div>

		  			<div class="col-sm-6">
		  				<div class="secondLevelHeading">Planning Poker Value</div>
		  				<div><?=$arrBacklog['planningPoker'];?></div>
	  				</div>

	  			</div>

	  			<div class='clear'></div>

		  			<div class="row-fluid contentOffsetTop">

			  			<div class="col-sm-6">
			  				<div class="secondLevelHeading">Progress</div>

			  				<div><?=$arrBacklog['backlogProgress'];?>%</div>
		  				</div>

	  				</div>


		  		</div>




	  		<?php

		}

	?>