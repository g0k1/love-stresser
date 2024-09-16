<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
session_start();
include("../../componements/php/root_domain.php");
include("./../../componements/php/database_conn.php");
include("./../../componements/php/unauthorized.php");
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
        header("Location: ../../logout");
        exit;
    }

    $stmt_banned = $conn->prepare("SELECT banned FROM users WHERE token = ?");
    $stmt_banned->bind_param("s", $token);
    $stmt_banned->execute();
    $stmt_banned->bind_result($banned);
    $stmt_banned->fetch();
    $stmt_banned->close();

    if ($banned == 1) {
        header("Location: ../../banned");
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
        header("Location: ../../home");
        exit;
    }


    ?>

    <?php

} else {
    header("Location: ../../home");
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
$file = '../../authentication/handler/status/status.json';
$status = json_decode(file_get_contents($file), true);
if ($status['status'] === 'offline') {
    include('../../help/cgu/index.php');
    die();
} else {
}
?>
<html class="no-js" lang="en-US"><head>
    <meta charset="UTF-8">
    <script>console.log = function(){ };</script>
    <title>Love Stresser - Admin</title>
    <meta name="robots" content="max-image-preview:large">
    <meta name="generator" content="Elementor 3.20.2; features: e_optimized_assets_loading, e_optimized_css_loading, additional_custom_breakpoints, block_editor_assets_optimize, e_image_loading_optimization; settings: css_print_method-external, google_font-enabled, font_display-swap">
    <link rel="icon" href="../images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="../images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="../images/cropped-favicon-180x180.png">
    <meta name="msapplication-TileImage" content="https://alethemes.com/onchain/wp-content/uploads/sites/109/2022/12/cropped-favicon-270x270.png">
</head>
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
body,div,span,h3,ul,li,a,img,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
}

@media all{
html,body{box-sizing:border-box;margin:0;padding:0;width:100vw;background:#06060C;position:relative;max-width:100%;overflow-x:hidden;font-family:'Urbanist', sans-serif;}
*,*:before,*:after{box-sizing:inherit;margin:0;padding:0;color:#fff;list-style-type:none;}
*::placeholder{font-size:16px;}
a,button{font-family:'Urbanist', sans-serif;text-decoration:none;cursor:pointer;}
a{cursor:pointer;}
.container{display:flex;align-items:flex-start;flex-direction:row;flex-wrap:wrap;max-width:1440px;width:100%;margin:0 auto;position:relative;}
@media (max-width: 1480px){
.container{padding:0 20px;}
}
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
.current-menu-item{font-weight:900;}
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
button{display:flex;align-items:center;justify-content:center;border-radius:100px;font-style:normal;font-weight:600;font-size:18px;line-height:22px;color:#FFFFFF;border:none;height:62px;width:154px;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);box-shadow:0 16px 24px rgba(247, 15, 255, 0.48);cursor:pointer;}
.hero__object{animation:zoom ease-out;animation-delay:0.4s;animation-duration:1.5s;top:-160px;left:260px;z-index:1;}
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
.current_selected{text-decoration:underline;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}

.modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;overflow:auto;justify-content:center;align-items:center;}
.modal-content{margin:auto;padding:20px;width:600px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);background-color:#0b0b11;}
.close{color:#aaa;float:right;font-size:28px;font-weight:bold;}
.close:hover,.close:focus{cursor:pointer;}
.sidebar-section{display:flex;flex-direction:column;padding:50px;margin-bottom:24px;height:1192px;margin-top:24px;margin-left:50px;width:300px;border-radius:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);}
.sidebar-items{text-align:center;}
.main-content{border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);padding:50px 0;width:1440px;display:flex;height:1025px;margin-top:-1050px;justify-content:center;align-items:center;}
table{border-collapse:separate;border-spacing:0;border:none;border-radius:15px;}
th,td{border-bottom:1px solid rgba(255, 255, 255, 0.2);border-top:none;border-left:none;border-right:none;text-align:center;padding:20px;color:#fff;}
.pagination-link{margin-right:5px;cursor:pointer;}
.pagination-controls{text-align:center;margin-top:20px;}
.pagination-controls a{display:inline-block;margin:0 5px;text-decoration:none;color:#fff;border-radius:4px;}
.pagination-controls a.active{color:#fff;}
.pagination-controls a:hover{color:#fff;}
button{width:150px;height:50px;border-radius:15px;}

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
    <body data-rsssl="1" class="home page-template page-template-template-landing page-template-template-landing-php page page-id-93 theme-onchain woocommerce-js elementor-default elementor-kit-6 elementor-page elementor-page-93 e--ua-blink e--ua-opera e--ua-webkit" data-elementor-device-mode="desktop">
    <main>
<header class="header">
    <div class="container">
        <div id="header__row" class="header__row">
            <a href="https://<?php echo $root_domain ?>/" class="header__logo">
                <img src="../images/logo.png" alt="logo">
            </a>
            <div id="header__burger" class="header__burger">
                <span></span>
            </div>
            <div id="header__menu" class="header__menu">
            <center>
                    <nav class="header__nav nav">
                        <ul id="menu-header-menu" class="menu nav__list">
                            <li class="menu-item">
                                <a href="../../hub">ATTACK-HUB</a>
                            </li>
                            <li class="menu-item">
                                <a href="../../logs">LOGS</a>
                            </li>
                            <li class="menu-item">
                                <a href="../../shop">SHOP</a>
                            </li>
                            <li class="menu-item">
                                <a href="../../members">MEMBERS</a>
                            </li>
                            <li class="menu-item">
                                <a href="https://discord.gg/Sn9ZpCkTHX">DISCORD</a>
                            </li>
                        </ul>
                    </nav>
                </center>
                <span class="header__divider"></span>
                <div class="header__button">
                  <a><img src="<?php echo $avatar_url ? $avatar_url : '../images/default-avatar.png'; ?>" alt="User Avatar" id="user-avatar"></a>
                </div>
                <div id="dropdown-menu" class="dropdown-menu">
                    <a href="../../profile">Profile</a>
                    <a href="../../ip">Grabber</a>
                    <a href="../../logout">Logout</a>
                    <?php if ($rank === 'owner' || $rank === 'admin') : ?>
                        <div class="dropdown-separator"></div>
                        <a href="../">Admin</a>
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
                                  <center><a href="../"><h3>Admin</a></h3></center>
                                  <br></br>
                                    <div class="sidebar-items">
                                          <ul>
                                            <li><a href="../users">Users</a></li>
                                            <li><a href="../bans">Bans</a></li>
                                            <li><a href="../logs">Logs</a></li>
                                            <li><a class="current_selected current-menu-item" href="">GrabLogs</a></li>
                                            <li><a href="../codes">Codes</a></li>
                                            <li><a href="../ongoing">Ongoing</a></li>
                                            <li><a href="../blacklist">Blacklist</a></li>
                                            <li><a href="../add-image">Add-Image</a></li>
                                          </ul>
                                      </div>
                              </section>
                              <center>

                              <section class="main-content">
                        
<section class="containerabc">
    <section class="new-section2">
        <div id="results"></div>
    </section>
    <section class="new-section3">
        <div id="other-content"></div>
    </section>
</section>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <table id="resultDetails"></table>
    </div>
</div>
</section>

<script>
function fetchResults() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "results.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                displayResults(JSON.parse(xhr.responseText));
            }
        };
        xhr.send();
    }

    const countryMapping = {
    'AF': 'Afghanistan',
    'AL': 'Albania',
    'DZ': 'Algeria',
    'AS': 'American Samoa',
    'AD': 'Andorra',
    'AO': 'Angola',
    'AI': 'Anguilla',
    'AQ': 'Antarctica',
    'AG': 'Antigua and Barbuda',
    'AR': 'Argentina',
    'AM': 'Armenia',
    'AW': 'Aruba',
    'AU': 'Australia',
    'AT': 'Austria',
    'AZ': 'Azerbaijan',
    'BS': 'Bahamas',
    'BH': 'Bahrain',
    'BD': 'Bangladesh',
    'BB': 'Barbados',
    'BY': 'Belarus',
    'BE': 'Belgium',
    'BZ': 'Belize',
    'BJ': 'Benin',
    'BM': 'Bermuda',
    'BT': 'Bhutan',
    'BO': 'Bolivia',
    'BA': 'Bosnia and Herzegovina',
    'BW': 'Botswana',
    'BR': 'Brazil',
    'IO': 'British Indian Ocean Territory',
    'BN': 'Brunei',
    'BG': 'Bulgaria',
    'BF': 'Burkina Faso',
    'BI': 'Burundi',
    'KH': 'Cambodia',
    'CM': 'Cameroon',
    'CA': 'Canada',
    'CV': 'Cape Verde',
    'KY': 'Cayman Islands',
    'CF': 'Central African Republic',
    'TD': 'Chad',
    'CL': 'Chile',
    'CN': 'China',
    'CO': 'Colombia',
    'KM': 'Comoros',
    'CG': 'Congo - Brazzaville',
    'CD': 'Congo - Kinshasa',
    'CR': 'Costa Rica',
    'CI': 'Côte d’Ivoire',
    'HR': 'Croatia',
    'CU': 'Cuba',
    'CY': 'Cyprus',
    'CZ': 'Czechia',
    'DK': 'Denmark',
    'DJ': 'Djibouti',
    'DM': 'Dominica',
    'DO': 'Dominican Republic',
    'EC': 'Ecuador',
    'EG': 'Egypt',
    'SV': 'El Salvador',
    'GQ': 'Equatorial Guinea',
    'ER': 'Eritrea',
    'EE': 'Estonia',
    'SZ': 'Eswatini',
    'ET': 'Ethiopia',
    'FK': 'Falkland Islands',
    'FO': 'Faroe Islands',
    'FJ': 'Fiji',
    'FI': 'Finland',
    'FR': 'France',
    'GF': 'French Guiana',
    'PF': 'French Polynesia',
    'TF': 'French Southern Territories',
    'GA': 'Gabon',
    'GM': 'Gambia',
    'GE': 'Georgia',
    'DE': 'Germany',
    'GH': 'Ghana',
    'GI': 'Gibraltar',
    'GR': 'Greece',
    'GL': 'Greenland',
    'GD': 'Grenada',
    'GP': 'Guadeloupe',
    'GU': 'Guam',
    'GT': 'Guatemala',
    'GG': 'Guernsey',
    'GN': 'Guinea',
    'GW': 'Guinea-Bissau',
    'GY': 'Guyana',
    'HT': 'Haiti',
    'HN': 'Honduras',
    'HK': 'Hong Kong SAR China',
    'HU': 'Hungary',
    'IS': 'Iceland',
    'IN': 'India',
    'ID': 'Indonesia',
    'IR': 'Iran',
    'IQ': 'Iraq',
    'IE': 'Ireland',
    'IM': 'Isle of Man',
    'IL': 'Israel',
    'IT': 'Italy',
    'JM': 'Jamaica',
    'JP': 'Japan',
    'JE': 'Jersey',
    'JO': 'Jordan',
    'KZ': 'Kazakhstan',
    'KE': 'Kenya',
    'KI': 'Kiribati',
    'KW': 'Kuwait',
    'KG': 'Kyrgyzstan',
    'LA': 'Laos',
    'LV': 'Latvia',
    'LB': 'Lebanon',
    'LS': 'Lesotho',
    'LR': 'Liberia',
    'LY': 'Libya',
    'LI': 'Liechtenstein',
    'LT': 'Lithuania',
    'LU': 'Luxembourg',
    'MO': 'Macao SAR China',
    'MG': 'Madagascar',
    'MW': 'Malawi',
    'MY': 'Malaysia',
    'MV': 'Maldives',
    'ML': 'Mali',
    'MT': 'Malta',
    'MH': 'Marshall Islands',
    'MQ': 'Martinique',
    'MR': 'Mauritania',
    'MU': 'Mauritius',
    'YT': 'Mayotte',
    'MX': 'Mexico',
    'FM': 'Micronesia',
    'MD': 'Moldova',
    'MC': 'Monaco',
    'MN': 'Mongolia',
    'ME': 'Montenegro',
    'MS': 'Montserrat',
    'MA': 'Morocco',
    'MZ': 'Mozambique',
    'MM': 'Myanmar (Burma)',
    'NA': 'Namibia',
    'NR': 'Nauru',
    'NP': 'Nepal',
    'NL': 'Netherlands',
    'NC': 'New Caledonia',
    'NZ': 'New Zealand',
    'NI': 'Nicaragua',
    'NE': 'Niger',
    'NG': 'Nigeria',
    'NU': 'Niue',
    'NF': 'Norfolk Island',
    'KP': 'North Korea',
    'MK': 'North Macedonia',
    'MP': 'Northern Mariana Islands',
    'NO': 'Norway',
    'OM': 'Oman',
    'PK': 'Pakistan',
    'PW': 'Palau',
    'PS': 'Palestinian Territories',
    'PA': 'Panama',
    'PG': 'Papua New Guinea',
    'PY': 'Paraguay',
    'PE': 'Peru',
    'PH': 'Philippines',
    'PN': 'Pitcairn Islands',
    'PL': 'Poland',
    'PT': 'Portugal',
    'PR': 'Puerto Rico',
    'QA': 'Qatar',
    'RE': 'Réunion',
    'RO': 'Romania',
    'RU': 'Russia',
    'RW': 'Rwanda',
    'WS': 'Samoa',
    'SM': 'San Marino',
    'ST': 'São Tomé and Príncipe',
    'SA': 'Saudi Arabia',
    'SN': 'Senegal',
    'RS': 'Serbia',
    'SC': 'Seychelles',
    'SL': 'Sierra Leone',
    'SG': 'Singapore',
    'SX': 'Sint Maarten',
    'SK': 'Slovakia',
    'SI': 'Slovenia',
    'SB': 'Solomon Islands',
    'SO': 'Somalia',
    'ZA': 'South Africa',
    'GS': 'South Georgia and South Sandwich Islands',
    'KR': 'South Korea',
    'SS': 'South Sudan',
    'ES': 'Spain',
    'LK': 'Sri Lanka',
    'BL': 'St. Barthélemy',
    'SH': 'St. Helena',
    'KN': 'St. Kitts and Nevis',
    'LC': 'St. Lucia',
    'MF': 'St. Martin',
    'PM': 'St. Pierre and Miquelon',
    'VC': 'St. Vincent and Grenadines',
    'SD': 'Sudan',
    'SR': 'Suriname',
    'SJ': 'Svalbard and Jan Mayen',
    'SE': 'Sweden',
    'CH': 'Switzerland',
    'SY': 'Syria',
    'TW': 'Taiwan',
    'TJ': 'Tajikistan',
    'TZ': 'Tanzania',
    'TH': 'Thailand',
    'TL': 'Timor-Leste',
    'TG': 'Togo',
    'TK': 'Tokelau',
    'TO': 'Tonga',
    'TT': 'Trinidad and Tobago',
    'TN': 'Tunisia',
    'TR': 'Turkey',
    'TM': 'Turkmenistan',
    'TC': 'Turks and Caicos Islands',
    'TV': 'Tuvalu',
    'UG': 'Uganda',
    'UA': 'Ukraine',
    'AE': 'United Arab Emirates',
    'GB': 'United Kingdom',
    'US': 'United States',
    'UY': 'Uruguay',
    'UZ': 'Uzbekistan',
    'VU': 'Vanuatu',
    'VA': 'Vatican City',
    'VE': 'Venezuela',
    'VN': 'Vietnam',
    'WF': 'Wallis and Futuna',
    'EH': 'Western Sahara',
    'YE': 'Yemen',
    'ZM': 'Zambia',
    'ZW': 'Zimbabwe'
};
let currentPage = 1;
const resultsPerPage = 8;
const maxVisiblePages = 5;

function displayResults(results) {
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = '';

    let allData = results.data || [];

    allData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    if (allData.length === 0) {
        resultsContainer.textContent = 'No results to display';
        return;
    }

    const table = document.createElement('table');
    const header = document.createElement('tr');
    ['OWNER ID', 'OWNER', 'CODE', 'COLLECTED IP', 'COLLECTED OS', 'COLLECTED COUNTRY', 'DATE/TIME', 'ACTION'].forEach(text => {
        const th = document.createElement('th');
        th.textContent = text;
        header.appendChild(th);
    });
    table.appendChild(header);

    const totalPages = Math.ceil(allData.length / resultsPerPage);
    const start = (currentPage - 1) * resultsPerPage;
    const end = start + resultsPerPage;
    const paginatedData = allData.slice(start, end);

    paginatedData.forEach(data => {
        const row = document.createElement('tr');

        const userIdCell = document.createElement('td');
        const avatarCell = document.createElement('td');
        const codeCell = document.createElement('td');
        const ipCell = document.createElement('td');
        const osCell = document.createElement('td');
        const countryCell = document.createElement('td');
        const dateCell = document.createElement('td');
        const actionCell = document.createElement('td');

        userIdCell.textContent = data.user_id;

        const avatarImg = document.createElement('img');
        avatarImg.src = data.avatar;
        avatarImg.alt = 'User Avatar';
        avatarImg.style.width = '50px';
        avatarImg.style.height = '50px';
        avatarImg.style.borderRadius = '50%';

        avatarCell.appendChild(avatarImg);

        codeCell.textContent = data.code;
        ipCell.textContent = data.ip;
        osCell.textContent = data.os;
        countryCell.textContent = countryMapping[data.country] || data.country;
        dateCell.textContent = data.created_at;

        const viewButton = document.createElement('button');
        viewButton.textContent = 'View Full Report';
        viewButton.href = '#';
        viewButton.onclick = () => openModal(data);
        actionCell.appendChild(viewButton);

        row.appendChild(userIdCell);
        row.appendChild(avatarCell);
        row.appendChild(codeCell);
        row.appendChild(ipCell);
        row.appendChild(osCell);
        row.appendChild(countryCell);
        row.appendChild(dateCell);
        row.appendChild(actionCell);

        table.appendChild(row);
    });

    resultsContainer.appendChild(table);

    // Pagination controls
    const paginationControls = document.createElement('div');
    paginationControls.className = 'pagination-controls';

    if (currentPage > 1) {
        const prevButton = document.createElement('a');
        prevButton.textContent = 'Previous';
        prevButton.href = '#';
        prevButton.className = 'pagination-link';
        prevButton.setAttribute('data-page', currentPage - 1);
        paginationControls.appendChild(prevButton);
    }

    const startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    const endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (startPage > 1) {
        const firstPage = document.createElement('a');
        firstPage.textContent = '1';
        firstPage.href = '#';
        firstPage.className = 'pagination-link';
        firstPage.setAttribute('data-page', 1);
        paginationControls.appendChild(firstPage);

        if (startPage > 2) {
            paginationControls.appendChild(document.createTextNode('...'));
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        const pageLink = document.createElement('a');
        pageLink.textContent = i;
        pageLink.href = '#';
        pageLink.className = (i === currentPage) ? 'pagination-link active' : 'pagination-link';
        pageLink.setAttribute('data-page', i);
        paginationControls.appendChild(pageLink);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            paginationControls.appendChild(document.createTextNode('...'));
        }
        const lastPage = document.createElement('a');
        lastPage.textContent = totalPages;
        lastPage.href = '#';
        lastPage.className = 'pagination-link';
        lastPage.setAttribute('data-page', totalPages);
        paginationControls.appendChild(lastPage);
    }

    if (currentPage < totalPages) {
        const nextButton = document.createElement('a');
        nextButton.textContent = 'Next';
        nextButton.href = '#';
        nextButton.className = 'pagination-link';
        nextButton.setAttribute('data-page', currentPage + 1);
        paginationControls.appendChild(nextButton);
    }

    resultsContainer.appendChild(paginationControls);

    paginationControls.addEventListener('click', function(e) {
        if (e.target.classList.contains('pagination-link')) {
            e.preventDefault();
            currentPage = parseInt(e.target.getAttribute('data-page'));
            fetchResults();
        }
    });
}

function openModal(data) {
    const modal = document.getElementById('myModal');
    const span = document.getElementsByClassName('close')[0];
    const resultDetails = document.getElementById('resultDetails');
    resultDetails.innerHTML = '';

    const mapping = {
        'code': 'Code',
        'ip': 'IP',
        'hostname': 'Hostname',
        'city': 'City',
        'region': 'Region',
        'country': 'Country',
        'loc': 'LOC',
        'org': 'ORG',
        'postal': 'ZIP',
        'timezone': 'Timezone',
        'browser': 'Browser',
        'os': 'OS',
        'screen': 'Display',
        'gpu': 'GPU',
        'created_at': 'Date/Time'
    };

    const table = document.createElement('table');
    const header = document.createElement('tr');
    const nameHeader = document.createElement('th');
    const resultHeader = document.createElement('th');
    nameHeader.textContent = 'Name';
    resultHeader.textContent = 'Result';
    header.appendChild(nameHeader);
    header.appendChild(resultHeader);
    table.appendChild(header);

    for (const key in data) {
        if (data.hasOwnProperty(key) && mapping[key]) {
            const row = document.createElement('tr');
            const cellKey = document.createElement('td');
            const cellValue = document.createElement('td');
            cellKey.innerText = mapping[key];

            if (key === 'country') {
                cellValue.innerText = countryMapping[data[key]] || data[key];
            } else {
                cellValue.innerText = data[key];
            }

            row.appendChild(cellKey);
            row.appendChild(cellValue);
            table.appendChild(row);
        }
    }

    resultDetails.appendChild(table);

    modal.style.display = 'block';

    span.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
}

fetchResults();
    let notifications = [];

    function createNotificationContainer() {
        let container = document.querySelector('.notification-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'notification-container';
            document.body.appendChild(container);
        }
        return container;
    }

    function updateNotificationPositions() {
        notifications.forEach((notification, index) => {
            notification.style.bottom = `${index * 70}px`;
        });
    }

    function displayErrorMessage(message) {
        displayNotification(message, 'error_notification');
    }

    function displayNotification(message, type = 'notification') {
        const container = createNotificationContainer();
        
        var notification = document.createElement('div');
        notification.className = type;
        
        var messageContainer = document.createElement('p');
        messageContainer.className = `${type}_message`;
        messageContainer.textContent = message;
        
        notification.appendChild(messageContainer);
        container.appendChild(notification);

        notifications.push(notification);
        updateNotificationPositions();

        setTimeout(function() {
            notification.classList.remove('hide');
            notification.style.display = 'flex';
        }, 10);

        setTimeout(function() {
            notification.classList.add('hide');
            
            setTimeout(function() {
                notification.remove();
                notifications = notifications.filter(n => n !== notification);
                updateNotificationPositions();
            }, 500);
        }, 3000);
    }
function toggleInputField() {
    var sortBy = document.getElementById('sort_by').value;
    var textInput = document.getElementById('filter_value');
    var dateInput = document.getElementById('filter_date');

    if (sortBy === 'time') {
        textInput.style.display = 'none';
        dateInput.style.display = 'inline';
    } else {
        textInput.style.display = 'inline';
        dateInput.style.display = 'none';
    }
}
</script>


                              </center>
                              </section>
                          </div>
                        </div>    
    </main>
    <script src="../js/frontend.min.js" id="elementor-frontend-js"></script><span id="elementor-device-mode" class="elementor-screen-only"></span>
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
