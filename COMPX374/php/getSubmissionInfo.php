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
	
	//Output the header
	echo "<h1>Verify this Submission</h1>";
	
	//Get the media information
	$query = "select * from Media where media_id=".$media_id;
	$result1 = $con->query($query);
	
	if($result1 != FALSE)
	{
		$rowMedia = $result1->fetch();
				
		//Get the artist information
		$query = "select username from Artist where artist_id=".$rowMedia['artist_id'];
		$result2 = $con->query($query);
				
		if($result2 != FALSE)
		{
			$rowArtist = $result2->fetch();
			
			//Output the submission information
			echo "<div>";
			echo "<button type=submit' onclick='getSubmissions()'>Back</button>";
			echo "<div class='image-container'>";
			echo "<img src='".$rowMedia['media_url']."' alt='Media Submission Image'>";
			echo "</div>";
			echo "<p>Mural Name: ".$rowMedia['name']."</p>";
			echo "<p>Mural Description: ".$rowMedia['description']."</p>";
			echo "<p>Artist Name: ".$rowArtist['username']."</p>";
			echo "<p>Artist Description: ".$rowArtist['description']."</p>";
			echo "<button type=submit' onclick='approveSubmission(".$media_id.")'>Approve</button>";
			echo "<button type=submit' onclick='disapproveSubmission(".$media_id.")'>Disapprove</button>";
			echo "</div>";
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
