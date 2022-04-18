<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/stylesheet.css">
		<title>McGill TA Management System | Login</title>
	</head>

	<body>
		<div class="header">
			<h1>McGill TA Management System</h1>
		</div>
		
		<div class="desc">
			<h2>Welcome to the McGill SOCS TA Management System. This system can be accessed by students, faculty, and staff within the SOCS department.</h2>
		</div>
	
		<div id="login">
			<h3>Login</h3>
			
			<div class="login-form">
				<form method="post" action="login.php">
					<label for="username">Username: </label>
					<input type="text" name="username" id="username">
					<label for="password">Password: </label>
					<input type="password" name="password" id="password">
					
					<button type="submit" name="login-btn" class="submit" value="Login">Login</button>
				</form>
			</div>
			
			<div class="register-link">
				<a href="register.php">Register an account</a>
			</div>
		</div>
		
		<div class="footer">
			<p>&copy 1995, Joe Vybihal</p>
		</div>
	</body>
</html>
