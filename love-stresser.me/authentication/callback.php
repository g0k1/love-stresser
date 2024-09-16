<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
session_start();
include("../componements/php/root_domain.php");
$client_id = 'YOUR_DISCORD_APPLICATION_CLIENT_ID';
$client_secret = 'YOUR_DISCORD_APPLICATION_SECRET_ID';
$redirect_uri = 'https://' . $root_domain . '/authentication/callback.php';
$token_url = 'https://discord.com/api/oauth2/token';
$user_url = 'https://discord.com/api/users/@me';
$user_guilds_url = 'https://discord.com/api/users/@me/guilds';
$required_guild_id = 'YOUR_DISCORD_SERVER_ID';

function generateToken($length = 100) {
    return bin2hex(random_bytes($length / 2));
}

$default_avatar_urls = [
    'https://better-default-discord.netlify.app/Icons/Ocean-Red.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Orange.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Yellow.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Green.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Indigo.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Blue.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Violet.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Pink.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Black.png',
    'https://better-default-discord.netlify.app/Icons/Ocean-Gray.png'
];

$random_index = array_rand($default_avatar_urls);
$default_avatar_url = $default_avatar_urls[$random_index];

try {
    if (isset($_GET['code']) && isset($_GET['state']) && isset($_SESSION['state']) && $_GET['state'] === $_SESSION['state']) {
        $code = $_GET['code'];
        $data = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        $response = curl_exec($ch);

        if ($response === false) {
            header('Location: ../home');
            exit;
        }
        curl_close($ch);

        $token = json_decode($response, true);

        if (isset($token['access_token'])) {
            $access_token = $token['access_token'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $user_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
            $user_response = curl_exec($ch);

            if ($user_response === false) {
                header('Location: ../home');
                exit;
            }
            curl_close($ch);

            $user = json_decode($user_response, true);

            if (isset($user['id'], $user['username'], $user['email'])) {
                $discord_id = $user['id'];
                $username = $user['username'];
                $email = $user['email'];
                $avatar = isset($user['avatar']) && !empty($user['avatar']) ? 'https://cdn.discordapp.com/avatars/' . $user['id'] . '/' . $user['avatar'] . '.png' : $default_avatar_url;

                if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                    $user_ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
                } else {
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $user_guilds_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
                $guilds_response = curl_exec($ch);

                if ($guilds_response === false) {
                    header('Location: ../home');
                    exit;
                }
                curl_close($ch);

                $guilds_json = json_decode($guilds_response, true);

                $in_required_guild = false;
                foreach ($guilds_json as $guild) {
                    if ($guild['id'] === $required_guild_id) {
                        $in_required_guild = true;
                        break;
                    }
                }

                if (!$in_required_guild) {
                    header('Location: ../join');
                    exit;
                }

                $guilds = json_encode($guilds_json);

                $new_token = generateToken();

                $mysqli = new mysqli('localhost', 'YOUR_DATABASE_NAME', 'YOUR_DATABASE_PASSWORD', 'YOUR_DATABASE_NAME');

                if ($mysqli->connect_error) {
                    header('Location: ../hub');
                    exit;
                }

                $stmt = $mysqli->prepare('
                    INSERT INTO users (discord_id, username, email, avatar, token, guilds, ip, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, IFNULL(created_at, NOW()), NOW()) 
                    ON DUPLICATE KEY UPDATE 
                        username = VALUES(username), 
                        email = VALUES(email), 
                        avatar = VALUES(avatar), 
                        token = VALUES(token), 
                        guilds = VALUES(guilds), 
                        ip = VALUES(ip), 
                        updated_at = NOW()
                ');
                if ($stmt === false) {
                    header('Location: ../home');
                    exit;
                }

                $bind = $stmt->bind_param('sssssss', $discord_id, $username, $email, $avatar, $new_token, $guilds, $user_ip);
                if ($bind === false) {
                    header('Location: ../home');
                    exit;
                }

                $execute = $stmt->execute();
                if ($execute === false) {
                    header('Location: ../home');
                    exit;
                }

                $stmt->close();
                $mysqli->close();

                setcookie('LS_ASP', $new_token, time() + 3600, '/', '', false, true);
                header('Location: ../hub');
                exit;
            } else {
                header('Location: ../home');
                exit;
            }
        } else {
            header('Location: ../home');
            exit;
        }
    } else {
        header('Location: ../home');
        exit;
    }
} catch (Exception $e) {
    echo 'Exception caught: ' . $e->getMessage();
}
?>
