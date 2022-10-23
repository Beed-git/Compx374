<?php
	//Start the session
	session_start();
	
	//Connect to the database
	require_once('connection.php');
	
	//Check if the form is submitted
	if (isset($_POST['login'])
	{
		//Retrieve the form data
		$email = $_POST['email'];
        $password = $_POST['password'];
		
		//Query the database for the email
		$query = "select * from Artist where email = '".$email."'";
		$result = $con->query($query);
		
		//Check that the email already exists in the database
		if($result != FALSE)
		{	
			//Check that the user has entered the correct password
			if ($password == $result['password'])
			{
				$_SESSION['email'] = $email;
				header("Location: upload.php");
				exit();
			}
			else
			{
				header("Location: ../login.php");
				exit();
			}
		}
		else
		{
			header("Location: ../login.php");
			exit();
		}
	}
?>