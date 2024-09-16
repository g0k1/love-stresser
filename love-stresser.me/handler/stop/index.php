<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
include("../../componements/php/api_token.php");
$attack_id = isset($_GET['id']) ? $_GET['id'] : null;
$target_id = isset($_GET['target']) ? $_GET['target'] : null;
$port_id = isset($_GET['port']) ? $_GET['port'] : null;
$duration_id = isset($_GET['duration']) ? $_GET['duration'] : null;

include("../../componements/php/database_conn.php");

if ($attack_id) {
    function is_valid_ip($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    $apiEndpoint = is_valid_ip($target_id) ? 'layer4' : 'layer7';

    if ($method === 'CLOUD-BYPASS') {
        $url = "https://api.cloudnode.me/?hub=layer7_premium&token={$token}&host={$target_id}&port={$port_id}&time={$duration_id}&method=STOP";
    } else {
        $url = "https://api.cloudnode.me/?hub={$apiEndpoint}&token={$token}&host={$target_id}&port={$port_id}&time={$duration_id}&method=STOP";
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['status' => 'error', 'message' => 'cURL error: ' . curl_error($ch)]);
    } else {
        header('Content-Type: application/json');

        if ($response === '{"error":"No active attacks found to stop."}') {
            echo json_encode(['adm' => 'LSF-STOP']);
        } else {
            $responses = [];
            $responseParts = preg_split('/(?<=\}\})\{/', $response);

            foreach ($responseParts as $part) {
                $responsePart = trim($part);
                if ($responsePart) {
                    $decoded = json_decode($responsePart, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $responses[] = $decoded;
                    }
                }
            }

            $finalOutput = [];
            foreach ($responses as $data) {
                if (isset($data['status']) && isset($data['message'])) {
                    $finalOutput = [
                        'status' => $data['status'] === 'success' ? 'true' : $data['status'],
                        'message' => $data['message']
                    ];
                    break;
                }
            }

            if (empty($finalOutput)) {
                $finalOutput = isset($responses[0]) ? $responses[0] : ['status' => 'error', 'message' => 'No valid response found'];
            }

            echo json_encode($finalOutput);
        }
    }

    curl_close($ch);

    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM attacks WHERE id = :id");
    $stmt->bindParam(':id', $attack_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
    } else {
    }

    $pdo = null;
} else {
    header('Content-Type: application/json');
    echo '{"status":"error","message":"No ID parameter provided in the URL."}';
}
?>
