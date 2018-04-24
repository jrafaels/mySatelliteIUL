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
    <?php	
	$sat = new Satellite();
	$satId = $_GET['satId'];
	$sat->find_info($satId);
	?>
    <table class="table1">
      <tr>
        <td>Nome do Satélite:</td>
        <td><?php echo $sat->getName() ?></td>
      </tr>
      <tr>
        <td>NORAD ID:</td>
        <td><?php echo $sat->getNorad() ?></td>
      </tr>
        <td>Int'l Code:</td>
        <td><?php echo $sat->getCode() ?></td>
      </tr><tr>
        <td>Origem:</td>
        <td><?php echo $sat->getSource() ?></td>
      </tr>
      <tr>
        <td>Data de Lançamento:</td>
        <td><?php echo $sat->getLaunchDate() ?></td>
      </tr>
      <tr>
        <td>Período:</td>
        <td><?php echo $sat->getPeriod() ?></td>
      </tr>
      <tr>
        <td>Perigeu (altura):</td>
        <td><?php echo $sat->getPerigee() ?></td>
      </tr>
      <tr>
        <td>Apogeu (altura):</td>
        <td><?php echo $sat->getApogee() ?></td>
      </tr>
      <tr>
        <td>Semi-Eixo (a):</td>
        <td><?php echo $sat->getSemiMajor() ?></td>
      </tr>
      <tr>
        <td>Inclinação:</td>
        <td><?php echo $sat->getInclination() ?></td>
      </tr>
      <!-- TLE -->
      <tr>
        <td>Raio do Perigeu (rp):</td>
        <td><?php echo $sat->getPerigeeRadius() ?> km</td>
      </tr>
      <tr>
        <td>Raio do Apogeu (ra):</td>
        <td><?php echo $sat->getApogeeRadius() ?> km</td>
      </tr>
      <tr>
        <td>Excentricidade (e):</td>
        <td><?php echo $sat->getExcentricity() ?></td>
      </tr>
      <tr>
        <td>Semi-Eixo Menor(b):</td>
        <td><?php echo $sat->getSemiMinor() ?></td>
      </tr>
      <tr>
        <td>Azimute (az):</td>
        <td><?php echo $sat->getAzimute() ?></td>
      </tr>
      <tr>
        <td>Elevação:</td>
        <td><?php echo $sat->getElevation() ?></td>
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
