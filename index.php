<?php 
	session_start();
	
	if(!isset($_SESSION['username'])){
		header("location:login.php");
	}
	require("database/classes.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
    <meta charset="utf-8">
<title>mySatellite-IUL | Index</title>
</head>

<body>
<?php
	include('cabecalho.php');
	include('menu.php');
?>

<h1>ALOOOOOOOOOOOOOOOOOOOOOOOO</h1>
<?php
	$n=40889;
        echo '<iframe width="1110" height="510" src="https://www.n2yo.com/leaflet.php?s='.$n.'&amp;size=large&amp;all=1&amp;me=10" scrolling="no" style="border: none; overflow: hidden; display: block"></iframe>';

	?>

</body>
</html>