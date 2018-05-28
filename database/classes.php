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
		public function newUser($username, $name, $email, $password){
			
			$sql = "INSERT INTO user (username, name, email, password) VALUES (:username, :name, :email, :password)";
		
			//Hash Password
			//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":username"=>$username, ":name"=>$name, ":email"=>$email, ":password"=>$password));
		
			$resultado->closeCursor();
			
			//echo "Novo usuário criado com sucesso";
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
			
			//alerts::getGreenCallout("Satélite adiciona com sucesso!", "Parabéns!!! Agora você é satelitônico!");
			$sat = new Satellite();
			$sat->find_info($sat_id);
			$sat->get_satelliteTime($sat_id);
			$text = "O satélite ". $sat->getName() ." está quase a passar!!";
			//$msg = new Message();
			//$msg->newMsg($user_id, $sat_id, $text);
		}
		
		public function remSatFav($username, $sat_id){
			$sql = "DELETE FROM user_sat WHERE user_id=:user_id AND sat_id=:sat_id";
		
			$user_id = $this->getId($username);
		
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
			
			$resultado->bindValue(":user_id", $user_id);
			$resultado->bindValue(":sat_id", $sat_id);

		
			$resultado->execute(array(":user_id"=>$user_id, ":sat_id"=>$sat_id));
		
			$resultado->closeCursor();
			
			//echo "Satélite favorito removido com sucesso.";
			//$msg = new Message();
			//$msg->remMsg($user_id, $sat_id);
		}
		
		public function haveThisSatFav($username, $sat_id){
			$sql = "SELECT * FROM user_sat WHERE user_id=:user_id AND sat_id=:sat_id";
			
			$user_id = $this->getId($username);
			
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
			$resultado->bindValue(":sat_id", $sat_id);
		
			$resultado->execute(array(":user_id"=>$user_id, ":sat_id"=>$sat_id));
			$alunos = $resultado->fetchAll(PDO::FETCH_ASSOC);
		
			$count = $resultado->rowCount();					
			
			$resultado->closeCursor();
			
			if($count==0)
				return false;
			else
				return true;	
		}
		
		public function getSatFav($username){
			$sql = "SELECT sat_id FROM user_sat WHERE user_id=:user_id";
			
			$user_id = $this->getId($username);
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$list = $resultado->fetchAll(PDO::FETCH_ASSOC);
			
			$resultado->closeCursor();

			return $list;
		}
		
		public function sendEmail($username, $subject, $message){
			$user = $this->getUser($username);
			
			$to = $user['email'];
			$headers = 'From: geral@satellite-iul.pt' . "\r\n" .
				'Reply-To: geral@satellite-iul.pt' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $message, $headers);

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
		private $listTime = array();
		
		private $earthRadius = 6378;
		private $key = "W5JT3A-AEEYVQ-AZAHCH-3TIT";
		
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
				$this->newSat($items[$i][1], $items[$i][0]);
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
		
		//Tabela com infos
		$url = 'https://www.n2yo.com/widgets/widget-tracker.php?s='.$x.'&size=small&all=1&me=10&map=2';
        $content = file_get_contents($url);
		$first_step = explode( 'START' , $content);
        //$second_step = explode('Track ' , $first_step[0]);
        //$third_step = explode('now' , $second_step[1]);
		//$this->items[0] = $third_step[0];
	}
	
	public function get_satPosition($norad){
			$url = 'https://www.n2yo.com/rest/v1/satellite/positions/'.$norad.'/'.$this->getISCTELat().'/'.$this->getISCTELong().'/'.$this->getISCTEAlt().'/1/&apiKey=W5JT3A-AEEYVQ-AZAHCH-3TIT';
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$jsonIterator = new RecursiveIteratorIterator(
    			new RecursiveArrayIterator(json_decode($json, TRUE)),
    			RecursiveIteratorIterator::SELF_FIRST);

			
			$i=8;
			foreach ($jsonIterator as $key => $val) {
				if(is_array($val)) {
					//echo "$key:\n";
				} else {
					//echo "$key => $val<br>";
					if($i>10 && $i<16){
						$this->items[$i]=$val;
					}
					$i++;
				}
			}
	}
	
	public function get_allSatsVisible(){
			$url = 'https://www.n2yo.com/rest/v1/satellite/above/'.$this->getISCTELat().'/'.$this->getISCTELong().'/'.$this->getISCTEAlt().'/30/0/&apiKey=W5JT3A-AEEYVQ-AZAHCH-3TIT';
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$jsonIterator = new RecursiveIteratorIterator(
    			new RecursiveArrayIterator(json_decode($json, TRUE)),
    			RecursiveIteratorIterator::SELF_FIRST);

			
			$i=-2;
			$list = array();
			foreach ($jsonIterator as $key => $val) {
				if(is_array($val)) {
					//echo "$key:<br><br>";
					$i++;
					$j=0;
				} else {
					if($i>-1){
						//echo "$key => $val<br>";
						$list[$i][$j]=$val;
						$j++;
					}
				}
			}
			return $list;
	}
	
	public function get_satelliteTime($norad){
			$id = $norad;
			$url = 'https://www.n2yo.com/rest/v1/satellite/radiopasses/'.$norad.'/'.$this->getISCTELat().'/'.$this->getISCTELong().'/'.$this->getISCTEAlt().'/3/40/&apiKey=W5JT3A-AEEYVQ-AZAHCH-3TIT';
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$jsonIterator = new RecursiveIteratorIterator(
    			new RecursiveArrayIterator(json_decode($json, TRUE)),
    			RecursiveIteratorIterator::SELF_FIRST);

			
			$i=-2;
			$this->listTime = array();
			foreach ($jsonIterator as $key => $val) {
				if(is_array($val)) {
					//echo "$key:<br><br>";
					$i++;
					$j=0;
				} else {
					if($i>-1){
						//echo "$key => $val<br>";
						$this->listTime[$i][$j]=$val;
						$j++;
					}
				}
			}
			$this->updateTime($norad);
			return $this->listTime;
	}
	
	public function updateTime($sat_id){
			$sql = "UPDATE satellite SET start_time=:start_time, end_time=:end_time WHERE sat_id=:sat_id ";
					
			$start_time = $this->getStartTime();
			$end_time = $this->getEndTime();
			
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":start_time"=>$start_time, "end_time"=>$end_time, ":sat_id"=>$sat_id));
		
			$resultado->closeCursor();
	}
	
	public function getStartTime(){
		return $this->listTime[1][2];
	}
	
	public function getEndTime(){
		return $this->listTime[1][9];
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
		return $this->items[14];
	}
	
	public function getElevation(){
		return $this->items[15];
	}
	
	public function getISCTELat(){
		return 38.71667;
	}
	
	public function getISCTELong(){
		return -9.13333;
	}
	
	public function getISCTEAlt(){
		return 0;
	}
	
	public function getLatitude(){
		return $this->items[11];
	}
	
	public function getLongitude(){
		return $this->items[12];
	}
	
	public function getAltitude(){
		return $this->items[13];
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
	
	public function haveThisSatellite($sat_id){
			$sql = "SELECT sat_id FROM satellite WHERE sat_id=:sat_id";
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":sat_id", $sat_id);
		
			$resultado->execute(array(":sat_id"=>$sat_id));
			$alunos = $resultado->fetchAll(PDO::FETCH_ASSOC);
		
			$count = $resultado->rowCount();					
			
			$resultado->closeCursor();
			
			if($count==0)
				return false;
			else
				return true;	
		}
	
	public function newSat($sat_id, $name){
		if(!$this->haveThisSatellite($sat_id)){
			$sql = "INSERT INTO satellite (sat_id, name) VALUES (:sat_id, :name)";
				
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":sat_id"=>$sat_id, ":name"=>$name));
		
			$resultado->closeCursor();
		}
	}
	
	public function randomSatellite(){
		$sql = "SELECT sat_id FROM satellite";
		
		$resultado = $this->connection->prepare($sql);
		
		$resultado->execute(array());
		$list = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
		$resultado->closeCursor();
			
		$satt = array_rand($list, 1);
		return $satt[0];
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
	
	class Message extends Connection{
		
		public function Message(){
			parent::__construct();	
		}
		
		/**
		* Create new user
		* @param
		*/
		public function newMsg($user_id, $sat_id, $msg){
			
			$sql = "INSERT INTO message (user_id, sat_id, text) VALUES (:user_id, :sat_id, :text)";
				
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":user_id"=>$user_id, ":sat_id"=>$sat_id, ":text"=>$msg));
		
			$resultado->closeCursor();
			
			//echo "Nova mensagem criada com sucesso";
		}
		
		public function remMsg($user_id, $sat_id){
			$sql = "DELETE FROM message WHERE user_id=:user_id AND sat_id=:sat_id";
				
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
			
			$resultado->bindValue(":user_id", $user_id);
			$resultado->bindValue(":sat_id", $sat_id);

		
			$resultado->execute(array(":user_id"=>$user_id, ":sat_id"=>$sat_id));
		
			$resultado->closeCursor();
			
			//echo "Mensagem removida com sucesso.";
		}
		
		public function getMsgs($user_id){
			$sql = "SELECT * FROM message WHERE user_id=:user_id";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$msg = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
			$resultado->closeCursor();
			
			return $msg;
		}
		
		private function getSatsToMessage($user_id){
			$sql = "SELECT * FROM user_id_satellite_time WHERE user_id=:user_id";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$list = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
			$resultado->closeCursor();
			
			return $list;
		}
		
		public function getMessages($user_id){
			$list = $this->getSatsToMessage($user_id);
			
			date_default_timezone_set('Europe/London');
			$now = date_create();
			$listMsg = array();
			$i=0;
			foreach($list as $aa){
				$difs = $aa['start_time']-$now->getTimestamp();
				$dife = $aa['end_time']-$now->getTimestamp();
				echo "<br>";

				if($difs < 3600){
					if($difs > 0){
						$time = $this->getTime($difs);
						$listMsg[$i][0]="O satélite ".$aa['name']." está a aproximar-se. Faltam ". $time;
						$listMsg[$i][1]=$aa['sat_id'];
					}else if($dife > 0){
						$time = $this->getTime($dife);
						$listMsg[$i][0]="O satélite ".$aa['name']." está contactável durante ". $time;
						$listMsg[$i][1]=$aa['sat_id'];
					}
					$i++;
				}
			}
			return $listMsg;
		}
		
		private function getTime($time){
			if($time>3600){
				return round($time/60/60)."h";
			}else{
				return round($time/60)."min";	
			}
		}
	}
	
?>