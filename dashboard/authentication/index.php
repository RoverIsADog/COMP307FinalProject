<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . "/../rootpath.php");

$username = $_POST["username"];
$password = $_POST["password"];

if (isset($_POST['login-btn'])) {

	echo "Username = $username <br>\n";
	echo "Password = $password <br>\n";
	
	if (!empty($username) && !empty($password)) {
		$command = escapeshellcmd('python3 '.__ROOT_DIR__.'register_login/verify_login.py'.' '.$username.' '.$password);
		$output = exec($command);
		
		if ($output == '1') {
			echo '<script>alert("Invalid username or password.")</script>';
			//header("Refresh:0");
			//exit;
		}
		

		echo print_r($output) . "<br>";
		$ticket = explode(",", $output);

		echo print_r($ticket) . "<br>";

		$_SESSION['ticket'] = $ticket[0];
		$_SESSION['username'] = $ticket[1];

		// $_SESSION['username'] = $username;
		// $_SESSION['password'] = $password;

		// echo "Username = $username <br>\n";
		// echo "Password = $password <br>\n";

		echo "ticket = " . $_SESSION["ticket"] .  "<br>\n";
		echo "username = " . $_SESSION["username"] .  "<br>\n";
		
		header("Location: http://r469.yetongzhou.ca:20563/dashboard/dashboard.php");
    } else {
		echo '<script>alert("Some of the fields were left empty.")</script>';
		//header("Refresh:0");	
		//exit;
	}
}

?>

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
				<form method="post" action="">
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
