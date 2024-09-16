<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
include("../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newDisplayName = strtoupper(trim($_POST['new_display_name']));
    $token = isset($_COOKIE['LS_ASP']) ? $_COOKIE['LS_ASP'] : '';

    if (empty($newDisplayName)) {
        echo json_encode(['status' => 'error', 'message' => 'Display name cannot be empty.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();

    if (!$userId) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE (username = ? OR display_name = ?) AND id != ?");
    $stmt->bind_param("ssi", $newDisplayName, $newDisplayName, $userId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Display name is already taken.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET display_name = ? WHERE id = ?");
    $stmt->bind_param("si", $newDisplayName, $userId);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update display name.']);
    }
    $stmt->close();
}
?>
