<?php

$property_name = $_POST["property_name"];
$description = $_POST["description"];
$pid = $_POST["pid"];

$target_dir = "../uploads/property/";

$file_name_value = NULL;
$file_data = $_FILES["img"];

if($file_data["tmp_name"] !== "") {
    $file_name = $file_data["name"];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = "property-" . time() . "." . $file_ext;
    
    $check = getimagesize($file_data["tmp_name"]);      
    
    if($check) {
        if(move_uploaded_file($file_data["tmp_name"], $target_dir . $file_name)) {
            $file_name_value = $file_name;
        }
    }
}

try {
    $sql = "UPDATE properties SET property_name = ?, description = ?, img = ? WHERE id = ?";

    include("connection.php");
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$property_name, $description, $file_name_value, $pid]);

    $sql = "DELETE FROM propertytenants WHERE property=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$pid]);

    $tenants = isset($_POST["tenants"]) ? $_POST["tenants"] : [];
    foreach($tenants as $tenant) {
        $tenant_data = [
            "tenant_id" => $tenant,
            "property_id" => $pid,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ];

        $sql = "INSERT INTO propertytenants (tenant, property, created_at, updated_at) VALUES (:tenant_id, :property_id, :created_at, :updated_at)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tenant_data); 
    }
    
    
    $response = [
        "success" => true,
        "message" => "<strong>$property_name</strong> successfully updated to the database."
    ];
} catch (Exception $e) {
    $response = [
        "success" => false,
        "message" => "Error updating the property"
    ];
}



echo json_encode($response);