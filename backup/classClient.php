    <?php

class allClient extends Conn {

    public function __construct() {
        parent::__construct();
    }

        public function showClient() {
                
            $result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? AND tipo = "Cliente"');   
            $result->bindParam('1',$_SESSION['cliente']);   
            $result->execute();

            echo '<table class="table table-hover">
               <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Acciones</th>
               </tr>';
                $row = $result->fetch(PDO::FETCH_ASSOC);
                    echo "<tr>";
                    echo "<td>".$row["nombre"]."</td>";
                    echo "<td>".$row["dni"]."</td>";
                    echo "<td>".$row["telefono"]."</td>";
                    echo "<td><form method='post' class='mr-5'><button type='submit' class='btn btn-primary w-100 w-md-50 pr-3' name='verFactura' value='".$row["dni"]."'>Facturas</button></form></td>";
                  echo 
                      "<td><form method='post' class='mr-5'>
                          <button class='btn btn-primary w-50 pr-3' 
                              type='submit' name='cmodificar'
                                value='".$row["dni"]."'>
                                      Modificar
                          </button>
                      </form></td>";

                echo '</tr>';
                echo '</table>';                
        }

        public function verModificarCliente(){
          $result = $this->connection->prepare('SELECT * FROM usuarios WHERE dni = ? and tipo = "Cliente" ');
            $result->bindParam('1', $_SESSION['cliente']);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);

            echo '<div class="container border border-info mt-2 mb-2 bg-white" id="unlock">
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
                      <p> <input type="submit" class="btn btn-primary w-50 pr-3" name="modificarCliente" value="Modificar"></p>
                    </form>
                  </div>
                </div>
              </div>';
        }

        public function modificarCliente($nombre,$telefono,$dni) {
          $result = $this->connection->prepare("UPDATE usuarios SET nombre =?, telefono =? WHERE dni = ? and tipo ='Cliente'");
          $result->bindParam('1', $nombre); 
          $result->bindParam('2', $telefono);
          $result->bindParam('3', $dni); 
          if($result->execute()){
              echo allClient::verModificarCliente().
              '<div class="container alert alert-success mt-2" role="alert">
                    ¡Cliente actualizado correctamente!
              </div>';
          }          
        }

        public function showCar() {          
              $result = $this->connection->prepare('SELECT * FROM vehiculos where dni_c = ?');
              $result->bindParam('1',$_SESSION['cliente']);
              $result->execute();
              echo    
                  '<table class="table table-hover">
                      <tr>
                          <th>Matricula</th>
                          <th>DNI</th>
                          <th>Marca</th>
                          <th>Modelo</th>
                          <th>Tipo</th>
                          <th>Gama</th>
                      </tr>'
                  ;
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td>".$row["matricula"]."</td>";
                  echo "<td>".$row["dni_c"]."</td>";
                  echo "<td>".$row["marca"]."</td>";
                  echo "<td>".$row["modelo"]."</td>";
                  echo "<td>".$row["tipo"]."</td>";
                  echo "<td>".$row["gama"]."</td>";
                  echo 
                      "<td><form method='post' class='mr-5'>
                          <button class='btn btn-primary w-50 pr-3' 
                              type='submit' id='vmodificar' name='vmodificar'
                                value='".$row["matricula"]."'>
                                      Modificar
                          </button>
                      </form></td>";
                  }
                  echo '</tr>';
                  echo '</table>';                
            }

       public function verModificarCoche(){
          $result = $this->connection->prepare('SELECT * FROM vehiculos WHERE dni_c = ?');
            $result->bindParam('1', $_SESSION['cliente']);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);

            echo '<div class="container border border-info mt-2 mb-2 bg-white">
              <div class="row pb-3">
                <div class="col-12"></div>
              </div>
              <div class="container row border-info pb-3 pt-3">
                <div class="col-12 col-md-6 offset-md-3 border border-success rounded bg-light">
                  <form method="POST" name="">
                    <div class="form-group mb-2">
                      <h1 class="text-center">Formulario</h1>
                      <label for="dni">DNI*</label>
                      <input value="'.$row["dni_c"].'" type="text" class="form-control" name="dni_c" id="dni_c" title="e.g 11111111N" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" required readonly>
                    </div>
                    <div class="form-group mb-2">
                      <label for="nombre">Matricula*</label> 
                      <input value="'.$row["matricula"].'" type="text" name="matricula" id="matricula" class="form-control" title="e.g 0000FPZ" pattern="[0-9]{4}[A-Z]{3,4}" required readonly>
                    </div>
                    <div class="form-group mb-2">
                      <label for="nombre">Marca*</label> 
                      <input value="'.$row["marca"].'" type="text" name="marca" id="marca" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[A-Za-z]{1,10}" required>
                    </div>
                    <div class="form-group mb-2">
                      <label for="nombre">Modelo*</label> 
                      <input value="'.$row["modelo"].'" type="text" name="modelo" id="modelo" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[A-Za-z0-9]{1,10}" required>
                    </div>
                    <div class="form-group mb-2">
                      <label for="nombre">Tipo*</label> 
                        <input value="'.$row["tipo"].'" type="text" name="tipo" id="tipo" class="form-control" title="e.g Coche o Moto" pattern="[A-Za-z]{4,6}" required>
                    </div>
                    <div class="form-group mb-2">
                      <label for="nombre">Gama*</label> 
                      <select name="gama" id="gama" class="form-control" required>
                        <option selected>'.$row["gama"].'</option>
                          <option>Baja</option>
                          <option>Media</option>
                          <option>Alta</option>
                      </select>
                    </div>
                    <p> <input type="submit" class="btn btn-primary w-50 pr-3" name="modificarVehicle" value="Modificar"></p>
                  </form>
                </div>
              </div>
            </div>'; 
        }

        public function modificarCoche($dni_c,$matricula,$marca,$modelo,$tipo,$gama) {

          $result = $this->connection->prepare('UPDATE vehiculos SET marca= ?,modelo= ?,tipo= ?,gama= ? where matricula = ?');
          $result->bindParam('1', $marca);
          $result->bindParam('2', $modelo);
          $result->bindParam('3', $tipo);
          $result->bindParam('4', $gama);
          $result->bindParam('5', $matricula);
          $result->execute();

          return allClient::verModificarCoche().'
                <div class="container alert alert-success mt-2" role="alert">
                  ¡Vehículo actualizado correctamente!
                </div>'; 
        }

        public function insertClient($dni,$nombre,$telefono,$pass) {
                
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
                          echo "$exec";
                        }
                    }
        }

        public function showClientToDel() {
                
        $result = $this->connection->prepare('SELECT * FROM usuarios where tipo = "Cliente"');   
            
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
            echo '<input type="submit" name="submit" class="btn btn-primary mt-3" value="Eliminar"><br><br>';
            echo '</div>';
            echo '</form>';
            
            if (isset($_POST['eliminar'])) {
              echo allClient::delClient($_POST['cliente']);
            }
            
            echo '</div>';

        }


        public function delClient($dni) {
                
            $result = $this->connection->prepare('DELETE FROM usuarios where dni = ? and tipo = "Cliente"');
            $result->bindParam('1', $dni);  
               if($result->execute()){
                    echo '<div class="alert alert-success mt-2" role="alert">
                          ¡Cliente eliminado correctamente!
                        </div>';  
                }          
        }
    }
    /*
        if(isset($_POST['submit'])){
        $user = new addClient();
        echo $user->insertClient($_POST['dni'],$_POST['nombre'],$_POST['telefono'],$_POST['pass']);
        }
    */
    /*
        if(isset($_POST['submit'])){
            echo delClient($_POST['cliente']);
        }             
    */
?>
