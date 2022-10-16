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
		
		echo "<p><span id='bold'>First Name: </span><span id='artistFirstName'>".$nameArray[0]."</span><input id='editArtistFirstName' type='text' name='firstname' placeholder='First Name' value=\"".$nameArray[0]."\" style='display:none' /></p>";
		echo "<p><span id='bold'>Last Name: </span><span id='artistLastName'>".$nameArray[1]."</span><input id='editArtistLastName' type='text' name='lastname' placeholder='Last Name' value=\"".$nameArray[1]."\" style='display:none' /></p>";
		echo "<p><span id='bold'>Story: </span><span id='artistStory'>".$row['story']."</span><textarea id='editArtistStory' type='text' name='story' placeholder='Story' cols='50' rows='10' maxlength='500' style='display:none'>".$row['story']."</textarea></p>";
		echo "<button id='editArtistInfoButton' type=submit' onclick='editArtistInfo()'>Edit</button>";
		echo "<button id='updateArtistInfoButton' type=submit' onclick='updateArtistInfo()' style='display:none'>Update</button>";
		echo "<button id='cancelArtistInfoButton' type=submit' onclick='getArtistInfo()' style='display:none'>Cancel</button>";
	}
	else
	{
    	die("Error in database query");
	}
?>