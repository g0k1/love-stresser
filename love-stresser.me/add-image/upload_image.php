<?php
include("../../componements/php/database_conn.php");
$conn = new mysqli($servername, $username, $password, $dbname);
include("../../componements/php/root_domain.php");
function generateRandomString($length = 50) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

$targetDir = "../../files/img/";
$uploadOk = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $displayName = $_POST['displayName'];
    $originalName = $_POST['name'];
    $image = $_FILES['image']['name'];
    $isAdminImage = isset($_POST['admin_image_button_status']) ? 1 : 0;

    $randomName = generateRandomString();
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $randomFileName = $randomName . '.' . $imageFileType;

    $targetFile = $targetDir . $randomFileName;

    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        header("Location: index.php?status=error&message=File+is+not+an+image.");
        exit();
    }

    if ($_FILES['image']['size'] > 5000000) {
        header("Location: index.php?status=error&message=File+is+too+large.");
        exit();
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" && $imageFileType != "gif") {
        header("Location: index.php?status=error&message=Only+JPG,+JPEG,+PNG,+WEBP,+and+GIF+files+are+allowed.");
        exit();
    }

    if ($uploadOk == 0) {
        header("Location: index.php?status=error&message=File+was+not+uploaded.");
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imageUrl = "https://" . $root_domain . "/" . $targetFile;

            if ($isAdminImage) {
                $stmt = $conn->prepare("INSERT INTO images_admin (name, display_name, url) VALUES (?, ?, ?)");
            } else {
                $stmt = $conn->prepare("INSERT INTO images (name, display_name, url) VALUES (?, ?, ?)");
            }
            
            $stmt->bind_param("sss", $randomName, $displayName, $imageUrl);

            if ($stmt->execute()) {
                header("Location: index.php?status=success&message=Image+uploaded+successfully.");
            } else {
                header("Location: index.php?status=error&message=Failed+to+add+image+to+database.");
            }

            $stmt->close();
        } else {
            header("Location: index.php?status=error&message=There+was+an+error+uploading+your+file.");
        }
    }
}

$conn->close();
?>
