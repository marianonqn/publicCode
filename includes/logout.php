<?php

	include 'functions.php';
	
	sec_session_start();
	
	//Desconfigura todos los valores de sesión
	
	$_SESSION = array();
	
	//Obtén parámetros de sesión
	
	$params = session_get_cookie_params();
	
	//Borra la cookie actual
	
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	
	//Destruye sesión
	
	session_destroy();
	
	header('Location: ./');

?>