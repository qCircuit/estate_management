<?php
    // Aquí compruebo si un usuario ya ha iniciado sesión. En ese caso, los redirijo a la página "dashboard.php".
    session_start();
    if(isset($_SESSION['user'])) header("location: dashboard.php");

    $error_message = '';
    
    if($_POST) { // cuando se envía el formulario
        include("database/connection.php"); // establece una conexión a una base de datosutilizando la biblioteca PDO

        // Recupero los valores enviados a través del formulario
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $query = 'SELECT * FROM users WHERE users.email="'. $username .'" AND users.password="'. $password .'"';
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetchAll()[0];
            $_SESSION['user'] = $user;

            // el usuario se redirige a "dashboard.php”
            header("Location: dashboard.php");
        } else $error_message = 'Invalid username or password';    
    }
?>

<!-- La parte HTML del código define la estructura de la página de inicio de sesión. 
Incluye un formulario con campos para el nombre de usuario y la contraseña. -->

<!DOCTYPE html>
<html>
<head>
    <title>REMS login - Real Estate Management System</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body id="loginBody">
    <?php if(!empty($error_message)) { ?>
        <div id="errorMessage">
            <strong>Error:</strong> <p><?= $error_message ?> </p>
        </div>
    <?php } ?>

    <div class="container">
        <div class="loginHeader">
            <h1>REMS</h1>
            <h3>Real Estate Management System</h3>
        </div>
        <div class="loginBody">
            <form action="login.php" method="POST">
                <div class="loginInputsContainer">
                    <label for="">Username</label>
                    <input type="text" name="username" placeholder="username" />
                </div>
                <div class="loginInputsContainer">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="password" />
                </div>
                <div class="loginButtonContainer">
                    <button>login</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>