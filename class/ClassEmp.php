<?php
	class ClassEmp extends Conn {
		public function __construct() {
			parent::__construct();
		}

		public function showEmp($dni) {
		  $result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo="Empleado"');   
		  $result->bindParam('1',$dni);   
		  $result->execute();
		 

		  echo '<table class="table table-hover bg-white">
		    <tr>
		    <th>Nombre</th>
		    <th>DNI</th>
		    <th>Teléfono</th>
		    <th>Estado</th>
		    </tr>';
		  $row = $result->fetch(PDO::FETCH_ASSOC);
		    echo "<tr class='bg-light'>";
		    echo "<td>".$row["nombre"]."</td>";
		    echo "<td>".$row["dni"]."</td>";
			echo "<td>".$row["telefono"]."</td>";
			if ($row['estado'] == 1) {
				echo "<td class='text-danger'>Ocupado</td>";
			} elseif ($row['estado'] == 0) {
				echo "<td class='text-success'>Libre</td>";
			}
		  echo '</tr>';
		  echo '</table>';                
		}

		public function showStatus($dni) {
			$result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo="Empleado"');   
			$result->bindParam('1',$dni);   
			$result->execute();

			echo '<table class="table table-hover bg-white">
			  <tr>
			  <th>Nombre</th>
			  <th>DNI</th>
			  <th>Estado</th>
			  <th>Acciones</th>
			  </tr>';
			$row = $result->fetch(PDO::FETCH_ASSOC);

			  echo "<tr class='bg-light'>";
			  echo "<td>".$row["nombre"]."</td>";
			  echo "<td>".$row["dni"]."</td>";
			  if($row["estado"]==0) {
			    echo "<td class='text-success'>Libre</td>";
			  } else {
			    echo "<td class='text-danger'>Ocupado</td>";
			  }
			  echo "<td><form method='post' class='mr-5' action='verEmp.php'><button type='submit' class='btn btn-primary w-50 pr-3' name='verDatos' value='".$row["dni"]."'>Datos</button></form></td>";
			echo '</tr>';
			echo '</table>';
		}

		public function verModificar($dni){
			$result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo="Empleado"');
			$result->bindParam('1', $_SESSION['empleado']);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			if($row["estado"]==0) {
			  $estado="Libre";
			} else {
			  $estado="Ocupado";
			}

			echo '<div class="container mt-2 mb-2">
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
			          <div class="form-group mb-2 pt-2">
			            <label for="select">Selecciona el estado del empleado:</label><br>
			            <select name="estado" id="select" class="form-control">
						  <option selected value="'.$row["estado"].'">'.$estado.'</option>';
						  if ($row["estado"]==1) {
							  echo '<option value="0">Libre</option>';
						  } elseif ($row["estado"]==0) {
							echo '<option value="1">Ocupado</option>';
						}
			            echo '
			            </select>
			          </div>
			          <p> <input type="submit" class="btn btn-primary w-50 pr-3" name="modificarmeami" value="Modificar"></p>
			        </form>';
			        

			      echo '</div>
			    </div>
			  </div>';
		}

		public function modificar($dni,$nombre,$telefono,$estado) {
			$result = $this->connection->prepare("UPDATE usuarios SET nombre =?, telefono =?, estado =? WHERE dni =?");
			$result->bindParam('1', $nombre); 
			$result->bindParam('2', $telefono);
			$result->bindParam('3', $estado); 
			$result->bindParam('4', $dni); 
			if($result->execute()){
			  //ClassEmp::verModificar().
			    return '<div class="alert alert-success mt-2" role="alert">
			          ¡Empleado actualizado correctamente!
			        </div> <a class="m-2" href="http://localhost/web2/empleado/modEmp.php" role="button">Ver perfil actualizado</a>';
			}          
		}

		public function cargaEmpleadosLibres() {
          $datos = $this->connection->prepare('SELECT * FROM usuarios WHERE estado=0 AND tipo="Empleado"');
          $datos->execute();
          echo '<div class="text-center">
                  <select class="form-control" name="Empleado">';
          while($linea = $datos->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$linea['dni'].'">'.$linea['nombre'].'</option>';      
          }
          echo '</select>
            </div>';
        }

        public function getEstado($session) {
        	$verEstado = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND  tipo="Empleado"');
        	$verEstado->bindParam('1', $session);
        	$verEstado->execute();
        	
        	$row = $verEstado->fetch(PDO::FETCH_ASSOC);
        	
        	if($row["estado"]==0) {
			    return "<span class='text-success'>Libre</span>";
			} else {
			    return "<span class='text-danger'>Ocupado</span>";
			}
		}
		
		
		}

?>