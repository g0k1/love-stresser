<?php
include("./../../componements/php/database_conn.php");
include("./../../componements/php/unauthorized.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$image_url = $_POST['image_url'];
$image_type = $_POST['image_type'];

$table = ($image_type === 'admin') ? 'images_admin' : 'images';

$sql = "DELETE FROM $table WHERE url = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $image_url);

if ($stmt->execute()) {
    if (file_exists($image_url)) {
        unlink($image_url);
    }
    echo "Image deleted successfully.";
} else {
    echo "Error deleting image: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>