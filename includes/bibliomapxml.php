<?php
	require("dbinfo.php");
	
	function parseToXML($htmlStr) 
	{ 
		$xmlStr=str_replace('<','&lt;',$htmlStr); 
		$xmlStr=str_replace('>','&gt;',$xmlStr); 
		$xmlStr=str_replace('"','&quot;',$xmlStr); 
		$xmlStr=str_replace("'",'&#39;',$xmlStr); 
		$xmlStr=str_replace("&",'&amp;',$xmlStr); 
		return $xmlStr; 
	}

	$stmt = $mysqli_conn->prepare("SELECT * FROM bibliotecas");

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
	
	header("Content-type: text/xml");

	// Start XML file, echo parent node
	
	echo '<markers>';

	// Iterate through the rows, printing XML nodes for each
	
	foreach($results as $row)
	{
	  // ADD TO XML DOCUMENT NODE
	  echo '<marker ';
	  
	  echo 'name="' . parseToXML(utf8_encode ($row['nombrebiblioteca'])) . '" ';
	  
	  echo 'address="' . parseToXML(utf8_encode ($row['direccion'])) . '" ';
	  
	  echo 'email="' . parseToXML(utf8_encode ($row['e-mail'])) . '" ';
	  
	  echo 'telephone="' . parseToXML(utf8_encode ($row['telefono'])) . '" ';
	  
	  echo 'lat="' . $row['lat'] . '" ';
	  
	  echo 'lng="' . $row['lng'] . '" ';
	  
	  echo 'type="biblioteca" ';
	  
	  echo '/>';
	}

	// End XML file
	
	echo '</markers>';

?>