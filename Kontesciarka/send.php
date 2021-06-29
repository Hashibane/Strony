<?php
	session_start();
	if (isset($_POST['Send']))
	{
		$file = $_FILES['file'];
		$filename = $file['name'];
		$filetmpname = $file['tmp_name'];
		$filesize = $file['size'];
		$fileError = $file['error'];
		$filetype = $file['type'];
		
		$fileExt = explode('.', $filename);
		$fileExtension = strtolower(end($fileExt));
		
		$allowed = array('docx', 'jpg', 'jpeg', 'png', 'pdf', 'txt');
		
		if (in_array($fileExtension, $allowed))
		{
			if ($fileError===0)
			{
				if ($filesize > 5000000)
				{
					$_SESSION['error']="Twój plik jest za duży";
					header("Location: Upload.php");
				}
				else
				{
					$fileDestination = 'Zadania/'.$filename;
					move_uploaded_file($filetmpname, $fileDestination);
					header("Location: Zadania.php");
				}
			}
			else
			{
				$_SESSION['error']="Wystąpił błąd przy presyłaniu pliku";
				header("Location: Upload.php");
			}
		}
		else
		{
			$_SESSION['error']='Nieprawidłowe rozszerzenie pliku';
			header("Location: Upload.php");
		}
	}

?>