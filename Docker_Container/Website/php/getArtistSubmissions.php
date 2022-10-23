<?php
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
	
	//Get the artist's ID
	$query = "select * from Artist where email = '".$_SESSION["email"]."'";
	$result1 = $con->query($query);
	
	if($result1 != FALSE)
	{
		$rowArtist = $result1->fetch();
		
		//Get all media belonging to this artist
		$query = "select * from Media where artist_id=".$rowArtist['artist_id'];
		$result2 = $con->query($query);
		
		if($result2 != FALSE)
		{
			$counter = 0;
			
			//Repeat for each piece of media
			while($rowMedia = $result2->fetch())
			{
				echo "<div class='submission'>";
				echo "<div class='image-container'>";
				echo "<img src='".$rowMedia['media_url']."' alt='Media Submission Image'>";
				echo "</div>";
        echo "<div class='submission-description'>";
				echo "<p>Mural Name: ".$rowMedia['name']."</p>";
				echo "<p>Mural Description: ".$rowMedia['description']."</p>";
        echo "</div>";
				echo "<button class='disapprove-button' id='deleteSubmission' type=submit' onclick='deleteSubmission(".$rowMedia['media_id'].")'>Delete</button>";
				echo "</div>";
				
				$counter = $counter + 1;
			}
			
			//Check if the artist has no submissions
			if ($counter == 0)
			{
				echo "<p>You do not have any submissions yet.</p>";
			}
		}
		else
		{
			die("Error in database query");
		}
	}
	else
	{
		die("Error in database query");
	}
?>