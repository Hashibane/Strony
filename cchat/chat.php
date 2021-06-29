<?php

	session_start();

	if (!isset($_SESSION['zalogowany']))
	{
			header('Location: index.php');
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
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<style>
		#gornypasek
		{
			padding: 0;
			margin: 0;
			opacity: 0.9;
			width: 100%;
			height: 15vh;
			background-color: #999999;
			border-style: groove;
			border-color: #737373;
		}
		body
		{
			background-image: url("cos1.jpg");
			margin: 0;
			padding: 0;
		}
		.przyciskgorny
		{
			text-align: center;
			border-style: solid;
			border-color: #d4d2d3;
			border-bottom: none;
			border-top: none;
			float: right;
			width: 10%;
			background-color: #b5b5b5;
			height: 15vh;
			font-size: 150%;
			font-family: 'Lato', black;
		}
		#aidsdi
		{
			text-align: center;
			opacity: 0.9;
			background-image: url('images.png');
			width: 15vh;
			height: 15vh;
			background-size: 15vh 15vh;
			background-repeat: no-repeat;
		}
		#aidsdi:hover
		{
				background-image: url('imagehover.png');
		}
		#aidsdi:hover li
		{
			display: block;
		}
		li
		{
			display: none;
			border: white 1px dashed;
			background-color: #c2c0c0;
			font-size: 3vh;
			list-style-type: none;
			clear: both;
			float: top;
			width: 100%;
			height: 7.4vh;
		}
		li a
		{
			color: #ffffff;
			text-decoration: none;
			display: block;
		}
	</style>
</head>

<body>
	<div id="gornypasek">
		<div id="aidsdi" class="przyciskgorny">
				<li><a href="logout.php">Wyloguj</a></li>
				<li><a href="#">Zmień Hasło</a></li>
		</div>
	</div>
</body>

</html>