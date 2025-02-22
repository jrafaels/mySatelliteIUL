<!DOCTYPE html>
<html>
<head>
<title>mySatellite-IUL | Sobre</title>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta charset="utf-8">
</head>
<body>
	<?php
	
  include('header.php');
?>
	<div id="wrapper">
		Este trabalho surgiu no âmbito da unidade curricular de Sistemas de Comunicações Digitais por Satélite e tem como objetivo mostrar dados e órbitas de satélites num Video Wall.
		Para o desenvolvimento deste sistema decidimos fazer um site utilizando, para isso, as linguagens: HTML, PHP, JavaScript e CSS. 
		Inicialmente extraímos informação do site n2yo.com, que por sua vez contem os ficheiros TLE (two elements line) recebidos dos satélites e algumas informações extra. Utilizamos, deste site, os mapas com as órbitas dos vários satélites, as informações extra e ainda os dados Kepler provenientes do TLE, a partir dos quais calculamos outros parâmetros. 
		Apos o tratamento dos dados recolhidos, analisámos os quais consideramos mais pertinentes e disponibilizamos no site.
		<hr>
		<div id="img-wrapper">
			<img src="img/rafa.jpg">
			<img src="img/carol.jpg">
			<img src="img/goncalo.jpg">
		</div>
	</div>
</body>
</html>