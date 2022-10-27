<?php
	//Check if the form is submitted
	if(isset($_POST['forgot-password']))
	{
    echo '<div class="error"><p>Reset password functionality not yet implemented.</p></div>';
  }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Forgot Password</title>
		<link href="../css/tuakiri.css" rel="stylesheet" type="text/css">
	</head>
	<body>
      <br><br>
      <form method="post" action="" name="forgot-password-form">
			  <h1>Forgot Password</h1>
			  <p>Please enter your email address. You will recieve a link to create a new password via email.</p>
			  <div class="form-element">
				  <input type="email" name="email" placeholder="Email" required />
			  </div>
			  <button class="form-button" type="submit" name="forgot-password" value="forgot-password">Reset Password</button>
        <p><a href="../index.php">&#x2190; Return to login page</a></p>
		  </form>
   </div>
	</body>
</html>	
