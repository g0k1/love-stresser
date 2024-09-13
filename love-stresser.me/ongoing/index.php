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

    include("../../componements/php/plans.php");

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
body,div,span,h3,p,ul,li,a,img,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
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
a{font-family:'Urbanist', sans-serif;text-decoration:none;cursor:pointer;}
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
.stop_button_a {
    align-items: center;
    justify-content: center;
    align-self: center;
    border-radius: 10px;
    padding: 10px;
    font-style: normal;
    font-weight: 600;
    font-size: 18px;
    line-height: 22px;
    color: #FFFFFF;
    border: none;
    height: 42px;
    width: 64px;
    background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
    /* box-shadow: 0 16px 24px rgba(247, 15, 255, 0.48); */
    cursor: pointer;
    /* margin-bottom: 10px; */
    transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
}
.loadingDots {
    display: inline-block;
    position: relative;
    width: 30px;
    height: 10px;
}

.loadingDots div {
    position: absolute;
    top: 0;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FFFFFF;
    animation-timing-function: cubic-bezier(0, 1, 1, 0);
}

.loadingDots div:nth-child(1) {
    left: 0;
    animation: loadingDots1 0.6s infinite;
}
.loadingDots div:nth-child(2) {
    left: 8px;
    animation: loadingDots2 0.6s infinite;
}
.loadingDots div:nth-child(3) {
    left: 16px;
    animation: loadingDots2 0.6s infinite;
}
.loadingDots div:nth-child(4) {
    left: 24px;
    animation: loadingDots3 0.6s infinite;
}

@keyframes loadingDots1 {
    0% {
        transform: scale(0);
    }
    100% {
        transform: scale(1);
    }
}
@keyframes loadingDots2 {
    0% {
        transform: translate(0, 0);
    }
    100% {
        transform: translate(8px, 0);
    }
}
@keyframes loadingDots3 {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(0);
    }
}
.sidebar-section{display:flex;flex-direction:column;padding:50px;margin-bottom:24px;height:1192px;margin-top:24px;margin-left:50px;width:300px;border-radius:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);}
.sidebar-items{text-align:center;}
.main-content{border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);padding:50px 0;width:1440px;display:flex;height:1025px;margin-top:-1050px;justify-content:center;align-items:center;}
table{border-collapse:separate;border-spacing:0;border:none;border-radius:15px;}
th,td{border-bottom:1px solid rgba(255, 255, 255, 0.2);border-top:none;border-left:none;border-right:none;text-align:center;padding:20px;color:#fff;}
tbody tr:nth-child(odd){background-color:transparent;}
tbody tr:nth-child(even){background-color:transparent;}
.notification,.error_notification{position:absolute;right:20px;background-color:#0b0b11;padding:15px;border-radius:14px;display:none;align-items:center;z-index:1000;box-shadow:0 2px 10px rgba(0, 0, 0, 0.2);animation:slideInFromRight 0.5s ease-out;margin-bottom:10px;transform:translateX(0);opacity:1;transition:opacity 0.5s ease-out, transform 0.5s ease-out, bottom 0.5s ease-out;white-space:nowrap;max-width:calc(100vw - 40px);word-wrap:break-word;}
.notification p,.error_notification p{color:#26d833;margin:0;}
.error_notification p{color:#bb0b0b;}

@keyframes zoom{0%{width:40px;height:40px;top:50px;left:20px;}100%{width:240px;height:240px;top:-160px;left:260px;}}
@keyframes slideInFromRight{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}

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
    <link rel="icon" href="../images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="../images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="../images/cropped-favicon-180x180.png">
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
<div id="notification" class="notification">
                            <p id="notification_message"></p>
                            </div>
                          <div id="error_notification" class="error_notification">
                            <p id="error_notification_message"></p>
                          </div>
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
                                            <li><a href="../iplogs">GrabLogs</a></li>
                                            <li><a href="../codes">Codes</a></li>
                                            <li><a class="current_selected current-menu-item" href="">Ongoing</a></li>
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
    date_default_timezone_set('UTC');
    $current_time = new DateTime();

    $records_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;

    $total_sql = "SELECT COUNT(*) as total FROM attacks a
                  WHERE a.end_time > '" . $current_time->format('Y-m-d H:i:s') . "'";
    $total_result = $conn->query($total_sql);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    $sql = "SELECT a.id, a.user_token, a.ip, a.port, a.method, a.start_time, a.end_time, u.avatar, u.username
            FROM attacks a
            JOIN users u ON a.user_token = u.token
            WHERE a.end_time > '" . $current_time->format('Y-m-d H:i:s') . "'
            LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);

    echo '<table>';
    echo '<tr>
            <th>Attack ID</th>
            <th>Avatar</th>
            <th>Username</th>
            <th>Target</th>
            <th>Port</th>
            <th>Method</th>
            <th>Time</th>
            <th>Action</th>
          </tr>';

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $start_time = new DateTime($row['start_time']);
            $end_time = new DateTime($row['end_time']);
            $remaining_seconds = $end_time->getTimestamp() - $current_time->getTimestamp();

            $is_ip = filter_var($row['ip'], FILTER_VALIDATE_IP);
            $api_type = $is_ip ? "layer4" : "layer7";

            if ($remaining_seconds > 0) {
                echo '<tr data-id="' . $row["id"] . '" data-target="' . $row["ip"] . '" data-port="' . $row["port"] . '" data-method="' . $row["method"] . '" data-duration="' . $remaining_seconds . '">
                    <td>' . $row["id"] . '</td>
                    <td><img src="' . $row["avatar"] . '" style="width: 50px; height: 50px; border-radius: 50%;" alt="Avatar"></td>
                    <td>' . $row["username"] . '</td>
                    <td>' . $row["ip"] . '</td>
                    <td>' . $row["port"] . '</td>
                    <td>' . $row["method"] . '</td>
                    <td id="remaining_time_' . $row["id"] . '">' . $remaining_seconds . '</td>
                    <td><button class="stop_button_a" data-id="' . $row["id"] . '">STOP</button></td>
                </tr>';
            }
        }
    } else {
        echo '<tr><td colspan="8">No running attacks found</td></tr>';
    }

    echo '</table>';

    $conn->close();
?>
<script>
    function updateRemainingTime() {
        document.querySelectorAll('[id^="remaining_time_"]').forEach(function(element) {
            let remainingTime = parseInt(element.innerText.split(' ')[0]);

            if (remainingTime > 0) {
                remainingTime--;
                element.innerText = remainingTime;
            } else {
                element.innerText = "Expired";
            }
        });
    }

    setInterval(updateRemainingTime, 1000);
</script>
<script>
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

function playSound(type) {
    const sound = new Audio(type === 'error_notification' ? 'https://<?php echo $root_domain ?>/files/mp3/error_sound.mp3' : 'https://<?php echo $root_domain ?>/files/mp3/success_sound.mp3');
    sound.play();
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

        playSound(type);
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

function displayErrorMessage(message) {
    displayNotification(message, 'error_notification');
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.stop_button_a').forEach(function (button) {
        button.addEventListener('click', function () {
            var row = this.closest('tr');
            var attackId = row.getAttribute('data-id');
            var attackTarget = row.getAttribute('data-target');
            var attackPort = row.getAttribute('data-port');
            var attackMethod = row.getAttribute('data-method');
            var attackDuration = row.getAttribute('data-duration');
            
            stopAttack(attackId, attackTarget, attackPort, attackMethod, attackDuration);
        });
    });
});

function stopAttack(attackId, attackTarget, attackPort, attackMethod, attackDuration) {
    var stopButton = document.querySelector('button[data-id="' + attackId + '"]');
    if (!stopButton) {
        displayErrorMessage('Stop button not found.');
        return;
    }

    var originalButtonText = stopButton.innerHTML;

    stopButton.innerHTML = '<div class="loadingDots"><div></div><div></div><div></div><div></div></div>';
    stopButton.disabled = true;

    $.ajax({
        url: `https://love-stresser.me/handler/stop/?id=${attackId}&target=${attackTarget}&port=${attackPort}&duration=${attackDuration}&method=${attackMethod}`,
        type: 'GET',
        success: function(response) {
            console.log("API Response:", response);

            stopButton.innerHTML = originalButtonText;
            stopButton.disabled = false;

            if (response.status === 'true' || response.adm === 'LSF-STOP') {
                var rowToDelete = document.querySelector('tr[data-id="' + attackId + '"]');
                if (rowToDelete) {
                    rowToDelete.remove();
                }

                var tableBody = document.querySelector('table tbody');
                var rows = tableBody.querySelectorAll('tr');

                if (rows.length === 1) {
                    var noDataRow = document.createElement('tr');
                    noDataRow.innerHTML = '<td colspan="8">No running attacks found</td>';
                    tableBody.appendChild(noDataRow);
                }

                displayNotification('Server-Side Attack Stopped Successfully!');
                updatePagination();
            } else {
                displayErrorMessage(response.message);
            }
        },
        error: function() {
            stopButton.innerHTML = originalButtonText;
            stopButton.disabled = false;

            displayErrorMessage('Failed to stop attack.');
        }
    });
}
</script>
</section>

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