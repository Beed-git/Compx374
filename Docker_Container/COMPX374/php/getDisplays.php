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
 
  //Get all competition IDs in descending order
  $query = "select * from Competition order by competition_id DESC";
	$result1 = $con->query($query);
	
	//Check that we get data back
	if($result1 != FALSE)
	{
    //Output the header
		echo "<h1>Edit Displays</h1>";
		
    //Get all of the displays
    $query = "select * from Display";
    $result1 = $con->query($query);
   
    //Check that we get the data back
    if($result1 != FALSE)
    {
      //Initialise the counter for the displays in this competiton
      $countDisplays = 0;
     
      //Repeat for each display
      while($rowDisplay = $result1->fetch()) 
      {
        //Get the media associated with this display
        $query = "select * from Media where media_id = (select media_id from Media_Instance where minstance_id = (select minstance_id from Display_Contains where display_id=".$rowDisplay['display_id']."))";
        $result2 = $con->query($query);
          
        //Check that we get the data back
        if($result2 != FALSE)
        {
          $rowMedia = $result2->fetch();
            
          //Get the artist informations associated with this media
          $query = "select * from Artist where artist_id = ".$rowMedia['artist_id'];
          $result3 = $con->query($query);
            
          //Check that we get the data back
          if($result3 != FALSE)
          {
            $rowArtist = $result3->fetch();
              
            //Output the display information
            echo "<div class='submission' onclick='viewSubmission(".$rowMedia['media_id'].");'>";
            echo "<div class='image-container'>";
            echo "<img src='".$rowMedia['media_url']."' alt='Media Submission Image'>";
            echo "</div>";
            echo "<div class='submission-description'>";
            echo "<p>Mural Name: ".$rowMedia['name']."</p>";
            echo "<p>Artist Name: ".$rowArtist['username']."</p>";
            echo "</div>";
            echo "<button class='approve-button' id='editSubmission' type=submit' onclick='editSubmission(".$rowMedia['media_id'].")'>Edit</button>";
            echo "<button class='disapprove-button' id='deleteSubmission' type=submit' onclick='deleteDisplay(".$rowMedia['media_id'].")'>Delete</button>";
            echo "</div>";
          }
          else
          {
            die("Error in database query!");
          }
        }
      
        //Increment the counter
        $countDisplays = $countDisplays + 1;
      }
      
      //Check if there are no displays yet
      if ($countDisplays == 0)
      {
        echo "<p>There are no displays for this competition.</p>";
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
