<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../componements/php/database_conn.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profileType = "Image";
    $name = $_POST['name'];
    $token = $_POST['token'];

    $stmt = $conn->prepare("SELECT id, plan, rank FROM users WHERE token = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit();
    }

    if (strtolower($user['plan']) === 'free') {
        echo json_encode(['status' => 'error', 'message' => 'Action not allowed for free plan users']);
        exit();
    }

    $userId = $user['id'];
    $userRank = strtolower($user['rank']);

    if ($userRank === 'admin' || $userRank === 'owner') {
        $stmt = $conn->prepare("SELECT url FROM images WHERE name = ? UNION SELECT url FROM images_admin WHERE name = ?");
    } else {
        $stmt = $conn->prepare("SELECT url FROM images WHERE name = ?");
    }

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        exit();
    }
    
    if ($userRank === 'admin' || $userRank === 'owner') {
        $stmt->bind_param("ss", $name, $name);
    } else {
        $stmt->bind_param("s", $name);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();

    if (!$image) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid image name']);
        exit();
    }

    $profileBackgroundUrl = $image['url'];

    try {
        $updateStmt = $conn->prepare("UPDATE users SET profile_type = ?, profile_background = ? WHERE id = ?");
        if (!$updateStmt) {
            throw new Exception('Prepare update statement failed: ' . $conn->error);
        }
        $updateStmt->bind_param("ssi", $profileType, $profileBackgroundUrl, $userId);

        if ($updateStmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception('Failed to update profile: ' . $updateStmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>