<?php
	try
	{
		$con = new PDO('mysql:host=db.trex-sandwich.com;dbname=team_echo','team_echo','cane-reproach-sudden-undergrad');
   	}
	catch (PDOException $e)
	{
		echo "Database connection error " . $e->getMessage();
   	}
   	
   	
   	//<?php
	//$servername = "db.trex-sandwich.com";
	//$username = "team_echo";
	//$password = "cane-reproach-sudden-undergrad";

	// Create connection
	//$conn = new mysqli($servername, $username, $password);

	// Check connection
	//if ($conn->connect_error) {
  	//	die("Connection failed: " . $conn->connect_error);
	//}
?>
