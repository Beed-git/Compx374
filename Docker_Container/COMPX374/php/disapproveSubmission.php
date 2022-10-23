<?php
	//Read the data sent to the PHP script from the input stream
	$media_id = file_get_contents('php://input');
	
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
	
	//Delete the submission from the database	
	$query = "delete from Media_Instance where media_id=".$media_id;
	$result2 = $con->query($query);
	
	$query = "delete from Media where media_id=".$media_id;
	$result1 = $con->query($query);
	
	if($result1 != FALSE and $result2 != FALSE)
	{		
		//Show a confirmation message to the user
		echo "<div class='success'><button class='back-button' type=submit' onclick='getSubmissions()'>&#x2190;</button>";
		echo "<p>The submission has been successfully deleted.</p></div>";
	}
	else
	{
		die("Error in database query");
	}
?>