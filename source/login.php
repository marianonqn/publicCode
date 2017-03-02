<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" href="../scripts/dojo/dijit/themes/claro/claro.css">
		
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600|Archivo+Narrow:400,700" rel="stylesheet" type="text/css" />

		<link href="../style/default.css" rel="stylesheet" type="text/css" media="all" />
	
		<script>dojoConfig = {parseOnLoad: true}</script>
	
		<script src='../scripts/dojo/dojo/dojo.js'></script>

		<!--[if IE 6]>

		<link href="default_ie6.css" rel="stylesheet" type="text/css" />

		<![endif]-->
		
		<script>
			require(["dojo/parser", "dijit/form/Form", "dijit/form/Button", "dijit/form/ValidationTextBox", "dijit/form/DateTextBox"]);
		</script>

	</head>

	<body class="claro" style="background-color:white">

		<div align="center" style="magin:auto;">

			<div id="loginFormContent">
				
				<div data-dojo-type="dijit/form/Form" id="formNode" data-dojo-id="formNode" encType="multipart/form-data" action="" method="">
					
					<table style="border: 1px solid #9f9f9f;" cellspacing="10">
        
						<tr>
            
							<td>Usuario</td>
							
							<td><input type="text" id="username" name="username" required="true" data-dojo-type="dijit/form/ValidationTextBox"/></td>
					
						</tr>
						
						<tr>
						
							<td>Password</td>
							
							<td><input type="password" name="password" required="true" data-dojo-type="dijit/form/ValidationTextBox"/></td>
						
						</tr>
							
					</table>
					
					<div align="center">
					
						<button data-dojo-type="dijit/form/Button" type="submit" name="submitButton" value="Login">Login</button>
						
					</div>	
				
				</div>
				
			</div>

			<div id="resultDiv">
					
				
				
			</div>
		<div>	
	
		<script>
			
			require(["dojo/dom", "dojo/on", "dojo/request", "dojo/dom-form"],
				function(dom, on, request, domForm)
				{
					var form = dom.byId('formNode');
					
					// Attach the onsubmit event handler of the form
					
					on(form, "submit", function(evt)
					{

						// prevent the page from navigating after submit
						evt.stopPropagation();
						evt.preventDefault();

						// Post the data to the server
						request.post("../processlogin.php", {
							// Send the username and password
							data: domForm.toObject("formNode"),
							// Wait 2 seconds for a response
							timeout: 2000

						}).then(function(response){
							dom.byId('resultDiv').innerHTML = response;
						});
					});
				}
			);
		</script>
	</body>
</html>
