<?php 
	session_start();
	
	if(!isset($_SESSION['username'])){
		header("location:login.php");
	}
	require("database/classes.php");
?>
 <div class="cabecalho">
      <a href=""><img id="user" src="img/man.png"></a>
     </div>