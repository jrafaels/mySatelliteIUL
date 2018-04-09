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
		
		public function getUsernameById($user_id){
			$sql = "SELECT username FROM user WHERE user_id=:user_id";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$list = $resultado->fetch();
			
			$resultado->closeCursor();
			
			return $list[0];
		}
		
		public function getTAGByUsername($username){
			$sql = "SELECT tag FROM user WHERE username=:username";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$list = $resultado->fetch();
			
			$resultado->closeCursor();
			
			$list[0];
		}
		
		public function getEntryDate($user_id){
			$sql = "SELECT date FROM users_firsttime WHERE user_id=:user_id";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id, PDO::PARAM_INT);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$datelist = $resultado->fetch();	
			
			$resultado->closeCursor();
			
			return $datelist[0];
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
		
		public function newTag($username, $tag){
			$sql = "UPDATE user SET tag=:tag WHERE username=:username";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":tag", $tag);
			$resultado->bindValue(":username", $username);
		
			$resultado->execute();
			
			$resultado->closeCursor();
			
			echo "Nova tag registada com sucesso.";	
		
		}
		
		public function getId($username){
			$sql = "SELECT user_id FROM user WHERE username=:username";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":username", $username);
		
			$resultado->execute(array(":username"=>$username));
			$idlist = $resultado->fetch();
			
			$resultado->closeCursor();
			
			return $idlist[0];
		}
		
		public function getUsersByPatent($patent){
			$sql = "SELECT * FROM users_patent WHERE patent=:patent";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":patent", $patent);
		
			$resultado->execute(array(":patent"=>$patent));
			$list = $resultado->fetchAll(PDO::FETCH_ASSOC);
			
			$resultado->closeCursor();
			
			return $list;
		}
		
		public function getPatent($username){
			$sql = "SELECT patent FROM users_patent WHERE username=:username";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":username", $username);
		
			$resultado->execute(array(":username"=>$username));
			$list = $resultado->fetch();
			
			$resultado->closeCursor();
			
			return $list[0];
		}
	
		/**
		* Login
		*
		*/
		public function login($username, $password, $ip){
			
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
				$this->logLogin($username, 1, $ip);
				header("location:index.php");
			
			}else{
				$this->logLogin($username, 0, $ip);
				header("location:login.php");
			}			
			
		}
		
		private function logLogin($username, $entry, $ip){
			// 0 - Login unsuccessful
			// 1 - Login successful
			
			$sql = "INSERT INTO logs_login (user_id, date, entry, ip) VALUES (:user_id, :date, :entry, :ip)";
			
			$user = new User();
			$aux = new Aux();
			$user_id = $user->getId($username);
			$date = date("Y-m-d H:i:s");
		
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":user_id"=>$user_id, ":date"=>$date, ":entry"=>$entry, ":ip"=>$ip));
		
			$resultado->closeCursor();
			
			//echo "Log inserido com sucesso.";
		}
	}
	
	
	
	
	/* COMPANY */


	class Company extends Connection{
		
		public function Company(){
			parent::__construct();	
		}
		
		public function getCompanys(){
			$sql = "SELECT name, designation FROM company";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array());
			$cursos = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
			$resultado->closeCursor();
			
			return $cursos;
		}
		
		public function getNumCompanys(){
			$sql = "SELECT name FROM company";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array());
			$num = $resultado->rowCount();	
			
			$resultado->closeCursor();
			
			return $num;
		}
		
		public function haveThisCompany($name){
			$sql = "SELECT name FROM company WHERE name=:name";
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":name", $name);
		
			$resultado->execute(array(":name"=>$name));
		
			$count = $resultado->rowCount();					
			
			$resultado->closeCursor();
			
			if($count==0)
				return false;
			else
				return true;	
		}
		
		public function newCompany($name, $designation, $description){
			$sql = "INSERT INTO company (name, designation, description) VALUES (:name, :designation, :description)";
		
			//Devolve PDO Statement	
			$resultado = $this->connection->prepare($sql);
		
			$resultado->execute(array(":name"=>$name, ":designation"=>$designation, ":description"=>$description));
			
			$resultado->closeCursor();
			
			echo "Nova companhia criada com sucesso";
		}
	}
	
	class Message extends Connection{
		
		public function Message(){
			parent::__construct();	
		}
		
		public function getNumberMessagesReceived($user_id, $read){
			//read=0 - Não lida
			//read=1 - Lida
			//read=2 - Todas
			if($read==2){
				$sql = "SELECT message.message_id FROM message WHERE message.to_id=:user_id";
				
				$resultado = $this->connection->prepare($sql);
			
				$resultado->bindValue(":user_id", $user_id);
		
				$resultado->execute(array(":user_id"=>$user_id));
			}else{ 
				$sql = "SELECT message.message_id FROM message WHERE message.to_id=:user_id AND message.read=:read";

				$resultado = $this->connection->prepare($sql);

				$resultado->bindValue(":user_id", $user_id);
				$resultado->bindValue(":read", $read);
		
				$resultado->execute(array(":user_id"=>$user_id, ":read"=>$read));
			}
			
			$num = $resultado->rowCount();	
			
			$resultado->closeCursor();
			
			return $num;
		}
		
		public function getMessages($user_id){
			$sql = "SELECT * FROM message WHERE to_id=:user_id";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$messages = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
			$resultado->closeCursor();
			
			return $messages;
		}
		
		public function getDifferenceTimeOnMessage($date){
			$now = date('Y-m-d H:i:s');
			
			//echo $date ."   ".$now;
			
			return $now - $date;
		}
	}
	
	class Aux extends Connection{
		
		public function Aux(){
			parent::__construct();	
		}
		
		public function getMenusTop($dad_id=0){
			$sql = "SELECT * FROM channel WHERE dad_id=:dad_id ORDER BY sort";
		
			$resultado = $this->connection->prepare($sql);
			$resultado->bindValue(":dad_id", $dad_id);
		
			$resultado->execute(array(":dad_id"=>$dad_id));
			$menu = $resultado->fetchAll(PDO::FETCH_ASSOC);		
			
			$resultado->closeCursor();
			
			return $menu;			
		}
		
		public function getMonth($month){
			if($month==01){
				$date = 'Jan';
			}elseif($month==02){
				$date = 'Fev';
			}elseif($month==03){
				$date = 'Mar';
			}elseif($month==04){
				$date = 'Abr';
			}elseif($month==05){
				$date = 'Mai';
			}elseif($month==06){
				$date = 'Jun';
			}elseif($month==07){
				$date = 'Jul';
			}elseif($month==08){
				$date = 'Ago';
			}elseif($month==09){
				$date = 'Set';
			}elseif($month==10){
				$date = 'Out';
			}elseif($month==11){
				$date = 'Nov';
			}elseif($month==12){
				$date = 'Dez';
			}
			return $date;
		}
		
		public function getMonthYear($date){
			$tokens = explode(" ", $date);
			$tokens = explode("-", $tokens[0]);
			
			$newdate = $this->getMonth($tokens[1])." ".$tokens[0];
			return $newdate;
		}
		
		public function getDayMonthYear($date){
			$tokens = explode(" ", $date);
			$tokens = explode("-", $tokens[0]);
			
			$newdate = $tokens[2]." ".$this->getMonth($tokens[1])." ".$tokens[0];
			return $newdate;
		}
		
		public function getPatents($type){
			$sql = "SELECT * FROM patent WHERE type=:type ORDER BY sort DESC";
		
			$resultado = $this->connection->prepare($sql);
			$resultado->bindValue(":type", $type);
		
			$resultado->execute(array(":type"=>$type));
			$list = $resultado->fetchAll(PDO::FETCH_ASSOC);		
			
			$resultado->closeCursor();
			
			return $list;
		}	
		
		public function getUserIP(){
    		$client  = @$_SERVER['HTTP_CLIENT_IP'];
    		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    		$remote  = $_SERVER['REMOTE_ADDR'];

    		if(filter_var($client, FILTER_VALIDATE_IP)){
        		$ip = $client;
    		}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
       			$ip = $forward;
    		}else{
        		$ip = $remote;
    		}

    		return $ip;
		}
	}
	
?>