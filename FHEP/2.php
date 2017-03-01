<?php
require_once("1.php");
class Users
{

	private $con;
	public function __construct()
	{
		
		//en $this->con tenemos la conexión con la bd pruebas
		$this->con = new Database();

	}
	
	//creamos una tabla con postgreSql
	public function create_table_users()
	{
		
		try{
			//SERIAL equivale a auto_increment en mysql
			$query = $this->con->prepare('CREATE TABLE IF NOT EXISTS users(
											id SERIAL,
											nombre varchar(100),
											apellidos varchar(100),
											fecha_registro date,
											primary key(id)
										 );');
		    
			$query->execute();
			//cerramos la conexión con la bd
			$this->con->close_con();
		
		} catch(PDOException $e) {

	        echo  $e->getMessage(); 

	    }
	}
	
	//insertamos usuarios en una tabla con postgreSql
	public function inserta_usuarios($nombre,$apellidos,$fecha_registro)
	{
		
		try{
			
			$query = $this->con->prepare('INSERT INTO users (nombre,apellidos,fecha_registro) values (?,?,?)');
			$query->bindParam(1,$nombre);
			$query->bindParam(2,$apellidos);
			$query->bindParam(3,$fecha_registro);
			$query->execute();
			$this->con->close_con();
		
		} catch(PDOException $e) {

	        echo  $e->getMessage(); 

	    }
	}
	
	//obtenemos usuarios de una tabla con postgreSql
	public function getUsers()
	{

		try{
			$query = $this->con->prepare('SELECT * FROM data');
			$query->execute();
			$this->con->close_con();
			return $query->fetchAll();
		
		} catch(PDOException $e) {

	        echo  $e->getMessage(); 

	    }

	}

}
$a =new Users();
$var=$a->getUsers();
foreach ($var as $key => $value) {
	echo $key." = ".$value."<br>";
	# code...
}
?>