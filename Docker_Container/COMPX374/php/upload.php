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
	
	//Check if the form is submitted
	if(isset($_POST['submit']))
	{
		//Retrieve the form data
		$file_upload = $_POST['file_upload'];
        $name = $_POST['name'];
		$description = $_POST['description'];
		
		//Save the image to the server !!TO BE COMPLETED!!
		if(isset($_FILES['file-upload']))
		{
			move_uploaded_file($_FILES['file-upload']['tmp_name'], "../images/". $_FILES['file-upload']['name']);
		}
		else
		{
			echo "image not found!";
		}
		
		//Add this new media to the media table
		$media_url = '../images/'.uniqid();
		
		$id_query = "select id from Artist where email='".$_SESSION["email"].'"';
		$id_result = $con->query($query);
		
		if ($result)
		{
			$artist_id = $id_result->fetch();
			
			$query = "insert into Media(media_url,name,description,artist_id) values('".$media_url."','".$name."','".$description."','".$artist_id."')";
			echo '<p>'.$query.'</p>';
			$result = $con->query($query);
			
			if ($result)
			{
				echo '<p>Success.</p>';
			}
			//Otherwise, display an error message
			else
			{
				echo '<div class="error"><p>Error in database query.</p></div>';
			}
		}
		//Otherwise, display an error message
		else
		{
			echo '<div class="error"><p>Error in database query.</p></div>';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Upload</title>
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
		<script>	
			function showPreview(event)
			{
				if(event.target.files.length > 0)
				{
					var src = URL.createObjectURL(event.target.files[0]);
					var preview = document.getElementById("file-upload-preview");
					preview.src = src;
					preview.style.display = "block";
				}
			}
		</script>	
	</head>
	<body>
		 <div class="topnav">
			<a class="active" href="upload.php">New Submission</a>
			<a href="artistInfo.php">Your Information</a>
			<a href="artistSubmissions.php">Your Submissions</a>
			<a class="logout" href="logout.php">Log out</a>
		</div> 
		<h1>Submit Mural</h1>		
		<div class="center">
			<div class="form-input">
				<form action="" method="post" name="submission-form">
					<div class="form-element">
						<div class="image-upload">
							<input type="file" name="file-upload" id="file-upload" accept="image/*" onchange="showPreview(event);">
							<div class="preview">
								<img id="file-upload-preview">
							</div>
						</div>
					</div>
					<div class="form-element">
						<input type="text" name="name" placeholder="Name" required />
					</div>
					<div class="form-element">
						<br>
						<textarea name="description" cols="50" rows="10" maxlength="500" placeholder="Description"></textarea>
						<br>
					</div>
					<input type="submit" name="submit" class="submit" value="Submit">
				</form>
			</div>
		</div>
	</body>
</html>	