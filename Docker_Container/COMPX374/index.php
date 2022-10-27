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
    $user_type = $_POST['user_type'];
		 
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
      if ($user_type == 'option_user' AND gettype($artistRow) == 'array')
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
					echo '<div class="error"><p>Your username or password was incorrect.</p></div>';
				}
			}
			//Check if the email belongs to a moderator
			elseif ($user_type == 'option_moderator' AND gettype($moderatorRow) == 'array')
			{
        //Check that the user has entered the correct password
				
        echo password_verify($password, $moderatorRow['password']);
        if (password_verify($password, $moderatorRow['password']))
				{
					$_SESSION["loggedin"] = true;
					$_SESSION['email'] = $email;
					header("Location: php/submissions.php");
				}
				//Otherwise, display an error message
				else
				{
					echo '<div class="error"><p>Your username or password was incorrect.</p></div>';
				}
			}
			//Otherwise, display an error message
			else
			{
				echo '<div class="error"><p>Your username or password was incorrect.</p></div>';
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
		<title>Login</title>
		<link href="css/tuakiri.css" rel="stylesheet" type="text/css">
	</head>
	<body>		
		  <br><br>
      <form action="" method="post" name="signin-form">
			  <h1>Log into Tuakiri</h1>
			  <div class="form-element">
				  <input type="email" id="email" name="email" placeholder="Email" required />
			  </div>
			  <div class="form-element">
				  <input type="password" id="password" name="password" placeholder="Password" required />
			  </div>
        <div class="form-element radio-button">
          <label for"option_user">User</label>
          <input type="radio" class="radio" id="option_user" name="user_type" value="option_user" checked>
          <label for"option_moderator">Moderator</label>
          <input type="radio" id="option_moderator" name="user_type" value="option_moderator">
			  </div>
			  <div>
				  <a href="php/forgot-password.php">Forgot password?</a>
			  </div>
			  <button class="form-button" type="submit" name="login" value="login">Log In</button>
			  <p>No account? <a href="php/register.php">Create one</a></p>
		  </form>
	</body>
</html>	
