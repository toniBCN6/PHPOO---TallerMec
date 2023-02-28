
<?php
    class ClassVehic extends Conn {
        public function __construct() {
            parent::__construct();
        }
        public function loadAll() {
                    
            $result = $this->connection->prepare('SELECT * FROM vehiculos');
            
            $result->execute();
            echo    
                '<form>
                <table class="table table-hover">
                    <tr>
                        <th>Matricula</th>
                        <th>DNI</th>
                        <th>marca</th>
                        <th>modelo</th>
                        <th>tipo</th>
                        <th>gama</th>
                        <th>Acciones</th>
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
                echo "<td> <div style='display:inline;'";
                if(isset($_SESSION['admin'])){
                    echo "<form style ='float: left; padding: 5px;' method='post'><button class='btn btn-primary' 
                        type='submit' id='borrador' name='borrador'
                        value='".$row["matricula"]."'>
                            Borrar
                    </button></form>";
                }
                echo "<form style='float: left; padding: 5px; padding-top:0px;' method='post'><button class='btn btn-primary' type='submit' id='vmodificar' name='vmodificar' value='".$row["matricula"]."'> Modificar </button></form></div></td>";
            }
            echo '</tr>';
            echo '</table>';  
        }
        public function load($dni) {
                    
            $result = $this->connection->prepare('SELECT * FROM vehiculos where dni_c = ?');
            $result->bindParam('1', $dni);
            $result->execute();
            echo    
                '<table class="table table-hover bg-light">
                    <tr>
                        <th>Matricula</th>
                        <th>DNI</th>
                        <th>marca</th>
                        <th>modelo</th>
                        <th>tipo</th>
                        <th>gama</th>
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
                    "<td><form method='post' class='mr-5'>";
                    if(isset($_SESSION['admin'])){
                        echo "<button class='btn btn-primary w-50 pr-3' 
                                type='submit' id='borrador' name='borrador'
                                value='".$row["matricula"]."'>
                                    Borrar
                        </button>";
                    }
                    echo "   <button class='btn btn-primary w-50 pr-3' 
                                type='submit' id='vmodificar' name='vmodificar'
                                value='".$row["matricula"]."'>
                                    Modificar
                        </button>
                    </form></td>";
            }
            echo '</tr>';
            echo '</table>';                
        }
        public function registrar($dni_c,$matricula,$marca,$modelo,$tipo,$gama) {
            //Se comprueba si existe el cliente
            $check =  $this->connection->prepare('SELECT dni FROM usuarios WHERE dni = ? AND tipo="Cliente"');
            $check->bindParam('1',$dni_c);
            $check->execute();

            $linea = $check->fetch(PDO::FETCH_ASSOC);

            if($linea>1) {
                //Existe por lo tanto preparamos la sentencia de insertar
                $result = $this->connection->prepare('INSERT INTO vehiculos (dni_c,matricula,marca,modelo,tipo,gama) values(?,?,?,?,?,?)');
                $result->bindParam('1', $dni_c);
                $result->bindParam('2', $matricula);
                $result->bindParam('3', $marca);
                $result->bindParam('4', $modelo);
                $result->bindParam('5', $tipo);
                $result->bindParam('6', $gama);
                //Se comprueba si existe el vehiculo en la base de datos
                $checkMatricula = $this->connection->prepare('SELECT matricula FROM vehiculos WHERE matricula = ?');
                $checkMatricula->bindParam('1',$matricula);
                $checkMatricula->execute();
                $linea2 = $checkMatricula->fetch(PDO::FETCH_ASSOC);
                if($linea2==0) {
                    //No existe el vehiculo-> Se registra el vehiculo en la base de datos
                    $result->execute();
                    echo '<div class="alert alert-success mt-2" role="alert">El vehiculo se ha añadido correctamente</div>';
                } else {
                    echo '<div class="alert alert-danger mt-2" role="alert">Ya existe un vehiculo con esa matricula</div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-2" role="alert">El dni no existe en la base de datos.</div>';
            }   
        }
        public function borrar($matricula){
            $result = $this->connection->prepare('DELETE FROM vehiculos where matricula=?');
            $result->bindParam('1', $matricula);
            if($result->execute()){
                echo "El vehiculo se ha borrado correctamente";
            } else {
                echo '<p class="p-3 mb-2 bg-light text-dark">El vehiculo no se ha eliminado por alguna razon<p>';
            }
            
        }
        public function verModificar($matricula) {
            $result = $this->connection->prepare('SELECT * FROM vehiculos WHERE matricula = ?');
            $result->bindParam('1', $matricula);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo '<div class="container mt-2 mb-2">
                    <div class="row pb-3">
                        <div class="col-12"></div>
                    </div>
                    <div class="container row pb-3 pt-3">
                        <div class="col-12 col-md-6 offset-md-3 border border-success rounded bg-light">
                            <form method="POST" name="">
                                <div class="form-group mb-2">
                                    <h1 class="text-center">Modificar datos del vehiculo</h1>
                                    <label for="dni">DNI*</label>
                                    <input value="'.$row["dni_c"].'" type="text" class="form-control" name="dni_c" id="dni_c" title="e.g 11111111N" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" required readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nombre">Matricula*</label> 
                                    <input value="'.$row["matricula"].'" type="text" name="matricula" id="matricula" class="form-control" title="e.g 0000FPZ" pattern="[0-9]{4}[A-Z]{3,4}" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nombre">Marca*</label> 
                                    <input value="'.$row["marca"].'" type="text" name="marca" id="marca" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[A-Za-z]{1,10}" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nombre">Modelo*</label> 
                                    <input value="'.$row["modelo"].'" type="text" name="modelo" id="modelo" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[A-Za-z]{1,10}" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nombre">Tipo*</label> 
                                    <input value="'.$row["tipo"].'" type="text" name="tipo" id="tipo" class="form-control" title="e.g Pepe Gonzales Morales" pattern="[A-Za-z]{1,10}" required>
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
                                <p> <input type="submit" class="btn btn-primary w-50 pr-3" name="modificarvehiculo" value="Modificar"></p>
                            </form>
                        </div>
                    </div>
                </div>';
            
        }
        public function modificar($matricula){
                    
            $dni_c = $_POST['dni_c'];
            $matricula = $_POST['matricula'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $tipo = $_POST['tipo'];
            $gama = $_POST['gama'];
            $result = $this->connection->prepare('UPDATE vehiculos SET dni_c = ?,matricula= ?,marca= ?,modelo= ?,tipo= ?,gama= ? where matricula = "'.$matricula.'"');
            $result->bindParam('1', $dni_c);
            $result->bindParam('2', $matricula);
            $result->bindParam('3', $marca);
            $result->bindParam('4', $modelo);
            $result->bindParam('5', $tipo);
            $result->bindParam('6', $gama);
            
            $check =  $this->connection->prepare('SELECT * from usuarios where dni = "'. $dni_c .'";');
            $check->execute();
            if ($check->rowCount() > 0){
                    if($result->execute()){
                        echo '<div class="alert alert-success mt-2" role="alert">
                            El vehiculo se ha modificado correctamente
                        </div>';
                    }
                    return null;
                
            } else {
                echo '<div class="alert alert-danger mt-2" role="alert">El dni no existe en la base de datos.</div>';
            }
            
        }
        public function findCliente() {
                    
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
                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="verclientevehiculobuscado">Ver</button>&nbsp';
            
                echo '</p>
              </form>';
                
            }

        public function VerInsertar() {

            echo '<div class="container">
            <form method="POST" name="">
                <div class="form-group mb-2">
                    <h1 class="text-center">Formulario</h1>
                    <label for="dni">DNI*</label>
                    <input type="text" class="form-control" name="dni" id="dni" minlength="9" maxlength="9" required>
                </div>
                <div class="form-group mb-2">
                    <label for="matricula">Matricula*</label>
                    <input type="text" class="form-control" name="matricula" id="matricula" minlength="7" maxlength="8" required>
                </div>
                <div class="form-group mb-2">
                    <label for="marca">Marca*</label>
                    <input type="text" class="form-control" name="marca" id="marca" maxlength="10" required>
                </div>
                <div class="form-group mb-2">
                    <label for="modelo">Modelo*</label>
                    <input type="text" class="form-control" name="modelo" id="modelo" maxlength="10" required>
                </div>
                <div class="form-group mb-2">
                    <label for="tipo">Tipo*</label></br>
                    <select class="select custom-select-sm col-12" name="tipo" >
                        <option>Coche</option>
                        <option>Moto</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="gama">Gama*</label></br>
                    <select class="select custom-select-sm col-12" name="gama">
                        <option>Baja</option>
                        <option>Media</option>
                        <option>Alta</option>
                    </select>
                </div>
                <p> <input type="submit" class="btn btn-primary w-100" name="registrarvehiculo" value="Registrar"></p>
            </form>
            </div>';

        }
    }

?>