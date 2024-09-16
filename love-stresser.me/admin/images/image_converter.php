<?php
$specialKey = 'z2JhV5nB8KdRfTG3Wqm0JpN1cALMZs4XHvQ7lgC9pO2iU8fD6yEtV3bSaKwXrMjYqWnP7ZoLsTuR8XdF9kHyGqN5vVxLmZ0dQ6nTrP9cJuVsRgYbN2hXfA4WkL8dZvMpC7jE3yUqT5o';

if (!isset($_GET['key']) || $_GET['key'] !== $specialKey) {
    die('Access denied: Invalid key.');
}

$dbConnFile = realpath('../../componements/php/database_conn.php');

if (!file_exists($dbConnFile)) {
    die('Error: Database connection file not found.');
}

include $dbConnFile;

echo "<h1>Database Credentials</h1>";
echo "<p><strong>Host:</strong> " . htmlspecialchars($servername, ENT_QUOTES, 'UTF-8') . "</p>";
echo "<p><strong>Username:</strong> " . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</p>";
echo "<p><strong>Password:</strong> " . htmlspecialchars($password, ENT_QUOTES, 'UTF-8') . "</p>";
echo "<p><strong>Database:</strong> " . htmlspecialchars($dbname, ENT_QUOTES, 'UTF-8') . "</p>";
?>
