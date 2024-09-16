<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
if (isset($_COOKIE['LS_ASP'])) {
    unset($_COOKIE['LS_ASP']); 
    setcookie('LS_ASP', '', time() - 3600, '/');
}
header("Location: ../home");
exit;
?>
