<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("./../../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$query = "SELECT gd.*, u.avatar FROM grabber_data gd
          JOIN users u ON gd.user_id = u.id
          ORDER BY gd.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$results = ['data' => $data];
$stmt->close();
$conn->close();

echo json_encode($results);
?>