<?php
$attacks_file = '../attacks.json';
$tokens_file = '../tokens.json';

$tokens = json_decode(file_get_contents($tokens_file), true)['tokens'];

$token = $_GET['token'] ?? '';

if (!in_array($token, $tokens)) {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API authorization token."];
    render_response($response);
    exit;
}

$ongoing_attacks = file_exists($attacks_file) ? json_decode(file_get_contents($attacks_file), true) : [];

if (empty($ongoing_attacks)) {
    $response = [
        "status" => "true",
        "message" => "No attacks are currently running.",
        "attack_ids" => []
    ];
} else {
    $response = [
        "status" => "true",
        "message" => "List of currently running attacks.",
        "attack_ids" => array_keys($ongoing_attacks)
    ];
}

render_response($response);

function render_response($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
