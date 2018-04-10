<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> mySatellite-IUL | Registo</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
	</head>

	<body>
	<?php
			//session_start();
			//$error=$_GET['q'];
			$error="a";
			if($error == "login"){
				echo '<div class="alert alert-danger">
					  	<strong>Alert!</strong> Username and/or Password are not correct!
					  	<button type="button" class="close" onclick="location.href=\'index.php\'">&times;</button>
					</div>';
			}
	
		?>
		
		<div class="top1">
			<img class="logo1" src="img/logo.png">
			
			<?php
				if(!isset($_SESSION['username'])){
				
					echo  '<div class="login">
						<h2 class="cover_text"> Formulário de Registo </h2>
						<form role="form" method="post" action=""> 
						    <div class="form-group">
						    	<label for="email">Username:</label>
						     	<input name="myusername" type="text" class="form-control" id="email" placeholder="Introduzir username">
						    </div>
						    <div class="form-group">
						      	<label for="email">E-mail:</label>
						      	<input name="email" type="text" class="form-control" id="pwd" placeholder="Introduzir e-mail">
						    </div>
						    <div class="form-group">
						      	<label for="pwd"> Password:</label>
						      	<input name="mypassword" type="password" class="form-control" id="pwd" placeholder="Introduzir password">
						    </div>
						    
						    <button type="submit" class="btn btn-default">Enter</button>
						</form>
						</div>';
				} else {
					echo "<script>window.location = './main.php'</script>";
					exit();
				}
			?>

			<div class="footer">
				<p id="footer_text">  ISCTE-IUL 2018 | SCDS | Professor: Francisco Cercas | Alunos: Carolina, Gonçalo e Jorge </p>
			</div>
		</div>
	</body>
</html>
