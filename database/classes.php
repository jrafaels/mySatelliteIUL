<?php
	require('config.php');


	/* USER */
	
	class User extends Connection{
	
		public function User(){
			parent::__construct();	
		}
		
		/**
		* Return list of users
		*/
		public function getUsers(){
			$sql = "SELECT username FROM user";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array());
			$alunos = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
			$resultado->closeCursor();
			
			return $alunos;
		}
		
		/**
		* Return number os users
		*/
		public function getNumUsers(){
			$sql = "SELECT username FROM user";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array());
			$num = $resultado->rowCount();	
			
			$resultado->closeCursor();
			
			return $num;
		}		
		
		/**
		* Return true if have this user
		* @param username 
		*/
		public function haveThisUser($username){
			$sql = "SELECT username FROM user WHERE username=:username";
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":username", $username);
		
			$resultado->execute(array(":username"=>$username));
			$alunos = $resultado->fetchAll(PDO::FETCH_ASSOC);
		
			$count = $resultado->rowCount();					
			
			$resultado->closeCursor();
			
			if($count==0)
				return false;
			else
				return true;	
		}	
		
		/**
		* Return true if have this email
		* @param email 
		*/
		public function haveThisEmail($email){
			$sql = "SELECT email FROM user WHERE email=:email";
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":email", $email);
		
			$resultado->execute(array(":email"=>$email));
			$alunos = $resultado->fetchAll(PDO::FETCH_ASSOC);
		
			$count = $resultado->rowCount();					
			
			$resultado->closeCursor();
			
			if($count==0)
				return false;
			else
				return true;	
		}	
		
		/**
		* Create new user
		* @param
		*/
		public function newUser($username, $email, $password){
			
			$sql = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
		
			//Hash Password
			//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":username"=>$username, ":email"=>$email, ":password"=>$password));
		
			$resultado->closeCursor();
			
			echo "Novo usuário criado com sucesso";
		}
		
		/**
		* Return id
		*/
		public function getId($username){
			$sql = "SELECT user_id FROM user WHERE username=:username";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":username", $username);
		
			$resultado->execute(array(":username"=>$username));
			$idlist = $resultado->fetch();
			
			$resultado->closeCursor();
			
			return $idlist[0];
		}
		
		/**
		* Return user
		*/
		public function getUser($username){
			$sql = "SELECT * FROM user WHERE username=:username";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":username", $username);
		
			$resultado->execute(array(":username"=>$username));
			$user = $resultado->fetch();
			
			$resultado->closeCursor();

			return $user;
		}
		
		public function addSatFav($username, $sat_id){
			$sql = "INSERT INTO user_sat (user_id, sat_id) VALUES (:user_id, :sat_id)";
		
			$user_id = $this->getId($username);
			
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":user_id"=>$user_id, ":sat_id"=>$sat_id));
		
			$resultado->closeCursor();
			
			alerts::getGreenCallout("Satélite adiciona com sucesso!", "Parabéns!!! Agora você é satelitônico!");
		}
		
		public function remSatFav($user_id, $sat_id){
			$sql = "DELETE FROM user_sat WHERE user_id=:user_id AND sat_id=:sat_id";
		
			//Hash Password
			//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
			
			$resultado->bindValue(":user_id", $user_id);
			$resultado->bindValue(":sat_id", $sat_id);

		
			$resultado->execute(array(":user_id"=>$user_id, ":sat_id"=>$sat_id));
		
			$resultado->closeCursor();
			
			echo "Satélite favorito removido com sucesso.";
		}
	
		/**
		* Login
		*
		*/
		public function login($username, $password){
			
			$sql = "SELECT * FROM user WHERE username=:username AND password=:password";
			$resultado = $this->connection->prepare($sql);
	
			//Hash Password
			//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
			$resultado->bindValue(":username", $username);
			$resultado->bindValue(":password", $password);
		
			$resultado->execute();
		
			$num_registos = $resultado->rowCount();
		
			if($num_registos!=0){
				session_start();
				$_SESSION["username"]=$username;
				//$this->logLogin($username, 1, $ip);
				header("location:index.php");
			
			}else{
				//$this->logLogin($username, 0, $ip);
				alerts::getRedCallout("Erro no Login", "Username e/ou password estão incorretos.");
			}			
			
		}	

	}
	
	class Satellite extends Connection{
		private $flag;
		private $items = array();
		
		private $earthRadius = 6378;
		
		public function Satellite(){
			parent::__construct();	
		}
		
		/**
		* Read TLE files from website https://www.celestrak.com
		* URL: https://www.celestrak.com/NORAD/elements/$name.txt
		*/
		
		/**
		* Get número de satélites por categoria
		*/
    	function get_satListSize($v)
    	{
        	$items = array();
        	$ch = curl_init("http://www.n2yo.com/satellites/?c=".$v);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        	$cl = curl_exec($ch);
        	$dom = new DOMDocument();
        	@$dom->loadHTML($cl);
        	$table = $dom->getElementById("categoriestab");
        	$rows = $table->getElementsByTagName('tr');
        	return $rows->length;   
    	}
		
		/**
		* Get lista de categorias
		*/
		function get_catList()
		{
			$items = array();
			$ch = curl_init("http://www.n2yo.com/satellites/");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$cl = curl_exec($ch);
			$dom = new DOMDocument();
			@$dom->loadHTML($cl);
			$table = $dom->getElementById("categoriestab");
			$rows = $table->getElementsByTagName('tr');

			for($i=1; $i<50; $i++){
				$cols = $rows->item($i)->getElementsByTagName('td');
				$href = $cols->item(0)->getElementsByTagName('a');
				$items[$i] = array();
				$items[$i][0] = $cols->item(0)->textContent;
				$first = explode( '=' , $href->item(0)->getAttribute( 'href' ) );
				$items[$i][1] = $first[1];
			}
			$options='';
			for($i=1; $i<=sizeof($items); $i++){
				$options.="<tr><td id=\"".$items[$i][1]."\" onclick=\"satPage(this)\">".$items[$i][0].'</td></tr><br>';
			}
			return $options;
		} 
	
		/**
		* Get lista de satélites por categoria
		*/
		function get_satList($v)
		{
			$items = array();
			$ch = curl_init("http://www.n2yo.com/satellites/?c=".$v);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$cl = curl_exec($ch);
			$dom = new DOMDocument();
			@$dom->loadHTML($cl);
			$table = $dom->getElementById("categoriestab");
			$rows = $table->getElementsByTagName('tr');
			for($i=0; $i<$rows->length-1; $i++){
				if($i>0){
				$cols = $rows->item($i)->getElementsByTagName('td');
				$items[$i][0] = $cols->item(0)->textContent;
				$items[$i][1] = $cols->item(1)->textContent;
				}
			}	
			$options='';
			/*while(list($k,$v)=each($items))
			{
				$options.='<tr><td>'.$v.'</td></tr><br>';
			}	*/
			for($i=1; $i<=sizeof($items); $i++){
				$options.="<tr><td id=\"".$items[$i][1]."\" onclick=\"satPage(this)\">".$items[$i][0].'</td></tr><br>';
			}
			return $options;     
		}
				
		/**
		* Get infos de um satélite
		*/
		function find_info($x)
    {
		$id = $x;
        $url = 'http://www.n2yo.com/satellite/?s='.$x;
        $content = file_get_contents($url);
		
		//Nome do satélite
		$first_step = explode( 'NORAD ID' , $content);
        $second_step = explode('Track ' , $first_step[0]);
        $third_step = explode('now' , $second_step[1]);
		$this->items[0] = $third_step[0];
				
		//Ver se tem informação disponível
		//Se tiver o perigeu, tem
        $first_step = explode( 'NORAD ID' , $content);
        $second_step = explode('<br/>' , $first_step[1]);
        $third_step = explode('<a class' , $second_step[2]);
        $fourth_step = explode(": ", $third_step[0]);
        $fith_step = explode("<B>", $fourth_step[0]);
        $sixth_step = explode("</B>", $fith_step[1]);
        $itemss = $sixth_step[0];

        for($i=0; $i<11; $i++){
            if($itemss == 'Perigee'){
                $flag = 's';
                if($i==8){
                    $first_step = explode( 'NORAD ID' , $content );
                    $second_step = explode('<br/>' , $first_step[1] );
                    $third_step = explode('<a class' , $second_step[$i] );
                    $fourth_step = explode(": ", $third_step[0]);
                    $fith_step = explode('<a href', $fourth_step[1]);
                    $sixth_step = explode(">", $fith_step[1]);
                    $this->items[$i+1] = $sixth_step[1];
                }
                else{
                    $first_step = explode( 'NORAD ID' , $content );
                    $second_step = explode('<br/>' , $first_step[1] );
                    $third_step = explode('<a class' , $second_step[$i] );
                    $fourth_step = explode(": ", $third_step[0]);
                    $this->items[$i+1] = $fourth_step[1];
                }

            }
            else {
                $flag = 'n';
                $this->items[$i] = 'Sem Informação Disponível';
            }
        }
	}

	public function getName(){
		return $this->items[0];
	}

	public function getNorad(){
		return $this->items[1];
	}
	
	public function getCode(){
		return $this->items[2];
	}
	
	public function getPerigee(){
		return $this->items[3];
	}
	
	public function getApogee(){
		return $this->items[4];
	}
	
	public function getInclination(){
		return $this->items[5];
	}
	
	public function getPeriod(){
		return $this->items[6];
	}
	
	public function getSemiMajor(){
		return $this->items[7];
	}
	
	public function getLaunchDate(){
		return $this->items[9];
	}
	
	public function getSource(){
		return $this->items[10];
	}
	
	public function getPerigeeRadius(){
		$a = explode(" ",$this->getPerigee());
		$b = floatval(str_replace(',', '', $a[0]));
		return $b+$this->earthRadius;
	}
	
	public function getApogeeRadius(){
		$a = explode(" ",$this->getApogee());
		$b = floatval(str_replace(',', '', $a[0]));
		return $b+$this->earthRadius;
	}
	
	public function getExcentricity(){
		$a = $this->getApogeeRadius()-$this->getPerigeeRadius();
		$b = $this->getApogeeRadius()+$this->getPerigeeRadius();
		return $a/$b;
	}
	
	public function getSemiMinor(){
		$a = explode(" ",$this->getSemiMajor());
		$b = floatval(str_replace(',', '', $a[0]));
		$c = $b * sqrt(1-(pow($this->getExcentricity(),2)));
		return round($c,3);
	}
	
	public function getAzimute(){
		return "Sem informação disponível";
	}
	
	public function getElevation(){
		return "Sem informação disponível";
	}
	
	public function getCoordenates(){
			
	}
	
	public function getLatitude(){
			
	}
	
	public function getLongitude(){
			
	}
	
	public function getAltitude(){
			
	}
	
	function get_tle($x)
    {
        //global $flag;
        //if($flag == 's'){
            $url = 'http://www.n2yo.com/satellite/?s='.$x;
            $content = file_get_contents($url);
            $first = explode( "<pre>" , $content );
            $second = explode( "</pre>" , $first[1]);
            $third = explode("\n" , $second[0]);
            return $third[1]."<br>".$third[2];
        //}
        //else {
        //    return 'Sem Informação Disponível';
        //}
    }
}
	
	class Alerts{
		
		/**
		* @param @title - Title of callout
		* @param @msg - Message of callour
		*/
		public static function getRedCallout($title, $msg){
			echo "<div class=\"alert alert-danger\">
                <h4><strong>". $title ."</strong></h4>

                <p>". $msg ."</p>
              </div>";
		}
		
		public static function getGreenCallout($title, $msg){
			echo "<div class=\"alert alert-success\">
                <h4>". $title ."</h4>

                <p>". $msg ."</p>
              </div>";
		}
	}
	
?>