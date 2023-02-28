<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="vendor/fontawesome-5.11.2/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="">
    
    <title>Inicio | Taller</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="http://localhost/ejer/objet/poo/cliente/index.php">Taller</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto text-center">
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/ejer/objet/poo/cliente/index.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="http://localhost/ejer/objet/poo/cliente/login.php">Iniciar Sesión</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    
    <div class="container mt-2 mb-2 bg-white">
      <div class="container row border-info pb-3 pt-3">
        <div class="col-12 col-md-6 offset-md-3 border border-success rounded bg-light">
          <?php
            require_once 'Conn.php';
            require_once 'class/ValidateLogin.php';
          ?>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="">
            <div class="form-group mb-2">
              <h1 class="text-center">Iniciar Sesión</h1>
              <label for="usuario">Usuario</label> 
              <input type='text' name='usuario' id="usuario" placeholder="" class="form-control" required>
            </div>
            <div class="form-group mb-2">
              <label for="password">Contraseña</label>
              <input type='password' class="form-control" name='password' id="password" required>
            </div>
            <p> <input type="submit" class="btn btn-primary w-100" name='submit' value="Iniciar Sesión"></p>
          </form>
          <?php
            if(isset($_POST['submit'])) {
              $log = new ValidateLogin();
              return $log->load($_POST["usuario"],$_POST["password"]);
            }
          ?>
        </div>
      </div>
    </div>

    <?php
      require_once 'footer.php';
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="vendor/jquery-3.3.1.slim.min.js"></script>
    <script src="vendor/popper.min.js"></script>
    <script src="vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
  </body>
</html>