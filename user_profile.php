
<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<meta charset="utf-8">
</head>

<body>
<?php
	include('cabecalho.php');
	include('menu.php');
?>
<div class="profile_main">
  <div class="profile_info">
  <?php	
	$aux = new User();
	
	$user = $aux->getUser($_SESSION['username']);	
	?>
    <h2>Meu Perfil:</h2>
    
    <table class="profile_table">
      <tr>
        <td>Nome:</td>
        <td><?php echo $user[2] ?></td>
      </tr>
      <tr>
        <td>username:</td>
        <td><?php echo $user[1] ?></td>
      </tr>
      <tr>
        <td>E-mail:</td>
        <td><?php echo $user[3] ?></td>
      </tr>
    </table>
  </div>

  <div class="profile_pic">
    <img src="img/jorginho.jpg"/>
  </div>

  <div class="favoritos">
    <table class="favoritos_table">
      <tr>
        <td>Nome do satélite 1</td>
        <td><button>Remover dos Favoritos</button></td>
      </tr>
      <tr>
        <td>Nome do satélite 2</td>
        <td><button>Remover dos Favoritos</button></td>
      </tr>
      <tr>
        <td>Nome do satélite 3</td>
        <td><button>Remover dos Favoritos</button></td>
      </tr>
    </table> 
  </div>
</div>

</body>
</html>
