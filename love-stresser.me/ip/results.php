<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "love";
$password = "XtdQ/sib>b6VPn3s%59:Y,XP.R;_5494";
$dbname = "lovestresser";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$token = $_COOKIE['LS_ASP'];
$user_id = getUserId($conn, $token);

$query = "SELECT code FROM grabber_ids WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($code);

$results = [];
while ($stmt->fetch()) {
    $resultQuery = "SELECT * FROM grabber_data WHERE code = ?";
    $resultStmt = $conn->prepare($resultQuery);
    $resultStmt->bind_param("s", $code);
    $resultStmt->execute();
    $result = $resultStmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $results[] = ['code' => $code, 'data' => $data];
    $resultStmt->close();
}

$stmt->close();
$conn->close();

echo json_encode($results);

function getUserId($conn, $token) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    return $user_id;
}
?>
