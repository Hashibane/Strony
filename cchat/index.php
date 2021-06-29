<?php

	session_start();
	if (isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))
	{
		header('Location: chat.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<title>ClassChat.pl</title>
	<meta name="description" content="Czat klasowy dla wybranych ludzi :)"/>
	<meta name="keywords" content="II LO, mat-fiz, II LO mat-fiz, wałbrzychbrzych"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css"/>	
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
</head>

<body>
	<div id="container">
		
		<div id="logan">
			<div id="logo" style="font-size: 2vw;">
				ClassChat.pl   
			</div>
			<br />
				<div id="log" style="font-size: 1.5vw;">
					<form action="zaloguj.php" method="post">
						Login: <input type="text" name="login" style="height: 1.5vw"/> <br /> 
						Hasło: <input type="password" name="haslo" style="height: 1.5vw"/> <br />
								<?php
									if (isset($_SESSION['blad']))
									echo $_SESSION['blad'];
								?>
								<br />
						        <input type="submit" value="Zaloguj się"  style="height:5vh; width:11vw; font-size: 1.5vw;"/>
					</form>
				</div>
				<div id="zalozkonto" style="font-size: 1.5vw;">
						<a href="rejestracja.php">Załóż konto</a>
				</div>
			<br />
		</div>
		
	</div>

</body>

</html>