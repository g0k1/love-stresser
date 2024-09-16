<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
$secret_access_code = "aeikfgjaeigvboaeigbhoikaeznbloikdfzviafiokjaeogijlakdgjnvjkadev";

if (!isset($_GET['code']) || $_GET['code'] !== $secret_access_code) {
    die("Access denied. Invalid access code.");
}

$servername = "localhost";
$username = "love";
$password = "XtdQ/sib>b6VPn3s%59:Y,XP.R;_5494";
$dbname = "lovestresser";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function displaySuccess($message) {
    echo '<script>';
    echo 'alert("' . $message . '");';
    echo 'window.location.href = "index.php?code=' . $GLOBALS['secret_access_code'] . '";'; // Redirect to avoid resubmission on refresh
    echo '</script>';
}

function displayError($error) {
    echo '<script>';
    echo 'alert("Error: ' . $error . '");';
    echo '</script>';
}

if (isset($_POST['restore_submit'])) {
    if ($_FILES['sql_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['sql_file']['tmp_name'])) {
        $sqlFile = $_FILES['sql_file']['tmp_name'];
        $sqlStatements = file_get_contents($sqlFile);

        if ($sqlStatements === false) {
            displayError("Error reading SQL file: $sqlFile");
        } else {
            $sqlStatements = rtrim($sqlStatements, "\n;");
            $queries = explode(";", $sqlStatements);

            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    if (!$conn->query($query)) {
                        displayError("Error executing query: $query<br>Error: " . $conn->error);
                    }
                }
            }

            displaySuccess("Backup SQL file '$sqlFile' executed successfully.");
        }
    } else {
        displayError("Error uploading SQL file.");
    }
}

if (isset($_POST['query_submit'])) {
    $sqlQueries = $_POST['sql_queries'];

    if (!empty($sqlQueries)) {
        $queries = explode(";", $sqlQueries);

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$conn->query($query)) {
                    displayError("Error executing query: $query<br>Error: " . $conn->error);
                }
            }
        }

        displaySuccess("Custom SQL queries executed successfully.");
    } else {
        displayError("No SQL queries entered.");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2b2a2a;
            margin: 20px;
            padding: 20px;
        }
        h2 {
            color: #fff;
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            color: white;
            border: 1px solid #fff;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #ffffff;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button {
            background-color: #ffffff;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        h3 {
            color: white;
        }
        input[type="submit"]:hover {
            background-color: black;
            color: #ffffff;
        }
        button:hover {
            background-color: black;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        td {
            color: white;
        }
        th {
            background-color: #f2f2f2;
        }
    .notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
        opacity: 1;
        transition: opacity 0.6s ease;
        z-index: 9999;
    }
    .notification.success {
        background-color: #4CAF50;
        color: white;
    }
    .notification.error {
        background-color: #f44336;
        color: white;
    }
    </style>
    <script>
        function displayNotification(message, type) {
            const notification = document.createElement('div');
            notification.classList.add('notification', type);
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 600);
            }, 3000);
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Database Management</h2>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <h3>Restore Database from SQL File</h3>
        <input type="file" name="sql_file" accept=".sql">
        <br><br>
        <input type="submit" name="restore_submit" value="Restore Database">
    </form>

    <form action="index.php" method="post">
        <h3>Execute Custom SQL Queries</h3>
        <textarea name="sql_queries" rows="5" placeholder="Enter SQL queries"></textarea>
        <br><br>
        <input type="submit" name="query_submit" value="Execute Queries">
    </form>

    <h3>Users Table</h3>
    <div>
        <?php include 'display_users.php'; ?>
    </div>
</div>
</body>
</html>
