<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set Content-Type for JSON response
header('Content-Type: application/json');

// Get IP Address from POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['ip'])) {
    error_log("IP address not provided or invalid request");
    echo json_encode(['error' => 'IP address not provided or invalid request']);
    exit;
}

$IP_ADDRESS = $data['ip'];

// Input VPNAPI.IO API Key
$API_KEY = "387f19051332489180ef1cfa5e86118d"; // Replace with your VPNAPI.IO API Key

// API URL
$API_URL = 'https://vpnapi.io/api/' . $IP_ADDRESS . '?key=' . $API_KEY;

// Fetch VPNAPI.IO API Response
$response = file_get_contents($API_URL);
if ($response === FALSE) {
    error_log("Failed to fetch data from VPNAPI.IO");
    echo json_encode(['error' => 'Error fetching data from VPNAPI.IO']);
    exit;
}

// Decode JSON response
$responseData = json_decode($response);

if (!$responseData) {
    error_log("Failed to decode JSON response from VPNAPI.IO");
    echo json_encode(['error' => 'Error decoding JSON response from VPNAPI.IO']);
    exit;
}

// Check if IP Address is VPN, Proxy, or TOR
$isVPN = $responseData->security->vpn ? true : false;
$isProxy = $responseData->security->proxy ? true : false;
$isTOR = $responseData->security->tor ? true : false;

// Output the results as JSON
echo json_encode([
    'isVPN' => $isVPN,
    'isProxy' => $isProxy,
    'isTOR' => $isTOR
]);
?>
