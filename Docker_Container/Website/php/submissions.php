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
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
		<script>
			//Fetch the submissions for the current competition
			let getSubmissions = () => {
				fetch("getSubmissions.php", {method: 'post'}).then(response => response.text()).then(displayResults);
			}
			
			//Fetch the info for the individual selected submission
			let viewSubmission = (media_id) => {
				fetch("getSubmissionInfo.php", {method: 'post', body: media_id}).then(response => response.text()).then(displayResults);
			}
			
			//Approve the selected submission
			let approveSubmission = (media_id) => {
				if (confirm("Are you sure you want to add this submission to the current competition?")) {
					fetch("approveSubmission.php", {method: 'post', body: media_id}).then(response => response.text()).then(displayResults);
				}
			}
			
			//Disapprove the selected submission
			let disapproveSubmission = (media_id) => {
				if (confirm("Are you sure you want to permanently delete this submission?")) {
					fetch("disapproveSubmission.php", {method: 'post', body: media_id}).then(response => response.text()).then(displayResults);
				}
			}
			
			//Display the results
			let displayResults = (response) => {
				document.getElementById("submissions").innerHTML = response;
			}
		</script>
	</head>
	<body onload="getSubmissions();">
		<div class="topnav">
			<a class="active" href="submissions.php">Review Submissions</a>
			<a href="editDisplays.php">Edit Displays</a>
			<a href="newCompetition.php">New Competition</a>
			<a href="newModerator.php">Register New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div>
		<div id="submissions"></div>
	</body>
</html>	
