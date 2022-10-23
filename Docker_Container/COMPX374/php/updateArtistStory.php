<?php
	//Read the data sent to the PHP script from the input stream
	$data = file_get_contents('php://input');
	$dataArray = json_decode($data, true);
	$email = $dataArray['email'];
	$newArtistStory = $dataArray['newArtistStory'];
	
	//Connect to the database
	require_once('connection.php');
	
	//Send an SQL query updating the player notes
	$updateQuery = "update Artist set story='".$newArtistStory."' where email='".$email"'";
	$con->query($updateQuery);
	
	//Send an SQL query requesting the artist's story
	$query = "select story from Artist where email = '".$artistEmail."'";
	$result = $con->query($query);
	
	//If we get data back, then return it
	if($result != FALSE)
	{
		$row = $result->fetch();
		echo $row['story'];
	}
	else
	{
    	die("Error in database query");
	}
?>