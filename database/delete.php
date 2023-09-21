<?php

    $data = $_POST;
    $id = (int) $data['id'];
    $table = $data['table'];

    try {
        include("connection.php");
        
        if ($table === "tenants") {
            $supplier_id = $id; 

            $command = "DELETE FROM propertytenants WHERE tenant={$id}";
            $conn->exec($command);

        }
        if ($table === "properties") {
            $supplier_id = $id; 

            $command = "DELETE FROM propertytenants WHERE property={$id}";
            $conn->exec($command);

        }

        $command = "DELETE FROM $table WHERE id={$id}";
        $conn->exec($command);

        echo json_encode([
            "success" => true
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "success" => false
        ]);
    }