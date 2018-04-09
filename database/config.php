<?php

	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'citius');
	
	define('DB_CHAR', 'utf8');

	
	class Connection{
		
		protected $connection;
		
		public function Connection(){
			
			try{
				
				$this->connection= new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
				
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$this->connection->exec("SET CHARACTER SET " . DB_CHAR);
				return $this->connection;
				
			}catch(Exception $e){
				echo "Erro na linha " . $e->getLine();	
			}
		}
	}
		
?>