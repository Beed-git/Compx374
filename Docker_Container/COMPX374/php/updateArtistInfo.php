<?php
	//Read the data sent to the PHP script from the input stream
	$data = file_get_contents('php://input');
	$dataArray = json_decode($data, true);
	
	$firstName = $dataArray['firstName'];
	$lastName = $dataArray['lastName'];
	$story = $dataArray['story'];
	
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
	
	//Deal with any apostrophes present in the input
	$firstName = str_replace("'", "''", $firstName);
	$lastName = str_replace("'", "''", $lastName);
	$story = str_replace("'", "''", $story);
	
	//Create username from first name and last name
	$username = $firstName.' '.$lastName;
	
	$updateQuery = "update Artist set username='".$username."', story='".$story."' where email='".$_SESSION["email"]."'";
	$con->query($updateQuery);
?>