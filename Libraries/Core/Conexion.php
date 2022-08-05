<?php 
class Conexion{
	private $conect;
	private $conectMaster;
	private $database;
	
	/*public function __construct(){
		$connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";".DB_CHARSET;
		try{
			$this->conect = new PDO($connectionString,DB_USER, DB_PASSWORD);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			$this->conect = 'Error de conexión';
			echo "Error: ".$e->getMessage();  
		}
	}
	
	public function conect(){
		return $this->conect;
	}

	*/

	public function setDataBase(string $db){
		$this->database = $db;
	}

	public function conectar(){
		$connectionString = "mysql:host=".DB_HOST.";dbname=".$this->database.";".DB_CHARSET;
		try{
			$this->conect = new PDO($connectionString,DB_USER, DB_PASSWORD);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			$this->conect = 'Error de conexión';
			echo "Error: ".$e->getMessage();  
		}
	}

	public function conectarMaster(){
		$connectionString = "mysql:host=".DB_MASTER_HOST.";dbname=".DB_MASTER_NAME.";".DB_MASTER_CHARSET;
		try{
			$this->conectMaster = new PDO($connectionString,DB_MASTER_USER, DB_MASTER_PASSWORD);
			$this->conectMaster->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			$this->conectMaster = 'Error de conexión';
			echo "Error: ".$e->getMessage();  
		}
	}

	public function getConnect(){
		return $this->conect;
	}

	public function getConnectMaster(){
		return $this->conectMaster;
	}




}


 ?>