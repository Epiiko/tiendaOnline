<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php require 'base_de_datos.php' ?>

</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
    } else {
        header("Location: iniciar_sesion.php");
        // $_SESSION["usuario"] = "invitado";
        // $usuario = $_SESSION["usuario"];
    }
    ?>
    <div class="container">
        <h1>Pagina Principal</h1>
        <h2>Bienvenid@ <?php echo $usuario ?></h2>
    </div>
    <h1 class="mt-3">PRODUCTOs</h1>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM productos";
            $res = $conexion->query($sql);
            while ($fila = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila["idProducto"] . "</td>
                    <td>" . $fila["nombreProductos"] . "</td>
                    <td>" . $fila["precio"] . " €</td>
                    <td>" . $fila["descripcion"] . "</td>
                    <td>" . $fila["cantidad"] . "</td>"
            ?>
                <td><img src="<?= $fila["rutaImagen"] ?>" alt="" height="50px"></td>
            <?php
            }
            ?>

        </tbody>
    </table>
</body>

</html>