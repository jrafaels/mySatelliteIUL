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
				$options.=$items[$i][1].'    '.$items[$i][0].'<br>';
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
			for($i=0; $i<$rows->length; $i++){
				$cols = $rows->item($i)->getElementsByTagName('td');
				$items[$i] = $cols->item(0)->textContent;
			}	
			$options='';
			while(list($k,$v)=each($items))
			{
				$options.=$k.'    '.$v.'<br>';
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
}
	
	class Alerts{
		
		/**
		* @param @title - Title of callout
		* @param @msg - Message of callour
		*/
		public static function getRedCallout($title, $msg){
			echo "<div class=\"alert alert-danger\">
                <h4>". $title ."</h4>

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