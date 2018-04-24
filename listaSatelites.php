<!DOCTYPE html>

<html>
<head>
<title>mySatellite-IUL</title>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<meta charset="utf-8">
</head>

<body>
<?php
	include('cabecalho.php');
	include('menu.php');
?>
<div class="main">
  <table class="tableLista">
    <tr id= tituloLista>
      <td>Lista de Satelites:</td>
    </tr>
    <?php
		$aux = new Satellite();
		$list = $aux->get_satList(20);
	
		echo $list;
	?>
    <tr>
      <td>OI</td>
    </tr>
    <tr>
      <td>OI outra vez</td>
    </tr>
  </table>
</div>
</body>
</html>
