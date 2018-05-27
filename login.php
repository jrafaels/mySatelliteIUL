<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> mySatellite-IUL | Login </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/logincss.css" type="text/css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	</head>

	<body>
		
		<div class="top">
			<center>
				<img class="logo" src="img/logo.png">
			</center>
				<div class="login">
						<h2 class="cover_text"> Bem Vindo </h2>
						<?php
		require("database/classes.php");

		if(isset($_POST["enviar"])){
		
		try{
			$user = new User();
		
			$username = htmlentities(addslashes($_POST['myusername']));
			$password = htmlentities(addslashes($_POST['mypassword']));	
		
			$user->login($username,$password);
			
		}catch(Exception $e){
			echo "Erro no login " . $e->GetMessage();	
			alerts::getRedCallout("Erro no Login", "Erro desconhecido.");
		}
	}
	
		?>
						<form role="form" method="post" action="">
						    <div class="form-group">
						    	<label for="email">Username:</label>
						     	<input name="myusername" type="text" class="form-control" id="email" placeholder="Introduzir username">
						    </div>
						    <div class="form-group">
						      	<label for="pwd">Password:</label>
						      	<input name="mypassword" type="password" class="form-control" id="pwd" placeholder="Introduzir password">

						    </div>
						   <div style="text-align: center; padding-bottom: 5px;">
						   <button type="submit" name="enviar" class="btn btn-default">Enter</button>
						   <button type="button" onclick="location.href='register.php';" class="btn btn-default"> Registar</button> 
   							</div>
						</form>
						</div>
					
					<!--<script>window.location = './main.php'</script>-->
		</div>
		<?php  include "rodape.php"   ?>
	</body>
</html>
