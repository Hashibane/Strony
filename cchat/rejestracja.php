<?php

	session_start();
	if (isset($_POST['nik']))
	{
		$all_ok = true;
		$nick=$_POST['nik'];
		//sprawdzenie długości loginu
		if ((strlen($nick)<3)||(strlen($nick)>20))
		{
			$all_ok=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków";
		}
		if (ctype_alnum($nick)==false)
		{
			$all_ok=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		if ($haslo1!=$haslo2)
		{
			$all_ok=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne";
		}
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
	
		//print_r($_POST);
		$url = "https://www.google.com/recaptcha/api/siteverify";
		$data = [
			'secret' => "6LeSLrUUAAAAAF6GMql2BsVJUNtDnRH5OMbVhoU2",
			'response' => $_POST['token'],
			// 'remoteip' => $_SERVER['REMOTE_ADDR']
		];
		$options = array(
		    'http' => array(
		      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		      'method'  => 'POST',
		      'content' => http_build_query($data)
		    )
		  );
		$context  = stream_context_create($options);
  		$response = file_get_contents($url, false, $context);
		$res = json_decode($response, true);
		if($res['success'] == true) {
			// Perform your logic here for ex:- save you data to database
		} else {
			$all_ok=false;
			$_SESSION['e_bot']="Botem jesteś :O";
		}
	
	
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat1 = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");
				
				if (!$rezultat1) throw new Exception($polaczenie->error);
					$ile_takich_loginow = $rezultat1->num_rows;
				if ($ile_takich_loginow>0)
				{
					$all_ok=false;
					$_SESSION['e_login']="Podany login już istnieje";
				}
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">"Błąd serwera! Proszę o rejestracje w innym terminie</span>';
		}
		
		if ($all_ok==true)
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick','$haslo_hash', 0, 0, 0, 0, 0)"))
			{
				header('Location: index.php');
			}
			else
			{
				throw new Exception($polaczenie->error);
			}
			$polaczenie->close();
			exit();
		}
	}
?>
<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<title>ClassChat.pl - Rejestracja</title>
	<meta name="description" content="Czat klasowy dla wybranych ludzi :)"/>
	<meta name="keywords" content="II LO, mat-fiz, II LO mat-fiz, wałbrzychbrzych"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css"/>	
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<script src="https://www.google.com/recaptcha/api.js?render=6LeSLrUUAAAAAK2zT_6XuZKQ6ULm1lBClfl4NPEf"></script>
	<style>
		.error
		{
			color: red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		body 
		{
		   padding: 0;
		   margin: 0;
		}
		#container
		{
			background-image: url('fast.jpg');
		}
		#loggin
		{
			position: relative;
			top: 40%;
			background-color: #e6eeff;
			width: 40%;
			height: 40vh;
			margin-left: auto;
			margin-right:  auto;
			padding: 5px;
			border-style: ridge;
			border-width: 10px;
			border-color: #004080;
			opacity: 0.7;
		}
		#logincon
		{
			top: 5%;
			margin-left: auto;
			margin-right: auto;
			text-align: center;
			font-family: 'Lato', black;
		}
	</style>
</head>

<body>
	<div id="container">
		<div id="loggin">
		<div id="logincon" style="font-size: 1.5vw;">
			<form method="post" id="kek">
				Login: <br /> <input type="text" name="nik" style="height: 1.5vw"> <br />
				<?php
					if (isset($_SESSION['e_nick']))
					{
						echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
						unset($_SESSION['e_nick']);
					}
				?>
				Hasło:  <br /> <input type="password" name="haslo1" style="height: 1.5vw"> <br />
				<?php
					if (isset($_SESSION['e_haslo']))
					{
						echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
						unset($_SESSION['e_haslo']);
					}
				?>
				Powtorz hasło: <br /> <input type="password" name="haslo2" style="height: 1.5vw"> <br />
				<script>
					grecaptcha.ready(function() {
						grecaptcha.execute('6LeSLrUUAAAAAK2zT_6XuZKQ6ULm1lBClfl4NPEf', {action: 'homepage'}).then(function(token) {
							console.log(token);
							document.getElementById("token").value = token;
						});
					});
				</script>
				<?php
					if (isset($_SESSION['e_bot']))
					{
						echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
						unset($_SESSION['e_bot']);
					}
					if (isset($_SESSION['e_login']))
					{
						echo '<div class="error">'.$_SESSION['e_login'].'</div>';
						unset($_SESSION['e_login']);
					}
				?>
				<br />
				<input type="submit" value="Zarejestruj się" name="post" style="height:5vh; width:11vw; font-size: 1.5vw;"/>
				<input type="hidden" id="token" name="token">
			</form>
			</div>
		</div>
	</div>
</body>

</html>