<?php

	class ClassClient extends Conn
	{
		
		public function __construct() {
			parent::__construct();
		}

		/* 
			Función que va a registrar clientes.
		*/
		public function insert($dni,$nombre,$telefono,$pass) {
		                
		    $nif = $this->connection->prepare('SELECT * FROM usuarios where dni=? AND tipo = "Cliente"');
		    $tel = $this->connection->prepare('SELECT * FROM usuarios where telefono=? AND tipo = "Cliente"');

		    $nif->bindParam('1', $dni);
		    $tel->bindParam('1', $telefono);
		    
		    $nif->execute();
		    $tel->execute();


		    if($nif->fetch() > 1){
		        $fail[] = '
		        <div class="alert alert-danger mt-2" role="alert">
		            Dni ya existe!
		        </div>';
		    }

		    if($tel->fetch() > 1){
		        $fail[] = '
		        <div class="alert alert-danger mt-2" role="alert">
		            Telefono ya existe!
		        </div>';
		    }


		    if (empty($fail)){

		    	$hash = password_hash($pass, PASSWORD_DEFAULT);
		    	$tipo = "Cliente";
		    	$status = NULL;
		    	$result = $this->connection->prepare('INSERT INTO usuarios (dni,nombre,telefono,tipo,estado,password) values(?,?,?,?,?,?)');
		    	$result->bindParam('1', $dni);
		    	$result->bindParam('2', $nombre);
		    	$result->bindParam('3', $telefono);
		    	$result->bindParam('4', $tipo);
		    	$result->bindParam('5', $status);
		    	$result->bindParam('6', $hash);

		    	if($result->execute()){
		        	return '<div class="alert alert-success mt-2" role="alert">
		                ¡Cliente registrado correctamente!
		                </div>';
		    	}

		    	return null;
			}

		    if(isset($fail)){
		       	foreach ($fail as $exec){
		            return "$exec";
		        }
		    }
		}

		/*
			Funcion que va a mostrar mediante un select todos los usuarios que sean Clientes
		*/
		public function showClientToDel() {
		                
		    $result = $this->connection->prepare('SELECT * FROM usuarios WHERE tipo="Cliente"');   
		    
		    $result->execute();
		    
		    echo '<div class="container border border-info mt-2 mb-2 bg-light">';
		    echo '<form method="post">';
		    echo '<div class="form-group mb-2 pt-2">';
		    echo '<label for="select">Selecciona el nombre del cliente:</label><br>';
		    echo '<select name="cliente" id="select" class="form-control">';
		    echo '<option selected>No has seleccionado nada</option>';
		    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		        echo '<option value="'.$row["dni"].'">'.$row["nombre"].', '.$row["dni"].'</option>';
		    }
		    echo '</select></div><br>';
		    echo '<input type="submit" name="eliminar" class="btn btn-primary mt-3" value="Eliminar"><br><br>';
		    echo '</div>';
		    echo '</form>';
		    /*El mensaje de cliente borrado te lo saca dentro del mismo div donde se encuentra el formulario*/
		    if (isset($_POST['eliminar'])) {
		      echo ClassClient::delClient($_POST['cliente']);
		    }
		    echo '</div>';
		}

		/* 
			Funcion que va a eliminar Clientes
		*/
		public function delClient($dni) {
		     
		    $result = $this->connection->prepare('DELETE FROM usuarios where dni = ? AND tipo="Cliente"');
		    $result->bindParam('1', $dni);  
		    if($result->execute()){
		        return '<div class="alert alert-success mt-2" role="alert">
		               ¡Cliente eliminado correctamente!
		             </div>';  
		    }          
		}

		/*
			Funciona que va a buscar cliente por DNI
		*/
		public function searchDNI($dni) {
			$result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo = "Cliente"');   
		  	$result->bindParam('1',$dni);   
		  	$result->execute();
		  	$row = $result->fetch(PDO::FETCH_ASSOC);

		  	if($row>1) {
		    	return ClassClient::getTabla($row);                
		  	} else {
		    	return '<div class="alert alert-danger mt-2" role="alert">
		     		¡Cliente no encontrado!
		   		</div>';
		  	}               
		}

		/*
			Funciona que va a buscar cliente por Nombre
		*/
		public function searchNombre($nombre) {
		 	$result = $this->connection->prepare('SELECT * FROM usuarios WHERE nombre = ? AND tipo = "Cliente"');   
		  	$result->bindParam('1',$nombre);   
		  	$result->execute();
		  	$row = $result->fetch(PDO::FETCH_ASSOC);
		  	
		  	if($row>1) {
		    	return ClassClient::getTabla($row);                
		  	} else {
		    	return '<div class="alert alert-danger mt-2" role="alert">
		     		¡Cliente no encontrado!
		   		</div>';
		  	}               
		}    

		/*
			Funciona que va a buscar cliente por Telefono
		*/
		public function searchTelefono($telefono) {
		 	$result = $this->connection->prepare('SELECT * FROM usuarios WHERE telefono = ? AND tipo = "Cliente"');   
		 	$result->bindParam('1',$telefono);   
		  	$result->execute();
		  	$row = $result->fetch(PDO::FETCH_ASSOC);

		  	if($row>1) {
		    	return ClassClient::getTabla($row);                
		  	} else {
		    	return '<div class="alert alert-danger mt-2" role="alert">
		     		¡Cliente no encontrado!
		   		</div>';
		  	}
		}         

		/*
			Funcion que muestra una tabla con los datos de cliente.
		*/
		public function getTabla($row) {
		    echo '<table class="table table-hover bg-light">
		   <tr>
		    <th>Nombre</th>
		    <th>DNI</th>
		    <th>Teléfono</th>
		    <th>Acciones</th>
		   </tr>';
		        echo "<tr>";
		        echo "<td>".$row["nombre"]."</td>";
		        echo "<td>".$row["dni"]."</td>";
		        echo "<td>".$row["telefono"]."</td>";
		        //Modificar la ruta del formulario o poner un if isset que permite ver factura 
		        echo "<td><form method='post' class='mr-5'><button type='submit' class='btn btn-primary w-100 w-md-50 pr-3' name='verFactura' value='".$row["dni"]."'>Facturas</button></form></td>";
		    echo '</tr>';
		    echo '</table>';
		}

		/*
			Funcion que muestra todos los usuarios tipo cliente en una tabla.
		*/
		public function showAll() {
			$result = $this->connection->prepare('SELECT * FROM usuarios where tipo = "Cliente"');
			$result->execute();

			echo '<table class="table table-hover bg-light">
			<tr>
			 <th>Nombre</th>
			 <th>DNI</th>
			 <th>Teléfono</th>
			 <th>Acciones</th>
			</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			    echo "<tr>";
			    echo "<td>".$row["nombre"]."</td>";
			    echo "<td>".$row["dni"]."</td>";
			    echo "<td>".$row["telefono"]."</td>";
			     //Modificar la ruta del formulario o poner un if isset que permite ver factura 
			    echo "<td><form method='post' class='mr-5' action='../empleado/verRepar.php'><button type='submit' class='btn btn-primary w-100 w-md-50 pr-3' name='verFactura' value='".$row["dni"]."'>Facturas</button></form></td>";
			}
			echo '</tr>';
			echo '</table>';
		}
		

		/*
			Funcion que muestra por un formulario los datos de un cliente. Y permitira modificar
		*/
		public function verModificar($dni){
		  $result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo = "Cliente"');
		    $result->bindParam('1', $dni);
		    $result->execute();
		    $row = $result->fetch(PDO::FETCH_ASSOC);

		    echo '<div class="container mt-2 mb-2" id="unlock">
		        <div class="row pb-3">
		          <div class="col-12"></div>
		        </div>
		        <div class="container row border-info pb-3 pt-3">
		          <div class="col-12 col-md-6 offset-md-3 border border-success rounded bg-light">
		            <form method="POST" name="">
		              <div class="form-group mb-2">
		                <label for="dni">DNI*</label>
		                <input type="text" class="form-control" name="dni" id="dni" title="e.g 11111111N" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" required readonly value="'.$row["dni"].'"}">
		              </div>
		              <div class="form-group mb-2">
		                <label for="nombre">Nombre*</label> 
		                <input type="text" name="nombre" id="nombre" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]{2,25}[ ]{1}[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]{2,25}"  required value="'.$row["nombre"].'"}">
		              </div>
		              <div class="form-group mb-2">
		                <label for="telefono">Teléfono*</label>
		                <input type="text" class="form-control" name="telefono" id="telefono" title="e.g 666666666" pattern="[0-9]{9}" required value="'.$row["telefono"].'"}">
		              </div>
		              <p> <input type="submit" class="btn btn-primary w-50 pr-3" name="modificar" value="Modificar"></p>
		            </form>';
		            if(isset($_POST["modificar"])) {
		              echo ClassClient::modificar($_POST['nombre'],$_POST['telefono'],$_SESSION["cliente"]);
		            }
		          echo '</div>
		        </div>
		      </div>';
		}

		public function modificar($nombre,$telefono,$dni) {
		  $result = $this->connection->prepare('UPDATE usuarios SET nombre =?, telefono =? WHERE dni =? AND tipo ="Cliente"');
		  $result->bindParam('1', $nombre); 
		  $result->bindParam('2', $telefono);
		  $result->bindParam('3', $dni); 
		  if($result->execute()){
		  	//ClassClient::verModificar($dni).
		      echo '<div class="alert alert-success mt-2" role="alert">
		            ¡Cliente actualizado correctamente!
		          </div>';
		  }          
		} 

		public function showClient($dni) {
		     $result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo = "Cliente"');   
		     $result->bindParam('1', $dni);   
		     $result->execute();

		    echo '<table class="table table-hover bg-light">
		    <tr>
		     <th>Nombre</th>
		     <th>DNI</th>
		     <th>Teléfono</th>
		    </tr>';
		     $row = $result->fetch(PDO::FETCH_ASSOC);
		         echo "<tr>";
		         echo "<td>".$row["nombre"]."</td>";
		         echo "<td>".$row["dni"]."</td>";
		         echo "<td>".$row["telefono"]."</td>";
		     echo '</tr>';
		     echo '</table>';                
		}

		public function addClient() {

			echo '<div class="container"><form method="POST" action="empleado.php">
            <div class="form-group mb-2">
              <h1 class="text-center">Cliente</h1>
              <label for="nombre">Nombre completo*</label> 
              <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]{2,25}[ ]{1}[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]{2,25}" required>
            </div>
            <div class="form-group mb-2">
              <label for="dni">DNI*</label>
              <input type="text" class="form-control" placeholder="DNI" name="dni" id="dni" title="e.g 11111111N" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" required>
            </div>
            <div class="form-group mb-2">
              <label for="telefono">Teléfono*</label>
              <input type="text" class="form-control" placeholder="Telefono" name="telefono" title="e.g 666666666" pattern="[0-9]{9}" required>
            </div>
            <div class="form-group mb-2">
              <label for="pass">Contraseña*</label>
              <input type="password" class="form-control" placeholder="Contraseña" name="pass" id="pass" title="e.g Pepe123/" required>
            </div>
            <p> <input type="submit" class="btn btn-primary w-100" name="registrar" value="Registrar"></p>
		  </form></div>';
		  
		  
	}

	public function findCliente() {
                    
		$result = $this->connection->prepare('SELECT dni, nombre FROM usuarios where tipo="cliente"');   
		
		$result->execute();

		  echo '<form method="POST" name="">
			<h2>Buscar Cliente</h2>
			<div class="form-group mt-4">
				<select class="select custom-select-sm col-8" name="dni_c" class="w-50">';
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					echo '<p><option value="'.$row["dni"].'">'.$row["dni"].', '.$row["nombre"].'</option></p>';
				}
				echo '</select>
			</div>
			<p> 
			  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="verclientebuscado">Ver</button>&nbsp';
		
			echo '</p>
		  </form>';
			
		}

}
?>