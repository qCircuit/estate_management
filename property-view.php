<?php

    session_start();
    if(!isset($_SESSION["user"])) header("location: login.php");

    $show_table="properties";
    $properties = include("database/show.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Resumen de la propiedad: Sistema de Gestion de Inmobiliaria</title>
    <?php include("partials/app-header-scripts.php") ?>
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include("partials/app-sidebar.php") ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include("partials/app-topnav.php") ?>
            <div class="dashboard_content">
            <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12" id="content">
                            <h1 class="section_header"><i class="fa fa-list"></i> Listar propiedades disponibles</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Imagen</th>
                                                <th>Nombre de la propiedad</th>
                                                <th>Descripcion</th>
                                                <th>Inquilino</th>
                                                <th>Creado Por</th>
                                                <th>Creado En</th>
                                                <th>Actualizado En</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($properties as $index => $property){ ?>
                                                <tr>
                                                    <td><?= $index+1 ?></td>
                                                    <td class="firstName">
                                                        <img class="propertyImages" src="uploads/property/<?= $property['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="lastName"><?= $property["property_name"] ?></td>
                                                    <td class="email"><?= $property["description"] ?></td>
                                                    <td class="email">
                                                        <?php
                                                            $tenant_list = "No tenant";

                                                            $pid = $property["id"];
                                                            $stmt = $conn->prepare("SELECT tenant_name FROM tenants, propertytenants WHERE propertytenants.property=$pid AND propertytenants.tenant = tenants.id");
                                                            $stmt->execute(); 
                                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            if($row) {
                                                                $tenant_arr = array_column($row, "tenant_name");
                                                                $tenant_list = "<li>" . implode("</li><li>", $tenant_arr);
                                                            }

                                                            echo $tenant_list;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $uid = $property["created_by"];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                            $stmt->execute(); 
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                            $created_by_name = $row["first_name"]." ".$row["last_name"];
                                                            echo $created_by_name;
                                                        ?>
                                                    
                                                    </td>
                                                    <td><?= date("M d,Y h:i:s A", strtotime($property["created_at"])) ?></td>
                                                    <td><?= date("M d,Y h:i:s A", strtotime($property["updated_at"])) ?></td>
                                                    <td>
                                                        <a href="" class="updateProperty" data-pid="<?= $property['id'] ?>"> <i class="fa fa-pencil"></i> Edit</a>
                                                        <a href="" class="deleteProperty" data-name="<?= $property['property_name'] ?>" data-pid="<?= $property['id'] ?>"><i class="fa fa-remove"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($properties) ?> unidades </p>
                                </div>
                            </div>
                        </div>
                        <button id="download-pdf">Descargar PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('download-pdf')
        .addEventListener('click', () => {
            const element = document.getElementById('content');
            const options = {
                filename: 'property.pdf',
                margin: 0,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { 
                    unit: 'in', 
                    format: 'a2', 
                    orientation: 'landscape' 
                }
            };
              
            html2pdf().set(options).from(element).save();
        });
    </script>

<?php 
    include("partials/app-scripts.php");

    $show_table = "tenants";
    $tenants = include("database/show.php");

    $tenants_arr = [];

    foreach($tenants as $tenant){
        
        $tenants_arr[$tenant["id"]] = $tenant["tenant_name"];

    }
    $tenants_arr = json_encode($tenants_arr);

?>

<script>
    var tenantsList = <?= $tenants_arr ?>;

    function script() {
        var vm = this;

        this.registerEvents = function() {
            document.addEventListener("click", function(e){
                targetElement = e.target;
                classList = targetElement.classList;

                if(classList.contains("deleteProperty")) {
                    e.preventDefault(); 

                    pId = targetElement.dataset.pid;
                    pName =targetElement.dataset.name;

                    BootstrapDialog.confirm({
                        type:BootstrapDialog.TYPE_DANGER,
                        title: "Delete Property",
                        message: "Confirm to delete <strong>"+pName+"</strong>?",
                        callback: function(isDelete){
                            if(isDelete) {
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        id: pId,
                                        table: "properties"
                                    },
                                    url: "database/delete.php",
                                    dataType: "json",
                                    success: function(data){
                                        message = data.success ? pName + " successfully deleted" : "Error while deleting";

                                        BootstrapDialog.alert({
                                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                            message: message,
                                            callback: function(){
                                                if(data.success) location.reload();
                                            }
                                        });                       
                                    }
                                });
                            }
                          
                        }
                    });
                }
                if(classList.contains("updateProperty")) {
                    e.preventDefault(); 

                    pId = targetElement.dataset.pid;
                    vm.showEditDialog(pId);

                }
                
            });

            document.addEventListener("submit", function(e) {
                e.preventDefault();
                targetElement = e.target;

                if(targetElement.id == "editPropertyForm") {
                    vm.saveUpdatedData(targetElement);
                }               
            }); 
        },

        this.saveUpdatedData = function(form) {

            $.ajax({
                method: "POST",
                data: new FormData(form),
                url: "database/update-property.php",
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data){
                    BootstrapDialog.alert({
                        type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                        message: data.message,
                    })


                    if(data.success) {
                        BootstrapDialog.alert({
                            type:BootstrapDialog.TYPE_SUCCESS,
                            message: data.message,
                            callback: function(){
                                location.reload();
                            }
                        });
                    } else BootstrapDialog.alert({
                            type:BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                        });                      
                }
            });
        },

        this.showEditDialog = function(id){
            $.get("database/get-property.php", {id: id}, function(propertyDetails){
                
                let curTenants = propertyDetails["tenants"];
                let tenantOption = "";

                for (const [tenantId,tenantName] of Object.entries(tenantsList)){
                    selected = curTenants.indexOf(tenantId) > -1 ? "selected" : "";
                    tenantOption += "<option "+selected+" value='"+tenantId+"'>"+tenantName+"</option>";
                }

                BootstrapDialog.confirm({
                    title: "Update <strong>" + propertyDetails.property_name + "</strong>",
                    message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editPropertyForm">\
                    <div class="appFormInputContainer">\
                        <label for="property_name">Property Name</label>\
                        <input type="text" class="appFormInput" id="property_name"\ name="property_name" value="'+propertyDetails.property_name +'" placeholder="Enter property name" />\
                    </div>\
                    <div class="appFormInputContainer">\
                        <label for="tenants">Tenants</label>\
                        <select name="tenants[]" id="tenantsSelect">\
                            <option>Select Tenant</option>\
                            ' + tenantOption + '\
                        </select>\
                    </div>\
                    <div class="appFormInputContainer">\
                        <label for="description">Description</label>\
                        <textarea class="appFormInput productTextAreaInput" id="description" name="description" placeholder="Enter property description">'+ propertyDetails.description +' </textarea>\
                    </div>\
                    <div class="appFormInputContainer">\
                        <label for="property_name">Property Image</label>\
                        <input type="file" name="img" />\
                    </div>\
                    <input type="hidden" name="pid" value ="'+propertyDetails.id+'" />\
                    <input type="submit" value="submit" id="editPropertySubmitBtn" class="hidden"/>\
                    </form>\
                    ',
                    callback: function(isUpdate){
                        if(isUpdate) {
                            document.getElementById("editPropertySubmitBtn").click();
                        }
                    }
                });
            }, "json");

        }

        this.initialize = function(){
            this.registerEvents();
        }
    }
    var script = new script;
    script.initialize();
</script>
</body>
</html>