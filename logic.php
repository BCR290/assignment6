<?php
	include("config.php");
	$dbc = getdbc();

	#$query = "INSERT INTO videos(id, name, category, length)";


	#remove all 
	if ($_GET["action"] == "removeAll") {
		echo "remove";
	}
	
	#rent and return
	#some other $_GET if statements

	#add a movie
	if ($_GET["action"] == "addmovie") {
		echo "poop";
	}


?>
