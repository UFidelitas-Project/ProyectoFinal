
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <a href="index.php" class="navbar-brand">
    <!-- <img src="/examples/images/logo.svg" height="28" alt="CoolBrand"> -->
        Sistema Facturación
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="index.php" class="nav-item nav-link">Inicio</a>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuarios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="registro_usuario.php">Nuevo Usuario</a>
                    <a class="dropdown-item" href="lista_usuario.php">Lista de Usuarios</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Clientes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="registro_cliente.php">Nuevo Cliente</a>
                    <a class="dropdown-item" href="lista_cliente.php">Lista de Clientes</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Proveedores
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="registro_proveedor.php">Nuevo Proveedor</a>
                    <a class="dropdown-item" href="lista_proveedor.php">Lista de Proveedores</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Productos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="registro_producto.php">Nuevo Producto</a>
                    <a class="dropdown-item" href="lista_producto.php">Lista de Productos</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ventas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="nueva_venta.php">Nueva Ventas</a>
                    <a class="dropdown-item" href="lista_venta.php">Ventas</a>
                </div>
            </li>

        </div>
        <div class="navbar-nav ml-auto">
            <span class="nav-item nav-link"><?php echo $_SESSION['nombre'] ?></span>
            <a class="nav-item nav-link" href="salir.php">Salir</a>
        </div>
    </div>
</nav>



<!--<nav>
    <ul>
        <li><a href="#">Inicio</a></li>
        <li class="principal">
            <a href="#">Usuarios</a>
            <ul>
                <li><a href="registro_usuario.php">Nuevo Usuario</a></li>
                <li><a href="lista_usuario.php">Lista de Usuarios</a></li>
            </ul>
        </li>
        <li class="principal"> 
            <a href="#">Clientes</a>
            <ul>
                <li><a href="registro_cliente.php">Nuevo Cliente</a></li>
                <li><a href="lista_cliente.php">Lista de Clientes</a></li>
            </ul>
        </li>
        <li class="principal">
            <a href="#">Proveedores</a>
            <ul>
                <li><a href="registro_proveedor.php">Nuevo Proveedor</a></li>
                <li><a href="lista_proveedor.php">Lista de Proveedores</a></li>
            </ul>
        </li>
        <li class="principal">
            <a href="#">Productos</a>
            <ul>
                <li><a href="registro_producto.php">Nuevo Producto</a></li>
                <li><a href="lista_producto.php">Lista de Productos</a></li>
            </ul>
        </li>
        <li class="principal">
            <a href="#">Ventas</a>
            <ul>
                <li><a href="nueva_venta.php">Nueva venta</a></li>
                <li><a href="lista_venta.php">Ventas</a></li>
            </ul>
        </li>
    </ul>
</nav> -->