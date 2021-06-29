<?php

	session_start();
	require_once "connecting.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection -> connect_errno)
	{
		echo "ERROR ".$connection -> connect_errno." Description: ".$connection -> connect_error;
	}
	else
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$username = htmlentities($username, ENT_QUOTES, "UTF-8");
		$userRecord = "SELECT * FROM uzytkownicy WHERE Username='$username' AND Password='$password'";
		if ($result = @$connection->query(sprintf("SELECT * FROM uzytkownicy WHERE Username='%s'", mysqli_real_escape_string($connection, $username))))
		{
			if ($result -> num_rows)
			{
				$record = $result->fetch_assoc();
				if (password_verify($password, $record['Password']))
				{
					$_SESSION['user'] = $record['Username'];
					$_SESSION['logged'] = true;
					$_SESSION['id'] = $record['ID'];
					unset($_SESSION['error']);
					$result->free_result();
					header('Location: main.php');
				}
				else
				{
					$_SESSION['error'] = 'Incorrect Username or Password';
					header('Location: logowanie.php');
				}
			}
			else
			{
				$_SESSION['error'] = 'Incorrect Username or Password';
				header('Location: logowanie.php');
			}
		}
		
		$connection->close();
	}
?>