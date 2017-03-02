<?php

	include 'functions.php';
	
	sec_session_start();
	
	//Desconfigura todos los valores de sesi�n
	
	$_SESSION = array();
	
	//Obt�n par�metros de sesi�n
	
	$params = session_get_cookie_params();
	
	//Borra la cookie actual
	
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	
	//Destruye sesi�n
	
	session_destroy();
	
	header('Location: ./');

?>