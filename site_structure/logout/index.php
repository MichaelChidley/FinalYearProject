<?php

session_start();

unset($_SESSION['authentication']);


header("Location:" .$configArray['FALL_BACK']);

?>