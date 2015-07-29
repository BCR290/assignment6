<?php

	function getdbc() {
		$dbhost = 'oniddb.cws.oregonstate.edu'; 
		$dbname = 'smithcr-db';
		$dbuser = 'smithcr-db';
		$dbpass = 'NSIq13ND6ShjS9UV';
		
		$dbc = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("ERROR: Could not connect to the database server");
		return $dbc; 
	}
?>