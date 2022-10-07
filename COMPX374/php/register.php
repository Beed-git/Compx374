<?php
	//Start the session
	session_start();
	
	//Connect to the database
	require_once('connection.php');
	
	//Check if the form is submitted
	if(isset($_POST['register']))
	{
		//Retrieve the form data
		$username = $_POST['username'];
		$email = $_POST['email'];
        $password = $_POST['password'];
		$story = $_POST['story'];
		
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
				}	
			}
			else
			{
				echo '<p>This email address is already registered.</p>';
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
	</head>
	<body>
		<form method="post" action="" name="signup-form">
			<h1>Create an Account for Tuakiri</h1>
			<div class="form-element">
				<input type="text" name="username" placeholder="Name" required />
			</div>
			<div class="form-element">
				<input type="email" name="email" placeholder="Email" required />
			</div>
			<div class="form-element">
				<input type="password" name="password" placeholder="Password" required />
			</div>
			<div class="form-element">
				<input type="text" name="story" placeholder="Story" />
			</div>
			<div class="form-element">
				<input type="checkbox" name="user_type" value="Moderator">
				<label for="user_type">Moderator</label><br>
			</div>			
			<button type="submit" name="register" value="register">Register</button>
			<p>Already have an account? <a href="../index.php">Log in</a></p>
		</form>
	</body>
</html>	
