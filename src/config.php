<?php

	function getdbc() {
		$dbhost = 'oniddb.cws.oregonstate.edu'; 
		$dbname = 'smithcr-db';
		$dbuser = 'smithcr-db';
		$dbpass = 'NSIq13ND6ShjS9UV';
		

		$dbc = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if($dbc->connect_error){
			die("Connection failed: " . $dbc->connect_error);
		}
		return $dbc; 
	}
?>