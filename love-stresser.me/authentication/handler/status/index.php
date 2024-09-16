<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
$file = 'status.json';
$correctKey = 'g5ze4g5z4bzr544hg3a21ef54er4h685zr4g65a4eg';

if (!file_exists($file)) {
    $status = ['status' => 'offline'];
    file_put_contents($file, json_encode($status));
}

$status = json_decode(file_get_contents($file), true);

$keyValid = isset($_GET['key']) && $_GET['key'] === $correctKey;

if ($keyValid && isset($_POST['toggle'])) {
    $status['status'] = ($status['status'] === 'online') ? 'offline' : 'online';
    file_put_contents($file, json_encode($status));
    // Refresh the page after updating the status
    header("Location: " . $_SERVER['PHP_SELF'] . "?key=" . $correctKey);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Toggle</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .button {
            padding: 10px 20px;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .online {
            background-color: green;
        }
        .offline {
            background-color: red;
        }
    </style>
</head>
<body>
    <?php if ($keyValid): ?>
        <form method="post">
            <button type="submit" name="toggle" class="button <?php echo ($status['status'] === 'online') ? 'online' : 'offline'; ?>">
                <?php echo ($status['status'] === 'online') ? 'Online' : 'Offline'; ?>
            </button>
        </form>
        
    <?php else: ?>
        <p>Invalid key. Access denied.</p>
    <?php endif; ?>
</body>
</html>
