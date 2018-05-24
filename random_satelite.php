<!DOCTYPE html>

<html>
<head>
<title>mySatellite-IUL | Perfil Satélite</title>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<meta charset="utf-8">
</head>

<body>
<?php
  
  include('header.php');
?>
<div class="main">
  <div class="info">
    <?php	
	$sat = new Satellite();
	$user = new User();
	$satAdd="";
	$satRem="";
	$satId=25861;
	if(isset($_GET['satId'])){
		$satId = $_GET['satId'];
	}else if(isset($_GET['addSat'])){
		$satId = $_GET['addSat'];
		$satAdd = $satId;	
	}else if(isset($_GET['remSat'])){
		$satId = $_GET['remSat'];
		$satRem = $satId;	
	}
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
    </table>
  </div>
  <div class="mainTLE">
    <div class="dataTLE">
      <table class=tableTLE1>
        <!-- TLE -->
        <tr>
          <td><b>TLE</b></td>
          <td><?php echo $sat->get_tle($satId) ?></td>
        </tr>
      </table>
    </div>
    <div class="TLE">
      <table class=tableTLE2>
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
    <?php
		if(!empty($satAdd)){
		try{
					
			$user->addSatFav($_SESSION['username'], $satAdd);
			//$msg = "Tem um novo satélite favorito!! É o ". $sat->getName() ."! \n Parabéns!!";
			//$user->sendEmail($_SESSION['username'], "Novo Satélite Favorito", $msg);
			
		}catch(Exception $e){
			echo "Erro nos satélites favoritos " . $e->GetMessage();	
			//alerts::getRedCallout("Erro ao adicionar", "Erro desconhecido.");
		}
		}
		if(!empty($satRem)){
		try{
					
			$user->remSatFav($_SESSION['username'], $satRem);
			//$msg = "Removeu um satélite favorito!! O satélite ". $sat->getName() ." já não é mais seu amigo \n :( :( :(";
			//$user->sendEmail($_SESSION['username'], "Perdeu um satélite amigo", $msg);
			
		}catch(Exception $e){
			echo "Erro nos satélites favoritos " . $e->GetMessage();	
			//alerts::getRedCallout("Erro ao remover", "Erro desconhecido.");
		}
	}
	
		?>
    <div class="coordenadas">
      <table class=tableCoordenadas>
        <!--<tr>
          <td>Próxima passagem:</td>
          <td></td>
        </tr>
        <tr>
          <td> Tempo restante:</td>
          <td>NADAAAA</td>
        </tr>
        <tr>
          <td> Longitude:</td>
          <td>RAFA PREENCHE</td>
        </tr>-->
        <tr>
          <td>Coordenadas do ISCTE</td>
          <td></td>
        </tr>
        <tr>
          <td> Latitude:</td>
          <td>38.71667</td>
        </tr>
        <tr>
          <td> Longitude:</td>
          <td>-9.13333</td>
        </tr>
      </table>

      <div class="button_div">
        <form action="">
        <?php 
          if($user->haveThisSatFav($_SESSION['username'], $satId)){
          echo "<button type=\"submit\" value=\"". $satId ."\" name=\"remSat\" class=\"button\"> Remover dos Favoritos</button>";  
          }else{
          echo "<button type=\"submit\" value=\"". $satId ."\" name=\"addSat\" classe class=\"button\"> Adicionar aos Favoritos</button>";  
        }
        ?>
        </form>
     </div>

    </div>
      
  </div>
  <div class="media">
    <div class="image"> <img src="img/satelite2.jpg"/> </div>
    <div class="rota">
      <?php
        echo '<iframe width="540" height="320" src="https://www.n2yo.com/leaflet.php?s='.$satId.'&amp;size=large&amp;all=1&amp;me=10" scrolling="no" style="border: none; overflow: hidden; display: block"></iframe>';

	    ?>
    </div>
  </div>
<!--<<<<<<< HEAD
  
=======

>>>>>>> 1303966431aa1114370c1c3da5d45d156165f55d-->
</div>
<script>
$(window).load(function() {
	alert(id);
				id = <?php $sat->randomSatellite() ?>;
               window.setTimeout(window.location.href = "http://localhost/satellite/random_satelite.php?satId="+id,1000);
            });
</script>
</body>
</html>
