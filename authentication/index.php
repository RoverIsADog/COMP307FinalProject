<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styles/stylesheet.css">

	<title>McGill TA Management System</title>
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
		
		<div class="">
			<form id="login-form" name="login-form">
				<label for="username">Username: </label>
				<input type="text" name="username" id="username" value="" required>
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" value="" required>
				
				<button type="submit" id="login-button" name="login-button" value="login">Login</button>
			</form>
		</div>
		
		<div class="register-link">
			<a href="register.php">Register an account</a>
		</div>
	</div>
	
	<div class="footer">
		<p>&copy 1995, Joe Vybihal</p>
	</div>
	<script type="text/javascript" src="login.js"></script>
</body>
</html>
