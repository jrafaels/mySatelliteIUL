<?php
  session_start();
  
  if(!isset($_SESSION['username'])){
    header("location:login.php");
  }
  require("database/classes.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Pacifico" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="./css/headerstyle.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
	 <nav class="navbar">
    <span class="open-slide">
      <a href="#" onclick="openSlideMenu()">
        <svg width="30" height="30">
            <path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
            <path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
            <path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
        </svg>
      </a>
    </span>
    <img id="logo" src="img/logo.png">
    <img id="user" src="img/user-shape.png" onclick="javascript:location='user_profile.php'">
    <div class="notifications">
      <i class="fas fa-bell"></i>
      <span class="num">4</span>
      <ul>
      <?php
	  	$user = new User();
	  	$user_id = $user->getId($_SESSION['username']);
	  	$msg = new Message();
		$list = $msg->getMsgs($user_id);
		
		foreach($list as $m){
			if($m['available']==1){
				echo "<li>
      		    <span class=\"icon\"><i class=\"fas fa-exclamation-circle\"></i></span>
        		<span class=\"text\">". $m['text'] ."</span>
         		</li>";	
			}
		}
	  ?>
        <li>
          <span class="icon"><i class="fas fa-exclamation-circle"></i></span>
          <span class="text">Uma notificação</span>
         </li>
         <li>
          <span class="icon"><i class="fas fa-exclamation-circle"></i></span>
          <span class="text">Outra notificação</span>
         </li>
         <li>
          <span class="icon"><i class="fas fa-exclamation-circle"></i></span>
          <span class="text">Uma notificação</span>
         </li>
         <li>
          <span class="icon"><i class="fas fa-exclamation-circle"></i></span>
          <span class="text">Outra notificação</span>
         </li>
      </ul>
    </div>
  </nav>

  <div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    
    <a href="index.php">Início</a>
    <a href="random_satelite.php">Modo Automático</a>
    <a href="listaContactaveis.php">Satélites Contactáveis</a>
    <a href="sobre.php">Sobre</a>
    <a href="logout.php">Logout</a>
  </div>

  <script>
    function openSlideMenu(){
      document.getElementById('side-menu').style.width = '20%';
    }

    function closeSlideMenu(){
      document.getElementById('side-menu').style.width = '0';
    }
  </script>

</body>
</html>