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
		<title>Upload</title>
		<link href="../css/upload.css" rel="stylesheet" type="text/css">
		<script>	
			function showPreview(event)
			{
				if(event.target.files.length > 0)
				{
					var src = URL.createObjectURL(event.target.files[0]);
					var preview = document.getElementById("file-ip-1-preview");
					preview.src = src;
					preview.style.display = "block";
				}
			}
			
			//Create the XHR object
			ajaxRequest = new XMLHttpRequest();
			
			//Prepare and send an AJAX request			
			let sendAjaxRequest = (method, url, data, callback) => {
			//Initialise the XHR object with the request type and URL
			ajaxRequest.open(method, url);
	
			if (method == "POST")
			{
				ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			}
	
			//Set the callback function
			ajaxRequest.onload = callback;
			//Send the request
			ajaxRequest.send(data);
			}
			
			//Fetch the artist's story
			let getArtistStory = (artistEmail) => {
				fetch("getArtistStory.php", {method: 'post', body: artistEmail}).then(response => response.text()).then(displayArtistStory);
			}

			//Display the full info for a given player
			let displayArtistStory = (response) => {
				document.getElementById("artist-story").textContent = response;
			}
			
			//Function for updating the artist story
			let updateArtistStory = () => {
				//Create a JSON object of data to send
				dataArray = {email:'samsteed4@gmail.com', newArtistStory: document.getElementById("artist-story").textContent};
				data = JSON.stringify(dataArray);
				
				fetch("updateArtistStory.php", {method: 'post', body: data}).then(response => response.text());
	
				//Send the AJAX request
				//sendAjaxRequest("post", "updateArtistStory.php", data, displayData);
			}
			
			//Submit the mural information to the database
			function submitMural()
			{
				//Update the artist story
				//THIS DOESN'T WORK!!
				updateArtistStory();
			}
		</script>	
	</head>
	<body onload="getArtistStory('<?php echo htmlspecialchars($_SESSION["email"]);?>')">
		 <div class="topnav">
			<a href="logout.php">Log out</a>
		</div> 
		<h1>Submit Mural</h1>		
		<div class="center">
			<div class="form-input">
				<form action="">
					<label for="artist-story">About You:</label>
					<br>
					<textarea name="artist-story" id="artist-story" cols="50" rows="10" maxlength="500"></textarea>
					<br>
					<label for="file-ip-1">Upload Image</label>
					<div class="image-upload">
						<input type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
						<div class="preview">
							<img id="file-ip-1-preview">
						</div>
					</div>
					<label for="description">Description:</label>
					<br>
					<textarea name="description" cols="50" rows="10" maxlength="500"></textarea>
					<br>
					<input type="submit" name="submit" class="submit" value="Submit" onclick="submitMural()">
				</form>
			</div>
		</div>
	</body>
</html>	