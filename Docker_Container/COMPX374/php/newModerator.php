<?php
	//Start the session
	session_start();
	
	//Connect to the database
	require_once('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Register</title>
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="topnav">
			<a href="submissions.php">Review Submissions</a>
			<a href="editDisplays.php">Edit Displays</a>
			<a href="newCompetition.php">New Competition</a>
			<a class="active" href="newModerator.php">Register New Moderator</a>
			<a class="logout" href="logout.php">Log out</a>
		</div>
		<?php
			//Check if the form is submitted
			if(isset($_POST['register']))
			{
				//Retrieve the form data
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$confirmPassword = $_POST['confirmPassword'];
			
				//Deal with any apostrophes present in the input
				$username = str_replace("'", "''", $username);
		
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
							//Insert new user into the database
							$moderatorQuery = "insert into Moderator(email,username,password) values('".$email."','".$username."','".$hashed_password."')";
							$result2 = $con->query($moderatorQuery);
			
							if ($result2)
							{
								echo "<div class='success'><p>New moderator successfully registered.</p></div>";
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
    <h1>Register New Moderator</h1>
		<form method="post" action="" name="signup-form">
			<h2>New Moderator Information</h2>
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
			<button class="form-button" type="submit" name="register" value="register">Register</button>
		</form>
	</body>
</html>	