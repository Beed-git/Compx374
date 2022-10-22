<?php
	//Read the data sent to the PHP script from the input stream
	$data = file_get_contents('php://input');
	$dataArray = json_decode($data, true);
	$name = $dataArray['name'];
	$description = $dataArray['description'];
	
	// Initialize the session
	session_start();
	
	//Connect to the database
	require_once('connection.php');
 
	// Check if the user is logged in, if not then redirect them to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location: ../index.php");
		exit;
	}
	
	//Insert new competition into the database
	$query = "insert into Competition(name, description) values('".$name."','".$description."')";		
	$con->exec($query);
		
	//Get the ID of the newly created competition
	$last_id = $con->lastInsertId();
		
	//Set this competition as the current competition
	$update_query = "update Location set current_competition = ".$last_id." where name = 'anywhere'";
	$con->query($update_query);
	
	//Return a confirmation message
	echo "The new competition has been successfully created and is set as the current competition.";
?>
