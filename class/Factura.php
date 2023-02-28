<?php

    class Factura extends Conn {

        public function __construct() {
            parent::__construct();
        }

        public function FacturaExtendida($id) {
            $datos = $this->connection->prepare('SELECT id,reparar.matricula as matriculareparar,fechaSalida,coste,aceite,motor,ventanas,ruedas,usuarios.nombre as nombrecliente,usuarios.dni as dnicliente,usuarios.telefono as telefonocliente,vehiculos.dni_c as dnipropietario,vehiculos.matricula as matriculavehiculo ,vehiculos.marca as marcavehiculo, vehiculos.modelo as modelovehiculo FROM reparar JOIN vehiculos ON reparar.matricula = vehiculos.matricula JOIN usuarios ON vehiculos.dni_c = usuarios.dni where id='.$id);
            $datos->execute();
            $row = $datos->fetch(PDO::FETCH_BOTH);

            echo '<td>'.$row['nombrecliente'].'<br>'.$row['dnicliente'].'<br>'.$row['telefonocliente'].'</td></tr></table><span>Vehiculo: '.$row['marcavehiculo'].'   
            '.$row['modelovehiculo'].'</span><span style="float:right;">Matricula: '.$row['matriculareparar'].'</span></td></tr><tr class="heading"><td>Reparacion</td>
            <td>Precio</td></tr>';

            if ($row['aceite'] != 0) {
                echo '<tr class="item"><td>Aceite</td><td>'.$row['aceite'].'€</td></tr>';
            }

            if ($row['motor'] != 0) {
                echo '<tr class="item"><td>Motor</td><td>'.$row['motor'].'€</td></tr>';
            }

            if ($row['ventanas'] != 0) {
                echo '<tr class="item"><td>Ventana</td><td>'.$row['ventanas'].'€</td></tr>';
            }

            if ($row['ruedas'] != 0) {
                echo '<tr class="item"><td>Ruedas</td><td>'.$row['ruedas'].'€</td></tr>';
            }

            echo '<tr class="total"><td></td><td>Total: '.$row['coste'].'€</td></tr>';

        }
    }

?>