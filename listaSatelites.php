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
      <th>Lista de Satelites:</th>
    </tr>
    <?php
		$aux = new Satellite();
		$catId = $_GET['catId'];
		$list = $aux->get_satList($catId);
	
		echo $list;
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
