    <header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="http://localhost/web2/cliente/cliente.php">Cliente</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item dropdown dropbottom">
              <a class="nav-link dropdown-toggle" href="#" id="navbarCatalogo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i> <span class="text-success"> <?php echo $cliente->getNombre() ?> </span>
              </a>
              <div class="dropdown-menu bg-dark" aria-labelledby="navbarCatalogo">
              <form method="post">
                <button type="submit" class="btn btn-dark col-12 mt-0 text-success text-left" name="miscochescliente" ><i class="fas fa-car"></i> Mis coches</button></br>
                <button type="submit" class="btn btn-dark col-12 mt-0 text-danger text-left" name="misdatoscliente" ><i class="fas fa-glasses"></i> Mis datos</button></br>
                <button type="submit" class="btn btn-dark col-12 mt-0 text-warning text-left" name="actualizarperfilcliente" ><i class="fas fa-user-edit"></i> Actualizar Perfil</button></br>
                <button type="submit" class="btn btn-dark col-12 mt-0 text-info text-left" name="verfacturasclientevista" ><i class="fas fa-clipboard"></i> Ver facturas</button></br>
              </form>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="../logout.php"><i class="fas fa-power-off"></i> Cerrar Sesión</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>