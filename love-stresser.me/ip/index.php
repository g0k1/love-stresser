<?php
session_start();
include("../componements/php/root_domain.php");
include("../componements/php/database_conn.php");
include("../componements/php/discord_server.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getUserId($conn, $token) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    return $user_id;
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
function getAttackLogs($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM attack_logs WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    $stmt->close();
    return $logs;
}

if (isset($_COOKIE['LS_ASP'])) {
    $token = $_COOKIE['LS_ASP'];
    $user_id = getUserId($conn, $token);
    $avatar_url = getUserAvatar($conn, $token);
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

    $attack_logs = getAttackLogs($conn, $user_id);
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
<html class="no-js" lang="en-US"><head>
    <meta charset="UTF-8">
    <script>console.log = function(){ };</script>
    <title>Love Stresser - IP Grabber</title>
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
body,div,span,h5,h6,p,ul,li,a,img,footer,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,input{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
.story h5,.story h6{text-transform:none;margin-bottom:20px;}
.story a{color:inherit;}
.story a:link,.story a:visited,.story a:hover,.story a:active{text-decoration:none;}
.story table{margin-bottom:30px;border-collapse:collapse;}
.story table th{color:rgba(255, 255, 255, 0.5);}
.story table td,.story table th{padding:20px 25px;}
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
select{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;}
select option{color:#333;}
input{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;font-family:'Urbanist', sans-serif;}
button{display:flex;align-items:center;justify-content:center;border-radius:100px;font-style:normal;font-weight:600;font-size:18px;line-height:22px;color:#FFFFFF;border:none;height:62px;width:154px;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);box-shadow:0 16px 24px rgba(247, 15, 255, 0.48);cursor:pointer;}
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
}

@media all{
:root{--swiper-theme-color:#007aff;}
:root{--swiper-navigation-size:44px;}
}

@media all{
.elementor-kit-6{--e-global-color-primary:#6EC1E4;--e-global-color-secondary:#54595F;--e-global-color-text:#7A7A7A;--e-global-color-accent:#61CE70;--e-global-typography-primary-font-family:"Roboto";--e-global-typography-primary-font-weight:600;--e-global-typography-secondary-font-family:"Roboto Slab";--e-global-typography-secondary-font-weight:400;--e-global-typography-text-font-family:"Roboto";--e-global-typography-text-font-weight:400;--e-global-typography-accent-font-family:"Roboto";--e-global-typography-accent-font-weight:500;}
.elementor-element{--widgets-spacing:20px 20px;}
}

@media all{
.elementor-93 .elementor-element.elementor-element-823b18a{margin-top:0px;margin-bottom:0px;padding:0px 0px 0px 0px;}
.elementor-93 .elementor-element.elementor-element-4e43c55 > .elementor-element-populated{margin:0px 0px 0px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;padding:0px 0px 0px 0px;}
}

body{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:none;font-weight:500;line-height:26px;background-color:#06060c;background-repeat:repeat;background-position:top center;background-attachment:scroll;background-size:cover;}
h5{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
h6{font-size:14px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
.new-section{width:800px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);padding:50px 0;height:500px;display:flex;justify-content:center;margin:200px auto;align-items:center;}
.new-section2{width:1200px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);padding:50px 0;height:1000px;display:flex;justify-content:center;margin:-100px auto -400px;align-items:center;}
.footer{margin-top:500px;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.notification,.error_notification{position:absolute;right:20px;background-color:#0b0b11;padding:15px;border-radius:14px;display:none;align-items:center;z-index:1000;box-shadow:0 2px 10px rgba(0, 0, 0, 0.2);animation:slideInFromRight 0.5s ease-out;margin-bottom:10px;transform:translateX(0);opacity:1;transition:opacity 0.5s ease-out, transform 0.5s ease-out, bottom 0.5s ease-out;white-space:nowrap;max-width:calc(100vw - 40px);word-wrap:break-word;}
.notification p,.error_notification p{color:#26d833;margin:0;}
.error_notification p{color:#bb0b0b;}
table{border-collapse:separate;border-spacing:0;border-radius:15px;}
table button{width:150px;height:50px;border-radius:15px;}
th,td{border-bottom:1px solid rgba(255, 255, 255, 0.2);border-top:none;text-align:center;padding:20px;color:#fff;}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}

.new-section{display:flex;flex-direction:column;gap:10px;}
.new-section input{padding:10px;font-size:16px;width:600px;}
.new-section button{padding:10px;font-size:16px;}
.select-group{display:flex;justify-content:space-between;gap:10px;}
.select-group select{flex:1;padding:10px;width:295px;font-size:16px;}
.select-title{margin-bottom:5px;font-weight:bold;}
.select-title.domain,#domainSelect{color:#02E9FC;}
.select-title.directory,#directorySelect{color:#00FF08;}
.select-title.type,#typeSelect{color:#FBFF00;}
.select-title.extension,#extensionSelect{color:#FF0000;}
.url-domain{color:#02E9FC;}
.url-directory{color:#00FF08;}
.url-type{color:#FBFF00;}
/* Modal Background */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);

    justify-content: center;
    align-items: center;
}

.modal-content {
    margin: 0 auto;
    padding: 20px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    overflow-x: hidden;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: #0b0b11;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
    margin-top: 30px;
}

.modal-content::-webkit-scrollbar {
    display: none;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #fff;
    text-decoration: none;
    outline: none;
}
.active{background-color:#ddd;}
table{width:100%;border-collapse:separate;border-spacing:0;border-radius:15px;}
th,td{border-bottom:1px solid rgba(255, 255, 255, 0.2);border-top:none;text-align:center;padding:20px;color:#fff;}
.pagination-controls{text-align:center;margin-top:20px;}
.pagination-controls a{display:inline-block;margin:0 5px;padding:5px 10px;text-decoration:none;color:#fff;border-radius:4px;}
.pagination-controls a.active{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);color:#fff;}
.pagination-controls a:hover{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);color:#fff;}

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
                    <a href="">Grabber</a>
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
                    <div id="notification" class="notification">
                            <p id="notification_message"></p>
                            </div>
                          <div id="error_notification" class="error_notification">
                            <p id="error_notification_message"></p>
                          </div>
<?php
include("../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_COOKIE['LS_ASP'];
    $user_id = getUserId($conn, $token);
    $randomId = $_POST['randomId'];
    $redirectUrl = $_POST['redirectUrl'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM grabber_ids WHERE code = ?");
    $stmt->bind_param("s", $randomId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Error: Duplicate code";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO grabber_ids (user_id, code, redirect_url) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $randomId, $redirectUrl);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM grabber_ids WHERE code = ?");
    $stmt->bind_param("s", $randomId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Success";
    } else {
        echo "Error: Insertion failed";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Link</title>
</head>
<body>
<section class="new-section">
    <h5>LOVE - IP GRABBER</h5>
    <h6 id="urlDisplay">
        https://<span class="url-domain">domain.com</span>/<span class="url-directory">directory</span>/?<span class="url-type">type</span>=<span class="url-id">XXXXXXXX</span><span class="url-extension">.extension</span>
    </h6>
    <input type="text" id="redirectLink" placeholder="Redirect Link">
    
    <div class="select-group">
        <div>
            <div class="select-title domain">Select Domain</div>
            <select id="domainSelect" class="domain" onchange="updateUrl()">
                <option value="vecyde.xyz" class="domain">vecyde.xyz</option>
                <option value="new-world-roleplay.fr" class="domain">new-world-roleplay.fr</option>
                <option value="hebergeur-priver.fr" class="domain">hebergeur-priver.fr</option>
                <option value="cforfree.fr" class="domain">cforfree.fr</option>
            </select>
        </div>
        <div>
            <div class="select-title directory">Select Path</div>
            <select id="directorySelect" class="directory" onchange="updateUrl()">
                <option value="file" class="directory">file</option>
                <option value="film" class="directory">film</option>
                <option value="image" class="directory">image</option>
                <option value="invite" class="directory">invite</option>
                <option value="join" class="directory">join</option>
                <option value="news" class="directory">news</option>
                <option value="profile" class="directory">profile</option>
                <option value="showthread" class="directory">showthread</option>
                <option value="watch" class="directory">watch</option>
                <option value="location" class="directory">location</option>
                <option value="map" class="directory">map</option>
            </select>
        </div>
    </div>
    
    <div class="select-group">
        <div>
            <div class="select-title type">Select Parameter</div>
            <select id="typeSelect" class="type" onchange="updateUrl()">
                <option value="id" class="type">id</option>
                <option value="ref" class="type">ref</option>
                <option value="tid" class="type">tid</option>
                <option value="v" class="type">v</option>
                <option value="location" class="type">location</option>
                <option value="map" class="type">map</option>
                <option value="video" class="type">video</option>
                <option value="tag" class="type">tag</option>
                <option value="identifier" class="type">identifier</option>
                <option value="name" class="type">name</option>
                <option value="link" class="type">link</option>
                <option value="referer" class="type">referer</option>
            </select>
        </div>
        <div>
            <div class="select-title extension">Select Extension</div>
            <select id="extensionSelect" class="extension" onchange="updateUrl()">
                <option value="">none</option>
                <option value="png" class="extension">.png</option>
                <option value="jpg" class="extension">.jpg</option>
                <option value="exe" class="extension">.exe</option>
                <option value="gif" class="extension">.gif</option>
                <option value="psd" class="extension">.psd</option>
                <option value="txt" class="extension">.txt</option>
                <option value="csv" class="extension">.csv</option>
                <option value="mp3" class="extension">.mp3</option>
                <option value="mp4" class="extension">.mp4</option>
                <option value="wma" class="extension">.wma</option>
                <option value="avi" class="extension">.avi</option>
                <option value="apk" class="extension">.apk</option>
                <option value="jar" class="extension">.jar</option>
                <option value="html" class="extension">.html</option>
                <option value="php" class="extension">.php</option>
                <option value="js" class="extension">.js</option>
                <option value="ico" class="extension">.ico</option>
                <option value="zip" class="extension">.zip</option>
                <option value="rar" class="extension">.rar</option>
                <option value="iso" class="extension">.iso</option>
                <option value="torrent" class="extension">.torrent</option>
                <option value="gz" class="extension">.gz</option>
                <option value="tar" class="extension">.tar</option>
                <option value="tgz" class="extension">.tgz</option>
                <option value="pdf" class="extension">.pdf</option>
                <option value="ext" class="extension">.ext</option>
                <option value="link" class="extension">.link</option>
                <option value="lnk" class="extension">.lnk</option>
                <option value="jpeg" class="extension">.jpeg</option>
                <option value="docx" class="extension">.docx</option>
                <option value="pptx" class="extension">.pptx</option>
            </select>
        </div>
    </div>
    <button id="createLinkBtn" onclick="createLink()">Create Link</button>
    <p id="result"></p>
</section>

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

<script>
    const randomId = generateRandomId(8);

    function generateRandomId(length) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return result;
    }

    function updateUrl() {
    const domain = document.getElementById('domainSelect').value;
    const directory = document.getElementById('directorySelect').value;
    const type = document.getElementById('typeSelect').value;
    const extension = document.getElementById('extensionSelect').value;
    const url = `https://${domain}/${directory}/?${type}=${randomId}${extension ? '.' + extension : ''}`;
    document.getElementById('urlDisplay').innerHTML = `<span class="url-domain">https://${domain}/</span><span class="url-directory">${directory}/</span><span class="url-type">?${type}=</span><span class="url-id">${randomId}</span>${extension ? '<span class="url-extension">.' + extension + '</span>' : ''}`;
    return url;
}

function createLink() {
    const redirectLink = document.getElementById('redirectLink').value;
    if (!redirectLink) {
        displayErrorMessage("Please enter a redirect link.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            displayNotification("Link created successfully!");
            fetchResults();
            const generatedUrl = updateUrl();
            copyToClipboard(generatedUrl);
        }
    };
    const params = "randomId=" + randomId + "&redirectUrl=" + encodeURIComponent(redirectLink);
    xhr.send(params);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        displayNotification("Link copied to clipboard!");
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}

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

function displayResults(results) {
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = '';

    let allData = [];
    results.forEach(result => {
        allData = allData.concat(result.data);
    });

    allData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    if (allData.length === 0) {
        resultsContainer.textContent = 'No results to display';
        return;
    }

    const table = document.createElement('table');
    const header = document.createElement('tr');
    ['ID', 'CODE', 'IP', 'OS', 'COUNTRY', 'DATE/TIME', 'ACTION'].forEach(text => {
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

        const idCell = document.createElement('td');
        const codeCell = document.createElement('td');
        const ipCell = document.createElement('td');
        const osCell = document.createElement('td');
        const countryCell = document.createElement('td');
        const dateCell = document.createElement('td');
        const actionCell = document.createElement('td');

        idCell.textContent = data.id;
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

        row.appendChild(idCell);
        row.appendChild(codeCell);
        row.appendChild(ipCell);
        row.appendChild(osCell);
        row.appendChild(countryCell);
        row.appendChild(dateCell);
        row.appendChild(actionCell);

        table.appendChild(row);
    });

    resultsContainer.appendChild(table);

    const paginationControls = document.createElement('div');
    paginationControls.className = 'pagination-controls';

    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('a');
        pageLink.textContent = i;
        pageLink.className = (i === currentPage) ? 'active' : '';
        pageLink.href = '#';
        pageLink.onclick = (event) => {
            event.preventDefault();
            currentPage = i;
            displayResults(results);
        };
        paginationControls.appendChild(pageLink);
    }

    resultsContainer.appendChild(paginationControls);
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
        'created_at': 'Date/Time (UTC)',
        'is_vpn': 'VPN',
        'is_proxy': 'Proxy',
        'is_tor': 'TOR'
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
            } else if (key === 'is_vpn' || key === 'is_proxy' || key === 'is_tor') {
                cellValue.innerText = data[key] === 1 ? 'Yes' : 'No';
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
    updateUrl();
</script>
</div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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