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
			//echo "Erro nos satélites favoritos " . $e->GetMessage();	
			//alerts::getRedCallout("Erro ao adicionar", "Erro desconhecido.");
		}
		}
		if(!empty($satRem)){
		try{
					
			$user->remSatFav($_SESSION['username'], $satRem);
			//$msg = "Removeu um satélite favorito!! O satélite ". $sat->getName() ." já não é mais seu amigo \n :( :( :(";
			//$user->sendEmail($_SESSION['username'], "Perdeu um satélite amigo", $msg);
			
		}catch(Exception $e){
			//echo "Erro nos satélites favoritos " . $e->GetMessage();	
			//alerts::getRedCallout("Erro ao remover", "Erro desconhecido.");
		}
	}
	
		?>
    <div class="coordenadas">
      <table class=tableCoordenadas>
        <tr>
          <td><b>Coordenadas do Satélite</b> </td>
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
          <td><b>Coordenadas do ISCTE</b></td>
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
      <div class="buttons_panel">
        <div class="button_div1">
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
        <div class="button_div2">
            <button class="button" onclick="document.getElementById('id01').style.display='block'"> Próximas Passagens</button>  
            <div id="id01" class="modal">
  
                <form class="modal-content animate" action="/action_page.php">
                  <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                  </div>

                  <div class="container">
                    <a><b>Próximas Passagens do Satélite <?php echo $sat->getName() ?></b></a>
                    <table class=tableInfoTempo>
                      <thead>
                        <tr>
                            <th colspan="2">Start</th>
                              <th colspan="3">Max Altitude</th>
                              <th colspan="2">End</th>
                          </tr>
                          <tr>
                            <th>Data, Horas</th>
                              <th>Az</th>
                              <th>Horas</th>
                              <th>Az</th>
                              <th>El</th>
                              <th>Horas</th>
                              <th>Az</th>
                          </tr>
                      </thead>
                        <?php
						
						set_error_handler('exceptions_error_handler');

						function exceptions_error_handler($severity, $message, $filename, $lineno) {
						  if (error_reporting() == 0) {
							return;
						  }
						  if (error_reporting() & $severity) {
							throw new ErrorException($message, 0, $severity, $filename, $lineno);
						  }
						}
						try{
                          $lista=$sat->get_satelliteTime($satId);
                          date_default_timezone_set('Europe/London');
                          foreach($lista as $s){
                            echo "<tr>
                              <td>". date("d M H\hi", $s[2]) ."</td>
                                <td>". $s[0] ."º ". $s[1] ."</td>
                                <td>". date("H\hi", $s[6]) ."</td>
                                <td>". $s[3] ."º ". $s[4] ."</td>
                                <td>". $s[5] ."º</td>
                                <td>". date("H\hi", $s[9]) ."</td>
                                <td>". $s[7] ."º ". $s[8] ."</td>
                            </tr>"; 
                          }
						}catch(Exception $e){
							echo "<br>Sem informação disponível.";	
						}
                        ?>      
                    </table>
                  </div>
                </form>
            </div>
        </div>

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
    
</body>
</html>
