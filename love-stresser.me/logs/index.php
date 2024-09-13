<?php
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
body,div,span,h3,ul,li,a,img,form,label,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,input{-webkit-text-size-adjust:none;}
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
select{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;}
select option{color:#333;}
input{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;font-family:'Urbanist', sans-serif;}
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

.sidebar-section{display:flex;flex-direction:column;padding:50px;margin-bottom:24px;height:1192px;margin-top:24px;margin-left:50px;width:300px;border-radius:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);}
.sidebar-items{text-align:center;}
.main-content{border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);padding:50px 0;width:1440px;display:flex;height:1025px;margin-top:-1050px;justify-content:center;align-items:center;}
table{border-collapse:separate;border-spacing:0;border:none;border-radius:15px;}
th,td{border-bottom:1px solid rgba(255, 255, 255, 0.2);border-top:none;border-left:none;border-right:none;text-align:center;padding:20px;color:#fff;}
thead{background-color:transparent;}
tbody tr:nth-child(odd){background-color:transparent;}
tbody tr:nth-child(even){background-color:transparent;}
.pagination{margin-top:10px;margin-left:80px;margin-right:80px;}
.space_under{margin-bottom:10px;}
input,select{width:800px;}

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
    <link rel="icon" href="../images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="../images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="../images/cropped-favicon-180x180.png">
    <meta name="msapplication-TileImage" content="https://alethemes.com/onchain/wp-content/uploads/sites/109/2022/12/cropped-favicon-270x270.png">
    <script src="js/wp-emoji-release.min.js" defer=""></script>
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
                                            <li><a class="current_selected current-menu-item" href="">Logs</a></li>
                                            <li><a href="../iplogs">GrabLogs</a></li>
                                            <li><a href="../codes">Codes</a></li>
                                            <li><a href="../ongoing">Ongoing</a></li>
                                            <li><a href="../blacklist">Blacklist</a></li>
                                            <li><a href="../add-image">Add-Image</a></li>
                                          </ul>
                                      </div>
                              </section>
                              <center>

                              <section class="main-content">
                              <?php
include("./../../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$logs_per_page = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $logs_per_page;

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
$filter_value = isset($_GET['filter_value']) ? $_GET['filter_value'] : '';

$conditions = "";
if (!empty($sort_by) && !empty($filter_value)) {
    if ($sort_by == "id") {
        $conditions = "WHERE users.id = '$filter_value'";
    } elseif ($sort_by == "username") {
        $conditions = "WHERE users.username LIKE '%$filter_value%'";
    } elseif ($sort_by == "host") {
        $conditions = "WHERE attack_logs.attack_target LIKE '%$filter_value%'";
    }
}

$order_clause = "ORDER BY attack_logs.id DESC";

$total_sql = "SELECT COUNT(*) FROM attack_logs JOIN users ON attack_logs.user_id = users.id $conditions";
$total_result = $conn->query($total_sql);
$total_logs = $total_result->fetch_row()[0];
$total_pages = ceil($total_logs / $logs_per_page);

$sql = "
    SELECT 
        attack_logs.id,
        attack_logs.attack_layer,
        attack_logs.attack_target,
        attack_logs.attack_duration,
        attack_logs.attack_method,
        attack_logs.attack_port,
        attack_logs.attack_time,
        users.username,
        users.avatar
    FROM 
        attack_logs
    JOIN 
        users 
    ON 
        attack_logs.user_id = users.id
    $conditions
    $order_clause
    LIMIT $start_from, $logs_per_page
";

$result = $conn->query($sql);
?>
<center>
    <form method="GET" action="">
        <label for="sort_by">Sort/Filter By:</label>
        <br></br>
        <select class="space_under" id="sort_by" name="sort_by" onchange="toggleInputField()">
            <option value="">Select...</option>
            <option value="id" <?php if ($sort_by == 'id') echo 'selected'; ?>>ID</option>
            <option value="username" <?php if ($sort_by == 'username') echo 'selected'; ?>>Username</option>
            <option value="host" <?php if ($sort_by == 'host') echo 'selected'; ?>>Host</option>
        </select>
        <input class="space_under" type="text" id="filter_value" name="filter_value" value="<?php echo htmlspecialchars($filter_value); ?>">
        <button class="space_under" type="submit">Search</button>
    </form>
    
    <table id="logs-table">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Username</th>  
                <th>Layer</th>
                <th>Target</th>
                <th>Duration</th>
                <th>Method</th>
                <th>Port</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img src='" . htmlspecialchars($row["avatar"]) . "' alt='Avatar' style='border-radius: 15px;' width='50'></td>";
                    echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["attack_layer"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["attack_target"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["attack_duration"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["attack_method"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["attack_port"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["attack_time"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No logs found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <div class="pagination">
    <?php if ($total_pages > 1): ?>
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&sort_by=<?= $sort_by ?>&filter_value=<?= urlencode($filter_value) ?>">Previous</a>
        <?php endif; ?>

        <?php if ($page > 3): ?>
            <a href="?page=1&sort_by=<?= $sort_by ?>&filter_value=<?= urlencode($filter_value) ?>">1</a>
            <?php if ($page > 4): ?>
                <span>...</span>
            <?php endif; ?>
        <?php endif; ?>

        <?php
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $page + 2);

        for ($i = $start_page; $i <= $end_page; $i++): ?>
            <a href="?page=<?= $i ?>&sort_by=<?= $sort_by ?>&filter_value=<?= urlencode($filter_value) ?>" 
                class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($end_page < $total_pages - 2): ?>
            <span>...</span>
        <?php endif; ?>
        <?php if ($end_page < $total_pages): ?>
            <a href="?page=<?= $total_pages ?>&sort_by=<?= $sort_by ?>&filter_value=<?= urlencode($filter_value) ?>"><?= $total_pages ?></a>
        <?php endif; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>&sort_by=<?= $sort_by ?>&filter_value=<?= urlencode($filter_value) ?>">Next</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
</center>

<script>
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