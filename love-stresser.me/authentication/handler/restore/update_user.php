<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
include("../../componements/database_conn.php")

$data = json_decode(file_get_contents('php://input'), true);

$requiredFields = ['id', 'banned', 'username', 'email', 'rank', 'plan', 'concurents', 'max_time', 'methods', 'daily_attacks_limit', 'ip'];

foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        die(json_encode(['success' => false, 'error' => "Missing or invalid field: $field"]));
    }
}

$userId = $data['id'];
$userBanned = $data['banned'];
$userUsername = $data['username'];
$userEmail = $data['email'];
$userRank = $data['rank'];
$userPlan = $data['plan'];
$userConcurents = $data['concurents'];
$userMaxTime = $data['max_time'];
$userMethods = $data['methods'];
$userDailyAttacksLimit = $data['daily_attacks_limit'];
$userIp = $data['ip'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE users SET 
        banned='$userBanned', 
        username='$userUsername', 
        email='$userEmail', 
        rank='$userRank', 
        plan='$userPlan', 
        concurents='$userConcurents', 
        max_time='$userMaxTime', 
        methods='$userMethods', 
        daily_attacks_limit='$userDailyAttacksLimit', 
        ip='$userIp' 
        WHERE id=$userId";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
