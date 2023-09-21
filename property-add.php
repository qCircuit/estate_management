<?php

    session_start();
    if(!isset($_SESSION["user"])) header("location: login.php");

    $_SESSION["table"] = "properties";
    $_SESSION["redirect_to"] = "property-add.php";

    $user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Propiedad Agregar: Sistema de Gestion de Inmobiliaria</title>
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
                            <h1 class="section_header"><i class="fa fa-plus"></i> Agregar Propiedad</h1>                          
                            <div id="userAddFormContainer">
                                <form action="database/add.php" class="appForm" method="POST" enctype="multipart/form-data">
                                    <div class="appFormInputContainer">
                                        <label for="property_name">Nombre de la propiedad</label>
                                        <input type="text" class="appFormInput" id="property_name" name="property_name" placeholder="Enter property name" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="description">Descripcion</label>
                                        <textarea class="appFormInput productTextAreaInput" id="description" name="description" placeholder="Enter property description"></textarea>
                                        </textarea>
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="tenants">Inquilinos</label>
                                        <select name="tenants[]" id="tenantsSelect">
                                            <option>Selecciona inquilino</option>
                                            <?php
                                                $show_table = "tenants";
                                                $tenants = include("database/show.php");
                                                foreach($tenants as $tenant){
                                                    echo "<option value='" . $tenant["id"] . "'>" . $tenant['tenant_name'] . "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="property_name">Imagen de la propiedad</label>
                                        <input type="file" name="img" />
                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa fa-plus"> Agregar Propiedad</i></button>
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