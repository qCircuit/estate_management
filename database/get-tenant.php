<?php
include("connection.php");
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM tenants WHERE id=$id");
$stmt->execute(); 
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT property_name, properties.id FROM properties, propertytenants WHERE propertytenants.tenant=$id AND propertytenants.property = properties.id");
$stmt->execute(); 
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

$row['properties'] = array_column($properties, "id");

echo json_encode($row); 