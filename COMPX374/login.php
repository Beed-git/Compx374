<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link href="css/login.css" rel="stylesheet" type="text/css">
		</head>
	<body>
		<form method="post" action="" name="login-form">
			<h1>Log into Tuakiri</h1>
			<div class="form-element">
				<input type="email" name="email" placeholder="Email" required />
			</div>
			<div class="form-element">
				<input type="password" name="password" placeholder="Password" required />
			</div>
			<div>
				<a href="php/forgot-password.php">Forgot password?</a>
			</div>
			<button type="submit" name="login" value="login">Log In</button>
			<p class="seperator"><span>or</span></p>
			<button type="submit" name="google" value="google">Sign in with Google</button>
			<p>No account? <a href="php/register.php">Create one</a></p>
		</form>
	</body>
</html>	