<?php
session_start();
include("../componements/php/root_domain.php");
if (isset($_COOKIE['LS_ASP']) && !empty($_COOKIE['LS_ASP'])) {
    header('Location: ../hub');
    exit();
}

$_SESSION['state'] = bin2hex(random_bytes(32));

$client_id = 'YOUR_DISCORD_APPLICATION_CLIENT_ID';
$redirect_uri = 'https://' . $root_domain . '/authentication/callback.php';
$scope = 'identify email guilds';
$state = $_SESSION['state'];

$params = [
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => $scope,
    'state' => $state,
];

header('Location: https://discord.com/api/oauth2/authorize?' . http_build_query($params));
exit();
?>
