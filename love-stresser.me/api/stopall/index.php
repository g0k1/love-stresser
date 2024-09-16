<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
$attacks_file = 'attacks.json';
$tokens_file = 'tokens.json';

$tokens = json_decode(file_get_contents($tokens_file), true)['tokens'];

$ongoing_attacks = file_exists($attacks_file) ? json_decode(file_get_contents($attacks_file), true) : [];

$token = $_GET['token'] ?? '';

if (!in_array($token, $tokens)) {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API authorization token."];
    render_response($response);
    exit;
}

if (empty($ongoing_attacks)) {
    header('Content-Type: application/json');
    $response = ["status" => "true", "message" => "No attacks are currently running."];
    render_response($response);
    exit;
}

file_put_contents($attacks_file, json_encode([], JSON_PRETTY_PRINT));

$response = [
    "status" => "true",
    "message" => "All running attacks have been stopped!"
];

render_response($response);

function render_response($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
