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
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">	
		<script>
			let confirmCompCreation = () => {
					//Retrieve the competition info from the text boxes
          var name = document.getElementById("name").value;
          var description = document.getElementById("description").value;
          
          //Check that input has been entered into both input boxes
          if (name != "" && description != "")
          {
            //Clear away any error messages
            document.getElementById("confirmCompCreationMessage").innerHTML = "";
             
            if (confirm("If you choose to continue, this competition will become the current competition. Do you want to proceed?"))
            {
              dataArray = {name:name, description:description};
				      data = JSON.stringify(dataArray);
				
              fetch("createCompetition.php", {method: 'post', body: data}).then(response => response.text()).then(displayResults);
            }
          }
          else
          {
            //Clear away any previous messages
            document.getElementById("confirmCompCreationMessage").innerHTML = "";
            
            //Create and display an error message
            var divElement = document.createElement('div');
            divElement.setAttribute('class', 'error');
          
            var pElement = document.createElement('p');
            pElement.innerHTML = 'All of the fields must have at least some input';
          
            divElement.appendChild(pElement);
            document.getElementById("confirmCompCreationMessage").appendChild(divElement);
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
			<a href="editDisplays.php">Edit Displays</a>
			<a class="active" href="newCompetition.php">New Competition</a>
			<a href="newModerator.php">Register New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div> 
		<h1>New Competition</h1>
		<div id="confirmCompCreationMessage"></div>
		<form action="" method="post" name="new-competition-form">
      <h2>Competition Information</h2>
			<div class="form-element">
				<input type="text" id="name" name="name" placeholder="Competition Name" required />
			</div>
			<div class="form-element">
				<input type="text" id="description" name="description" placeholder="Description" required />
			</div>
			<button class='form-button' type="button" name="submit" value="submit" onclick="confirmCompCreation()">Submit</button>
		</form>		
	</body>
</html>
