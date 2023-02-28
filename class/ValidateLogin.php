<?php

include_once 'Conn.php';

class ValidateLogin {

		private $_nombre;
		private $_telefono;
		private $_dni;
 		private $db;

     public function __construct(){
          //Obtenemos la instancia de la BD
     	$this->db = Database::getInstance();
     }
	  

	  	public function load($user,$password) {
	    	$login = $this->db->getQuery('SELECT * FROM usuarios WHERE dni = ?');
	    	$login->bindParam('1',$user);
	    	$login->execute();
	    	$check_pass = $login->fetch();

	    	if(password_verify($password,$check_pass['password'])) {
	      		switch ($check_pass['tipo']) {
	        	case 'Cliente':
	          		$_SESSION['cliente'] = $user;
	          		header("Location:cliente/cliente.php");
	          		break;
	        	case 'Empleado':
	          		$_SESSION['empleado'] = $user;
	          		header("Location:empleado/empleado.php");
	          		break;
	        	case 'Admin':
	          		$_SESSION['admin'] = $user;
	          		header("Location:admin/admin.php");
	          		break;
	        	default:
	          		header("Location:login.php");
	          		break;
	      		}
	    	} else {
	      		echo '<div class="alert alert-danger mt-2" role="alert">
	            	¡Datos incorrectos!
	        	</div>';
	    	}
	  	}

	  	public function cliente($session) {
	  		$result = $this->db->getQuery('SELECT * FROM usuarios WHERE dni = ?');
	  		$result->bindParam('1', $session);
	  		$result->execute();
	  		$row = $result->fetch(PDO::FETCH_ASSOC);
	  		$this->_nombre = $row["nombre"];
	  		$this->_telefono = $row["telefono"];
	  		$this->_dni = $row["dni"];
	  	}

	  	public function empleado($session) {
	  		$result = $this->db->getQuery('SELECT * FROM usuarios WHERE dni = ?');
	  		$result->bindParam('1', $session);
	  		$result->execute();
	  		$row = $result->fetch(PDO::FETCH_ASSOC);
	  		$this->_nombre = $row["nombre"];
	  		$this->_telefono = $row["telefono"];
	  		$this->_dni = $row["dni"];
	  	}

	  	public function admin($session) {
	  		$result = $this->db->getQuery('SELECT * FROM usuarios WHERE dni = ?');
	  		$result->bindParam('1', $_SESSION['admin']);
	  		$result->execute();
	  		$row = $result->fetch(PDO::FETCH_ASSOC);
	  		$this->_dni = $row["user"];
	  	}

	  	public function getNombre(){
	  	  return $this->_nombre;
	  	}

	  	public function getTelefono(){
	  	  return $this->_telefono;
	  	}

	  	public function getDni(){
	  	  return $this->_dni;
	  	}
	}
?>