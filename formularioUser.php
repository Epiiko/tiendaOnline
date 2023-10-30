<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>


<body>
    <?php
    if (($_SERVER["REQUEST_METHOD"]) == "POST") {
        if ($_POST["action"] == "productos") {
            $nombre_producto = $_POST["name"];
            $precio_producto = (float)$_POST["price"];
            $descripcion_producto = $_POST["description"];
            $stock_producto = $_POST["stock"];
            $patern_nombre = "/^[a-zA-Z0-9 ]+$/";
            if (strlen($nombre_producto) <= 0) {
                $err_producto = "El campo de nombre debe de estar relleno";
            } else {
                if (strlen($nombre_producto) > 40) {
                    $err_producto = "El nombre debe de tener menos de 40 caracteres";
                } else {
                    if (!preg_match($patern_nombre, $nombre_producto)) {
                        $err_producto = "El nombre solo puede tener caracteres y espacios en blanco";
                    } else {
                        $nombre = $nombre_producto;
                        $nombre = ucfirst($nombre);
                        echo $nombre;
                    }
                }
            }
        }
    }
    ?>
    <div class="form-group">
        <fieldset>
            <legend>Productos</legend>
            <form action="" method="POST">
                <label for="name">Nombre</label>
                <input type="text" name="name">
                <?php
                if (isset($err_producto)) {
                    echo "$err_producto";
                }
                ?>
                <label for="name">Precio</label>
                <input type="text" name="price">
                <label for="name">Descripcion</label>
                <input type="text" name="description">
                <label for="stock">Stock</label>
                <input type="text" name="stock">
                <input type="hidden" name="action" value="productos">
                <input type="submit" value="productos">

            </form>

        </fieldset>
    </div>
</body>

</html>