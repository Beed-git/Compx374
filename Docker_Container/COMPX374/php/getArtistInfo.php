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
	
	//Send an SQL query requesting the artist's information
	$query = "select * from Artist where email = '".$_SESSION["email"]."'";
	$result = $con->query($query);
	
	//If we get data back, then return it
	if($result != FALSE)
	{
		$row = $result->fetch();
		
		$nameArray = explode(" ", $row['username']);
		
		echo "<div class='artist-info'><div class='form-element'><p><span id='fn-label' class='bold'>First Name: </span><span id='artistFirstName'>".$nameArray[0]."</span><input id='editArtistFirstName' type='text' name='firstname' placeholder='First Name' value=\"".$nameArray[0]."\" style='display:none' /></p></div>";
		echo "<div class='form-element'><p><span id='ln-label' class='bold'>Last Name: </span><span id='artistLastName'>".$nameArray[1]."</span><input id='editArtistLastName' type='text' name='lastname' placeholder='Last Name' value=\"".$nameArray[1]."\" style='display:none' /></p></div>";
		echo "<div class='form-element'><p><span id='story-label' class='bold'>Story: </span><span id='artistStory'>".$row['story']."</span><textarea id='editArtistStory' type='text' name='story' placeholder='Story' cols='50' rows='10' maxlength='500' style='display:none'>".$row['story']."</textarea></p></div>";
		echo "<button id='editArtistInfoButton' class='submit' type=submit' onclick='editArtistInfo()'>Edit</button>";
		echo "<button id='updateArtistInfoButton' class='approve-button' type=submit' onclick='updateArtistInfo()' style='display:none'>Update</button>";
		echo "<button id='cancelArtistInfoButton' class='disapprove-button' type=submit' onclick='getArtistInfo()' style='display:none'>Cancel</button></div>";
	}
	else
	{
    	die("Error in database query");
	}
?>