<?php

    session_start();
    if(!isset($_SESSION["user"])) header("location: login.php");
    
    $_SESSION["table"] = "users";
    $_SESSION["redirect_to"] = "users-add.php";

    $show_table = "users";
    $users = include("database/show.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Usuarios Agregar: Sistema de Gestion de Inmobiliaria</title>
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <?php include("partials/app-header-scripts.php") ?>
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include("partials/app-sidebar.php") ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include("partials/app-topnav.php") ?>
            <div class="dashboard_content">
            <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-plus"></i> Agregar Usuario</h1>                          
                            <div id="userAddFormContainer">
                                <form action="database/add.php" class="appForm" method="POST">
                                    <div class="appFormInputContainer">
                                        <label for="first_name">Nombre</label>
                                        <input type="text" class="appFormInput" id="first_name" name="first_name" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="last_name">Apellido</label>
                                        <input type="text" class="appFormInput" id="last_name" name="last_name" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" class="appFormInput" id="email" name="email" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="password">Contrasena</label>
                                        <input type="password" class="appFormInput" id="password" name="password" />
                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"> Agregar Usuario</i></button>
                                </form>
                                <?php
                                    if(isset($_SESSION["response"])){
                                        $response_message = $_SESSION["response"]["message"];
                                        $is_success = $_SESSION["response"]["success"];
                                ?>
                                    <div class="responseMessage">
                                        <p class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>" ><?= $response_message ?>
                                        </p>
                                    </div>
                                <?php unset($_SESSION["response"]); } ?>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("partials/app-scripts.php") ?>

</body>
</html>