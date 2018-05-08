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
  <table id="tabela" class="tableLista">
    <tr id= tituloLista>
      <td>Lista de Categorias:</td>
    </tr>
    <?php
		$aux = new Satellite();
		$list = $aux->get_catList();
	
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
<script>
var satPage = function(td) {
    //I want the ID of this td that I've captured by "this"
    var tdId = td.id; //<--- This doesn't works
    location.href="listaSatelites.php?catId="+tdId;
}
</script>
</body>
</html>
