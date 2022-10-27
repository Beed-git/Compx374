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
   
    //Trim spaces from front and end of strings
    $firstname = trim($firstname);
    $lastname = trim($lastname);   
    $email = trim($email);
    $story = trim($story);      
		
		//Deal with any apostrophes present in the input
		$firstname = str_replace("'", "''", $firstname);
		$lastname = str_replace("'", "''", $lastname);
		$story = str_replace("'", "''", $story);
		
    //Check that all input is valid
    $input_error = false;
    
    if (!preg_match("/^[a-zA-z-' ]*$/", $firstname))
    {  
      echo '<div class="error"><p>Invalid character in first name.</p></div>';
      $input_error = true;  
    }
    
    if (!preg_match("/^[a-zA-z-' ]*$/", $lastname))
    {  
      echo '<div class="error"><p>Invalid character in last name.</p></div>';
      $input_error = true; 
    }
    
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password))
    {  
      echo '<div class="error"><p>Password must container at least eight characters, and at least one uppercase letter, lowercase letter, and a number.</p></div>';
      $input_error = true; 
    }
   
		//Create username from first name and last name
		$username = $firstname.' '.$lastname;
		
		//Hash the password
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
		
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
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
	</head>
	<body>
      <br><br>
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
				  <textarea name="story" id="story" placeholder="Story" cols="50" rows="10" maxlength="500" required></textarea>
			  </div>			
			  <button class="form-button" type="submit" name="register" value="register">Register</button>
			  <p>Already have an account? <a href="../index.php">Log in</a></p>
		  </form>
	</body>
</html>	
