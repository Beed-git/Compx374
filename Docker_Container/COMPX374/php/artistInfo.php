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
		<title>Your Info</title>
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
		<script>
			//Fetch the artist's info
			let getArtistInfo = () => {
				fetch("getArtistInfo.php", {method: 'post'}).then(response => response.text()).then(displayResults);
			}

			//Display the results
			let displayResults = (response) => {
				document.getElementById("info").innerHTML = response;
        
        //Clear away any error messages
        document.getElementById("empty_input").innerHTML = "";
			}
			
			//Edit artist information
			let editArtistInfo = () => {
				//Hide the old information and the edit button
				document.getElementById("artistFirstName").style.display = "none";
				document.getElementById("artistLastName").style.display = "none";
				document.getElementById("artistStory").style.display = "none";
        
        document.getElementById("fn-label").style.display = "none";
        document.getElementById("ln-label").style.display = "none";
        document.getElementById("story-label").style.display = "none";
				
        document.getElementById("editArtistInfoButton").style.display = "none";
				document.getElementById("editArtistInfoButton").style.display = "none";
        
				//Show the text boxes for editing the information, and the update and cancel buttons
				document.getElementById("editArtistFirstName").style.display = "inline";
				document.getElementById("editArtistLastName").style.display = "inline";
				document.getElementById("editArtistStory").style.display = "inline";
				document.getElementById("updateArtistInfoButton").style.display = "inline";
				document.getElementById("cancelArtistInfoButton").style.display = "inline";
			}
			
			let updateArtistInfo= () => {
				//Retrieve the updated artist informatin from the text boxes
				var firstName = document.getElementById("editArtistFirstName").value;
				var lastName = document.getElementById("editArtistLastName").value;
				var story = document.getElementById("editArtistStory").value;
				
				dataArray = {firstName:firstName, lastName:lastName, story:story};
				data = JSON.stringify(dataArray);
				
        //Check that none of the fields have been left blank
        if (firstName != '' && lastName != '' && story != '')
        {
          //Update the artist information
				  fetch("updateArtistInfo.php", {method: 'post', body: data}).then(response => response.text()).then(getArtistInfo);
        }
        else
        {
          //Check if there is already an error message
          if (document.getElementById('empty_input').childElementCount == 0)
          {
            //Create and display an error message
            var divElement = document.createElement('div');
            divElement.setAttribute('class', 'error');
          
            var pElement = document.createElement('p');
            pElement.innerHTML = 'All of the fields must have at least some input';
          
            divElement.appendChild(pElement);
            document.getElementById("empty_input").appendChild(divElement);
          }
        }
			}
		</script>
	</head>
	<body onload="getArtistInfo()">
		 <div class="topnav">
			<a href="upload.php">New Submission</a>
			<a class="active" href="artistInfo.php">Your Information</a>
			<a href="artistSubmissions.php">Your Submissions</a>
			<a class="logout" href="logout.php">Log out</a>
		</div>
		<h1>Your Information</h1>
    <div id='empty_input'></div>	
		<div id="info"></div>
	</body>
</html>
