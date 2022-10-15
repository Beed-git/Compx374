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
	
	//Find all media instances which are not in a display (i.e, have not been verified by a moderator)
	$query = "select * from Media_Instance where minstance_id not in (select minstance_id from Display_Contains)";
	$result1 = $con->query($query);
	
	//Check that we get data back
	if($result1 != FALSE)
	{
		//Initialize the counter
		$count = 0;
		
		//Repeat for each unverified media instance
		while($row = $result1->fetch()) 
		{
			$query = "select * from Media where media_id=".$row['media_id'];
			$result2 = $con->query($query);
			
			if($result2 != FALSE)
			{
				$rowMedia = $result2->fetch();
				
				$query = "select username from Artist where artist_id=".$rowMedia['artist_id'];
				$result3 = $con->query($query);
				
				if($result2 != FALSE)
				{
					$rowArtist = $result3->fetch();
					
					//Output the submission information
					echo "<div>";
					echo "<img src='".$rowMedia['media_url']."' alt='Media Submission Image'>";
					echo "<p>Mural Name: ".$rowMedia['name']."</p>";
					echo "<p>Artist Name: ".$rowArtist['username']."</p>";
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
			
			//Increment the counter
			$count = $count + 1;
		}
		
		//Check if there have been no new submissions
		if ($count == 0)
		{
			echo "<p>There are no new submissions.</p>";
		}		
	}
	else
	{
		die("Error in database query");
	}
?>
