<?php
	//Initialize the session
	session_start();
 
	//Check if the user is logged in, if not then redirect him to login page
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
    <?php
      //Check if the form is submitted
      if(isset($_POST['submit']))
	    {
		    //Retrieve the form data
        $name = $_POST['name'];
		    $description = $_POST['description'];
		
		    //Save the image to the server !!TO BE COMPLETED!!
        $uploadOk = 1;
        $originalName = basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($originalName,PATHINFO_EXTENSION));
        $fileDestination = '../images/'.uniqid();
        $media_url = $fileDestination.'.'.$imageFileType;
    
        //Check if image file is an actual image or a fake image
        if(isset($_POST["submit"]))
        {
          $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
          if($check !== false)
          {
            $uploadOk = 1;
          }
          else
          {
            echo "<div class='error'><p>File is not an image.</p></div>";
            $uploadOk = 0;
          }
        }

        //Check if file already exists
        if (file_exists($fileDestination))
        {
          echo "'<div class='error'><p>Sorry, file already exists.</p></div>";
          $uploadOk = 0;
        }

        //Check file size
        if ($_FILES["fileToUpload"]["size"] > 2000000)
        {
          echo "'<div class='error'><p>Sorry, your file is too large.</p></div>";
          $uploadOk = 0;
        }

        //Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
        {
          echo "'<div class='error'><p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p></div>";      
          $uploadOk = 0;
        }

        //Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
          echo "'<div class='error'><p>Sorry, your file was not uploaded.</p></div>";
          //if everything is ok, try to upload file
        }
        else
        {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileDestination))
          {
          //Add this new media to the media table
		      $id_query = "select artist_id from Artist where email='".$_SESSION["email"]."'";
		      $id_result = $con->query($id_query);
		
		      if ($id_result)
		      {
			      $artist_row = $id_result->fetch();
			      
			      $query = "insert into Media(media_url,name,description,artist_id) values('".$fileDestination."','".$name."','".$description."','".$artist_row['artist_id']."')";
			      $result = $con->query($query);
			
			      if ($result)
			      {
				      echo '<div class="success"><p>Success.</p></div>';
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
        else
        {
          echo "'<div class='error'><p>Sorry, there was an error uploading your file.".$_FILES['fileToUpload']['error']."</p></div>";
        }
      }
    }
    ?>
		<h1>Submit Mural</h1>		
		<div class="center">
			<div class="form-input">
				<form action="" method="post" name="submission-form" enctype="multipart/form-data">
					<div class="form-element">
            <input type="file" name="fileToUpload" id="fileToUpload" onchange="showPreview(event);" required>
            <div class="preview">
					    <img id="file-upload-preview">
					  </div>
					</div>
					<div class="form-element">
						<input type="text" name="name" placeholder="Name" required />
					</div>
					<div class="form-element">
						<br>
						<textarea name="description" cols="50" rows="10" maxlength="500" placeholder="Description" required></textarea>
						<br>
					</div>
					<input type="submit" name="submit" class="submit" value="Submit">
				</form>
			</div>
		</div>
	</body>
</html>
