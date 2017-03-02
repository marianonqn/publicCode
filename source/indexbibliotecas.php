<?php
	
	require("../includes/dbinfo.php");
	require("../includes/functions.php");

	//**************
	
	if(isset($_GET['sort']))
	{
		$sSort = $_GET['sort'];
	}
	else
	{
		$sSort = '';
	}
	
	//**********
	
	if(isset($_GET['sWhere']))
	{
		$sWhere = $_GET['sWhere'];
	}
	else
	{
		$sWhere = '';
	}
	
	//**********
	
	if(isset($_GET['start']))
	{
		$nStart = $_GET['start'];
	}
	else
	{
		$nStart = 0;
	}
	
	//**********
	
	if(isset($_GET['count']))
	{
		$nCount = $_GET['count'];
	}
	else
	{
		$nCount = 0;
	}
	
	//************	
	
	$results = array();
	
	//*****************************************
	
	if($sSort == '')
	{
		$sSort = 'idbiblioteca';
	}

	if(strchr($sSort,'-'))
	{
		$sSort = substr($sSort, 1, strlen($sSort));
		$sOrder = 'Desc';
	}
	else
	{
		$sOrder = 'Asc';
	}
	try
	{
		$sConsulta = "SELECT bibliotecas.idbiblioteca, 
							bibliotecas.telefono,
							bibliotecas.`e-mail`,
							bibliotecas.nombrebiblioteca,
							bibliotecas.direccion,
							bibliotecas.barrio
						FROM bibliotecas";
		
		if ($sWhere !='')
		{
			$sConsulta .= ' WHERE '.$sWhere; 
		}
		
		$sConsulta .= ' ORDER BY '. $sSort.' '.$sOrder;			
		
		//****************************
		
		$stmt = $mysqli_conn->prepare($sConsulta);

		$stmt->execute();

		$meta = $stmt->result_metadata();

		while ($field = $meta->fetch_field()) 
		{
			$parameters[] = &$row[$field->name];
		}

		call_user_func_array(array($stmt, 'bind_result'), $parameters);

		while ($stmt->fetch()) 
		{
			foreach($row as $key => $val) 
			{
				$x[$key] = $val;
			}
  
			$results[] = $x;
		}
		
		//**********
		
		$nTotalRegistros = count($results);

	}
	catch (Exception $e)
	{
		$nTotalRegistros = 0;
	}
	
	//*****************************************
	
	$aDatosTransformados = convertToUtf($results);

	for($i=$nStart;$i<=$nCount+$nStart && $i<$nTotalRegistros;$i++)
	{
		$oPaginator[]=$aDatosTransformados[$i];
	}

	echo json_encode(array('identifier'=>'idbiblioteca','numRows'=>$nTotalRegistros,'items'=>$oPaginator));

	exit();
?>