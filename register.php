<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>mySatellite-IUL | Registo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
</head>

<body>
<?php		
		if(isset($_POST["enviar"])){
			require("database/classes.php");
			
			try{
				$user = new User();
		
				$username = htmlentities(addslashes($_POST['myusername']));
				$password = htmlentities(addslashes($_POST['mypassword']));	
				$email = htmlentities(addslashes($_POST['email']));
		
				if($user->haveThisEmail($email) || $user->haveThisUser($username)){
					echo '<div class="alert alert-danger">
					  	<strong>Alert!</strong> Username ou Email já se encontram registados.
					  	<button type="button" class="close" onclick="location.href=\'index.php\'">&times;</button>
					</div>';	
				}else{
					$user->newUser($username, $email, $password);
				}
			
			}catch(Exception $e){
				echo "Erro no registo " . $e->GetMessage();
				echo '<div class="alert alert-danger">
					  	<strong>Alert!</strong> Problema com o registo.
					  	<button type="button" class="close" onclick="location.href=\'index.php\'">&times;</button>
					</div>';	
			}
		
	}
	
		?>
<<<<<<< HEAD
		
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
=======
<div class="top1"> <img class="logo1" src="img/logo.png">
  <div class="login">
    <h2 class="cover_text"> REGISTARRR </h2>
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
      <button type="submit" name="enviar" class="btn btn-default">Enter</button>
    </form>
  </div>
  
  <!--<script>window.location = './main.php'</script>-->
  
  <div class="footer">
    <p id="footer_text"> ISCTE-IUL 2018 | SCDS | Professor: Francisco Cercas | Alunos: Carolina, Gonçalo e Jorge </p>
  </div>
</div>
</body>
>>>>>>> a38b4c45e742f96c6e6947e4af9745cc9eec1891
</html>
