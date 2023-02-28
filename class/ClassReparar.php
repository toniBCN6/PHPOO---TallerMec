<?php
	class ClassReparar extends Conn {
    protected $multiplicador = 1;

		public function __construct() {
			parent::__construct();
		}

		/*
			Muestra la factura de un cliente por DNI
		*/
		public function cargaFacturas($dni) {

      $datos = $this->connection->prepare('SELECT id,usuarios.dni as dni,reparar.matricula as matricula,fechaEntrada,fechaSalida,coste,vehiculos.dni_c as dni_c, vehiculos.marca as marca, vehiculos.modelo as modelo, usuarios.nombre as nombre FROM reparar JOIN vehiculos ON reparar.matricula = vehiculos.matricula JOIN usuarios ON usuarios.dni = vehiculos.dni_c where vehiculos.dni_c = ?');
      $datos->bindParam('1',$dni);
      $datos->execute();
      echo '<table class="table table-hover bg-light">
       <tr>
        <th>Nombre Empleado</th>
        <th>Dni Cliente</th>
        <th>Matricula</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Fecha Reparacion</th>
        <th>Coste</th>
        <th>Acciones</th>
       </tr>
       ';
      while($linea = $datos->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$linea["nombre"]."</td>";
        echo "<td>".$linea["dni_c"]."</td>";
        echo "<td>".$linea["matricula"]."</td>";
        echo "<td>".$linea["marca"]."</td>";
        echo "<td>".$linea["modelo"]."</td>";
        echo "<td>".$linea["fechaEntrada"]."</td>";
        echo "<td>".$linea["coste"]."€</td>";
        echo "<td><form method='post' class='mr-5' action='./invoice.php'><button type='submit' class='btn btn-primary w-100 pr-3' name='verFacturaExt' value='".$linea["id"]."'>Factura Extendida</button></form></td>";
        echo '</tr>';
      }
      echo '</table>';
    }

    /* Muestra la factura de todos los clientes */
    public function showAllFacturas() {

      $datos = $this->connection->prepare('SELECT id,usuarios.dni as dni,reparar.matricula as matricula,fechaEntrada,fechaSalida,coste,vehiculos.dni_c as dni_c, vehiculos.marca as marca, vehiculos.modelo as modelo, usuarios.nombre as nombre FROM reparar JOIN vehiculos ON reparar.matricula = vehiculos.matricula JOIN usuarios ON reparar.dni = usuarios.dni');
      $datos->execute();
      echo '<table class="table table-hover bg-light">
       <tr>
        <th>Nombre Empleado</th>
        <th>Dni Cliente</th>
        <th>Matricula</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Fecha Reparacion</th>
        <th>Coste</th>
        <th>Acciones</th>
       </tr>
       ';
      while($linea = $datos->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$linea["nombre"]."</td>";
        echo "<td>".$linea["dni_c"]."</td>";
        echo "<td>".$linea["matricula"]."</td>";
        echo "<td>".$linea["marca"]."</td>";
        echo "<td>".$linea["modelo"]."</td>";
        echo "<td>".$linea["fechaEntrada"]."</td>";
        echo "<td>".$linea["coste"]."€</td>";
        echo "<td><form method='post' class='mr-5' action='./invoice.php'><button type='submit' class='btn btn-primary w-100 pr-3' name='verFacturaExt' value='".$linea["id"]."'>Factura Extendida</button></form></td>";
        echo '</tr>';
      }
      echo '</table>';
    } 

    /*
      Muestra la factura de un cliente por Telefono
    */
    public function cargaFacturasTel($tel) {

      $datos = $this->connection->prepare('SELECT id,usuarios.dni as dni,reparar.matricula as matricula,fechaEntrada,fechaSalida,coste,vehiculos.dni_c as dni_c, vehiculos.marca as marca, vehiculos.modelo as modelo, usuarios.nombre as nombre FROM reparar JOIN vehiculos ON reparar.matricula = vehiculos.matricula JOIN usuarios ON usuarios.dni = vehiculos.dni_c where usuarios.telefono = ?');
      $datos->bindParam('1',$tel);
      $datos->execute();
      echo '<table class="table table-hover bg-light">
       <tr>
        <th>Nombre Empleado</th>
        <th>Dni Cliente</th>
        <th>Matricula</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Fecha Reparacion</th>
        <th>Coste</th>
        <th>Acciones</th>
       </tr>
       ';
      while($linea = $datos->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$linea["nombre"]."</td>";
        echo "<td>".$linea["dni_c"]."</td>";
        echo "<td>".$linea["matricula"]."</td>";
        echo "<td>".$linea["marca"]."</td>";
        echo "<td>".$linea["modelo"]."</td>";
        echo "<td>".$linea["fechaEntrada"]."</td>";
        echo "<td>".$linea["coste"]."€</td>";
        echo "<td><form method='post' class='mr-5' action='./invoice.php'><button type='submit' class='btn btn-primary w-100 pr-3' name='verFacturaExt' value='".$linea["id"]."'>Factura Extendida</button></form></td>";
        echo '</tr>';
      }
      echo '</table>';
    }

    /*
      Funcion que va a mostrar nombres, precios de la tabla Catalogo mediante un CheckBox.
    */
    public function cargaPrecios() {
      $datos = $this->connection->prepare('SELECT * FROM catalogo');
      $datos->execute();
      while($linea = $datos->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="form-check">
              <label class="form-check-label">
              <input type="checkbox" name="'.$linea['id'].'" class="form-check-input" value="'.$linea['precio'].'">'.$linea['nombre'].'
              </label>
            </div>';
      }
    }

    public function cargaDinero($dni,$plate,$aceite,$motor,$ruedas,$ventana) {
      $result = $this->connection->prepare('SELECT * FROM vehiculos WHERE matricula=' .(int) $plate);
      $result->execute();
      $result2 = $this->connection->prepare('SELECT * FROM catalogo');
      $result2->execute();
      $row = $result->fetch(PDO::FETCH_BOTH);
      $row2 = $result2->fetch(PDO::FETCH_BOTH);
        
      if ($row["gama"] == 'Baja') {
        $this->multiplicador = 1;
      } elseif ($row["gama"] == 'Media') {
        $this->multiplicador = 2;
      } elseif ($row["gama"] == 'Alta') {
        $this->multiplicador = 4;}



      $aceite = $this->multiplicador * $aceite;
      $motor = $this->multiplicador * $motor;
      $ruedas = $this->multiplicador * $ruedas;
      $ventana = $this->multiplicador * $ventana;
      $coste = $aceite+$motor+$ruedas+$ventana;

      $fechaEntrada =  date("Y/m/d");

      $fechaSalida = date('Y/m/d', strtotime('+ 2 days'));

      $this->load($dni,$plate,$fechaEntrada,$fechaSalida,$coste,$aceite,$motor,$ruedas,$ventana);

    }

    public function load($dni,$matricula,$fechaEntrada,$fechaSalida,$coste,$aceite,$motor,$ruedas,$ventana) {
      $result = $this->connection->prepare('INSERT INTO reparar (dni,matricula,fechaEntrada,fechaSalida,coste,aceite, motor, ruedas, ventanas) values(?,?,?,?,?,?,?,?,?)');
      $result->bindParam('1', $dni);
      $result->bindParam('2', $matricula);
      $result->bindParam('3', $fechaEntrada);
      $result->bindParam('4', $fechaSalida);
      $result->bindParam('5', $coste);
      $result->bindParam('6', $aceite);
      $result->bindParam('7', $motor);
      $result->bindParam('8', $ruedas);
      $result->bindParam('9', $ventana);

      echo $this->updateemploy($dni);
      
      if($result->execute()){
        return '<div class="alert alert-danger mt-2" role="alert">Reparacion añadida correctamente</div>';
      }
    }

    public function updateemploy($dni) {
      $result2 = $this->connection->prepare('UPDATE usuarios SET estado=1 WHERE dni=? AND tipo="Empleado"');
      $result2->bindParam('1', $dni);
      if($result2->execute()){
        $buscar = $this->connection->prepare('SELECT dni, nombre FROM usuarios WHERE dni=? AND tipo="Empleado"');
        $buscar->bindParam('1', $dni);
        $buscar->execute();
        $linea = $buscar->fetch();
        return '<div class="alert alert-success mt-2" role="alert">
            ¡'.$linea["nombre"].' ha recibido el encargo!
          </div>';
      }
    }

    public function VerInsert() {

      require_once '../class/ClassEmp.php';
      $emp1 = new ClassEmp();

      echo '<div class="container"><form method="POST" action="empleado.php" name="">
      <div class="form-group mb-2">
          <h1 class="text-center">Formulario</h1>
          <label for="dni">Empleado Encargado*</label>';
          
            $emp1->cargaEmpleadosLibres();

     echo '</div>
      <div class="form-group mb-2">
          <label for="matricula">Matricula*</label>
          <input type="text" class="form-control" name="matricula" id="matricula" minlength="7" maxlength="8" required>
      </div>
      <div class="form-group mb-2">
          <label for="matricula">Partes Reparadas*</label>';

          $this->cargaPrecios();

      echo '</div>
      <p> <input type="submit" class="btn btn-primary w-100" name="registrarfactura" value="Registrar"></p>
      </form></div>';
    }

    public function findFacturas() {
                    
      $result = $this->connection->prepare('SELECT dni, nombre FROM usuarios where tipo="cliente"');   
      
      $result->execute();

        echo '<form method="POST" name="">
          <h2>Buscar vehiculo</h2>
          <div class="form-group mt-4">
              <select class="select custom-select-sm col-8" name="dni_c" class="w-50">';
              while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  echo '<p><option value="'.$row["dni"].'">'.$row["dni"].', '.$row["nombre"].'</option></p>';
              }
              echo '</select>
          </div>
          <p> 
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="verfacturavehiculobuscado">Ver</button>&nbsp';
      
          echo '</p>
        </form>';
          
      }

	}
?>