<?php
	try
	{
		$db1 = getenv(DB_1);
		$db2 = getenv(DB_2);
		$db3 = getenv(DB_3);

		$con = new PDO($db1, $db2, $db3);
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
