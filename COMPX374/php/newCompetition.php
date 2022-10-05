<?php
	// Initialize the session
	session_start();
	
	//Connect to the database
	require_once('connection.php');
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location: ../index.php");
		exit;
	}
	
	//Check if the form is submitted
	if(isset($_POST['submit']))
	{
		//Retrieve the form data
		$name = $_POST['name'];
		$description = $_POST['description'];
		
		//Insert new competition into the database
		$query = "insert into Competition(name, description) values('".$name."','".$description."')";		
		$con->exec($query);
		
		//Get the ID of the newly created competition
		$last_id = $con->lastInsertId();
		
		//Set this competition as the current competition
		$update_query = "update Location set current_competition = ".$last_id." where name = 'anywhere'";
		$con->query($update_query);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>New Competition</title>
		<link href="../css/upload.css" rel="stylesheet" type="text/css">	
	</head>
	<body>
		<div class="topnav">
			<a class="active" href="newCompetition.php">New Competition</a>
			<a href="newModerator.php">Accept New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div> 
		<h1>New Competition</h1>
		<form action="" method="post" name="new-competition-form">
			<div class="form-element">
				<input type="text" id="name" name="name" placeholder="Competition Name" required />
			</div>
			<div class="form-element">
				<input type="text" name="description" placeholder="Description" required />
			</div>
			<button type="submit" name="submit" value="submit">Submit</button>
		</form>		
	</body>
</html>	
