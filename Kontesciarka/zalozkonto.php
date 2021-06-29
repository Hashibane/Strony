<?php 
	session_start(); 
	if (isset($_SESSION['logged']) and $_SESSION['logged'])
	{
		header("Location: main.php");
		exit();
	}
	if (isset($_POST['nick']))
	{
		$OK = true;
		
		$nick=$_POST['nick'];
		$password1=$_POST['passwordr'];
		$password2=$_POST['password0r'];
		if ($password1!=$password2)
		{
			$OK = false;
			$_SESSION['error']='Password and Confirm password dont match';
		}	
		if ((strlen($password1)<8)or(strlen($password1)>20))
		{
			$OK = false;
			$_SESSION['error']='Your password must be at least 8 characters and not more than 20';
		}
		if ((strlen($nick)<4)or(strlen($nick)>15))
		{
			$OK = false;
			$_SESSION['error']='Your nick must be at least 4 characters and not more than 15';
		}
		if (!ctype_alnum($nick))
		{
			$OK = false;
			$_SESSION['error']='Nick can only consist from letters and numbers';
		}
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		//bot OR !
		$secret = "6LeYGcoZAAAAAExOgIjRKFvjn3kXYmlkpp404ube";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$captcharesponse = json_decode($check);
		if (!($captcharesponse->success))
		{
			$OK = false;
			$_SESSION['error']='Confirm, that you are not a bot';
		}
		
		require_once "connecting.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if (!$connection->connect_errno)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$result = $connection->query("SELECT id FROM uzytkownicy WHERE Username='$nick'");
				if (!$result) throw new Exception($connection->error);
				if ($result->num_rows)
				{
					$OK=false;
					$_SESSION['error']="The given nick already exists!";
				}
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			$_SESSION['error']="Server error, sorry for unavailability";
		}
		
		if ($OK)
		{	
			if ($connection->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$password_hash')"))
			{
				header('Location: logowanie.php');
				exit();
			}
			else
			{
				throw new Exception($connection->error);
			}
		}
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
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	
</head>
<body style = "background-color: #131214;">
	<div id = "container" style="height: 47vh">
		<div id = "logowanie">
			<form action = "" method = "post">
				<label for = "nick">Nick:</label>
				<input type = "text" id = "username" name = "nick"/>
				<br/>
				<label for = "password1">Password:</label>
				<input type = "password" id = "password" name = "passwordr"/>
				<label for = "password2">Confirm Password:</label>
				<input type = "password" id = "password" name = "password0r"/>
				<div class="g-recaptcha" data-sitekey="6LeYGcoZAAAAAO2NzQ6jjnKoC6H6m_tq-EXQ2cMM" style = "margin-left: 2vw;"></div>
				<input type = "submit" value = "Create account" style="width: 160px; height = 1px; margin">
			</form>
			<div id = "ermsg" style="margin-top: 1vh; font-size: 18px; margin-left: 2vw; color: red; font-family: 'Helvetica Neue', Helvetica, sans-serif;">
				<?php
					if (isset($_SESSION['error']))
					{
						echo $_SESSION['error'];
						unset($_SESSION['error']);
					}
				?>
			</div>
			<a href = "logowanie.php" id = "zalozkonto" style="margin-left: 2vw;">Powrót</a>
		</div>
		
	</div>
</body>
</html>