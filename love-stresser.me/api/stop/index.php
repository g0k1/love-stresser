<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
$attacks_file = '../attacks.json';
$tokens_file = '../tokens.json';

$tokens = json_decode(file_get_contents($tokens_file), true)['tokens'];

$ongoing_attacks = file_exists($attacks_file) ? json_decode(file_get_contents($attacks_file), true) : [];

$token = $_GET['token'] ?? '';
$attack_id = $_GET['id'] ?? '';

if (!in_array($token, $tokens)) {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API authorization token."];
    render_response($response);
    exit;
}

if (!isset($ongoing_attacks[$attack_id])) {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid attack ID."];
    render_response($response);
    exit;
}

$attack = $ongoing_attacks[$attack_id];
$attack_start_time = $attack['start_time'];
$attack_duration = $attack['time'];

if (time() > $attack_start_time + $attack_duration) {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid attack ID; the attack has expired."];
    render_response($response);
    exit;
}

unset($ongoing_attacks[$attack_id]);

file_put_contents($attacks_file, json_encode($ongoing_attacks, JSON_PRETTY_PRINT));

$response = [
    "status" => "true",
    "message" => "Attack successfully stopped!"
];

render_response($response);

function render_response($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
