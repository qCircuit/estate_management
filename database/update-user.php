<?php
    $data = $_POST;
    $user_id = (int) $data['userId'];
    $first_name = $data['f_name'];
    $last_name = $data['l_name'];
    $email = $data['email'];

    try {
        $sql = "UPDATE users SET first_name=?, last_name=?, email=?, updated_at=? WHERE id=?";
        include("connection.php");
        $conn->prepare($sql)->execute([$first_name, $last_name, $email, date("Y-m-d H:i:s"), $user_id]);

        echo json_encode([
            "success" => true,
            "message" => "User ".$first_name." ".$last_name." successfully updated."
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update"
        ]);
    }
