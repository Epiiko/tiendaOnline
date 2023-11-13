<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php require 'funciones/base_de_datos.php' ?>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Good4Pay</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">

                    <?php
                    session_start();
                    if ($_SESSION["usuario"] == "invitado") {
                    ?>
                        <a class="nav-item nav-link" href="formularios/usuario.php">Registrarse</a>
                        <a class="nav-item nav-link active" href="registros/logIn.php">LogIn</a>

                    <?php
                    } else {
                    ?>
                        <a class="nav-item nav-link" href="registros/logOut.php">LogOut</a>
                        <?php
                        if ($_SESSION["rol"] == "admin") { ?>
                            <a class="nav-item nav-link" href="formularios/producto.php">Añadir producto</a>
                    <?php }
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <?php
    $usuario = $_SESSION["usuario"];
    ?>
    <div class="container">
        <h1>Pagina Principal</h1>
        <h2>Bienvenid@ <?php echo $usuario ?></h2>
    </div>

    <?php
    if ($_SESSION["usuario"] != "invitado") {
    ?>
        <div class="container mt-5">
            <h1>Tabla productos</h1>
            <table class="table table-hover table-dark">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripcion</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM productos";
                    $res = $conexion->query($sql);
                    while ($fila = $res->fetch_assoc()) { ?>
                    <tr>
                    <td> <?php echo $fila["idProducto"]?> </td>
                    <td> <?php echo $fila["nombreProductos"]?> </td>
                    <td> <?php echo $fila["precio"]?> </td>
                    <td> <?php echo $fila["cantidad"]?> </td>
                    ?> <td>
                            <img src="<?php $img = explode("/", $fila["imagen"]);
                                        echo $img[1] . "/" . $img[2] ?>" alt="<?php $img = explode("/", $fila["imagen"]);
                                                                                echo $img[1] . "/" . $img[2] ?>" height="50px">
                        </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    <?php
    }

    ?>

</body>

</html>