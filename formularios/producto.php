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
    <?php // ----------------------------Validacion Producto -------------------
    function depurar($entrada)
    {
        $salida = htmlspecialchars($entrada);
        $salida = trim($salida);
        return $salida;
    }
    if (($_SERVER["REQUEST_METHOD"]) == "POST") {
        if ($_POST["action"] == "productos") {
            //---------------------------Nombre--------------------------------
            $nombre_producto = depurar($_POST["name"]);
            $patern_nombre = "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñ ]+$/";
            if (strlen($nombre_producto) <= 0) {
                $err_producto_nombre = "El campo de nombre debe de estar relleno";
            } else {
                if (strlen($nombre_producto) > 40) {
                    $err_producto_nombre = "El nombre debe de tener menos de 40 caracteres";
                } else {
                    if (!preg_match($patern_nombre, $nombre_producto)) {
                        $err_producto_nombre = "El nombre solo puede tener caracteres y espacios en blanco";
                    } else {
                        $nombre = $nombre_producto;
                        $nombre = ucfirst($nombre);
                        echo $nombre;
                    }
                }
            }
            //----------------------------Precio-------------------------------------------
            $precio_producto = depurar((float)$_POST["price"]);
            if ($precio_producto == 0) {
                $err_producto_precio = "El precio debe de estar relleno con numeros";
            } else {
                if ($precio_producto > 99999.99 || $precio_producto < 0) {
                    $err_producto_precio = "El precio debe de estar entre 0,1 € y 99999,99 €";
                } else {
                    if (!is_numeric($precio_producto)) {
                        $err_producto_precio = "Deja de intentar cositas";
                    } else {
                        $precio = $precio_producto;
                        echo "<br>" . $precio . " €";
                    }
                }
            }
            //----------------------------Descripcion-------------------------------------------
            $descripcion_producto = depurar($_POST["description"]);
            if (strlen($descripcion_producto) <= 0) {
                $err_producto_descripcion = "La descripcion debe de estar rellena";
            } else {
                if (strlen($descripcion_producto) > 255) {
                    $err_producto_descripcion = "La descripcion no puede tener mas de 255 caracteres";
                } else {
                    if (!preg_match($patern_nombre, $descripcion_producto)) {
                        $err_producto_descripcion = "¿Que intentas?";
                    } else {
                        $descripcion = $descripcion_producto;
                        $descripcion = ucfirst($descripcion);
                        echo "<br>" . $descripcion;
                    }
                }
            }
            //----------------------------Cantidad-------------------------------------------
            $cantidad_producto = depurar($_POST["cantidad"]);
            if (strlen($cantidad_producto) <= 0) {
                $err_producto_cantidad = "Minimo debe de añadirse un producto";
            } else {
                if (((int)($cantidad_producto)) > 10) {
                    $err_producto_cantidad = "No puedes introducir más de 10 productos";
                } else {
                    if (!is_numeric($cantidad_producto)) {
                        $err_producto_cantidad = "Deja de intentar cositas";
                    } else {
                        $cantidad = $cantidad_producto;
                        echo "<br>" . $cantidad;
                    }
                }
            }
            // -----------------------------------Foto---------------------------------
            $ruta_imagen = $_FILES["imagen"]["tmp_name"];
            $nombre_imagen = $_FILES["imagen"]["name"];
            if (strlen($ruta_imagen) > 0) {
                $ruta_final = "./imgs/" . $nombre_imagen;
                echo "imagen clonada";
                move_uploaded_file($ruta_imagen, $ruta_final);
            } else {
                $err_imagen = "No se ha subido una foto de producto";
            }
            //----------------------------si todo ok a bdd---------------------------------
            if (isset($nombre) && isset($precio) && isset($descripcion) && isset($cantidad) && isset($ruta_final)) {
                require '../funciones/base_de_datos.php';
                $sql = "INSERT INTO productos VALUES ('$nombre','$precio', '$descripcion', '$cantidad','$ruta_final')";
                $conexion->query($sql);
            }
        }
    }
    ?>
    <!----------------------------Formulario Producto------------------------->
    <div class="form-group">
        <fieldset class="container form-group">
            <legend>Productos</legend>
            <form action="" method="POST" class="form-group" enctype="multipart/form-data">
                <label for="name">Nombre</label>
                <input type="text" name="name">
                <?php
                if (isset($err_producto_nombre)) {
                    echo "$err_producto_nombre";
                } else {
                }
                ?>
                <br><br>
                <label for="name">Precio</label>
                <input type="text" name="price">
                <?php
                if (isset($err_producto_precio)) {
                    echo "$err_producto_precio";
                }
                ?>
                <br><br>
                <label for="name">Descripcion</label>
                <input type="text" name="description">
                <?php
                if (isset($err_producto_descripcion)) {
                    echo "$err_producto_descripcion";
                }
                ?>
                <br><br>
                <label for="cantidad">cantidad</label>
                <input type="text" name="cantidad">

                <?php
                if (isset($err_producto_cantidad)) {
                    echo "$err_producto_cantidad";
                }
                ?>
                <br><br>
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
                <br><br>
                <?php
                if (isset($err_imagen)) {
                    echo "$err_imagen";
                }
                ?>
                <br><br>
                <input type="hidden" name="action" value="productos">
                <input type="submit" value="Productos">
            </form>
        </fieldset>
    </div>

</body>

</html>