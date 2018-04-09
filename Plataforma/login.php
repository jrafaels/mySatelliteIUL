<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> mySatellite-IUL | Login </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
	</head>

	<body background="">
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
			include 'templates/header.php';
		?>
		
		<div class="top">
			<img class="logo" src="/img/scds.png">
			
			<?php
				if(!isset($_SESSION['username'])){
					echo  '<div class="login">
						<h2 class="cover_text"> Welcome </h2>
						<form role="form" method="post" action="checklogin.php">
						    <div class="form-group">
						    	<label for="email">Username:</label>
						     	<input name="myusername" type="text" class="form-control" id="email" placeholder="Enter username">
						    </div>
						    <div class="form-group">
						      	<label for="pwd">Password:</label>
						      	<input name="mypassword" type="password" class="form-control" id="pwd" placeholder="Enter password">
						    </div>
						    <button type="submit" class="btn btn-default">Submit</button>
						</form>
						</div>';
				} else {
					echo "<script>window.location = './main.php'</script>";
					exit();
				}
			?>

			<div class="footer">
				<p id="footer_text">  ISCTE-IUL 2018. Todos os direitos estão reservados a esta maltinha kkkk: eh Jorginho, Carolina e Gonçalo</p>
				<div class="sponsor">
					<img class="img_footer" src= <!-- meter img -->>
				</div>
			</div>
		</div>
	</body>
</html>
