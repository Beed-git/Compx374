<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Register</title>
		<link href="../css/login.css" rel="stylesheet" type="text/css">
		</head>
	<body>
		<form method="post" action="" name="login-form">
			<h1>Create an Account for Tuakiri</h1>
			<div class="form-element">
				<input type="text" name="first-name" placeholder="First Name" required />
			</div>
			<div class="form-element">
				<input type="text" name="last-name" placeholder="Last Name" required />
			</div>
			<div class="form-element">
				<input type="email" name="email" placeholder="Email" required />
			</div>
			<div class="form-element">
				<input type="password" name="password" placeholder="Password" required />
			</div>
			<button type="submit" name="login" value="login">Register</button>
			<p>Already have an account? <a href="../login.php">Log in</a></p>
		</form>
	</body>
</html>	