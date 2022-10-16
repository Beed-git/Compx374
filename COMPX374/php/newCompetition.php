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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>New Competition</title>
		<link href="../css/upload.css" rel="stylesheet" type="text/css">	
		<script>
			let confirmCompCreation = () => {
					if (confirm("If you choose to continue, this competition will become the current competition. Do you want to proceed?")) {
					dataArray = {name:"<?php echo $_POST['name'];?>", description:"<?php echo $_POST['description'];?>"};
					data = JSON.stringify(dataArray);
				
					fetch("createCompetition.php", {method: 'post', body: data}).then(response => response.text()).then(displayResults);
				}
			}
			
			//Display the results
			let displayResults = (response) => {
				//Display the confirmation message
				document.getElementById("confirmCompCreationMessage").innerHTML = response;
				
				//Clear the form
				document.getElementById('name').value = '';
				document.getElementById('description').value = '';
			}
		</script>
	</head>
	<body>
		<div class="topnav">
			<a href="submissions.php">Review Submissions</a>
			<a class="active" href="newCompetition.php">New Competition</a>
			<a href="newModerator.php">Register New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div> 
		<h1>New Competition</h1>
		<div id="confirmCompCreationMessage"></div>
		<form action="" method="post" name="new-competition-form">
			<div class="form-element">
				<input type="text" id="name" name="name" placeholder="Competition Name" required />
			</div>
			<div class="form-element">
				<input type="text" id="description" name="description" placeholder="Description" required />
			</div>
			<button type="button" name="submit" value="submit" onclick="confirmCompCreation()">Submit</button>
		</form>		
	</body>
</html>
