<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> mySatellite-IUL | Registo </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
	</head>

	<body>
	<?php
		require("database/classes.php");

		if(isset($_POST["enviar"])){
		
		try{
			$user = new User();
		
			$username = htmlentities(addslashes($_POST['myusername']));
			$email = htmlentities(addslashes($_POST['myemail']));
			$password = htmlentities(addslashes($_POST['mypassword']));	
		
			$user->login($username,$password);
			
		}catch(Exception $e){
			echo "Erro no login " . $e->GetMessage();	
			echo '<div class="alert alert-danger">
					  	<strong>Alert!</strong> Username and/or Password are not correct!
					  	<button type="button" class="close" onclick="location.href=\'index.php\'">&times;</button>
					</div>';
		}
	}
	
		?>
		
		<div class="top">

			<img class="logo1" src="img/logo.png">
			<div class="register">
						<h2 class="cover_text"> Bem Vindo </h2>
						<form role="form" method="post" action="">
						    <div class="form-group">
						    	<label for="email">Username:</label>
						     	<input name="myusername" type="text" class="form-control" id="email" placeholder="Introduzir username">
						    </div>
						    <div class="form-group">
						      	<label for="pwd">E-mail:</label>
						      	<input name="myemail" type="text" class="form-control" id="email" placeholder="Introduzir E-mail">
						    </div>
						    <div class="form-group">
						      	<label for="pwd">Password:</label>
						      	<input name="mypassword" type="password" class="form-control" id="pwd" placeholder="Introduzir password">
						    </div>
						    <button type="submit" name="enviar" class="btn btn-default">Enter</button>
						    
						</form>
						</div>
					
					<!--<script>window.location = './main.php'</script>-->
		</div>
		<?php  include "rodape.html"   ?>
	</body>
</html>
