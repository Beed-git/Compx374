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
		<title>Review Submissions</title>
		<link href="../css/upload.css" rel="stylesheet" type="text/css">
		<script>
			//Fetch the submissions for the current competition
			let getSubmissions = () => {
				fetch("getSubmissions.php", {method: 'post'}).then(response => response.text()).then(displaySubmissions);
			}

			//Display the submissions for the current competition
			let displaySubmissions = (response) => {
				document.getElementById("submissions").innerHTML = response;
			}
			
			//getSubmissions() --> submissions should have the image (selectable) --> takes you to page with image, mural name, mural description, artist name, artist description & approve/disapprove options
		</script>
	</head>
	<body onload="getSubmissions();">
		<div class="topnav">
			<a class="active" href="reviewSubmissions.php">Review Submissions</a>
			<a href="newCompetition.php">New Competition</a>
			<a href="newModerator.php">Accept New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div>
		<h1>Review Submissions</h1>
		<div id="submissions"></div>
	</body>
</html>	
