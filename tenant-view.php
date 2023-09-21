<?php

    session_start();
    if(!isset($_SESSION["user"])) header("location: login.php");

    $show_table="tenants";
    $tenants = include("database/show.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Resumen de los inquilinos: Sistema de Gestion de Inmobiliaria</title>
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
                            <h1 class="section_header"><i class="fa fa-list"></i> Listar todos los Inquilinos</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nombre del inquilino</th>
                                                <th>Telefono del inquilino</th>
                                                <th>Email del inquilino</th>
                                                <th>Propiedad</th>
                                                <th>Creado Por</th>
                                                <th>Creado En</th>
                                                <th>Actualizado En</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tenants as $index => $tenant){ ?>
                                                <tr>
                                                    <td><?= $index+1 ?></td>
                                                    <td><?= $tenant["tenant_name"] ?></td>
                                                    <td><?= $tenant["tenant_phone"] ?></td>
                                                    <td><?= $tenant["tenant_email"] ?></td>
                                                    <td>
                                                        <?php
                                                            $property_list = "No property";

                                                            $tid = $tenant["id"];
                                                            $stmt = $conn->prepare("SELECT property_name FROM properties, propertytenants WHERE propertytenants.tenant=$tid AND propertytenants.property = properties.id");
                                                            $stmt->execute(); 
                                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                                            if($row) {
                                                                $property_arr = array_column($row, "property_name");
                                                                $property_list = "<li>" . implode("</li><li>", $property_arr);
                                                            }

                                                            echo $property_list;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $uid = $tenant["created_by"];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                            $stmt->execute(); 
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                            $created_by_name = $row["first_name"]." ".$row["last_name"];
                                                            echo $created_by_name;
                                                        ?>
                                                    
                                                    </td>
                                                    <td><?= date("M d,Y h:i:s A", strtotime($tenant["created_at"])) ?></td>
                                                    <td><?= date("M d,Y h:i:s A", strtotime($tenant["updated_at"])) ?></td>
                                                    <td>
                                                        <a href="" class="updateTenant" data-tid="<?= $tenant['id'] ?>"> <i class="fa fa-pencil"></i> Edit</a>
                                                        <a href="" class="deleteTenant" data-name="<?= $tenant['tenant_name'] ?>" data-tid="<?= $tenant['id'] ?>"><i class="fa fa-remove"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($tenants) ?> inquilinos </p>
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
                filename: 'tenants.pdf',
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

    $show_table = "properties";
    $properties = include("database/show.php");

    $properties_arr = [];

    foreach($properties as $property){
        
        $properties_arr[$property["id"]] = $property["property_name"];

    }
    $properties_arr = json_encode($properties_arr);

?>

<script>
    var propertiesList = <?= $properties_arr ?>;

    function script() {
        var vm = this;

        this.registerEvents = function() {
            document.addEventListener("click", function(e){
                targetElement = e.target;
                classList = targetElement.classList;

                if(classList.contains("deleteTenant")) {
                    e.preventDefault(); 

                    tid = targetElement.dataset.tid;
                    tenantName =targetElement.dataset.name;

                    BootstrapDialog.confirm({
                        type:BootstrapDialog.TYPE_DANGER,
                        title: "Delete Tenant",
                        message: "Confirm to delete <strong>"+tenantName+"</strong>?",
                        callback: function(isDelete){
                            if(isDelete) {
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        id: tid,
                                        table: "tenants"
                                    },
                                    url: "database/delete.php",
                                    dataType: "json",
                                    success: function(data){
                                        message = data.success ? tenantName + " successfully deleted" : "Error while deleting";

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
                if(classList.contains("updateTenant")) {
                    e.preventDefault(); 

                    tId = targetElement.dataset.tid;
                    vm.showEditDialog(tId);

                }
                
            });

            document.addEventListener("submit", function(e) {
                e.preventDefault();
                targetElement = e.target;

                if(targetElement.id == "editTenantForm") {
                    vm.saveUpdatedData(targetElement);
                }               
            }); 
        },

        this.saveUpdatedData = function(form) {

            $.ajax({
                method: "POST",
                data: {
                    tenant_name: document.getElementById("tenant_name").value,
                    tenant_phone: document.getElementById("tenant_phone").value,
                    tenant_email: document.getElementById("tenant_email").value,
                    properties: $("#properties").val(),
                    sid: document.getElementById("sid").value
                },
                url: "database/update-tenant.php",
                // processData: false,
                // contentType: false,
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
                    } else                                             BootstrapDialog.alert({
                            type:BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                        });                      
                }
            });
        },

        this.showEditDialog = function(id){
            $.get("database/get-tenant.php", {id: id}, function(tenantDetails){
                
                let curProperties = tenantDetails["properties"];
                let propertyOption = "";

                for (const [pId, pName] of Object.entries(propertiesList)){
                    selected = curProperties.indexOf(pId) > -1 ? "selected" : "";
                    propertyOption += "<option "+selected+" value='"+pId+"'>"+pName+"</option>";
                }

                BootstrapDialog.confirm({
                    title: "Update <strong>" + tenantDetails.tenant_name + "</strong>",
                    message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editTenantForm">\
                    <div class="appFormInputContainer">\
                        <label for="tenant_name">Tenant Name</label>\
                        <input type="text" class="appFormInput" id="tenant_name" value="'+tenantDetails.tenant_name+'" name="tenant_name" placeholder="Enter tenant name" />\
                    </div>\
                    <div class="appFormInputContainer">\
                        <label for="tenant_phone">Phone</label>\
                        <input type="text" class="appFormInput" id="tenant_phone" value="'+tenantDetails.tenant_phone+'" name="tenant_phone" placeholder="Enter tenant tenant_phone"></input>\
                    </div>\
                    <div class="appFormInputContainer">\
                        <label for="tenant_email">Email</label>\
                        <input type="text" class="appFormInput" id="tenant_email" value="'+tenantDetails.tenant_email+'" name="tenant_email" placeholder="Enter tenant email"></input>\
                    </div>\
                    <div class="appFormInputContainer">\
                        <label for="properties">Property</label>\
                        <select name="properties[]" id="properties">\
                            <option>Select property</option>\
                            ' + propertyOption + '\
                        </select>\
                    </div>\
                    <input type="hidden" name="sid" id="sid" value ="'+tenantDetails.id+'" />\
                    <input type="submit" value="submit" id="editTenantSubmitBtn" class="hidden"/>\
                    </form>\
                    ',
                    callback: function(isUpdate){
                        if(isUpdate) {
                            document.getElementById("editTenantSubmitBtn").click();
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