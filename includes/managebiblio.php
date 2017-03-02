<?php

	require("../includes/dbinfo.php");
	require("../includes/functions.php");

	//**************
	
	$sBarrio = '';
	$sTelefono = '';
	$sEmail = '';
	$sDirector = '';
	
	$sNombreBiblioteca = $_POST['nombrebiblioteca'];
	
	$sDireccion = $_POST['direccion'];
	
	$nLat = $_POST['lat'];
	
	$nLng = $_POST['lng'];
	
	if(isset($_GET['barrio']))
		$sBarrio.= $_GET['barrio'];
		
	if(isset($_GET['telefono']))
		$sTelefono.= $_GET['telefono'];
		
	if(isset($_GET['e-mail']))
		$sEmail.= $_GET['e-mail'];

	if(isset($_GET['director']))
		$sDirector.= $_GET['director'];
		
	//********************************************************************
	
	$sConsultaExistencia = "SELECT idbiblioteca
							FROM bibliotecas
							WHERE nombrebiblioteca = '".$sNombreBiblioteca."'";
							
	//****************************
		
	$stmtExistencia = $mysqli_conn->prepare($sConsultaExistencia);

	$stmtExistencia->execute();

	$meta = $stmtExistencia->result_metadata();

	while ($field = $meta->fetch_field()) 
	{
		$parameters[] = &$row[$field->name];
	}

	call_user_func_array(array($stmtExistencia, 'bind_result'), $parameters);

	while ($stmtExistencia->fetch()) 
	{
		foreach($row as $key => $val) 
		{
			$x[$key] = $val;
		}

		$results[] = $x;
	}
	
	//**********
	
	$nTotalRegistros = count($results);
	
	if($nTotalRegistros == 0)
	{
		$sSqlInsert = "INSERT INTO bibliotecas
						(telefono,
						e-mail,
						directorbiblio,
						nombrebiblioteca,
						direccion,
						barrio,
						lat,
						lng)
						VALUES(
							$sTelefono,
							$sEmail,
							$sDirector,
							$sNombre,
							$sDireccion,
							$sBarrio,
							$nLat,
							$nLng)";
							
		//****************************
		
		try
		{
			$stmtInsert = $mysqli_conn->prepare($sSqlInsert);

			$stmtInsert->execute();
			
			$sMensaje = 'Biblioteca insertada con exito';
		
			$bInsert = true;
		}
		catch(Exception $e)
		{
			$sMensaje = 'Se produjo un error al querer insertar la biblioteca';
		
			$bInsert = false;
		}
		
	}
	else
	{
		$sMensaje = 'Ya existe una biblioteca con ese nombre en el sistema';
		
		$bInsert = false;
	}
	
	//*****************************************
	
	echo json_encode(array('identifier'=>'sRespuesta','numRows'=>$bInsert,'items'=>array('sRespuesta' => $sMensaje)));

	exit();

?>