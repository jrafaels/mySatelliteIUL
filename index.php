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
  <table id="tabela" class="tableLista">
    <tr id= tituloLista>
      <th>Lista de Categorias:</th>
    </tr>
    <?php
		$aux = new Satellite();
		$list = $aux->get_catList();
	
		echo $list;
	?>
  
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
