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
			$list = $resultado->fetchAll(PDO::FETCH_ASSOC);	
			
			$resultado->closeCursor();
			
			return $list;
		}
		
		/**
		* Return username by Id
		*/
		public function getUsernameById($user_id){
			$sql = "SELECT username FROM user WHERE user_id=:user_id";
		
			$resultado = $this->connection->prepare($sql);
		
			$resultado->bindValue(":user_id", $user_id);
		
			$resultado->execute(array(":user_id"=>$user_id));
			$list = $resultado->fetch();
			
			$resultado->closeCursor();
			
			return $list[0];
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
		* Get Id by Username
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
				//$this->logLogin($username, 1, $ip);
				header("location:index.php");
			
			}else{
				//$this->logLogin($username, 0, $ip);
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
?>