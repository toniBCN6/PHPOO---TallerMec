<?php 
  session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../imgs/factura.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="../vendor/fontawesome-5.11.2/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../vendor/styles.css">
    
    <title>Panel | Cliente</title>
  </head> 
  
  <?php 
      if (empty($_SESSION['cliente'])){
        header("Location:../login.php");
      } 
      else {
        require_once '../class/Conn.php';
        require_once '../class/ValidateLogin.php';      
        $cliente = new ValidateLogin();
        $cliente->cliente($_SESSION['cliente']);
        require_once 'menuCliente.php';
        require_once '../class/ClassReparar.php';
        require_once '../class/ClassVehic.php';
        require_once '../class/ClassClient.php';
        $client = new ClassClient();
        $vehiculo = new ClassVehic();
        $reparar = new ClassReparar();
  ?>

      <body>
        <div class="container-fluid bg-white">
          <div class="row">
            <div class="col-12">
              <?php         
                  if (empty($_POST)) {
                    echo '<div class="alert alert-primary m-2" role="alert">
                    Bienvenido,'.$cliente->getNombre().'
                  </div>';
                  }

                  if (isset($_POST['miscochescliente'])) {
                    $vehiculo->load($cliente->getDni());
                  }

                  if (isset($_POST['misdatoscliente'])) {
                    $client->showClient($cliente->getDni());
                  }

                  if (isset($_POST['actualizarperfilcliente'])) {
                    $client->verModificar($cliente->getDni());
                  }

                  if (isset($_POST['modificar'])) {
                    $client->modificar($_POST['nombre'],$_POST['telefono'],$_POST['dni']);
                  }

                  if (isset($_POST['verfacturasclientevista'])) {
                    $reparar->cargaFacturas($cliente->getDni());
                  }

                  if (isset($_POST['vmodificar'])) {
                    $vehiculo->verModificar($_POST['vmodificar']);
                  }

                  if (isset($_POST['modificarvehiculo'])) {
                    $vehiculo->modificar($_POST['matricula']);
                  }
              ?>
            </div>
          </div>
        </div>      
      </body>
    <!-- /Resto de código aqui/ -->
    <?php
      require_once '../footer.php';
    } //No borrar
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../vendor/jquery-3.3.1.slim.min.js"></script>
    <script src="../vendor/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
  </body>
</html>