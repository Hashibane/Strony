<?php 
	session_start(); 
	if (isset($_SESSION['logged']) and $_SESSION['logged'])
	{
		header("Location: main.php");
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset = "utf-8" />
	<title>CONTEST MACHINE V0.0</title>
	<meta name = "description" content = "sprawdzarka klasa IIAR"/>
	<meta name = "author" content = "JJ 04092020 - ..."/>
	
	<link rel = "stylesheet" href = "kontesciara.css" type = "text/css"/>
	
</head>
<body style = "background-color: #131214;">
	<div id = "container">
		<div id = "logowanie">
			<form action = "logging.php" method = "post">
				<label for = "username">Username:</label>
				<input type = "text" name = "username"/>
				<br/>
				<label for = "password">Password:</label>
				<input type = "password" name = "password"/>
				<br/>
				<input type = "submit" value = "Login">
			</form>
			<div id = "ermsg" style="font-size: 18px; margin-left: 2vw; color: red; font-family: 'Helvetica Neue', Helvetica, sans-serif;">
				<?php
					if (isset($_SESSION['error']))
					{
						if ($_SESSION['error']=='Incorrect Username or Password')
						{
							echo $_SESSION['error'];
							$_SESSION['error']="";
						}
					}
				?>
			</div>
			<a href = "zalozkonto.php" id = "zalozkonto" >Nie masz konta? - stwórz je!</a>
		</div>
		
	</div>
</body>
</html>