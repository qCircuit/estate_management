<?php

    session_start();
    if(!isset($_SESSION["user"])) header("location: login.php");
    $_SESSION["table"] = "users";
    $user = $_SESSION["user"];

    $show_table = "users";
    $users = include("database/show.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Usuarios Listado: Sistema de Gestion de Inmobiliaria</title>
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
                            <h1 class="section_header"><i class="fa fa-list"></i> Listar Todos los Usuarios</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Email</th>
                                                <th>Creado En</th>
                                                <th>Atualizado En</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($users as $index => $user){ ?>
                                                <tr>
                                                    <td><?= $index+1 ?></td>
                                                    <td class="firstName"><?= $user["first_name"] ?></td>
                                                    <td class="lastName"><?= $user["last_name"] ?></td>
                                                    <td class="email"><?= $user["email"] ?></td>
                                                    <td><?= date("M d,Y h:i:s A", strtotime($user["created_at"])) ?></td>
                                                    <td><?= date("M d,Y h:i:s A", strtotime($user["updated_at"])) ?></td>
                                                    <td>
                                                        <a href="" class="updateUser" data-userid="<?= $user['id'] ?>"> <i class="fa fa-pencil"></i> Edit</a>
                                                        <a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>"><i class="fa fa-remove"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($users) ?> usuarios </p>
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
                filename: 'users.pdf',
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

<?php include("partials/app-scripts.php") ?>

<script>
    function script(){

        this.initialize = function(){
            this.registerEvents();
        },

        this.registerEvents = function(){
            document.addEventListener("click", function(e){
                targetElement = e.target;
                classList = targetElement.classList;

                if(classList.contains("deleteUser")) {
                    e.preventDefault(); 
                    userId =targetElement.dataset.userid;
                    fname =targetElement.dataset.fname;
                    lname =targetElement.dataset.lname;

                    BootstrapDialog.confirm({
                        title: "Delete User",
                        type:BootstrapDialog.TYPE_DANGER,
                        message: "Confirm to delete <strong>"+fname+" "+lname+"</strong>?",
                        callback: function(isDelete){
                            if(isDelete) {
                                $.ajax({
                                    method: "POST",
                                    data: {
                                        id: userId,
                                        table: "users"
                                    },
                                    url: "database/delete.php",
                                    dataType: "json",
                                    success: function(data){
                                        message = data.success ? fname + " " + lname + " successfully deleted" : "Error while deleting";

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

                if(classList.contains("updateUser")) {
                    e.preventDefault();
                    firstName = targetElement.closest("tr").querySelector("td.firstName").innerHTML;
                    lastName = targetElement.closest("tr").querySelector("td.lastName").innerHTML;
                    email = targetElement.closest("tr").querySelector("td.email").innerHTML;
                    userId =targetElement.dataset.userid;

                        BootstrapDialog.confirm({
                            title: "Update " + firstName + " " + lastName,
                            message: '<form>\
                                <div class="form-group">\
                                    <label for="firstName">First Name:</label>\
                                    <input type="text" class="form-control" id="firstName" value="' + firstName + '">\
                                </div>\
                                <div class="form-group">\
                                    <label for="lastName">Last Name:</label>\
                                    <input type="text" class="form-control" id="lastName" value="' + lastName + '">\
                                </div>\
                                <div class="form-group">\
                                    <label for="email">Email:</label>\
                                    <input type="email" class="form-control" id="emailUpdate" value="' + email + '">\
                                </div>\
                            </form>',
                            callback: function(isUpdate){
                                if(isUpdate) {
                                    $.ajax({
                                        method: "POST",
                                        data: {
                                            userId: userId,
                                            f_name: document.getElementById("firstName").value,
                                            l_name: document.getElementById("lastName").value,
                                            email: document.getElementById("emailUpdate").value
                                        },
                                        url: "database/update-user.php",
                                        dataType: "json",
                                        success: function(data){
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
                                    })
                                }
                            }
                        });

                }

                
            });
        }
    }

    var script = new script;
    script.initialize();
</script>
</body>
</html>