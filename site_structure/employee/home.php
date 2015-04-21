<div class='headingBlock'>Employees</div>
	<div class="table-responsive">
	  <table class="table table-hover projectsTable" >

	  <tr>
		<th>Firstname</th>
		<th>Lastname</th>
		<th>Email</th>
		<th>DOB</th>
		<th>Home</th>
		<th>Mobile</th>
	  </tr>
	  <?php

	  	$arrEmployees = $API->convertJsonArrayToArray($objEmployee->getAllEmployees());
	  	$arrEmployees = $arrEmployees['response'];

	  	foreach($arrEmployees as $arrIndEmployee)
	  	{
	  		echo "<tr class='employeeClick' id='".$arrIndEmployee['employeeID']."'>";
	  			echo "<td>".$arrIndEmployee['firstname']."</td>";
	  			echo "<td>".$arrIndEmployee['lastname']."</td>";
	  			echo "<td>".$arrIndEmployee['email']."</td>";
	  			echo "<td>".$arrIndEmployee['dob']."</td>";
	  			echo "<td>".$arrIndEmployee['homenumber']."</td>";
	  			echo "<td>".$arrIndEmployee['mobilenumber']."</td>";
	  		echo "</tr>";
	  	}

	  ?>
	  </table>

	  <div style='margin-top: 20px;float: left;margin-left:10px'><a href="<?=$configArray['SITE_URL'];?>employee/create"><button class="btn btn-primary">Add Employee</button></a></div>

	</div>