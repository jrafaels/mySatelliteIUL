
<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta charset="utf-8">
</head>

<body>
<?php
  
  include('header.php');
?>
<div class="profile_main">
  <div class="info_panel">
    <div class="info_header">
       Meu Perfil             
    </div>
    <div class="info_body">
      <?php	
    	$aux = new User();
    	
    	$user = $aux->getUser($_SESSION['username']);	
    	?>
        <div class="info_table">
          <table class="profile_table">
            <tr>
              <td>Nome:</td>
              <td><?php echo $user[2] ?></td>
            </tr>
            <tr>
              <td>username:</td>
              <td><?php echo $user[1] ?></td>
            </tr>
            <tr>
              <td>E-mail:</td>
              <td><?php echo $user[3] ?></td>
            </tr>
          </table>
        </div>
        <div class="profile_pic">
          <img src="img/man.png"/>
        </div>

    </div>
  </div>

  <div class="fav_panel">
    <div class="fav_header">
       Satélites Favoritos                 
    </div>

      <div class="favoritos">
  
        <table class="favoritos_table">
            <?php
            $list = $aux->getSatFav($_SESSION['username']);
            
            foreach($list as $sat_id){
              $sat = new Satellite();
              $sat->find_info($sat_id['sat_id']);
              echo "<tr>
                <td>". $sat->getName() ."</td>
                <td><button onclick=\"window.location.href='perfil_satelite.php?satId=". $sat->getNorad() ."'\">Ver satélite</button></td>
              </tr>"; 
            }
          ?>
        </table> 
      </div>

  </div>

  </div>

</body>
</html>
