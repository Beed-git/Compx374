<?php
	// Initialize the session
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location: ../index.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Edit Displays</title>
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
		<script>
			//Fetch the submissions for the current competition
			let getDisplays = () => {
				fetch("getDisplays.php", {method: 'post'}).then(response => response.text()).then(displayResults);
			}
      
			//Delete the display
			let deleteDisplay = (display_id) => {
				if (confirm("Are you sure you want to permanently delete this display?")) {
					fetch("deleteDisplay.php", {method: 'post', body: display_id}).then(response => response.text()).then(displayResults);
				}
			}
			
			//Display the results
			let displayResults = (response) => {
				document.getElementById("displays").innerHTML = response;
			}
		</script>
	</head>
	<body onload="getDisplays();">
		<div class="topnav">
			<a href="submissions.php">Review Submissions</a>
			<a class="active" href="editDisplays.php">Edit Displays</a>
			<a href="newCompetition.php">New Competition</a>
			<a href="newModerator.php">Register New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div>
		<div id="displays"></div>
	</body>
</html>
