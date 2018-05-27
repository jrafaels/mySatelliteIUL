<!DOCTYPE html>

<html>
<head>
<title>mySatellite-IUL | Perfil Satélite</title>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">--> 
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
	if(isset($_GET['satId'])){
		$satId = $_GET['satId'];
	}else if(isset($_GET['addSat'])){
		$satId = $_GET['addSat'];
		$satAdd = $satId;	
	}else{
		$satId = $_GET['remSat'];
		$satRem = $satId;	
	}
	$sat->find_info($satId);
	$sat->get_satPosition($satId);
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
          <td><?php echo $sat->getAzimute() ?>º</td>
        </tr>
        <tr>
          <td>Elevação:</td>
          <td><?php echo $sat->getElevation() ?>º</td>
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
			alerts::getRedCallout("Erro ao adicionar", "Erro desconhecido.");
		}
		}
		if(!empty($satRem)){
		try{
					
			$user->remSatFav($_SESSION['username'], $satRem);
			//$msg = "Removeu um satélite favorito!! O satélite ". $sat->getName() ." já não é mais seu amigo \n :( :( :(";
			//$user->sendEmail($_SESSION['username'], "Perdeu um satélite amigo", $msg);
			
		}catch(Exception $e){
			echo "Erro nos satélites favoritos " . $e->GetMessage();	
			alerts::getRedCallout("Erro ao remover", "Erro desconhecido.");
		}
	}
	
		?>
    <div class="coordenadas">
      <table class=tableCoordenadas>
        <tr>
          <td>Coordenadas do Satélite:</td>
          <td></td>
        </tr>
        <tr>
          <td> Latitude:</td>
          <td><?php echo $sat->getLatitude() ?> ºN</td>
        </tr>
        <tr>
          <td> Longitude:</td>
          <td><?php echo $sat->getLongitude() ?> ºE</td>
        </tr>
        <tr>
          <td> Altitude:</td>
          <td><?php echo $sat->getAltitude() ?> km</td>
        </tr>
        <tr>
          <td>Coordenadas do ISCTE</td>
          <td></td>
        </tr>
        <tr>
          <td> Latitude:</td>
          <td><?php echo $sat->getISCTELat() ?> ºN</td>
        </tr>
        <tr>
          <td> Longitude:</td>
          <td><?php echo $sat->getISCTELong() ?> ºE</td>
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
       <div class="button_div">
          <form action="">
          <?php 
            if($user->haveThisSatFav($_SESSION['username'], $satId)){
            echo "<button type=\"submit\" value=\"". $satId ."\" name=\"remSat\" class=\"button\"> cenas1</button>";  
            }else{
            echo "<button type=\"submit\" value=\"". $satId ."\" name=\"addSat\" classe class=\"button\"> cenas2</button>";  
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
    <div class="infoTempo">
      <table class=tableInfoTempo>
        <tr>
          <td>cenas</td>
          <td></td>
        </tr>
        <tr>
          <td> cenas1:</td>
          <td>info</td>
        </tr>
        <tr>
          <td> Longitude:</td>
          <td>info</td>
        </tr>
        
      </table>
</div>
</body>
</html>
