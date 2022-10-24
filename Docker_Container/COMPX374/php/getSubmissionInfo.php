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
		$query = "select * from Artist where artist_id=".$rowMedia['artist_id'];
		$result2 = $con->query($query);
				
		if($result2 != FALSE)
		{
			$rowArtist = $result2->fetch();
			
			//Output the submission information
			echo "<div class='individual-submission'>";
			echo "<button class='back-button' type=submit' onclick='getSubmissions()'>&#x2190;</button>";
			echo "<div class='image-container'>";
			echo "<img src='".$rowMedia['media_url']."' alt='Media Submission Image'>";
			echo "</div>";
			echo "<p><span class='bold'>Mural Name:</span> ".$rowMedia['name']."</p>";
			echo "<p><span class='bold'>Mural Description:</span> ".$rowMedia['description']."</p>";
			echo "<p><span class='bold'>Artist Name:</span> ".$rowArtist['username']."</p>";
			echo "<p><span class='bold'>Artist Email:</span> ".$rowArtist['email']."</p>";
      echo "<p><span class='bold'>Artist Description:</span> ".$rowArtist['story']."</p>";
			echo "<button class='approve-button' type=submit' onclick='approveSubmission(".$media_id.")'>Approve</button>";
			echo "<button class='disapprove-button' type=submit' onclick='disapproveSubmission(".$media_id.")'>Disapprove</button>";
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
