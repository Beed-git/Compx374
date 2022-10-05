<?php
	try
	{
		$con = new PDO('mysql:host=db.trex-sandwich.com;dbname=team_echo','team_echo','cane-reproach-sudden-undergrad');
   	}
	catch (PDOException $e)
	{
		echo "Database connection error " . $e->getMessage();
   	}
?>