<?php
    
    session_start();

    // obtener asignaciones de tablas
    include("table_columns.php");
 
    // obtener el nombre de la tabla
    $table_name = $_SESSION["table"];
    $columns = $table_columns_mapping[$table_name];

    $db_arr = [];
    $user = $_SESSION["user"];
    foreach ($columns as $column) {
        if(in_array($column, ["created_at", "updated_at"])) $value = date("Y-m-d H:i:s");
        else if ($column == "created_by") $value = $user["id"];
        else if ($column == "password") $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
        else if ($column == "img") {
            $target_dir = "../uploads/property/";
            $file_data = $_FILES[$column];

            $value = NULL;
            $file_data = $_FILES["img"];

            if($file_data["tmp_name"] !== "") {
                $file_name = $file_data["name"];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $file_name = "property-" . time() . "." . $file_ext;
                
                $check = getimagesize($file_data["tmp_name"]);      
                
                if($check) {
                    if(move_uploaded_file($file_data["tmp_name"], $target_dir . $file_name)) {
                        $value = $file_name;
                    }
                }
            }

        }
        else $value = isset($_POST[$column]) ? $_POST[$column] : "";

        $db_arr[$column] = $value;

    };

    $table_properties = implode(", ", array_keys($db_arr));
    $table_placeholders = ":" . implode(", :", array_keys($db_arr));

    try {
        $sql = "INSERT INTO $table_name ($table_properties) VALUES ($table_placeholders)";

        include("connection.php");

        $stmt = $conn->prepare($sql);
        $stmt->execute($db_arr); 

        $property_id = $conn->lastInsertId();

        if ($table_name === "properties") {

            $tenants = isset($_POST["tenants"]) ? $_POST["tenants"] : [];
            if($tenants) {
                foreach($tenants as $tenant) {
                    $tenant_data = [
                        "tenant_id" => $tenant,
                        "property_id" => $property_id,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s")
                    ];

                    $sql = "INSERT INTO propertytenants (tenant, property, created_at, updated_at) VALUES (:tenant_id, :property_id, :created_at, :updated_at)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($tenant_data); 
                }
            }
        }

        $response = [
            "success" => true,
            "message" => "Successfully added to the database."
        ];

    } catch (PDOException $e) {
        $response = [
            "success" => false,
            "message" => $e->getMessage()
        ];

    }

    $_SESSION["response"] = $response;
    header("location: ../" . $_SESSION["redirect_to"]);

?>