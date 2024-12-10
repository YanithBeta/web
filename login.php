<?php


session_start();

// Contador de errores
if (!isset($_SESSION['error_count'])) {
    $_SESSION['error_count'] = 0;
}

// Usuario y contraseña válidos
$valid_user = "Yanet";
$valid_password = "Yanet_123";

// Lista de imágenes CAPTCHA
$captcha_images = ['8LW1UST','atM13T','WRiZ8AL'];

// Selección de CAPTCHA aleatoria sin repetirse constantemente
if (!isset($_SESSION['captcha_image'])) {
    $random_key = array_rand($captcha_images);
    $_SESSION['captcha_image'] = $captcha_images[$random_key];
    print_r($_SESSION['captcha_image']);
}

// Función para validar la contraseña
function validate_password($password)
{
    $errors = [];
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Debe contener al menos una letra mayúscula.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Debe contener al menos un número.";
    }
    if (!preg_match('/[\W#$%^&*()_-]/', $password)) {
        $errors[] = "Debe contener al menos un carácter especial.";
    }
    return $errors;
}

// Validar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];



    $password_errors = validate_password($password);

    // Verificar si los datos son correctos
    if ($user == $valid_user && $password == $valid_password && $captcha == $_SESSION['captcha_image'] && empty($password_errors)) {
        $_SESSION['error_count'] = 0; // Restablecer el contador de errores en caso de éxito
        header('Location: menu.php'); // Redirigir al menú
        exit();
    
    
    
     // Restablecer el contador de errores en caso de éxito
    } else {
        $_SESSION['error_count']++;

        // Mostrar errores de contraseña si existen
        if (!empty($password_errors)) {
            foreach ($password_errors as $error) {
                echo "<p>$error</p>";
            }
        }

        // Verificar si el CAPTCHA es incorrecto
        if ($captcha != $_SESSION['captcha_image']) {
            echo "<p>CAPTCHA incorrecto.</p>";
        }

        // Verificar si el nombre de usuario o contraseña son incorrectos
        if ($user != $valid_user || $password != $valid_password) {
            echo "<p>Nombre de usuario o contraseña incorrectos.</p>";
        }

        // Verificar si se alcanzaron 3 errores
        if ($_SESSION['error_count'] >= 3) {
            echo "<script>window.close();</script>";
            exit();
        }

        // Regenerar un nuevo CAPTCHA en caso de error
        $random_key = array_rand($captcha_images);
        $_SESSION['captcha_image'] = $captcha_images[$random_key];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>

<body style= background-color:#FCE7D8>
    
    <div class="container mt-5 ">
        <div class="row justify-content-center ">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuario:</label>
                                <input type="text" id="user" name="user" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="captcha" class="form-label">CAPTCHA:</label><br>
                                <img src="image/<?php echo $_SESSION['captcha_image']; ?>.png" alt="CAPTCHA" class="img-fluid"><br><br>
                                <input type="text" id="captcha" name="captcha" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-secundary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>

</html>