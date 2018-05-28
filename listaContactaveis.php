<!DOCTYPE html>

<html>
<head>
<title>mySatellite-IUL</title>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta charset="utf-8">
</head>

<body>
<?php
  
  include('header.php');
?>
<div class="mainLista">
  <table class="tableLista">
    <tr id= tituloLista>
     <th>NORAD ID</th>
     <th>Nome</th>
    </tr>
 <?php
 	$sat = new Satellite();
	$list = $sat->get_allSatsVisible();
	
	foreach($list as $s){
		$sat->newSat($s[0], $s[1]);
		echo "<tr><td>". $s[0] ."</td>";
		echo "<td id=\"". $s[0] ."\" onclick=\"satPage(this)\">". $s[1] ."</td></tr>";
	}
 ?>
  </table>
</div>
<script>
var satPage = function(td) {
    //I want the ID of this td that I've captured by "this"
    var tdId = td.id; //<--- This doesn't works
    location.href="perfil_satelite.php?satId="+tdId;
}
</script>
</body>
</html>