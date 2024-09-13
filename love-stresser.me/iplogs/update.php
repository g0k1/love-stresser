<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];
$newName = $input['name'];

include("./../../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$sql = "UPDATE grabber_data SET name=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $newName, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

?>