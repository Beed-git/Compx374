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
	
	//Get the moderator ID
	$query = "select moderator_id from Moderator where email='".$_SESSION["email"]."'";
	$result1 = $con->query($query);

	//Get the current competition ID
	$query = "select current_competition from Location where name='anywhere'";
	$result2 = $con->query($query);
	
	//Get the media information
	$query = "select * from Media where media_id=".$media_id;
	$result3 = $con->query($query);
	
	//Get the media instance
	$query = "select * from Media_Instance where media_id=".$media_id;
	$result4 = $con->query($query);
	
	if($result1 != FALSE and $result2 != FALSE and $result3 != FALSE and $result4 != FALSE)
	{
		$rowModerator = $result1->fetch();
		$rowLocation = $result2->fetch();
		$rowMedia = $result3->fetch();
		$rowMediaInstance = $result4->fetch();
		
		//Add a new display to the database
		$query = "insert into Display(name, description, moderator_id, competition_id) values('".$rowMedia['name']."','".$rowMedia['description']."',".$rowModerator['moderator_id'].",".$rowLocation['current_competition'].")";
		$result5 = $con->query($query);
		
		$last_id = $con->lastInsertId();
		$query = "insert into Display_Contains(display_id, minstance_id) values(".$last_id.",".$rowMediaInstance['minstance_id'].")";
		$result5 = $con->query($query);
		
		//Show a confirmation message to the user
		echo "<div class='success'><button class='back-button' type=submit' onclick='getSubmissions()'>&#x2190;</button>";
		echo "<p>  The submission has been added to the current competition.</p></div>";
	}
	else
	{
		die("Error in database query");
	}
?>