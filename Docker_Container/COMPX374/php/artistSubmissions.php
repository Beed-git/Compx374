<?php
	// Initialize the session
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location: ../index.php");
		exit;
	}
	
	//Connect to the database
	require_once('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Your Submissions</title>
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
		<script>
			//Fetch the artist's submissions
			let getSubmissions = (artistEmail) => {
				fetch("getArtistSubmissions.php", {method: 'post'}).then(response => response.text()).then(displayResults);
			}
			
			//Delete the submission
			let deleteSubmission = (media_id) => {
				if (confirm("Are you sure you want to permanently delete this submission?")) {
					fetch("disapproveSubmission.php", {method: 'post', body: media_id}).then(response => response.text()).then(displayResults);
				}
			}
			
			//Display the results
			let displayResults = (response) => {
				document.getElementById("artistSubmissions").innerHTML = response;
			}
		</script>
	</head>
	<body onload="getSubmissions('<?php echo htmlspecialchars($_SESSION["email"]);?>')">
		 <div class="topnav">
			<a href="upload.php">New Submission</a>
			<a href="artistInfo.php">Your Information</a>
			<a class="active" href="artistSubmissions.php">Your Submissions</a>
			<a class="logout" href="logout.php">Log out</a>
		</div> 
		<h1>Your Submissions</h1>		
		<div id="artistSubmissions"></div>
	</body>
</html>	