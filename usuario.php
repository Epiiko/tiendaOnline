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
        if ($_POST["action"] == "usuarios") {
            //----------------------------Usuario------------------------------------------- 
            $temp_usuario = $_POST["user"];
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
             //----------------------------Contraseña-------------------------------------------
            $temp_contrasena = $_POST["pass"];
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
             //----------------------------Nacimiento-------------------------------------------
            $temp_fechaNac = $_POST["date"];
            $fecha_actual = new DateTime();
            if (strlen(($temp_fechaNac)) <= 0) {
                $err_fechNac = "La fecha debe de estar rellena";
            } else {

                $temp_fechaNac2 = new DateTime($temp_fechaNac);
                $dif_fech = $fecha_actual->diff($temp_fechaNac2);
                if ($dif_fech->format("%y") < 12 || $dif_fech->format("%y") > 120) {
                    $err_fechNac = "La edad debe de comprender entre 12 y 120 años";
                } else {
                    $fecha_nacimiento = $temp_fechaNac;
                    echo $fecha_nacimiento;
                }
            }
             //----------------------------Si todo ok a bdd-------------------------------------------
            if (isset($usuario) && isset($contrasena) && isset($fecha_nacimiento)) {
                $sql = "INSERT INTO productos VALUES ('$usuario','$contrasena', '$fecha_nacimiento')";
                $conexion->query($sql);
            }
        }
    }
    ?>
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
                <input type="hidden" name="action" value="usuarios">
                <input type="submit" value="Usuarios">
            </form>
        </fieldset>
    </div>
</body>

</html>