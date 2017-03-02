<?php

	include 'dbinfo.php';
	include 'functions.php';
	
	sec_session_start(); //Nuestra manera personalizada segura de iniciar sesión php.
	 
	if(isset($_POST['email'], $_POST['p'])) 
	{
	   $email = $_POST['email'];
	   
	   $password = $_POST['p']; //La contraseña con hash
	   
	   if(login($email, $password, $mysqli) == true) 
	   {
			//Inicio de sesión exitosa
			echo 'Éxito: ¡Has iniciado sesión!';
	   } 
	   else 
	   {
			//Inicio de sesión fallida
			header('Location: ./login.php?error=1');
	   }
	} 
	else 
	{
	   //Las variaciones publicadas correctas no se enviaron a esta página
	
		echo 'Solicitud no válida';
	}

?>