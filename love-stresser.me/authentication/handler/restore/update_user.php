<?php
// Database credentials
$servername = "localhost";
$username = "love";
$password = "XtdQ/sib>b6VPn3s%59:Y,XP.R;_5494";
$dbname = "lovestresser";

// Retrieve JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Validate JSON data
$requiredFields = ['id', 'banned', 'username', 'email', 'rank', 'plan', 'concurents', 'max_time', 'methods', 'daily_attacks_limit', 'ip'];

foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        die(json_encode(['success' => false, 'error' => "Missing or invalid field: $field"]));
    }
}

// Extract data
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

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update user in database
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

// Close MySQL connection
$conn->close();
?>
