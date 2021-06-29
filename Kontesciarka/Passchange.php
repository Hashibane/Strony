<?php 
	session_start();
	if (!isset($_SESSION['logged']))
	{
		header('Location: logowanie.php');
		exit();
	}
	if (isset($_POST['passwordc1']))
	{
		$OK = true;
		$password1=$_POST['passwordc1'];
		$password2=$_POST['passwordc2'];
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
	
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		require_once "connecting.php";
		$usr=$_SESSION['user'];
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
				$result = $connection->query("SELECT id FROM uzytkownicy WHERE Username='$usr'");
				if (!$result) throw new Exception($connection->error);
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			$_SESSION['error']="Server error, sorry for unavailability";
		}
		
		if ($OK)
		{	
			if ($connection->query("UPDATE uzytkownicy SET Password='$password_hash' WHERE Username='$usr';"))
			{
				header('Location: main.php');
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
	<link rel = "stylesheet" href = "main.css" type = "text/css"/>
	<link rel = "stylesheet" href = "css/fontello.css" type = "text/css"/>
</head>
<body style = "background-color: white; width: 100vw; height: 100vh;">
	<div id = "upperbar">

		<a class="ikonka" style="text-align: left; line-height: 10vh;" onclick="sidebar()"><i class="demo-icon icon-th-list" id="sico" style="font-size: 3vw; color: white;"></i></a>
		<script>
			function sidebar()
			{
				document.getElementById("sico").style.color = "grey";
				document.getElementById("main").style.width = "82%";
				document.getElementById("aaa").style.margin = "0";
			}
		</script>
		<div class="rectangle">
			Zalogowany jako: <?php echo $_SESSION['user'];?>
		</div>
	</div>
	<div id="aaa">
	
		<ul>
			<li><a href="main.php">Strona główna</a></li>
			<li>Ranking</li>
			<li><a href="Zadania.php">Zadania</a></li>
			<li><a href="Upload.php">Wyślij zadanie</a></li>
			<li>FAQ</li>
			<li>Zgłoś błąd</li>
			<li><a href="Passchange.php">Zmień hasło</a></li>
			<li><a href="loggingout.php">Wyloguj</a></li>
		</ul>
	</div>
	<div id="main" onclick="sidebarclose()">
		<div id="container">
			<form action = "" method = "post">
				<label for = "passwordc1">Hasło:</label>
				<input type = "password" id = "password" name = "passwordc1"/>
				<label for = "passwordc2">Powtórz hasło:</label>
				<input type = "password" id = "password" name = "passwordc2"/>
				<input type = "submit" value = "Zmień hasło" style="width: 160px; height = 1px; margin">
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
		</div>
	</div>
	<script>
		function sidebarclose()
				{
					document.getElementById("sico").style.color = "white";
					document.getElementById("aaa").style.marginLeft = "-18vw";
					document.getElementById("main").style.width = "100%";
				}
	</script>
</body>
</html>