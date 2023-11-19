<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php require '../util/base_de_datos.php';
    require '../util/productoObj.php'; ?>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <video src="imgs/fondo.mp4" autoplay loop muted></video>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="principal.php"><img src="imgs/logo.png" alt="" height="40px">Good4Game</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <?php
                    session_start();
                    $usuario = $_SESSION["usuario"];
                    ?>
                    <a class="nav-item nav-link" href="#">Bienvenid@ <?php echo $usuario ?></a>
                    <?php

                    //comprobamos si usuario esta vacio si es asi lo iniciamos como invitado
                    if ($_SESSION["usuario"] == '') {
                        $_SESSION["usuario"] = "invitado";
                        $_SESSION["rol"] = "cliente";
                    }
                    //si es invitado solo se muestra el primer bloque del if
                    if ($_SESSION["usuario"] == "invitado") {
                    ?>

                        <a class="nav-item nav-link" href="usuario.php">Registrarse</a>
                        <a class="nav-item nav-link active" href="logIn.php">LogIn</a>

                    <?php
                    } else {
                    ?>
                        <a class="nav-item nav-link" href="cesta.php">Cesta</a>
                        <?php
                        //si no es cliente y es admin muestra mas cosas
                        if ($_SESSION["rol"] == "admin") { ?>
                            <a class="nav-item nav-link" href="producto.php">Añadir producto</a>
                        <?php } ?>
                        <a class="nav-item nav-link" href="logOut.php">LogOut</a>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </nav>
    </header>
    <?php

    ?>
    <div class="container" align="center">
        <h1 class="mt-3"><img src="imgs/logo.png" alt="" height="70px">Good4Game</h1>
    </div>
    <div class="container mt-5">
        <?php if ($usuario != "invitado") {
        ?>
            <h1 align="center">Tabla productos</h1>
            <table class="table table-hover table-dark ">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripcion</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Añadir producto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM productos";
                    $res = $conexion->query($sql);
                    while ($fila = $res->fetch_assoc()) { ?>
                        <?php
                        //creamos un producto con los campos de la tabla recorriendola con fetchassoc()
                        $producto = new Producto($fila["idProducto"], $fila["nombreProductos"], $fila["precio"], $fila["descripcion"], $fila["cantidad"], $fila["imagen"]);
                        ?>
                        <tr>
                            <td><?php echo $producto->idProducto ?></td>
                            <td><?php echo $producto->nombreproductos ?></td>
                            <td><?php echo $producto->precio ?></td>
                            <td><?php echo $producto->descripcion ?></td>
                            <td><?php echo $producto->cantidad ?></td>
                            <td><img src="<?php echo $producto->rutaImagen ?>" alt="<?php echo $producto->nombreproductos ?>" width="50px"></td>
                            <?php
                            // if (intval($producto->cantidad) <= 0) {
                            ?>
                            <td>
                                <form action="" method="POST">
                                    <!-- pasamos los valores con botones hidden -->
                                    <input type="hidden" name="idProducto" value="<?php echo $producto->idProducto ?>">
                                    <input type="hidden" name="stockProducto" value="<?php echo $producto->cantidad ?>">
                                    <input type="submit" name="action" value="Añadir" class="btn btn-light">

                                    <select name="unidades" id="" max=5>
                                        <?php
                                        for ($i = 1; $i <= intval($producto->cantidad); $i++) {
                                        ?>
                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </form>
                            </td>
                            <?php
                            // } else {
                            ?>
                            <!-- <td>Producto fuera de stock</td> -->
                            <?php
                            // }
                            ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
    <?php

        }else{
            ?>
            <div class="container" align="center">
                <h1>Bienvenido a <img src="imgs/logo.png" alt="" height="50px">Good4Game</h1>
                <p>Para poder disfrutar de nuestra variedad de productos y servicios debe de ser usuario registrado de nuestra pagina</p>
                <p>puede o bien <a href="usuario.php">registrarse</a> o bien <a href="logIn.php">iniciar sesion</a> como usuario de nuestra web</p>
            </div>
            <?php
        }
        //si se pulsa el boton añadir añadimos una vez el producto en la cesta con la cantidad indicada en el select;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["action"] == "Añadir") {
                $usuario = $_SESSION["usuario"];
                $idProducto = $_POST["idProducto"];
                $unidades = $_POST["unidades"];
                //sacamos el id de la cesta del usuario en sesion
                $sqlCesta = "SELECT * FROM Cestas where usuario= '$usuario'";
                $idCestaUsuario = $conexion->query($sqlCesta)->fetch_assoc()["idCesta"];
                //comprobamos que en la base de datos no haya ese producto ya en esa cesta
                $res = $conexion->query("SELECT * FROM productoscestas");
                $existe = false;
                while ($fila = $res->fetch_assoc()) {
                    //en caso de encontrarlo existe pasa a ser true y no lo añadimos a la bdd si no lo modificamos
                    if ($fila["idCesta"] == $idCestaUsuario && $fila["idProducto"] == $idProducto) {
                        $conexion->query("UPDATE productoscestas SET cantidad = '$unidades' WHERE (idProducto = '$idProducto') and (idCesta = '$idCestaUsuario');");
                        //levantamos flag
                        $existe = true;
    ?>
                <div class="alert alert-warning container">Cantidad modificada en el carrito</div>
            <?php
                    }
                }
                //si no existe el producto en la cesta, en la tabla productosCestas introducimos los valores de idProducto e idCesta y la cantidad a añadir.
                if (!$existe) {
                    $sqlProductoCesta = "INSERT INTO productoscestas (idProducto , idCesta, cantidad) values ('$idProducto' , '$idCestaUsuario', '$unidades')";
                    $conexion->query($sqlProductoCesta);
            ?>
            <div class="alert alert-success container">Producto introducido en la cesta</div>
<?php
                }
            }
        }
?>
</body>

</html>