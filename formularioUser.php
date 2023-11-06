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
        // ----------------------------Validacion Producto -------------------
        if ($_POST["action"] == "productos") {
            $nombre_producto = $_POST["name"];
            $precio_producto = (float)$_POST["price"];
            $descripcion_producto = $_POST["description"];
            $stock_producto = $_POST["stock"];

            $patern_nombre = "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñ ]+$/";
            $patern_precio = "/^[0-9\\.]+$/";
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
            if ($precio_producto == 0) {
                $err_producto_precio = "El precio debe de estar relleno con numeros";
            } else {
                if ($precio_producto > 99999.99 || $precio_producto < 0) {
                    $err_producto_precio = "El precio debe de estar entre 0,1 € y 99999,99 €";
                } else {
                    if (preg_match($patern_precio, $precio_producto)) {
                        $err_producto_precio = "Deja de intentar cositas";
                    } else {
                        $precio = $precio_producto;
                        echo "<br>" . $precio . " €";
                    }
                }
            }
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
            if (strlen($stock_producto) <= 0) {
                $err_producto_stock = "Minimo debe de añadirse un producto";
            } else {
                if (((int)($stock_producto)) > 10) {
                    $err_producto_stock = "No puedes introducir más de 10 productos";
                } else {
                    if (preg_match($patern_precio, $stock_producto)) {
                        $err_producto_stock = "Deja de intentar cositas";
                    } else {
                        $stock = $stock_producto;
                        echo "<br>" . $stock;
                    }
                }
            }
        }
        // ----------------------------Validacion usuario -------------------
        if (($_SERVER["REQUEST_METHOD"]) == "POST") {
            if ($_POST["action"] == "usuarios") {
                $temp_usuario = $_POST["user"];
                $temp_contrasena = $_POST["pass"];
                $temp_fechaNac = $_POST["date"];
                $fecha_actual = new DateTime();
                $patern_usuario = "/^[a-zA-Z_]+$/";

                if (strlen($temp_usuario) <= 0) {
                    $err_usuario = "El nombre debe de estar relleno";
                } else {
                    if (strlen($temp_usuario) > 12) {
                        $err_usuario = "El nombre no puede ser mas largo a 12";
                    } else {
                        if (!preg_match($patern_usuario, $temp_usuario)) {
                            $err_usuario = "El nombre solo puede tener caracteres simples y barra baja";
                        } else {
                            $usuario = $temp_usuario;
                            $usuario = ucfirst($usuario);
                            echo $usuario . "<br><br>";
                        }
                    }
                }
                if (strlen($temp_contrasena) <= 0) {
                    $err_contrasena = "La contraseña es obligatoria";
                } else {
                    if (strlen($temp_contrasena) > 255) {
                        $err_contrasena = "La contraseña debe de ser menos de 255 caracteres";
                    } else {

                        $contrasena = password_hash($temp_contrasena, PASSWORD_DEFAULT);
                        echo $temp_contrasena . "<br> Hash: " . $contrasena;
                    }
                }
                if (strlen(($temp_fechaNac)) <= 0) {
                    $err_fechNac = "La fecha debe de estar rellena";
                } else {
                    
                    $temp_fechaNac2=new DateTime($temp_fechaNac);
                    $dif_fech=$fecha_actual->diff($temp_fechaNac2);
                    if($dif_fech->format("%y")<12 ||$dif_fech->format("%y")>120  ){
                        $err_fechNac="La edad debe de comprender entre 12 y 120 años";
                    }else{
                        $fecha_nacimiento=$temp_fechaNac;
                        echo $fecha_nacimiento;
                    }
                }
            }
        }
    }
    ?>
    <!-- ---------------------------Formulario Producto------------------------->
    <div class="form-group">
        <fieldset class="container form-group">
            <legend>Productos</legend>
            <form action="" method="POST" class="form-group">
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
                <label for="stock">Stock</label>
                <input type="text" name="stock">

                <?php
                if (isset($err_producto_descripcion)) {
                    echo "$err_producto_descripcion";
                }
                ?>
                <br><br>
                <input type="hidden" name="action" value="productos">
                <input type="submit" value="Productos">

            </form>

        </fieldset>
    </div>
    <!----------------------------Formulario usuario--------------------->
    <div class="form-group mt-5">
        <fieldset class="container form-group">
            <legend>usuario</legend>
            <form action="" method="POST" class="form-group">
                <label for="name">Ususario</label>
                <input type="text" name="user">
                <?php
                if (isset($err_usuario)) {
                    echo "$err_usuario";
                } else {
                }
                ?>
                <br><br>
                <label for="name">contrasena</label>
                <input type="text" name="pass">
                <?php
                if (isset($err_contrasena)) {
                    echo "$err_contrasena";
                }
                ?>
                <br><br>
                <label for="name">fechaNacimiento</label>
                <input type="date" name="date">
                <?php
                if (isset($err_fechNac)) {
                    echo "$err_fechNac";
                }
                ?>
                <br><br>
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
                <br><br>
                <input type="hidden" name="action" value="usuarios">
                <input type="submit" value="Usuarios">
            </form>
        </fieldset>
    </div>
</body>

</html>