<?php
	//Start the session
	session_start();
	
	//Connect to the database
	require_once('php/connection.php');
	
	//Check if the form is submitted
	if(isset($_POST['login']))
	{
		//Retrieve the form data
		$email = $_POST['email'];
        $password = $_POST['password'];
		
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
			
			//Check that the email belongs to an artist
			if (gettype($artistRow) == 'array')
			{
				//Check that the user has entered the correct password
				if (password_verify($password, $artistRow['password']))
				{
					$_SESSION["loggedin"] = true;
					$_SESSION['email'] = $email;
					header("Location: php/upload.php");
				}
				//Otherwise, display an error message
				else
				{
					echo '<p>Your username or password was incorrect.</p>';
				}
			}
			//Check if the email belongs to a moderator
			elseif (gettype($moderatorRow) == 'array')
			{
				//Check that the user has entered the correct password
				if (password_verify($password, $moderatorRow['password']))
				{
					$_SESSION["loggedin"] = true;
					$_SESSION['email'] = $email;
					header("Location: php/newCompetition.php");
				}
				//Otherwise, display an error message
				else
				{
					echo '<p>Your username or password was incorrect.</p>';
				}
			}
			//Otherwise, display an error message
			else
			{
				echo '<p>Your username or password was incorrect.</p>';
			}
		}
		//Otherwise, display an error message
		else
		{
			echo '<p>Error in database query.</p>';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link href="css/login.css" rel="stylesheet" type="text/css">
	</head>
	<body>		
		<form action="" method="post" name="signin-form">
			<h1>Log into Tuakiri</h1>
			<div class="form-element">
				<input type="email" id="email" name="email" placeholder="Email" required />
			</div>
			<div class="form-element">
				<input type="password" id="password" name="password" placeholder="Password" required />
			</div>
			<div>
				<a href="php/forgot-password.php">Forgot password?</a>
			</div>
			<button type="submit" name="login" value="login">Log In</button>
			<p>No account? <a href="php/register.php">Create one</a></p>
		</form>
	</body>
</html>	
