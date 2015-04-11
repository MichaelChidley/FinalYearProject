<?php

$data = $_POST['data'];
print_r(json_decode($data,true));

//create owner first if they dont already exist so can link to table etc
//itterate through the rest of the info, inputting in the right places.
//finalise with joining tables joining it all together!!
?>