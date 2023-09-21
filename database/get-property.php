<?php
include("connection.php");
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM properties WHERE id=$id");
$stmt->execute(); 
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT tenant_name, tenants.id FROM tenants, propertytenants WHERE propertytenants.property=$id AND propertytenants.tenant = tenants.id");
$stmt->execute(); 
$tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$row['tenants'] = array_column($tenants, "id");

echo json_encode($row); 