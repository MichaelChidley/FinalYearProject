<div class='headingBlock'>Teams</div>
	<div class="table-responsive">
	  <table class="table table-hover projectsTable" >

	  <tr>
		<th>Title</th>
		<th>Description</th>
	  </tr>
	  <?php

	  	//$objTeam = new Team($API);
	  	foreach($arrTeams as $arrIndTeams)
	  	{
	  		$intTeamID = $arrIndTeams['teamID'];
	  		$strTeamTitle = $arrIndTeams['teamTitle'];
	  		$strTeamDesc = $arrIndTeams['teamDescription'];

	  		echo "<tr>";
	  			echo "<td>".$strTeamTitle."</td>";
	  			echo "<td>".$strTeamDesc."</td>";
	  		echo "</tr>";

	  	}

	  ?>
	  </table>

	  <?php
	  	if(($objEmployee->isAdmin($_SESSION['authenticationID'])) || ($objEmployee->isProjectManager($_SESSION['authenticationID'])))
		{
	  		echo "<div style='margin-top: 20px;float: left;margin-left:10px'><a href='".$configArray['SITE_URL']."team/create'><button class=\"btn btn-primary\">Create Team</button></a></div>";
	  	}

	  ?>

	</div>
