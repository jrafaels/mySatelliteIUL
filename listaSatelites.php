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
<div class="mainLista">
  <table class="tableLista">
    <tr id= tituloLista>
      <td>Lista de Satelites:</td>
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
