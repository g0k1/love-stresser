<?php
session_start();

include("../componements/php/database_conn.php");
include("../componements/php/unauthorized.php");
include("../componements/php/discord_server.php");
include("../componements/php/root_domain.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getUserAvatar($conn, $token) {
    $stmt = $conn->prepare("SELECT avatar FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['avatar'];
    } else {
        $stmt->close();
        return null;
    }
}
function getUserRank($conn, $token) {
    $stmt = $conn->prepare("SELECT rank FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['rank'];
    } else {
        $stmt->close();
        return null;
    }
}

function getUserPlan($conn, $token) {
    $stmt = $conn->prepare("SELECT plan FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['plan'];
    } else {
        $stmt->close();
        return null;
    }
}

if (isset($_COOKIE['LS_ASP'])) {
    $token = $_COOKIE['LS_ASP'];
    $avatar_url = getUserAvatar($conn, $token);
    $user_plan = getUserPlan($conn, $token);
    $rank = getUserRank($conn, $token); 

    if ($avatar_url === null) {
        header("Location: ../logout");
        exit;
    }

    $stmt_banned = $conn->prepare("SELECT banned FROM users WHERE token = ?");
    $stmt_banned->bind_param("s", $token);
    $stmt_banned->execute();
    $stmt_banned->bind_result($banned);
    $stmt_banned->fetch();
    $stmt_banned->close();

    if ($banned == 1) {
        header("Location: ../banned");
        exit;
    }

    $plan_styles = [
        'bouffon' => 'color: #63340b text-shadow: 0 0 5px #63340b; text-transform: uppercase;',
        'free' => 'color: #00FF00; text-shadow: 0 0 5px #00FF00; text-transform: uppercase;',
        'starter1' => 'background: linear-gradient(90deg, orange, yellow); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 255, 0, 0.5); text-transform: uppercase;',
        'starter2' => 'background: linear-gradient(90deg, orange, yellow); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 255, 0, 0.5); text-transform: uppercase;',
        'starter3' => 'background: linear-gradient(90deg, orange, yellow); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 255, 0, 0.5); text-transform: uppercase;',
        'exp1' => 'background: linear-gradient(90deg, cyan, blue); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(0, 0, 255, 0.5); text-transform: uppercase;',
        'exp2' => 'background: linear-gradient(90deg, cyan, blue); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(0, 0, 255, 0.5); text-transform: uppercase;',
        'exp3' => 'background: linear-gradient(90deg, cyan, blue); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(0, 0, 255, 0.5); text-transform: uppercase;',
        'pro1' => 'background: linear-gradient(90deg, pink, purple); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 0, 255, 0.5); text-transform: uppercase;',
        'pro2' => 'background: linear-gradient(90deg, pink, purple); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 0, 255, 0.5); text-transform: uppercase;',
        'pro3' => 'background: linear-gradient(90deg, pink, purple); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 0, 255, 0.5); text-transform: uppercase;',
        'infinity' => 'background: linear-gradient(90deg, pink, white); -webkit-background-clip: text; color: transparent; text-shadow: 0 0 5px rgba(255, 0, 255, 0.5); text-transform: uppercase;'
    ];

    $stats = [
        'bouffon' => [
            'Concurents' => 5,
            'Max Time' => 600,
            'Methods' => 'FREE',
            'Daily Attacks Limit' => 500,
        ],
        'free' => [
            'Concurents' => 1,
            'Max Time' => 60,
            'Methods' => 'FREE',
            'Daily Attacks Limit' => 3,
        ],
        'starter1' => [
            'Concurents' => 1,
            'Max Time' => 60,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'starter2' => [
            'Concurents' => 1,
            'Max Time' => 120,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'starter3' => [
            'Concurents' => 2,
            'Max Time' => 360,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'exp1' => [
            'Concurents' => 3,
            'Max Time' => 420,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'exp2' => [
            'Concurents' => 3,
            'Max Time' => 600,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'exp3' => [
            'Concurents' => 4,
            'Max Time' => 720,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'pro1' => [
            'Concurents' => 4,
            'Max Time' => 840,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'pro2' => [
            'Concurents' => 5,
            'Max Time' => 960,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'pro3' => [
            'Concurents' => 5,
            'Max Time' => 1080,
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
        'infinity' => [
            'Concurents' => 'Unlimited',
            'Max Time' => 'Unlimited',
            'Methods' => 'PAID',
            'Daily Attacks Limit' => 'Unlimited',
        ],
    ];
    $current_stats = isset($stats[$user_plan]) ? $stats[$user_plan] : [];

    date_default_timezone_set('Europe/Paris');

    $stmt = $conn->prepare("SELECT email, id, discord_id, username, created_at, updated_at, rank FROM users WHERE token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $created_at = new DateTime($row['created_at'], new DateTimeZone('UTC'));
        $created_at->setTimezone(new DateTimeZone('Europe/Paris'));

        $updated_at = new DateTime($row['updated_at'], new DateTimeZone('UTC'));
        $updated_at->setTimezone(new DateTimeZone('Europe/Paris'));

        $email = htmlspecialchars($row["email"]);
        $id = htmlspecialchars($row["id"]);
        $discord_id = htmlspecialchars($row["discord_id"]);
        $username = htmlspecialchars($row["username"]);
        $created_at_formatted = htmlspecialchars($created_at->format('Y-m-d H:i:s'));
        $updated_at_formatted = htmlspecialchars($updated_at->format('Y-m-d H:i:s'));
        $rank = htmlspecialchars($row["rank"]);
    } else {
    }
    if (array_key_exists($user_plan, $stats)) {
        $plan_stats = $stats[$user_plan];
        
        $stmt_update = $conn->prepare("UPDATE users SET concurents = ?, max_time = ?, methods = ?, daily_attacks_limit = ? WHERE token = ?");
        if (!$stmt_update) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt_update->bind_param("iisss", $plan_stats['Concurents'], $plan_stats['Max Time'], $plan_stats['Methods'], $plan_stats['Daily Attacks Limit'], $token);
        $stmt_update->execute();
        if ($stmt_update->error) {
            die("Execute failed: (" . $stmt_update->errno . ") " . $stmt_update->error);
        }
        $stmt_update->close();
    } else {
        header("Location: ../home");
        exit;
    }


    ?>

    <?php

} else {
    header("Location: ../home");
    exit;
}
$stmt_user_data = $conn->prepare("SELECT plan, plan_expire FROM users WHERE token = ?");
    $stmt_user_data->bind_param("s", $token);
    $stmt_user_data->execute();
    $user_data_result = $stmt_user_data->get_result();
    $user_data = $user_data_result->fetch_assoc();
    $stmt_user_data->close();
    
    $current_date = new DateTime();
    $plan_expire_date = new DateTime($user_data['plan_expire']);
    
    if ($current_date > $plan_expire_date) {
        $new_plan = 'free';
        $stmt_update_plan = $conn->prepare("UPDATE users SET plan = ?, plan_expire = NULL WHERE token = ?");
        $stmt_update_plan->bind_param("ss", $new_plan, $token);
        $stmt_update_plan->execute();
        $stmt_update_plan->close();
        
        $user_plan = $new_plan;
    } else {
        $user_plan = $user_data['plan'];
    }
$conn->close();
?>
<?php
$file = '../authentication/handler/status/status.json';
$status = json_decode(file_get_contents($file), true);
if ($status['status'] === 'offline') {
    include('../help/cgu/index.php');
    die();
} else {
}
?>
<?php
session_start();

include("../componements/php/database_conn.php");
$total_attacks = 0;
$users_number = 0;

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_users = "SELECT COUNT(*) AS user_count FROM users";
    $result_users = $conn->query($sql_users);
    if ($result_users && $row = $result_users->fetch_assoc()) {
        $users_number = $row['user_count'];
    }

    $sql_attacks = "SELECT COUNT(*) AS attack_count FROM attack_logs";
    $result_attacks = $conn->query($sql_attacks);
    if ($result_attacks && $row = $result_attacks->fetch_assoc()) {
        $total_attacks = $row['attack_count'];
    }

    $conn->close();

?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v9/invites/$serverInviteCode?with_counts=true&with_expiration=true");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$memberCount = isset($data['approximate_member_count']) ? $data['approximate_member_count'] : "Error !";
?>
<html class="no-js" lang="en-US"><head>
    <meta charset="UTF-8">
    <script>console.log = function(){ };</script>
    <title>Love Stresser - Admin</title>
    <meta name="robots" content="max-image-preview:large">
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
    <style>
@media all{
:root{--woocommerce:#7F54B3;--wc-green:#7ad03a;--wc-red:#a00;--wc-orange:#ffba00;--wc-blue:#2ea2cc;--wc-primary:#7F54B3;--wc-primary-text:white;--wc-secondary:#e9e6ed;--wc-secondary-text:#515151;--wc-highlight:#b3af54;--wc-highligh-text:white;--wc-content-bg:#fff;--wc-subtext:#767676;}
}

@media only screen and (max-width: 768px){
:root{--woocommerce:#7F54B3;--wc-green:#7ad03a;--wc-red:#a00;--wc-orange:#ffba00;--wc-blue:#2ea2cc;--wc-primary:#7F54B3;--wc-primary-text:white;--wc-secondary:#e9e6ed;--wc-secondary-text:#515151;--wc-highlight:#b3af54;--wc-highligh-text:white;--wc-content-bg:#fff;--wc-subtext:#767676;}
}

@media all{
:root{--woocommerce:#7F54B3;--wc-green:#7ad03a;--wc-red:#a00;--wc-orange:#ffba00;--wc-blue:#2ea2cc;--wc-primary:#7F54B3;--wc-primary-text:white;--wc-secondary:#e9e6ed;--wc-secondary-text:#515151;--wc-highlight:#b3af54;--wc-highligh-text:white;--wc-content-bg:#fff;--wc-subtext:#767676;}
}

@media all{
header,nav,section{display:block;}
html{-webkit-tap-highlight-color:rgba(0, 0, 0, 0);-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
body,div,span,h3,p,ul,li,a,img,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
.head .head__subtitle,.head .head__title{opacity:0;}
.animated{animation-name:fadeInUp;-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;}
}

@media all{
html,body{box-sizing:border-box;margin:0;padding:0;width:100vw;background:#06060C;position:relative;max-width:100%;overflow-x:hidden;font-family:'Urbanist', sans-serif;}
*,*:before,*:after{box-sizing:inherit;margin:0;padding:0;color:#fff;list-style-type:none;}
*::placeholder{font-size:16px;}
a{font-family:'Urbanist', sans-serif;text-decoration:none;cursor:pointer;}
a{cursor:pointer;}
.container{display:flex;align-items:flex-start;flex-direction:row;flex-wrap:wrap;max-width:1440px;width:100%;margin:0 auto;position:relative;}
@media (max-width: 1480px){
.container{padding:0 20px;}
}
.head{display:flex;flex-direction:column;}
.head__subtitle{margin-bottom:8px;}
.head__subtitle p{font-style:normal;font-weight:700;font-size:18px;line-height:22px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255, 255, 255, 0.64);}
.head__title p{font-weight:700;font-size:48px;line-height:56px;}
.head__title p span{background:-webkit-linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.circle{width:240px;height:240px;position:absolute;border-radius:50%;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);}
.circle::before{content:'';width:100%;top:initial;bottom:initial;left:initial;right:initial;position:absolute;height:100%;border-radius:50%;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);opacity:0.84;filter:blur(100px);}
.header{width:100%;position:absolute;top:24px;z-index:4;}
.header__row{width:100%;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:24px;height:100px;display:flex;align-items:center;justify-content:space-between;padding:24px;flex-wrap:wrap;transition:all 0.7s ease-out;}
.header__burger{display:flex;align-items:center;justify-content:center;height:32px;width:32px;position:relative;}
.header__burger span{width:100%;height:3px;background:#fff;border-radius:50px;transition:all .5s ease-out;}
.header__burger span:before{content:'';position:absolute;transform:translateY(-10px);width:100%;height:3px;background:#fff;border-radius:50px;transition:all .5s ease-out;}
.header__burger span:after{content:'';position:absolute;transform:translateY(10px);width:100%;height:3px;background:#fff;border-radius:50px;transition:all .5s ease-out;}
.header__menu{display:flex;align-items:center;gap:48px;height:100%;}
.nav__list{display:flex;flex-direction:row;gap:48px;align-items:center;position:relative;}
.nav__list .menu-item{position:relative;display:flex;align-items:center;justify-content:center;}
.nav__list .menu-item a:hover{color:#d8d8d8;}
.nav__list .menu-item a{display:flex;align-items:center;justify-content:center;gap:8px;}
.header__divider{height:30px;width:1px;background-color:#7b7474;}
.header__button{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);width:50px;height:50px;position:relative;display:flex;align-items:center;justify-content:center;border-radius:24px;}
.header__button a{display:flex;align-items:center;justify-content:center;text-decoration:none;background:#06060C;width:46px;height:46px;position:absolute;border-radius:24px;border:none;}
.header__button img{width:100%;height:100%;border-radius:50%;object-fit:cover;}
@media (min-width: 991px){
.header__burger{display:none;}
}
@media (max-width: 992px){
.nav{width:100%;max-height:calc(100vh - 330px);overflow-y:auto;}
.nav__list{gap:24px;}
.menu-item{flex-direction:column;gap:12px;align-items:flex-start;}
.header__row{padding:33px 24px;align-items:flex-start;overflow:hidden;}
.header__menu{width:100%;flex-direction:column;align-items:flex-start;margin-top:48px;}
.nav__list{width:100%;flex-direction:column;align-items:flex-start;}
.header__divider{height:1px;width:100%;}
}
.hero__object{animation:zoom ease-out;animation-delay:0.4s;animation-duration:1.5s;top:-160px;left:260px;z-index:1;}
.stats{width:100%;margin-bottom:100px;}
.stats__row{display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));grid-auto-flow:row;width:100%;gap:30px;}
.stats__item{display:flex;align-items:center;justify-content:center;flex-direction:column;height:186px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(2px);border-radius:24px;gap:16px;}
.stats__count{width:100%;}
.stats__count p{font-style:normal;font-weight:700;font-size:48px;text-align:center;line-height:56px;}
.stats__title{width:100%;}
.stats__title p{font-weight:700;font-size:16px;line-height:19px;text-align:center;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255, 255, 255, 0.64);}
.features__head{width:100%;display:flex;align-items:center;}
}

@media all{
.elementor-screen-only{position:absolute;top:-10000em;width:1px;height:1px;margin:-1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);border:0;}
:root{--page-title-display:block;}
@media (min-width:1025px){
#elementor-device-mode:after{content:"desktop";}
}
@media (min-width:-1){
#elementor-device-mode:after{content:"widescreen";}
}
@media (max-width:-1){
#elementor-device-mode:after{content:"laptop";content:"tablet_extra";}
}
@media (max-width:1024px){
#elementor-device-mode:after{content:"tablet";}
}
@media (max-width:-1){
#elementor-device-mode:after{content:"mobile_extra";}
}
@media (max-width:767px){
#elementor-device-mode:after{content:"mobile";}
}
.animated{animation-duration:1.25s;}
@media (prefers-reduced-motion:reduce){
.animated{animation:none;}
}
}

@media all{
:root{--swiper-theme-color:#007aff;}
:root{--swiper-navigation-size:44px;}
}

@media all{
.elementor-kit-6{--e-global-color-primary:#6EC1E4;--e-global-color-secondary:#54595F;--e-global-color-text:#7A7A7A;--e-global-color-accent:#61CE70;--e-global-typography-primary-font-family:"Roboto";--e-global-typography-primary-font-weight:600;--e-global-typography-secondary-font-family:"Roboto Slab";--e-global-typography-secondary-font-weight:400;--e-global-typography-text-font-family:"Roboto";--e-global-typography-text-font-weight:400;--e-global-typography-accent-font-family:"Roboto";--e-global-typography-accent-font-weight:500;}
}

body{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:none;font-weight:500;line-height:26px;background-color:#06060c;background-repeat:repeat;background-position:top center;background-attachment:scroll;background-size:cover;}
h3{font-size:30px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}

.sidebar-section{display:flex;flex-direction:column;padding:50px;margin-bottom:24px;height:1192px;margin-top:24px;margin-left:50px;width:300px;border-radius:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);}
.sidebar-items{text-align:center;}
.main-content{border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);padding:50px 0;width:1440px;display:flex;height:1025px;margin-top:-1050px;justify-content:center;align-items:center;}
.stats{width:90%;}

@-webkit-keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0, 100%, 0);transform:translate3d(0, 100%, 0);}to{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}}
@keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0, 100%, 0);transform:translate3d(0, 100%, 0);}to{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}}
@keyframes zoom{0%{width:40px;height:40px;top:50px;left:20px;}100%{width:240px;height:240px;top:-160px;left:260px;}}

@font-face{font-family:'Urbanist';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDyx4vH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDyx4vEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:500;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqD-R4vH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:500;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqD-R4vEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDFRkvH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDFRkvEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDLBkvH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDLBkvEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDyx4vH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDyx4vEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:500;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqD-R4vH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:500;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqD-R4vEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDFRkvH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:600;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDFRkvEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDLBkvH5mqe8Q.woff2) format('woff2');unicode-range:U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;}
@font-face{font-family:'Urbanist';font-style:normal;font-weight:700;font-display:swap;src:url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDLBkvEZmq.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
    </style>
    <meta name="generator" content="Elementor 3.20.2; features: e_optimized_assets_loading, e_optimized_css_loading, additional_custom_breakpoints, block_editor_assets_optimize, e_image_loading_optimization; settings: css_print_method-external, google_font-enabled, font_display-swap">
    <meta name="msapplication-TileImage" content="https://alethemes.com/onchain/wp-content/uploads/sites/109/2022/12/cropped-favicon-270x270.png">
    <script src="js/wp-emoji-release.min.js" defer=""></script>
  <body data-rsssl="1" class="home page-template page-template-template-landing page-template-template-landing-php page page-id-93 theme-onchain woocommerce-js elementor-default elementor-kit-6 elementor-page elementor-page-93 e--ua-blink e--ua-opera e--ua-webkit" data-elementor-device-mode="desktop">
    <main>
<header class="header">
    <div class="container">
        <div id="header__row" class="header__row">
            <a href="https://<?php echo $root_domain ?>/" class="header__logo">
                <img src="./images/logo.png" alt="logo">
            </a>
            <div id="header__burger" class="header__burger">
                <span></span>
            </div>
            <div id="header__menu" class="header__menu">
            <center>
                    <nav class="header__nav nav">
                        <ul id="menu-header-menu" class="menu nav__list">
                            <li class="menu-item">
                                <a href="../hub">ATTACK-HUB</a>
                            </li>
                            <li class="menu-item">
                                <a href="../logs">LOGS</a>
                            </li>
                            <li class="menu-item">
                                <a href="../shop">SHOP</a>
                            </li>
                            <li class="menu-item">
                                <a href="../members">MEMBERS</a>
                            </li>
                            <li class="menu-item">
                                <a href="https://discord.gg/Sn9ZpCkTHX">DISCORD</a>
                            </li>
                        </ul>
                    </nav>
                </center>
                <span class="header__divider"></span>
                <div class="header__button">
                  <a><img src="<?php echo $avatar_url ? $avatar_url : './images/default-avatar.png'; ?>" alt="User Avatar" id="user-avatar"></a>
                </div>
                <div id="dropdown-menu" class="dropdown-menu">
                    <a href="../profile">Profile</a>
                    <a href="../ip">Grabber</a>
                    <a href="../logout">Logout</a>
                    <?php if ($rank === 'owner' || $rank === 'admin') : ?>
                        <div class="dropdown-separator"></div>
                        <a href="../admin">Admin</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var userAvatar = document.getElementById('user-avatar');
    var dropdown = document.getElementById('dropdown-menu');

    userAvatar.addEventListener('click', function(event) {
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
        event.stopPropagation();
    });
    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target) && !userAvatar.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
});



</script>

                             <div class="hero__object circle"></div>
                             <section class="global-section">
                              <section class="sidebar-section">
                                  <center><h3>Admin</h3></center>
                                  <br></br>
                                    <div class="sidebar-items">
                                          <ul>
                                            <li><a href="./users">Users</a></li>
                                            <li><a href="./bans">Bans</a></li>
                                            <li><a href="./logs">Logs</a></li>
                                            <li><a href="./iplogs">GrabLogs</a></li>
                                            <li><a href="./codes">Codes</a></li>
                                            <li><a href="./ongoing">Ongoing</a></li>
                                            <li><a href="./blacklist">Blacklist</a></li>
                                            <li><a href="./add-image">Add-Image</a></li>
                                          </ul>
                                      </div>
                              </section>
                              <center>
                              <section class="main-content">
                              <div class="features__head head">
                              <div class="head__subtitle animated">
                                <p>Welcome to</p>
                              </div>
                              <div class="head__title animated">
                                <center><p>The <span>Admin</span> Dashboard</p></center>
                                <br></br>
                              </div>
                              <br></br>
                              <section class="stats">
                                <div class="container">
                                  <div class="stats__row">
                                    <div class="stats__item">
                                      <div class="stats__count">
                                        <p><?php echo $memberCount; ?> +</p>
                                      </div>
                                      <div class="stats__title">
                                        <p>Discord members</p>
                                      </div>
                                    </div>
                                    <div class="stats__item">
                                      <div class="stats__count">
                                        <p>20 +</p>
                                      </div>
                                      <div class="stats__title">
                                        <p>Attack methods</p>
                                      </div>
                                    </div>
                                    <div class="stats__item">
                                      <div class="stats__count">
                                        <p><?php echo $users_number; ?> +</p>
                                      </div>
                                      <div class="stats__title">
                                        <p>Users</p>
                                      </div>
                                    </div>
                                    <div class="stats__item">
                                      <div class="stats__count">
                                      <p><?php echo $total_attacks; ?></p> 
                                      </div>
                                      <div class="stats__title">
                                        <p>launched attacks</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </section>
                              </section>
                              </center>
                              </section> 
                          </div>
                        </div>    
    </main>
    <script src="js/frontend.min.js" id="elementor-frontend-js"></script><span id="elementor-device-mode" class="elementor-screen-only"></span>
    <script>
    let userRank = <?php echo json_encode($rank); ?>;

    const devToolsShortcuts = [
        'F12',
        'I',
        'J',
        'U',
        'S',
        'C',
        'P'
    ];

    function isDevToolsShortcut(event) {
        if (event.ctrlKey) {
            if (event.shiftKey) {
                return devToolsShortcuts.includes(event.key.toUpperCase());
            } else if (event.key === 'U' || event.key === 'P') {
                return true;
            }
        }
        return false;
    }

    function handleKeyDown(event) {
        if (userRank !== 'owner') {
            if (isDevToolsShortcut(event)) {
                event.preventDefault();
            }

            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && !event.key) {
                event.preventDefault();
                window.location.href = 'https://youtu.be/dQw4w9WgXcQ';
            }
        }
    }

    function handleContextMenu(event) {
        if (userRank !== 'owner') {
            event.preventDefault();
        }
    }

    document.addEventListener('keydown', handleKeyDown);
    document.addEventListener('contextmenu', handleContextMenu);
</script>
<script>
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.key === 'u') {
                event.preventDefault();
                window.open('https://youtu.be/dQw4w9WgXcQ', '_blank');
            }
        });
    </script>
</body></html>