<?php

    session_start();
    if(!isset($_SESSION["user"])) header("location: login.php");

    $_SESSION["table"] = "tenants";
    $_SESSION["redirect_to"] = "tenant-add.php";

    $user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Inquilino: Sistema de Gestion de Inmobiliaria</title>
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
                            <h1 class="section_header"><i class="fa fa-plus"></i> Agregar Inquilino</h1>                          
                            <div id="userAddFormContainer">
                                <form action="database/add.php" class="appForm" method="POST" enctype="multipart/form-data">
                                    <div class="appFormInputContainer">
                                        <label for="tenant_name">Nombre del inquilino</label>
                                        <input type="text" class="appFormInput" id="tenant_name" name="tenant_name" placeholder="Enter tenant name" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="tenant_phone">Telefono</label>
                                        <input type="text" class="appFormInput" id="tenant_phone" name="tenant_phone" placeholder="Enter tenant's tenant_phone"></input>
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="tenant_email">Email</label>
                                        <input type="text" class="appFormInput" id="tenant_email" name="tenant_email" placeholder="Enter tenant's email"></input>
                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"> Agregar Inquilino</i></button>
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