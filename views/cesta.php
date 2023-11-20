<?php
session_start();
$usuario = $_SESSION["usuario"];
if ($_SESSION["usuario"] == "invitado") {
    header("Location: logIn.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php require '../util/base_de_datos.php';
    require '../util/productoObj.php' ?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <video src="imgs/fondo.mp4" autoplay loop muted></video>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="principal.php"><img src="imgs/logo.png" alt="" height="40px">Good4Game</a>
            <a class="nav-item nav-link" href="logOut.php">LogOut</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </header>
    <main>
        <div class="container divTablas">
            <h1 class="mt-5" align="center">Cesta de <?php echo $usuario ?></h1>
            <table class="table table-dark table-hover mt-5">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    //primero sacamos el id de la cesta del usuario
                    $sqlCesta = "SELECT * FROM Cestas where usuario= '$usuario'";
                    $idCestaUsuario = $conexion->query($sqlCesta)->fetch_assoc()["idCesta"];
                    //miramos que productos estan en su cesta y que cantidad hay
                    $resCestasUsuarios = $conexion->query("SELECT * FROM productoscestas WHERE idCesta='$idCestaUsuario'");
                    //creamos un sumatorio para sacar el total
                    $total = 0;
                    //recorremos en busca de cada producto con el id de cesta de nuestro usuario y almacenamos el producto y la cantidad
                    while ($cestaUsuario = $resCestasUsuarios->fetch_assoc()) {
                        $idProducto = $cestaUsuario["idProducto"];
                        $cantidadProducto = $cestaUsuario["cantidad"];
                        //miramos en productos que productos hay con ese id
                        $resProductos = $conexion->query("SELECT * FROM productos WHERE idProducto = '$idProducto'");
                        //los recorremos si hay
                        if ($resProductos->num_rows > 0) {
                            while ($resProducto = $resProductos->fetch_assoc()) {
                                //si hay fila creamos un objeto producto para poder mostrar lo que nos interesa
                                $producto = new Producto($resProducto["idProducto"], $resProducto["nombreProductos"], $resProducto["precio"], $resProducto["descripcion"], $resProducto["cantidad"], $resProducto["imagen"]);
                                $total += $producto->precio * $cantidadProducto;
                    ?>
                                <tr>
                                    <td><?php echo $producto->nombreproductos ?></td>
                                    <td><img src="<?php echo $producto->rutaImagen ?>" alt="<?php echo $producto->nombreproductos ?>" width="50px"></td>
                                    <td><?php echo $producto->precio ?> €</td>
                                    <td><?php echo $cantidadProducto; ?></td>
                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <h5 class="bg-dark border p-3" style="width: 21%;"><?php echo "Total de la cesta: " . $total . " €" ?></h5>
        </div>
    </main>
</body>

</html>