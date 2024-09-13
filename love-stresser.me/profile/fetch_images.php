<?php
include("../componements/php/database_conn.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter = $_POST['filter'];
    $images = [];

    if ($filter === 'admin') {
        $stmt = $conn->prepare("SELECT DISTINCT name, url FROM images_admin");
    } elseif ($filter === 'members') {
        $stmt = $conn->prepare("SELECT DISTINCT name, url FROM images");
    } else {
        $stmt = $conn->prepare("SELECT DISTINCT name, url FROM images UNION SELECT DISTINCT name, url FROM images_admin");
    }

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        echo json_encode(['status' => 'success', 'images' => $images]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }
}
?>