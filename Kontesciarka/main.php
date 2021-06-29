<?php 
	session_start();
	if (!isset($_SESSION['logged']))
	{
		header('Location: logowanie.php');
		exit();
	}
	unset($_SESSION['error']);
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
		<div id="container" class="contfont" style="height: 20vh;">
			<br/>
			Witaj!<br/>
			To projekt z informatyki do sprawdzania twoich zadań.<br/>
			Wersja projektu: 0.0.1 
			<br/>
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