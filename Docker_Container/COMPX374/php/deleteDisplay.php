<?php
	//Read the data sent to the PHP script from the input stream
	$display_id = file_get_contents('php://input');
	
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
  
  //Get the row from the DisplayContains table associated with this Display ID
  $query = "select * from Display_Contains where display_id=".$display_id;
	$result1 = $con->query($query);
  
  //Check that we get the data back
  if($result1 != FALSE)
  {
    $rowDisplayContains = $result1->fetch();
    
    //Get the Media Instance referenced in this Display Contains row
    $query = "select * from Media_Instance where minstance_id=".$rowDisplayContains['minstance_id'];
    $result2 = $con->query($query);
    
    //Check that we get the data back
    if($result2 != FALSE)
    {
      $rowMediaInstance = $result2->fetch();
      
      $minstance_id = $rowDisplayContains['minstance_id'];
      $media_id = $rowMediaInstance['media_id'];
      
      //Delete the media associated with this MediaInstance
	    $query = "delete from Media where media_id=".$media_id;
	    $result4 = $con->query($query);
      
      //Delete the display from the DisplayContains table
      $query = "delete from Display_Contains where display_id=".$display_id;
	    $result5 = $con->query($query);
         
      echo "Query: ".$query;
      
      echo "Query: ".$query;
      
      //Delete from the MediaInstance table
      $query = "delete from Media_Instance where minstance_id=".$minstance_id;
	    $result3 = $con->query($query);
      
      echo "Query: ".$query;
      
      //Delete the display from the Display table
      $query = "delete from Display where display_id=".$display_id;
	    $result6 = $con->query($query);
      
      echo "Query: ".$query;
      
      if($result3 != FALSE and $result4 != FALSE and $result5 != FALSE and $result6 != FALSE)
	    {		
		    //Show a confirmation message to the user
		    echo "<div class='success'><button class='back-button' type=submit' onclick='getDisplays()'>&#x2190;</button>";
		    echo "<p>The display has been successfully deleted.</p></div>";
	    }
	    else
	    {
		    die("Error in database queries.");
	    }
    }
    else
	  {
		  die("Error in database query.");
	  }
  }
  else
	{
		die("Error in database query.");
	}
?>
