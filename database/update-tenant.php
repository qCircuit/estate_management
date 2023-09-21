<?php

$tenant_name = isset($_POST["tenant_name"]) ? $_POST["tenant_name"] : "";
$tenant_phone = isset($_POST["tenant_phone"]) ? $_POST["tenant_phone"] : "";
$tenant_email = isset($_POST["tenant_email"]) ? $_POST["tenant_email"] : "";

$tenant_id = $_POST["sid"];


try {
    $sql = "UPDATE tenants SET tenant_name = ?, tenant_phone = ?, tenant_email = ? WHERE id = ?";

    include("connection.php");
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tenant_name, $tenant_phone, $tenant_email, $tenant_id]);

    $sql = "DELETE FROM propertytenants WHERE tenant=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tenant_id]);

    $properties = isset($POST["properties"]) ? $POST["properties"] : [];
    foreach($properties as $property) {
        $tenant_data = [
            "tenant_id" => $tenant_id,
            "property_id" => $property,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ];

        $sql = "INSERT INTO propertytenants (tenant, property, created_at, updated_at) VALUES (:tenant_id, :property_id, :created_at, :updated_at)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tenant_data); 
    }
    
    
    $response = [
        "success" => true,
        "message" => "<strong>$tenant_name</strong> successfully updated to the database."
    ];
} catch (Exception $e) {
    $response = [
        "success" => false,
        "message" => "Error updating the tenant"
    ];
}



echo json_encode($response);