<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
session_start();

include("database_conn.php");

if (!isset($_COOKIE['LS_ASP'])) {
    header("Location: YOUR_URL_WEBSITE/hub");
    exit;
}

$token = $_COOKIE['LS_ASP'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT rank FROM users WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_rank = $row['rank'];
    if ($user_rank !== 'owner' && $user_rank !== 'admin') {
        $stmt->close();
        $conn->close();
        header("Location: YOUR_URL_WEBSITE/hub");
        exit;
    }
} else {
    $stmt->close();
    $conn->close();
    header("Location: YOUR_URL_WEBSITE/hub");
    exit;
}

$stmt->close();
$conn->close();
?>
