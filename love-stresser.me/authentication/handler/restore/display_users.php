<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser

include("../../componements/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, banned, username, email, rank, plan, concurents, max_time, methods, daily_attacks_limit, ip FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            min-width: 100px;
            max-width: 300px;
            overflow-wrap: break-word;
        }
        button {
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>ID</th>
        <th>Banned</th>
        <th>Username</th>
        <th>Email</th>
        <th>Rank</th>
        <th>Plan</th>
        <th>Concurents</th>
        <th>Max Time</th>
        <th>Methods</th>
        <th>Daily Attacks Limit</th>
        <th>IP</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='banned'>{$row['banned']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='username'>{$row['username']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='email'>{$row['email']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='rank'>{$row['rank']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='plan'>{$row['plan']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='concurents'>{$row['concurents']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='max_time'>{$row['max_time']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='methods'>{$row['methods']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='daily_attacks_limit'>{$row['daily_attacks_limit']}</td>";
            echo "<td contenteditable='true' data-id='{$row['id']}' data-field='ip'>{$row['ip']}</td>";
            echo "<td><button onclick='updateUser({$row['id']})'>Update</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='12'>No users found.</td></tr>";
    }
    ?>
</table>

<script>
    function updateUser(userId) {
        let fields = ['banned', 'username', 'email', 'rank', 'plan', 'concurents', 'max_time', 'methods', 'daily_attacks_limit', 'ip'];
        let data = {};

        fields.forEach(field => {
            let value = document.querySelector(`[data-id='${userId}'][data-field='${field}']`).innerText;
            data[field] = value;
        });

        fetch('update_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: userId,
                ...data
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Update successful');
                // Optionally update UI or show a success message
            } else {
                console.error('Update failed:', data.error);
                // Handle errors here
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            // Handle fetch errors here
        });
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
