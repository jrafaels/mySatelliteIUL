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
<div class="main">
  <div class="info">
    <h2>Informação do Satélite:</h2>
    <!--<?php

	require('database/classes.php');
	
	$aux = new Satellite();
	
	$list = $aux->get_info(39574);
	?>-->
    <table class="table1">
      <tr>
        <td>Nome do Satélite:</td>
        <td>PUTAAAAAAAAAAAA</td>
      </tr>
      <tr>
        <td>NORAD ID:</td>
        <td><?php echo $list[0] ?></td>
      </tr>
        <td>Int'l Code:</td>
        <td><?php echo $list[1] ?></td>
      </tr><tr>
        <td>Origem:</td>
        <td><?php echo $list[9] ?></td>
      </tr>
      <tr>
        <td>Data de Lançamento:</td>
        <td><?php echo $list[8] ?></td>
      </tr>
      <tr>
        <td>Período:</td>
        <td><?php echo $list[5] ?></td>
      </tr>
      <tr>
        <td>Perigeu (altura):</td>
        <td><?php echo $list[2] ?></td>
      </tr>
      <tr>
        <td>Apogeu (altura):</td>
        <td><?php echo $list[3] ?></td>
      </tr>
      <tr>
        <td>Semi-Eixo (a):</td>
        <td><?php echo $list[6] ?></td>
      </tr>
      <tr>
        <td>Inclinação:</td>
        <td><?php echo $list[4] ?></td>
      </tr>
      <!-- TLE -->
      <tr>
        <td>Raio do Perigeu (rp):</td>
        <td>Tudo Puta</td>
      </tr>
      <tr>
        <td>Raio do Apogeu (ra):</td>
        <td>Tudo Puta</td>
      </tr>
      <tr>
        <td>Excentricidade (e):</td>
        <td>Tudo Puta</td>
      </tr>
      <tr>
        <td>Semi-Eixo Menor(b):</td>
        <td>Tudo Puta</td>
      </tr>
      <tr>
        <td>Azimute (az):</td>
        <td>Tudo Puta</td>
      </tr>
      <tr>
        <td>Elevação:</td>
        <td>Tudo Puta</td>
      </tr>
    </table>
  </div>
    <div class="image">
      <img src="img/satelite2.jpg"/>
    </div>
    <div class="rota">
      <img src="img/satelite2.jpg">
    </div>
</div>

</body>
</html>
