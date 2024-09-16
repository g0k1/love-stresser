<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
session_start();

include("../componements/php/database_conn.php");
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

    include("../componements/php/plans.php");
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
    
    $current_stats = isset($stats[$user_plan]) ? $stats[$user_plan] : [];
    
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
<script>console.log = function(){ };</script>
<html class="no-js" lang="en-US"><head>
    
    <meta charset="UTF-8">
    <title>Love Stresser - Attack-HUB</title>
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
footer,header,nav,section{display:block;}
html{-webkit-tap-highlight-color:rgba(0, 0, 0, 0);-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
body,div,span,h1,h5,p,ul,li,a,img,footer,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,input{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
.story h1{font-size:50px;}
.story h1,.story h5{text-transform:none;margin-bottom:20px;}
.story a{color:inherit;}
.story a:link,.story a:visited,.story a:hover,.story a:active{text-decoration:none;}
.head .head__title,.head .head__description{opacity:0;}
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
.head__title p{font-weight:700;font-size:48px;line-height:56px;}
.head__title p span{background:-webkit-linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.head__description{margin-top:24px;}
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
.hero{height:800px;position:relative;margin-bottom:100px;display:flex;}
select{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;}
select option{color:#333;}
input{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;font-family:'Urbanist', sans-serif;}
.hero__object{animation:zoom ease-out;animation-delay:0.4s;animation-duration:1.5s;top:-160px;left:260px;z-index:1;}
.hero__wrapper{width:100%;display:flex;height:100%;justify-content:space-between;}
@media (max-width: 992px){
.hero{height:auto;padding-top:180px;}
}
@media (max-width: 768px){
.hero{height:auto;padding-top:180px;}
}
.stats__row{display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));grid-auto-flow:row;width:100%;gap:30px;}
.stats__count{width:100%;}
.stats__count p{font-style:normal;font-weight:700;font-size:48px;text-align:center;line-height:56px;}
.stats__title{width:100%;}
.stats__title p{font-weight:700;font-size:16px;line-height:19px;text-align:center;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255, 255, 255, 0.64);}
.features__head{width:100%;display:flex;align-items:center;}
.footer{margin:140px 0 100px 0;}
.footer__wrapper{display:flex;flex-direction:column;padding:48px;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:24px;gap:48px;width:100%;}
.copyright{display:flex;align-items:center;justify-content:space-between;width:100%;flex-wrap:wrap-reverse;gap:24px;}
.copyright__nav{display:flex;align-items:center;gap:48px;}
.copyright__nav a{text-decoration:none;font-style:normal;font-weight:600;font-size:16px;line-height:19px;}
@media (max-width: 992px){
.copyright{align-items:center;justify-content:center;width:100%;}
}
}

@media all{
.elementor *,.elementor :after,.elementor :before{box-sizing:border-box;}
.elementor a{box-shadow:none;text-decoration:none;}
.elementor-element{--flex-direction:initial;--flex-wrap:initial;--justify-content:initial;--align-items:initial;--align-content:initial;--gap:initial;--flex-basis:initial;--flex-grow:initial;--flex-shrink:initial;--order:initial;--align-self:initial;flex-basis:var(--flex-basis);flex-grow:var(--flex-grow);flex-shrink:var(--flex-shrink);order:var(--order);align-self:var(--align-self);}
.elementor-element:where(.e-con-full,.elementor-widget){flex-direction:var(--flex-direction);flex-wrap:var(--flex-wrap);justify-content:var(--justify-content);align-items:var(--align-items);align-content:var(--align-content);gap:var(--gap);}
:root{--page-title-display:block;}
.elementor-section{position:relative;}
.elementor-section .elementor-container{display:flex;margin-right:auto;margin-left:auto;position:relative;}
@media (max-width:1024px){
.elementor-section .elementor-container{flex-wrap:wrap;}
}
.elementor-widget-wrap{position:relative;width:100%;flex-wrap:wrap;align-content:flex-start;}
.elementor:not(.elementor-bc-flex-widget) .elementor-widget-wrap{display:flex;}
.elementor-widget-wrap>.elementor-element{width:100%;}
.elementor-widget{position:relative;}
.elementor-widget:not(:last-child){margin-bottom:20px;}
.elementor-column{position:relative;min-height:1px;display:flex;}
.elementor-column-gap-default>.elementor-column>.elementor-element-populated{padding:10px;}
@media (min-width:768px){
.elementor-column.elementor-col-100{width:100%;}
}
@media (max-width:767px){
.elementor-column{width:100%;}
}
.elementor-element .elementor-widget-container{transition:background .3s,border .3s,border-radius .3s,box-shadow .3s,transform var(--e-transform-transition-duration,.4s);}
.elementor-element{--swiper-theme-color:#000;--swiper-navigation-size:44px;--swiper-pagination-bullet-size:6px;--swiper-pagination-bullet-horizontal-gap:6px;}
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
.elementor-widget:not(:last-child){margin-block-end:20px;}
.elementor-element{--widgets-spacing:20px 20px;}
}

@media all{
.elementor-93 .elementor-element.elementor-element-823b18a{margin-top:0px;margin-bottom:0px;padding:0px 0px 0px 0px;}
.elementor-93 .elementor-element.elementor-element-4e43c55 > .elementor-widget-wrap > .elementor-widget:not(.elementor-widget__width-auto):not(.elementor-widget__width-initial):not(:last-child):not(.elementor-absolute){margin-bottom:0px;}
.elementor-93 .elementor-element.elementor-element-4e43c55 > .elementor-element-populated{margin:0px 0px 0px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;padding:0px 0px 0px 0px;}
}

body{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:none;font-weight:500;line-height:26px;background-color:#06060c;background-repeat:repeat;background-position:top center;background-attachment:scroll;background-size:cover;}
h1{font-size:120px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
h5{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
.current_selected{text-decoration:underline;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}

:root{--fa-font-brands:normal 400 1em/1 "Font Awesome 6 Brands";}
:root{--fa-font-regular:normal 400 1em/1 "Font Awesome 6 Free";}
:root{--fa-font-solid:normal 900 1em/1 "Font Awesome 6 Free";}

.features__item_attack{display:flex;flex-direction:column;padding:50px;height:900px;margin-top:150px;width:500px;margin-right:50px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);}
.features__item_logs{display:flex;flex-direction:column;padding:50px;height:900px;margin-top:150px;width:900px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);}
.features__item_info{padding:50px;height:300px;margin-top:200px;width:1440px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);}
.elementor-widget-container{display:flex;justify-content:center;align-items:center;}

.color-cyan{color:cyan;}
.color-light-blue{color:lightblue;}
.color-dark-cyan{color:darkcyan;}
.color-blue{color:blue;}
.notification,.error_notification{position:absolute;right:20px;background-color:#0b0b11;padding:15px;border-radius:14px;display:none;align-items:center;z-index:1000;box-shadow:0 2px 10px rgba(0, 0, 0, 0.2);animation:slideInFromRight 0.5s ease-out;margin-bottom:10px;transform:translateX(0);opacity:1;transition:opacity 0.5s ease-out, transform 0.5s ease-out, bottom 0.5s ease-out;white-space:nowrap;max-width:calc(100vw - 40px);word-wrap:break-word;}
.notification p,.error_notification p{color:#26d833;margin:0;}
.error_notification p{color:#bb0b0b;}
input,select{transition:border-color 0.3s ease;}
input:hover,select:hover{border-color:rgba(255, 255, 255, 0.4);}

.pagination{margin-top:10px;}
@media (max-width: 1437px){
.features__item_attack,.features__item_logs{width:50%;margin:200px 0;}
}

input{width:400px;}
table{width:100%;border-collapse:separate;border-spacing:0;border-radius:15px;}
th{border-bottom:1px solid rgba(255, 255, 255, 0.2);border-top:none;text-align:center;padding:20px;color:#fff;}
thead{background-color:transparent;}
.button-ga54,.button-ga542,.button-ga543{align-items:center;justify-content:center;align-self:center;border-radius:10px;padding:10px;font-style:normal;font-weight:600;font-size:18px;line-height:22px;color:#FFFFFF;border:none;height:62px;width:154px;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);box-shadow:0 16px 24px rgba(247, 15, 255, 0.48);cursor:pointer;margin-bottom:10px;transition:transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;}
.button-ga54{margin:0 auto;}
.button-ga543{margin:0 auto;}
.marginbottom1{margin-bottom:20px;}
.color-cyan{color:#00CED1;}
.color-light-blue{color:#00BFFF;}
.color-dark-cyan{color:#1E90FF;}
.color-blue{color:#6A5ACD;}
.layer-content{display:none;}
.layer-content.active{display:block;margin-top:20px;}
.method-selection{margin-bottom:40px;}
select{width:100%;background-color:#0b0b11;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;appearance:none;line-height:22px;margin-top:10px;}
select option{color:#fff;}
.layer-content .id-5541{display:block;margin-top:10px;}
.layer-content input[type="text"],.layer-content select{width:100%;margin-top:10px;}
.layer-content input[type="number"]{margin-top:10px;}
select::-webkit-scrollbar{width:12px;}
select::-webkit-scrollbar-track{background:#222;}
select::-webkit-scrollbar-thumb{background:#444;border-radius:6px;}
select::-webkit-scrollbar-thumb:hover{background:#555;}
select{scrollbar-width:thin;scrollbar-color:#444 #222;}

@-webkit-keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0, 100%, 0);transform:translate3d(0, 100%, 0);}to{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}}
@keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0, 100%, 0);transform:translate3d(0, 100%, 0);}to{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}}
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
    <meta name="generator" content="Elementor 3.20.2; features: e_optimized_assets_loading, e_optimized_css_loading, additional_custom_breakpoints, block_editor_assets_optimize, e_image_loading_optimization; settings: css_print_method-external, google_font-enabled, font_display-swap">
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
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
                                <a class="current_selected current-menu-item" href="">ATTACK-HUB</a>
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
                                <a href="<?php echo $server_full_link ?>">DISCORD</a>
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

      <section class="story post-93 page type-page status-publish hentry" id="post-93" data-post-id="93">
        <div data-elementor-type="wp-page" data-elementor-id="93" class="elementor elementor-93">
          <section class="elementor-section elementor-top-section elementor-element elementor-element-823b18a elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="823b18a" data-element_type="section">
            <div class="elementor-container elementor-column-gap-default">
              <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4e43c55" data-id="4e43c55" data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">
                  <div class="elementor-element elementor-element-0e679ca elementor-widget elementor-widget-onchain_hero" data-id="0e679ca" data-element_type="widget" data-widget_type="onchain_hero.default">
                    <div class="elementor-widget-container">
                      <section class="hero">
                        <div class="container">
                          <div class="hero__object circle"></div>
                          <div class="hero__wrapper">

                          <div id="notification" class="notification">
                            <p id="notification_message"></p>
                            </div>
                          <div id="error_notification" class="error_notification">
                            <p id="error_notification_message"></p>
                          </div>

                          <style>
                            .features__item_attack {
                              display: flex;
                              flex-direction: column;
                              padding: 50px;
                              height: 850px;
                              margin-top : 150px;
                              width: 500px;
                              margin-right: 50px;
                              border-radius: 24px;
                              border: 1px solid rgba(255, 255, 255, 0.08);
                            }
                            .features__item_logs {
                                display: flex;
                                flex-direction: column;
                                padding: 50px;
                                height: 850px;
                                margin-top: 150px;
                                width: 900px;
                                border-radius: 24px;
                                border: 1px solid rgba(255, 255, 255, 0.08);
                            }
                            .features__item_info {
                                padding: 50px;
                                height: 300px;
                                margin-top: 150px;
                                width: 1440px;
                                border-radius: 24px;
                                border: 1px solid rgba(255, 255, 255, 0.08);
                            }
                            .elementor-widget-container {
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              
                            }
                            </style>
                            <style>
                                                    .color-cyan {
                                                        color: cyan;
                                                    }

                                                    .color-light-blue {
                                                        color: lightblue;
                                                    }

                                                    .color-dark-cyan {
                                                        color: darkcyan;
                                                    }

                                                    .color-corn-blue {
                                                        color: cornflowerblue;
                                                    }

                                                    .color-blue {
                                                        color: blue;
                                                    }

                                                    .color-dark-blue {
                                                        color: darkblue;
                                                    }
                                                    @keyframes slideInFromRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutToRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.notification, .error_notification {
    position: absolute;
    right: 20px;
    background-color: #0b0b11;
    padding: 15px;
    border-radius: 14px;
    display: none;
    align-items: center;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    animation: slideInFromRight 0.5s ease-out;
    margin-bottom: 10px;
    transform: translateX(0);
    opacity: 1;
    transition: opacity 0.5s ease-out, transform 0.5s ease-out, bottom 0.5s ease-out;
    white-space: nowrap;
    max-width: calc(100vw - 40px);
    word-wrap: break-word;
}

.notification p, .error_notification p {
    color: #26d833;
    margin: 0;
}

.error_notification p {
    color: #bb0b0b;
}

.notification.hide, .error_notification.hide {
    opacity: 0;
    transform: translateX(100%);
}

.notification-container {
    position: fixed;
    right: 20px;
    bottom: 20px;
    flex-direction: column-reverse;
    align-items: flex-end;
    z-index: 1000;
}
#loadingSpinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
input, select {
  transition: border-color 0.3s ease;
}
input:hover, select:hover {
  border-color: rgba(255, 255, 255, 0.4);
}
                                        </style>
                                        <script>
                                        var userPlan = "<?php echo $user_plan; ?>";
                                        var allowedPlansForCloudBypass = ['starter1','starter2','starter3','exp1','exp2','exp3','pro1', 'pro2', 'pro3', 'infinity'];

                                        function disablePaidMethods() {
                                            if (userPlan === 'free') {
                                                var select1 = document.getElementById('selectL3-4');
                                                var options1 = select1.getElementsByTagName('option');
                                                for (var i = 0; i < options1.length; i++) {
                                                    if (options1[i].textContent.includes('PAID')) {
                                                        options1[i].disabled = true;
                                                    }
                                                }
                                                var select2 = document.getElementById('selectL7');
                                                var options2 = select2.getElementsByTagName('option');
                                                for (var j = 0; j < options2.length; j++) {
                                                    if (options2[j].textContent.includes('PAID')) {
                                                        options2[j].disabled = true;
                                                    }
                                                }
                                            }
                                            
                                            if (!allowedPlansForCloudBypass.includes(userPlan)) {
                                                var select1 = document.getElementById('selectL3-4');
                                                var options1 = select1.getElementsByTagName('option');
                                                for (var i = 0; i < options1.length; i++) {
                                                    if (options1[i].textContent.includes('CLOUD-BYPASS')) {
                                                        options1[i].disabled = true;
                                                    }
                                                }
                                                var select2 = document.getElementById('selectL7');
                                                var options2 = select2.getElementsByTagName('option');
                                                for (var j = 0; j < options2.length; j++) {
                                                    if (options2[j].textContent.includes('CLOUD-BYPASS')) {
                                                        options2[j].disabled = true;
                                                    }
                                                }
                                            }
                                        }

                                        window.onload = function() {
                                            disablePaidMethods();
                                        };
                                        </script>
                          <section class="features__item_attack" style="z-index: 1000;">
                          <div class="features__head head">
                          <div class="head__title animated marginbottom1">
                                <p>Attack <span>HUB</span></p>
                              </div>
                              <div class="attack-form">
                              <div id="error_modal" class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close-button" onclick="closeErrorModal()">&times;</span>
                                    <h1>ERROR :</h1>
                                    <p id="error_messagea"></p>
                                </div>
                              </div>
                              <center><a class="button-ga54 active" onclick="showLayer('layer4')">Layer 3/4</a>
                              <a class="button-ga54" onclick="showLayer('layer7')">Layer 7</a></center>
                              <div id="error_messagea" style="display: none; color: red; margin-top: 10px;"></div>
                                    <div id="layer4" class="layer-content active">
                                    <span class="id-5541">IP:</span>
                                    <input id="l4_ip" required type="text" placeholder="1.1.1.1">
                                    <span id="ipError" class="error-message"></span><br><br>
                                    <span class="id-5541">Port:</span>
                                    <input id="l4_port" required type="number" placeholder="80">
                                    <span id="portError" class="error-message"></span><br><br>
                                    <span class="id-5541">Time:</span>
                                    <input id="l4_time" required type="number" placeholder="Min: 30 | Max: <?php echo htmlspecialchars($current_stats['Max Time']); ?>" min="1" max="<?php echo ($current_stats['Max Time'] === 'unlimited') ? 10000000 : htmlspecialchars($current_stats['Max Time']); ?>">
                                    <span id="timeError" class="error-message"></span><br><br>
                                    <span class="id-5541">Method:</span>
                                    <select id="selectL3-4" class="method-selection">
                                          <option value="" disabled></option>
                                          <option class="color-cyan" value="" disabled>-- FREE - Methods -- </option>
                                          <option value="" disabled></option>
                                          <option value="DNS">DNS - FREE</option>
                                          <option value="" disabled></option>
                                          <option class="color-light-blue" value="" disabled>-- Amplification - Methods --</option>
                                          <option value="" disabled></option>
                                          <option value="XLDAP">XLDAP - PAID</option>
                                          <option value="NTP">NTP - PAID</option>
                                          <option value="DVR">DVR - PAID</option>
                                          <option value="WSD">WSD - PAID</option>
                                          <option value="ARD">ARD - PAID</option>
                                          <option value="COAP">COAP - PAID</option>
                                          <option value="" disabled></option>
                                          <option class="color-dark-cyan" value="" disabled>-- UDP - Methods --</option>
                                          <option value="" disabled></option>
                                          <option value="UDP-VSE">UDP-VSE - PAID</option>
                                          <option value="UDP-STORM">UDP-STORM - PAID</option>
                                          <option value="UDP-OVH">UDP-OVH - PAID</option>
                                          <option value="UDP-PPS">UDP-PPS - PAID</option>
                                          <option value="" disabled></option>
                                          <option class="color-blue" value="" disabled>-- TCP - Methods --</option>
                                          <option value="" disabled></option>
                                          <option value="TCP-SYNACK">TCP-SYNACK - PAID</option>
                                          <option value="TCP-SYN">TCP-SYN - PAID</option>
                                          <option value="TCP-ACK">TCP-ACK - PAID</option>
                                          <option value="TCP-TFO">TCP-TFO - PAID</option>
                                          <option value="TCP-AMP">TCP-AMP - PAID</option>
                                      </select>
                                      
                                      <center><a class="button-ga542" id="startL4Button" onclick="startL4Attack()">L4 | Start Attack</a></center>

                                    </div>
                                    <div id="layer7" class="layer-content">
                                        <span class="id-5541">Domain:</span>
                                        <input id="l7_domain" required type="text" placeholder="https://domain.com">
                                        <span id="domainError" class="error-message"></span><br><br>
                                        <span class="id-5541">Time:</span>
                                        <input id="l7_time" required type="number" placeholder="Min: 30 | Max: <?php echo htmlspecialchars($current_stats['Max Time']); ?>" min="1" max="<?php echo ($current_stats['Max Time'] === 'unlimited') ? 10000000 : htmlspecialchars($current_stats['Max Time']); ?>">
                                        <span id="timeError" class="error-message"></span><br><br>
                                        <span class="id-5541">Method:</span>
                                        <select id="selectL7" class="method-selection">
                                            <option value="" disabled></option>
                                            <option class="color-cyan" value="" disabled>-- FREE - Methods --</option>
                                            <option value="" disabled></option>
                                            <option value="HTTP-SMART">HTTP-SMART - FREE </option>
                                            <option value="" disabled></option>
                                            <option class="color-light-blue" value="" disabled>-- BASIC - Methods --</option>
                                            <option value="" disabled></option>
                                            <option value="HTTP-SOCKET">HTTP-SOCKET - PAID</option>
                                            <option value="HTTP-XTLS">HTTP-XTLS - PAID</option>
                                            <option value="" disabled></option>
                                            <option class="color-dark-cyan" value="" disabled>-- PREMIUM - Methods --</option>
                                            <option value="" disabled></option>
                                            <option value="CLOUD-BYPASS">CLOUD-BYPASS - PAID</option>
                                            <option value="" disabled></option>
                                        </select>
                                        <div id="cloudBypassOptions" style="display: none;">
                                            <span class="id-5541">Request Method:</span>
                                            <select id="requestMethod">
                                                <option value="GET">GET</option>
                                                <option value="POST">POST</option>
                                            </select>
                                            <span id="requestMethodError" class="error-message"></span><br><br>

                                            <div id="postDataField" style="display: none;">
                                                <span class="id-5541">Post Data:</span>
                                                <input id="postData" type="text" placeholder="username=%RAND%&password=%RAND%">
                                                <span id="postDataError" class="error-message"></span><br><br>
                                            </div>
                                        </div>
                                        <center><a class="button-ga543" id="startL7Button" onclick="startL7Attack()">L7 | Start Attack</a></center>
                                    </div>
                                </div>
                              <div class="head__description animated">
                              </div>
                            </div>
                          </section>
                          <script>
    var maxTime = <?php echo json_encode($current_stats['Max Time']); ?>;
    var minTime = 30;

    function validateTimeInput(inputElement) {
        var max = maxTime;
        var min = minTime;
        var value = inputElement.value.trim();

        if (value === '') {
            clearErrorMessage(inputElement);
            return;
        }

        var numericValue = parseInt(value);

        if (isNaN(numericValue)) {
            displayErrorMessage('Please enter a valid number.');
        } else if (numericValue > max) {
            inputElement.value = '';
            displayErrorMessage('Value exceeds your maximum allowed time.');
        } else if (numericValue < min) {
            inputElement.value = '';
            displayErrorMessage('Value is below the minimum allowed time of 30 seconds.');
        } else {
            clearErrorMessage(inputElement);
        }
    }

    document.getElementById('l4_time').addEventListener('change', function() {
        validateTimeInput(this);
    });

    document.getElementById('l7_time').addEventListener('change', function() {
        validateTimeInput(this);
    });

    function validateIP(ip) {
        var ipRegex = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
        return ipRegex.test(ip);
    }

    function validatePort(port) {
        var portNum = parseInt(port);
        return !isNaN(portNum) && portNum >= 1 && portNum <= 65535;
    }

    function validateTime(time) {
        var timeRegex = /^\d+$/;
        return timeRegex.test(time);
    }

    function validateDomain(domain) {
        var domainRegex = /^(http:\/\/|https:\/\/)([a-zA-Z0-9]+([\-\.]{1}[a-zA-Z0-9]+)*\.[a-zA-Z]{2,}|(\d{1,3}\.){3}\d{1,3})(:[0-9]{1,5})?(\/.*)?$/;
        return domainRegex.test(domain);
    }

    function displayErrorMessage(inputElement, errorMessage) {
        var errorSpan = inputElement.nextElementSibling;
        errorSpan.textContent = errorMessage;
        errorSpan.style.color = 'red';
    }

    function clearErrorMessage(inputElement) {
        var errorSpan = inputElement.nextElementSibling;
        errorSpan.textContent = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var l4_ip = document.getElementById('l4_ip');
        var l4_port = document.getElementById('l4_port');
        var l4_time = document.getElementById('l4_time');
        var l7_domain = document.getElementById('l7_domain');

        l4_ip.addEventListener('blur', function() {
            var value = l4_ip.value.trim();

            if (value === '') {
                clearErrorMessage(l4_ip);
                return;
            }

            if (!validateIP(value)) {
                displayErrorMessage('Please enter a valid IP address.');
                l4_ip.value = '';
            } else {
                clearErrorMessage(l4_ip);
            }
        });

        l4_port.addEventListener('blur', function() {
            var value = l4_port.value.trim();

            if (value === '') {
                clearErrorMessage(l4_port);
                return;
            }

            if (!validatePort(value)) {
                displayErrorMessage('Please enter a valid port number (1-65535).');
                l4_port.value = '';
            } else {
                clearErrorMessage(l4_port);
            }
        });

        l4_time.addEventListener('blur', function() {
            var value = l4_time.value.trim();

            if (value === '') {
                clearErrorMessage(l4_time);
                return;
            }

            if (!validateTime(value)) {
                l4_time.value = '';
            } else {
                clearErrorMessage(l4_time);
            }
        });

        l7_domain.addEventListener('blur', function() {
            var value = l7_domain.value.trim();

            if (value === '') {
                clearErrorMessage(l7_domain);
                return;
            }

            if (!validateDomain(value)) {
                displayErrorMessage('Please enter a valid domain format (e.g., https://example.com).');
                l7_domain.value = '';
            } else {
                clearErrorMessage(l7_domain);
            }
        });
    });
</script>
                          <section class="features__item_logs">
                              <div class="features__head head">
                                  <div class="head__title animated marginbottom1">
                                      <p>Attack <span>Logs</span></p>
                                  </div>
                                  <div class="pagination">

                              </div>
                                  </div>
                                  <div class="logs-content">
                                    <table id="attack_logs_table" class="table">
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>TARGET</th>
                                              <th>PORT</th>
                                              <th>TIME</th>
                                              <th>METHOD</th>
                                              <th>ACTION</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                    
                              </div>
                              
                          </section>
                          </div>
                        </div>
                        
                      </section>
                      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                      <?php
include("../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getUserIdByToken($conn, $token) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();
    return $userId;
}

function logAttack($conn, $userId, $layer, $target, $duration, $method, $port, $timezone) {
    $attackTime = new DateTime("now", new DateTimeZone($timezone));
    $formattedAttackTime = $attackTime->format('d/m/Y H:i:s');
    $stmt = $conn->prepare("INSERT INTO attack_logs (user_id, attack_layer, attack_target, attack_duration, attack_method, attack_port, attack_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $userId, $layer, $target, $duration, $method, $port, $formattedAttackTime);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_COOKIE['LS_ASP'])) {
        $token = $_COOKIE['LS_ASP'];
        $userId = getUserIdByToken($conn, $token);
        
        if ($userId) {
            $attackType = $_POST['attack_type'];
            $target = $_POST['target'];
            $duration = $_POST['duration'];
            $method = $_POST['method'];
            $port = $_POST['port'];
            $timezone = $_POST['timezone'];
            
            if ($attackType === 'L4') {
                logAttack($conn, $userId, 'L3-4', $target, $duration, $method, $port, $timezone);
            } else if ($attackType === 'L7') {
                logAttack($conn, $userId, 'L7', $target, $duration, $method, '443', $timezone);
            }
            
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user token.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No LS_ASP cookie found.']);
    }
    exit;
}

$conn->close();
?>
<script>
    var rowCount = 0;
    var rowsPerPage = 9;
    var currentPage = 1;
    var nextRowId = 1;

    function calculateRemainingTime(duration, startTime) {
        var currentTime = new Date().getTime();
        var endTime = startTime + (duration * 1000);
        var remainingTime = Math.max(0, Math.floor((endTime - currentTime) / 1000));
        return remainingTime;
    }

    function startL4Attack() {
    var ip = document.getElementById('l4_ip').value;
    var port = document.getElementById('l4_port').value;
    var time = parseInt(document.getElementById('l4_time').value);
    var method = document.getElementById('selectL3-4').value;
    var button = document.getElementById('startL4Button');

    if (ip === '' || port === '' || isNaN(time) || time <= 29 || method === '') {
        displayErrorMessage('Please fill in all fields correctly.');
        return;
    }

    var originalButtonText = button.innerHTML;
    button.innerHTML = '<div id="loadingSpinner"></div>';
    button.classList.add('disabled');
    button.removeAttribute('onclick');
    
    var startTime = new Date().getTime();
    var apiUrl = `https://<?php echo $root_domain ?>/handler/start/index.php/?host=${ip}&port=${port}&time=${time}&method=${method}&token=<?php echo $token ?>`;

    $.ajax({
        url: apiUrl,
        type: 'GET',
        success: function(response) {
            console.log("API Response:", response);
            if (response.status === 'true') {
                var attackId = response.id;
                displayNotification('L4 Attack Launched Successfully!');
                
                setCookie('attack_' + attackId, JSON.stringify({
                    type: 'L4',
                    target: ip,
                    duration: time,
                    method: method,
                    port: port,
                    startTime: startTime,
                    id: attackId
                }), time);

                var tableRef = document.getElementById('attack_logs_table').getElementsByTagName('tbody')[0];
                var newRow = tableRef.insertRow();
                rowCount++;
                newRow.setAttribute('data-row-id', attackId);

                var idCell = newRow.insertCell(0);
                var targetCell = newRow.insertCell(1);
                var portCell = newRow.insertCell(2);
                var timeCell = newRow.insertCell(3);
                var methodCell = newRow.insertCell(4);
                var actionCell = newRow.insertCell(5);

                idCell.textContent = attackId;
                targetCell.textContent = ip;
                portCell.textContent = port;
                timeCell.textContent = time;
                methodCell.textContent = method;
                actionCell.innerHTML = '<a class="stop_button_a" id="stopbutton" onclick="stopAttack(' + attackId + ')">STOP</a>';

                startCountdown(time, timeCell, attackId);
                updatePagination();

                $.post('index.php', {
                    attack_type: 'L4',
                    target: ip,
                    duration: time,
                    method: method,
                    port: port,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    token: '<?php echo $token ?>'
                }, function(logResponse) {
                    console.log("Log Response:", logResponse);
                });
                
                button.innerHTML = originalButtonText;
                button.classList.remove('disabled');
                button.setAttribute('onclick', 'startL4Attack()');
                
            } else if (response.message === "Please wait a few seconds") {
                var countdownTime = 10;

                button.classList.add('disabled');
                button.removeAttribute('onclick');
                displayErrorMessage(response.message);
                var countdownInterval = setInterval(function() {
                    var formattedTime = countdownTime < 10 ? `00:0${countdownTime}` : `00:${countdownTime}`;
                    button.innerHTML = `${formattedTime}`;
                    countdownTime--;

                    if (countdownTime < 0) {
                        clearInterval(countdownInterval);
                        button.innerHTML = originalButtonText;
                        button.classList.remove('disabled');
                        button.setAttribute('onclick', 'startL4Attack()');
                    }
                }, 1000);
            } else {
                button.innerHTML = originalButtonText;
                button.classList.remove('disabled');
                button.setAttribute('onclick', 'startL4Attack()');
                displayErrorMessage(response.message);
            }
        },
        error: function() {
            button.innerHTML = originalButtonText;
            button.classList.remove('disabled');
            button.setAttribute('onclick', 'startL4Attack()');
            displayErrorMessage('Please refresh your page.');
        }
    });
}

document.getElementById('selectL7').addEventListener('change', function() {
    var cloudBypassOptions = document.getElementById('cloudBypassOptions');
    if (this.value === 'CLOUD-BYPASS') {
        cloudBypassOptions.style.display = 'block';
    } else {
        cloudBypassOptions.style.display = 'none';
        document.getElementById('postDataField').style.display = 'none';
        adjustDivStyles('default');
    }
});

document.getElementById('requestMethod').addEventListener('change', function() {
    var postDataField = document.getElementById('postDataField');
    if (this.value === 'POST') {
        postDataField.style.display = 'block';
        adjustDivStyles('post');
    } else {
        postDataField.style.display = 'none';
        adjustDivStyles('default');
    }
});

function adjustDivStyles(method) {
    var attackDivs = document.querySelectorAll('.features__item_attack, .features__item_logs');
    var infoDiv = document.querySelector('.features__item_info');
    var newHeight = (method === 'post') ? '900px' : '850px';
    var newMarginTop = (method === 'post') ? '200px' : '150px';
    
    attackDivs.forEach(function(div) {
        div.style.height = newHeight;
    });

    if (infoDiv) {
        infoDiv.style.marginTop = newMarginTop;
    }
}

function startL7Attack() {
    var domain = document.getElementById('l7_domain').value;
    var time = parseInt(document.getElementById('l7_time').value);
    var method = document.getElementById('selectL7').value;
    var requestMethod = document.getElementById('requestMethod') ? document.getElementById('requestMethod').value : 'GET';
    var postData = document.getElementById('postData') ? document.getElementById('postData').value : '';
    var button = document.getElementById('startL7Button');

    if (domain === '' || isNaN(time) || time <= 0 || method === '') {
        displayErrorMessage('Please fill in all fields correctly.');
        return;
    }

    var originalButtonText = button.innerHTML;
    button.innerHTML = '<div id="loadingSpinner"></div>';
    button.classList.add('disabled');
    button.removeAttribute('onclick');
    
    var startTime = new Date().getTime();
    var apiUrl = `https://<?php echo $root_domain ?>/handler/start/?host=${domain}&port=443&time=${time}&method=${method}&token=<?php echo $token ?>`;

    if (method === 'CLOUD-BYPASS') {
        apiUrl += `&request_method=${requestMethod}`;

        if (requestMethod === 'POST' && postData !== '') {
            apiUrl += `&postdata=${encodeURIComponent(postData)}`;
        }
    }

    $.ajax({
        url: apiUrl,
        type: requestMethod,
        success: function(response) {
            console.log("API Response:", response);

            if (response.status === 'true') {
                button.innerHTML = originalButtonText;
                button.classList.remove('disabled');
                button.setAttribute('onclick', 'startL7Attack()');

                var attackId = response.id;
                displayNotification('L7 Attack Launched Successfully!');
                
                setCookie('attack_' + attackId, JSON.stringify({
                    type: 'L7',
                    target: domain,
                    duration: time,
                    method: method,
                    port: 443,
                    startTime: startTime,
                    id: attackId
                }), time);

                var tableRef = document.getElementById('attack_logs_table').getElementsByTagName('tbody')[0];
                var newRow = tableRef.insertRow();
                rowCount++;
                newRow.setAttribute('data-row-id', attackId);

                var idCell = newRow.insertCell(0);
                var targetCell = newRow.insertCell(1);
                var portCell = newRow.insertCell(2);
                var timeCell = newRow.insertCell(3);
                var methodCell = newRow.insertCell(4);
                var actionCell = newRow.insertCell(5);

                idCell.textContent = attackId;
                targetCell.textContent = domain;
                portCell.textContent = 443;
                timeCell.textContent = time;
                methodCell.textContent = method;
                actionCell.innerHTML = '<a class="stop_button_a" id="stopbutton" onclick="stopAttack(' + attackId + ')">STOP</a>';

                startCountdown(time, timeCell, attackId);
                updatePagination();

                $.post('index.php', {
                    attack_type: 'L7',
                    target: domain,
                    duration: time,
                    method: method,
                    port: 443,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    token: '<?php echo $token ?>'
                }, function(logResponse) {
                    console.log("Log Response:", logResponse);
                });

                button.innerHTML = originalButtonText;
                button.classList.remove('disabled');
                button.setAttribute('onclick', 'startL7Attack()');

            } else if (response.message === "Please wait a few seconds") {
                var countdownTime = 10;

                button.classList.add('disabled');
                button.removeAttribute('onclick');
                displayErrorMessage(response.message);
                var countdownInterval = setInterval(function() {
                    var formattedTime = countdownTime < 10 ? `00:0${countdownTime}` : `00:${countdownTime}`;
                    button.innerHTML = `${formattedTime}`;
                    countdownTime--;

                    if (countdownTime < 0) {
                        clearInterval(countdownInterval);
                        button.innerHTML = originalButtonText;
                        button.classList.remove('disabled');
                        button.setAttribute('onclick', 'startL7Attack()');
                    }
                }, 1000);
            } else {
                button.innerHTML = originalButtonText;
                button.classList.remove('disabled');
                button.setAttribute('onclick', 'startL7Attack()');
                displayErrorMessage(response.message);
            }
        },
        error: function() {
            button.innerHTML = originalButtonText;
            button.classList.remove('disabled');
            button.setAttribute('onclick', 'startL7Attack()');
            displayErrorMessage('Please refresh your page.');
        }
    });
}

function restoreAttacksFromCookies() {
    var cookies = document.cookie.split(';');
    cookies.forEach(function(cookie) {
        var nameValue = cookie.split('=');
        var name = nameValue[0].trim();
        var value = decodeURIComponent(nameValue[1]);
        if (name.startsWith('attack_')) {
            var attackId = name.replace('attack_', '');
            try {
                var attackDetails = JSON.parse(value);
                var remainingTime = calculateRemainingTime(attackDetails.duration, attackDetails.startTime);
                if (remainingTime > 0) {
                    addRowToTable(attackDetails.target, attackDetails.port, attackDetails.duration, attackDetails.method, attackId, attackDetails.startTime);
                    
                } else {
                    eraseCookie(name);
                }
            } catch (e) {
                console.error('Error parsing JSON from cookie', e);
                eraseCookie(name);
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', restoreAttacksFromCookies);

function addRowToTable(target, port, time, method, rowId, startTime) {
    var tableRef = document.getElementById('attack_logs_table').getElementsByTagName('tbody')[0];
    var newRow = tableRef.insertRow();
    newRow.setAttribute('data-row-id', rowId);
    rowCount++;

    var idCell = newRow.insertCell(0);
    var targetCell = newRow.insertCell(1);
    var portCell = newRow.insertCell(2);
    var timeCell = newRow.insertCell(3);
    var methodCell = newRow.insertCell(4);
    var actionCell = newRow.insertCell(5);

    idCell.textContent = rowId;
    targetCell.textContent = target;
    portCell.textContent = port;
    methodCell.textContent = method;
    actionCell.innerHTML = '<a class="stop_button_a" onclick="stopAttack(' + rowId + ')">STOP</a>';

    var remainingTime = calculateRemainingTime(time, startTime);
    timeCell.textContent = remainingTime;
    startCountdown(remainingTime, timeCell, rowId);

    updatePagination();
}

function startCountdown(time, timeCell, rowId) {
    var countdown = setInterval(function() {
        time--;
        timeCell.textContent = time;
        if (time <= 0) {
            clearInterval(countdown);
            eraseCookie('attack_' + rowId);
            var table = document.getElementById('attack_logs_table').getElementsByTagName('tbody')[0];
            var rowToDelete = table.querySelector('tr[data-row-id="' + rowId + '"]');
            
            if (rowToDelete) {
                table.removeChild(rowToDelete);
                rowCount--;
            }

            updatePagination();
        }
    }, 1000);
}


function stopAttack(rowId) {
    var attackId = null;
    var cookies = document.cookie.split(';');
    cookies.forEach(function(cookie) {
        var nameValue = cookie.split('=');
        var name = nameValue[0].trim();
        var value = nameValue[1];

        if (name === 'attack_' + rowId) {
            var attackDetails = JSON.parse(value);
            attackId = attackDetails.id;
            attackMethod = attackDetails.method;
            attackTarget = attackDetails.target;
            attackPort = attackDetails.port;
            attackDuration = attackDetails.duration;
        }
    });

    if (!attackId) {
        displayErrorMessage('Attack ID not found.');
        return;
    }

    var stopButton = document.querySelector('tr[data-row-id="' + rowId + '"] .stop_button_a');
    if (!stopButton) {
        displayErrorMessage('Stop button not found.');
        return;
    }

    var originalButtonText = stopButton.innerHTML;

    stopButton.innerHTML = '<div class="loadingDots"><div></div><div></div><div></div><div></div></div>';
    stopButton.classList.add('disabled');
    stopButton.removeAttribute('onclick');

    $.ajax({
        url: `https://<?php echo $root_domain ?>/handler/stop/?id=${attackId}&target=${attackTarget}&port=${attackPort}&duration=${attackDuration}&method=${attackMethod}`,
        type: 'GET',
        success: function(response) {
            console.log("API Response:", response);

            if (response.status === 'true' || response.adm === 'LSF-STOP') {
                eraseCookie('attack_' + rowId);
                var table = document.getElementById('attack_logs_table').getElementsByTagName('tbody')[0];
                var rowToDelete = table.querySelector('tr[data-row-id="' + rowId + '"]');
                if (rowToDelete) {
                    table.removeChild(rowToDelete);
                    rowCount--;
                }
                displayNotification('Stopped Attack Successfully!');
                updatePagination();
            } else {
                displayErrorMessage(response.message);
            }

            stopButton.innerHTML = originalButtonText;
            stopButton.classList.remove('disabled');
            stopButton.setAttribute('onclick', 'stopAttack(' + rowId + ')');
        },
        error: function() {
            stopButton.innerHTML = originalButtonText;
            stopButton.classList.remove('disabled');
            stopButton.setAttribute('onclick', 'stopAttack(' + rowId + ')');

            displayErrorMessage('Please refresh your page.');
        }
    });
}

    function updatePagination() {
        var totalPages = Math.ceil(rowCount / rowsPerPage);

        var paginationHtml = '';
        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationHtml += '<a href="#" class="pagination-link current-page" data-page="' + i + '">' + i + '</a> ';
            } else {
                paginationHtml += '<a href="#" class="pagination-link" data-page="' + i + '">' + i + '</a> ';
            }
        }

        $('.pagination').html(paginationHtml);

        $('.pagination-link').on('click', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            currentPage = page;
            updateTable();
        });

        updateTable();
    }

    function setCookie(name, value, seconds) {
        var expires = "";
        if (seconds) {
            var date = new Date();
            date.setTime(date.getTime() + (seconds * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
    
    function eraseCookie(name) {   
        document.cookie = name + '=; Max-Age=-99999999; path=/';  
    }

    function updateTable() {
        var startIndex = (currentPage - 1) * rowsPerPage;
        var endIndex = startIndex + rowsPerPage - 1;

        $('#attack_logs_table tbody tr').hide();

        $('#attack_logs_table tbody tr').each(function(index) {
            if (index >= startIndex && index <= endIndex) {
                $(this).show();
            }
        });
    }
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










                      <style>
                        .pagination {
                            margin-top: 10px;
                        }
                        .pagination-link {
                            margin-right: 5px;
                            cursor: pointer;
                        }
                        .current-page {
                            font-weight: bold;
                        }
                        @media (max-width: 1437px) {
                            .features__item_attack,
                            .features__item_logs {
                                width: 50%;
                                margin: 200px 0;
                            }
                        }

                    </style>
        
                      <style>
                        .range-slider {
                            margin-top: 10px;
                            width: 100%;
                        }

                        .range-slider__range {
                            -webkit-appearance: none;
                            width: calc(100% - (73px));
                            height: 10px;
                            border-radius: 5px;
                            background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
                            outline: none;
                            padding: 0;
                            margin: 0;
                        }

                        .range-slider__range::-webkit-slider-thumb {
                            -webkit-appearance: none;
                            appearance: none;
                            width: 20px;
                            height: 20px;
                            border-radius: 50%;
                            background: #2c3e50;
                            cursor: pointer;
                            transition: background 0.15s ease-in-out;
                        }

                        .range-slider__range::-webkit-slider-thumb:hover {
                            background: #1abc9c;
                        }

                        .range-slider__range:active::-webkit-slider-thumb {
                            background: #1abc9c;
                        }

                        .range-slider__range::-moz-range-thumb {
                            width: 20px;
                            height: 20px;
                            border: 0;
                            border-radius: 50%;
                            background: #2c3e50;
                            cursor: pointer;
                            transition: background 0.15s ease-in-out;
                        }

                        .range-slider__range::-moz-range-thumb:hover {
                            background: #1abc9c;
                        }

                        .range-slider__range:active::-moz-range-thumb {
                            background: #1abc9c;
                        }

                        .range-slider__range:focus::-webkit-slider-thumb {
                            box-shadow: 0 0 0 3px #fff, 0 0 0 6px #1abc9c;
                        }

                        .range-slider__value {
                            display: inline-block;
                            position: relative;
                            width: 60px;
                            color: #fff;
                            line-height: 20px;
                            text-align: center;
                            border-radius: 3px;
                            background: #2c3e50;
                            padding: 5px 10px;
                            margin-left: 8px;
                        }

                        .range-slider__value:after {
                            position: absolute;
                            top: 8px;
                            left: -7px;
                            width: 0;
                            height: 0;
                            border-top: 7px solid transparent;
                            border-right: 7px solid #2c3e50;
                            border-bottom: 7px solid transparent;
                            content: '';
                        }

                        ::-moz-range-track {
                            background: #d7dcdf;
                            border: 0;
                        }

                        input::-moz-focus-inner,
                        input::-moz-focus-outer {
                            border: 0;
                        }
                        input {
                            width: 400px;
                        }
                       table {
                            width: 100%;
                            border-collapse: separate;
                            border-spacing: 0;
                            border-radius: 15px;
                        }

                        th, td {
                            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                            border-top: none;
                            text-align: center;
                            padding: 20px;
                            color: #fff;
                        }

                        thead {
                            background-color: transparent;
                        }

                        tbody tr:nth-child(odd) {
                            background-color: transparent;
                        }

                        tbody tr:nth-child(even) {
                            background-color: transparent;
                        }

                        .custom-option {
                          display: block;
                          padding: 8px 12px;
                          color: #fff;
                          text-align: center;
                          border-radius: 10px;
                          text-decoration: none;
                          cursor: pointer;
                      }

                        .custom-option:hover {
                            background: rgba(255, 255, 255, 0.1);
                        }
.button-ga54, .button-ga542, .button-ga543, .stop_button_a {
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
    height: 62px;
    width: 154px;
    background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
    box-shadow: 0 16px 24px rgba(247, 15, 255, 0.48);
    cursor: pointer;
    margin-bottom: 10px;
    transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
}

.button-ga54 {
    margin: 0 auto;
}

.button-ga543 {
    margin: 0 auto;
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

                        .marginbottom1 {
                          margin-bottom: 20px;
                        }
                        .color-cyan {
                          color: #00CED1;
                        }

                        .color-light-blue {
                          color: #00BFFF;
                        }

                        .color-corn-blue {
                          color: #4169E1;
                        }

                        .color-dark-cyan {
                          color: #1E90FF;
                        }

                        .color-blue {
                          color: #6A5ACD;
                        } 

                        .color-dark-blue {
                          color: #663399;
                        } 
                        .layer-content {
                            display: none;
                        }

                        .layer-content.active {
                            display: block;
                            margin-top: 20px;
                        }

                        .new-section {
                            width: 100%;
                            background: rgba(255, 255, 255, 0.02);
                            backdrop-filter: blur(12px);
                            padding: 50px 0;
                            margin-top: 200px;
                            border-radius: 24px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                        .method-selection {
                          margin-bottom: 40px;
                        }
                        select {
                            width: 100%;
                            background-color: #0b0b11;
                            border: 1px solid rgba(255, 255, 255, 0.08);
                            backdrop-filter: blur(12px);
                            border-radius: 12px;
                            padding: 16px 24px;
                            font-size: 16px;
                            appearance: none;
                            line-height: 22px;
                            margin-top: 10px;
                        }
                        select option {
                        color: #fff;
                        }
                        .layer-content .id-5541 {
                            display: block;
                            margin-top: 10px;
                        }

                        .layer-content input[type="text"],
                        .layer-content select {
                            width: 100%;
                            margin-top: 10px;
                        }
                        .layer-content input[type="number"] {
                            margin-top: 10px;
                        }
                        .layer-content .button-ga54 {
                            margin-top: 10px;
                        }
                        select::-webkit-scrollbar {
                        width: 12px;
                        }

                        select::-webkit-scrollbar-track {
                        background: #222;
                        }

                        select::-webkit-scrollbar-thumb {
                        background: #444;
                        border-radius: 6px;
                        }

                        select::-webkit-scrollbar-thumb:hover {
                        background: #555;
                        }

                        select {
                        scrollbar-width: thin;
                        scrollbar-color: #444 #222;
                        }
                        
                      </style>

                      <script>
                        function showLayer(layer) {
                          const layers = document.querySelectorAll('.layer-content');
                          layers.forEach(l => l.classList.remove('active'));
                          document.getElementById(layer).classList.add('active');

                          const buttons = document.querySelectorAll('.layer-btn');
                          buttons.forEach(btn => btn.classList.remove('active'));
                          document.querySelector(`[onclick="showLayer('${layer}')"]`).classList.add('active');
                      }
                      </script>
                    </div>
                  </div>
                  
                  <div class="elementor-element elementor-element-d273a56 elementor-widget elementor-widget-onchain_shop" data-id="d273a56" data-element_type="widget" data-widget_type="onchain_shop.default">
                   
                  
                  
                      </div></div></div></div></section>
                    </div>
                  
                    <div class="elementor-element elementor-element-6b6a065 elementor-widget elementor-widget-onchain_about" data-id="6b6a065" data-element_type="widget" data-widget_type="onchain_about.default">
                      <div class="elementor-widget-container">
                          <section class="features__item_info">
                              <h5>Your plan: <span style="<?php echo isset($plan_styles[$user_plan]['style']) ? $plan_styles[$user_plan]['style'] : ''; ?>"><?php echo htmlspecialchars($user_plan); ?></span></h5>
                              <center>
                                  <br>
                                  <div class="stats__row">
                                      <div class="">
                                          <div class="stats__count">
                                              <p><?php echo htmlspecialchars($current_stats['Concurents']); ?></p>
                                          </div>
                                          <div class="stats__title">
                                              <p>Concurents</p>
                                          </div>
                                      </div>
                                      <div class="">
                                          <div class="stats__count">
                                              <p><?php echo htmlspecialchars($current_stats['Max Time']); ?></p>
                                          </div>
                                          <div class="stats__title">
                                              <p>Max Time</p>
                                          </div>
                                      </div>
                                      <div class="">
                                          <div class="stats__count">
                                              <p><?php echo htmlspecialchars($current_stats['Methods']); ?></p>
                                          </div>
                                          <div class="stats__title">
                                              <p>Methods</p>
                                          </div>
                                      </div>
                                      <div class="">
                                          <div class="stats__count">
                                              <p><?php echo htmlspecialchars($current_stats['Daily Attacks Limit']); ?></p>
                                          </div>
                                          <div class="stats__title">
                                              <p>Daily Attacks Limit</p>
                                          </div>
                                      </div>
                                  </div>
                              </center>
                          </section>
                      </div>
                  </div>
                  <div class="elementor-element elementor-element-0ecc368 elementor-widget elementor-widget-onchain_team" data-id="0ecc368" data-element_type="widget" data-widget_type="onchain_team.default"> 
                  <div class="elementor-element elementor-element-b0cf7e0 elementor-widget elementor-widget-onchain_logos" data-id="b0cf7e0" data-element_type="widget" data-widget_type="onchain_logos.default">
                  </div>
                  <div class="elementor-element elementor-element-ea9b844 elementor-widget elementor-widget-onchain_features" data-id="ea9b844" data-element_type="widget" data-widget_type="onchain_features.default">
                    
                  </div>
                  
                  </div>
                  <div class="elementor-element elementor-element-c3aca87 elementor-widget elementor-widget-onchain_banner" data-id="c3aca87" data-element_type="widget" data-widget_type="onchain_banner.default">
                  
                  </div>
                  
                
              
            
          </section>

      <footer class="footer">
        <div class="container">
          <div class="footer__wrapper">
            <div class="footer__copyright copyright">
             
            
            
            
            <div class="copyright__main">
                Copyright LoveStresser &copy 2024 All rights reserved.
              </div>
              
              
              
              
              <ul id="menu-footer-two" class="copyright__nav">
                <li id="menu-item-112" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-112">
                  <a rel="nofollow" href="../tos">TOS</a>
                </li>
              
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </main>
    <script>
      (function () {
        function maybePrefixUrlField() {
          const value = this.value.trim();
          if (value !== "" && value.indexOf("http") !== 0) {
            this.value = "http://" + value;
          }
        }

        const urlFields = document.querySelectorAll(
          '.mc4wp-form input[type="url"]'
        );
        for (let j = 0; j < urlFields.length; j++) {
          urlFields[j].addEventListener("blur", maybePrefixUrlField);
        }
      })();
    </script>
    <script>
      (function () {
        var c = document.body.className;
        c = c.replace(/woocommerce-no-js/, "woocommerce-js");
        document.body.className = c;
      })();
    </script>
    <script src="js/sourcebuster.min.js" id="sourcebuster-js-js"></script>
    <script id="wc-order-attribution-js-extra">
      var wc_order_attribution = {
        params: {
          lifetime: 1.0e-5,
          session: 30,
          ajaxurl: "https:\/\/ \/onchain\/wp-admin\/admin-ajax.php",
          prefix: "wc_order_attribution_",
          allowTracking: true,
        },
        fields: {
          source_type: "current.typ",
          referrer: "current_add.rf",
          utm_campaign: "current.cmp",
          utm_source: "current.src",
          utm_medium: "current.mdm",
          utm_content: "current.cnt",
          utm_id: "current.id",
          utm_term: "current.trm",
          session_entry: "current_add.ep",
          session_start_time: "current_add.fd",
          session_pages: "session.pgs",
          session_count: "udata.vst",
          user_agent: "udata.uag",
        },
      };
    </script>
    <script src="js/order-attribution.min.js" id="wc-order-attribution-js"></script>
    <script src="js/imagesloaded.min.js" id="imagesloaded-js"></script>
    <script src="js/masonry.min.js" id="masonry-js"></script>
    <script src="js/jquery.appear.js" id="jquery-appear-js"></script>
    <script src="js/scripts.min.js" id="onchain-scripts-js"></script>
    <script id="ale-load-more-js-extra">
      var aleloadmore = {
        nonce: "87bf26812e",
        url: "https:\/\/ \/onchain\/wp-admin\/admin-ajax.php",
        button_text: "explore more",
        maxpage: "0",
        query: [],
      };
    </script>
    <script src="js/load-more.js" id="ale-load-more-js"></script>
    <script defer="" src="js/forms.js" id="mc4wp-forms-api-js"></script>
    <script src="js/webpack.runtime.min.js" id="elementor-webpack-runtime-js"></script>
    <script src="js/frontend-modules.min.js" id="elementor-frontend-modules-js"></script>
    <script src="js/waypoints.min.js" id="elementor-waypoints-js"></script>
    <script src="js/core.min.js" id="jquery-ui-core-js"></script>
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
