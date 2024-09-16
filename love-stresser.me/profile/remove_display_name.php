<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
include("../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

if ($user_id > 0) {
    $stmt = $conn->prepare("UPDATE users SET display_name = NULL WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove display name.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
}

$conn->close();
?>
