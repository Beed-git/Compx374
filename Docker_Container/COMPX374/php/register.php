<?php
	//Start the session
	session_start();
	
	//Connect to the database
	require_once('connection.php');
	
	//Check if the form is submitted
	if(isset($_POST['register']))
	{
		//Retrieve the form data
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
        $password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		$story = $_POST['story'];
		
		//Deal with any apostrophes present in the input
		$username = str_replace("'", "''", $username);
		$story = str_replace("'", "''", $story);
		
		//Create username from first name and last name
		$username = $firstname.' '.$lastname;
		
		//Hash the password
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		//Query the Artist and Moderator tables for the email
		$artistQuery = "select * from Artist where email = '".$email."'";
		$artistResult = $con->query($artistQuery);
		
		$moderatorQuery = "select * from Moderator where email = '".$email."'";
		$moderatorResult = $con->query($moderatorQuery);
		
		//Check that the queries were processed successfully
		if($artistResult != FALSE && $moderatorResult != FALSE)
		{
			
			$artistRow = $artistResult->fetch();
			$moderatorRow = $moderatorResult->fetch();
			
			//Check that the email does not already exist in the database
			if (gettype($artistRow) != 'array' && gettype($moderatorRow) != 'array')
			{
				//Check that the password is the same as the confirmation password
				if ($password == $confirmPassword)
				{
					if(isset($_POST['user_type']) && $_POST['user_type'] == 'Moderator')
					{
						//Insert new user into the database
						$moderatorQuery = "insert into Moderator(email,username,password) values('".$email."','".$username."','".$hashed_password."')";
						$result2 = $con->query($moderatorQuery);
			
						if ($result2)
						{
							$_SESSION["loggedin"] = true;
							$_SESSION['email'] = $email;
							header("Location: newCompetition.php");
						}
						//Otherwise, display an error message
						else
						{
							echo '<div class="error"><p>Error in database query.</p></div>';
						}
					}
					else
					{
						//Insert new user into the database
						$artistQuery = "insert into Artist(email,username,password,story) values('".$email."','".$username."','".$hashed_password."','".$story."')";
						$result2 = $con->query($artistQuery);
			
						if ($result2)
						{
							$_SESSION["loggedin"] = true;
							$_SESSION['email'] = $email;
							header("Location: upload.php");
						}
						//Otherwise, display an error message
						else
						{
							echo '<div class="error"><p>Error in database query.</p></div>';
						}
					}
				}
				else
				{
					echo '<div class="error"><p>The password and confirmation password do not match.</p></div>';
				}	
			}
			else
			{
				echo '<div class="error"><p>This email address is already registered.</p></div>';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Register</title>
		<link href="../css/login.css" rel="stylesheet" type="text/css">
		<script>
			function toggleStoryDisplay()
			{
				var story = document.getElementById('story');
				
				if (story.style.display == "none")
				{
					story.style.display = "block";
				}
				else
				{
					story.style.display = "none";
				}
			};
		</script>
	</head>
	<body>
		<form method="post" action="" name="signup-form">
			<h1>Create an Account for Tuakiri</h1>
			<div class="form-element">
				<input type="text" name="firstname" placeholder="First Name" required />
			</div>
			<div class="form-element">
				<input type="text" name="lastname" placeholder="Last Name" required />
			</div>
			<div class="form-element">
				<input type="email" name="email" placeholder="Email" required />
			</div>
			<div class="form-element">
				<input type="password" name="password" placeholder="Password" required />
			</div>
			<div class="form-element">
				<input type="password" name="confirmPassword" placeholder="Confirm Password" required />
			</div>
			<div class="form-element">
				<textarea name="story" id="story" placeholder="Story" cols="50" rows="10" maxlength="500"></textarea>
			</div>
			<div class="form-element">
				<input type="checkbox" name="user_type" onchange="toggleStoryDisplay()" value="Moderator">
				<label for="user_type">Moderator</label><br>
			</div>			
			<button type="submit" name="register" value="register">Register</button>
			<p>Already have an account? <a href="../index.php">Log in</a></p>
		</form>
	</body>
</html>	