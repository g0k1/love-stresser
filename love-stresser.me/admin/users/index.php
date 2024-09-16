<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
session_start();
include("../../componements/php/root_domain.php");
include("../../componements/php/database_conn.php");
include("../../componements/php/unauthorized.php");
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

    $rank_styles = [
        'owner' => 'background-color: #fd6c9e; color: white; box-shadow: 0 0 10px #fd6c9e;',
        'co-owner' => 'background-color: #677179; color: white; box-shadow: 0 0 10px #858d93;',
        'admin' => 'background-color: #F0AD48; color: white; box-shadow: 0 0 10px #F4C57E;',
        'customer' => 'background-color: #226B00; color: white; box-shadow: 0 0 10px #7AA666;',
        'member' => 'background-color: blue; color: white; box-shadow: 0 0 10px blue;'
    ];

    $rank = $row["rank"];
    $plan = $row["plan"];

    $rank_css = isset($rank_styles[$rank]) ? $rank_styles[$rank] : '';
    $plan_css = isset($plan_styles[$plan]) ? $plan_styles[$plan] : '';

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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'get_user_data') {
        $banned_user_id = intval($_POST['id']);
    
        $stmt = $conn->prepare("SELECT rank FROM users WHERE id = ?");
        $stmt->bind_param("i", $banned_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
    
        echo json_encode(['rank' => $data['rank']]);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'get_current_user_rank') {
        $stmt = $conn->prepare("SELECT rank FROM users WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
    
        echo json_encode(['rank' => $data['rank']]);
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
body,div,span,h2,h3,p,ul,li,a,img,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,textarea,input{-webkit-text-size-adjust:none;}
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
textarea{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;height:148px;font-size:16px;line-height:22px;font-family:'Urbanist', sans-serif;}
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
h2{font-size:40px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
h3{font-size:30px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
.current_selected{text-decoration:underline;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}

.rank_tag{padding: 1px 5px;border-radius:5px;}
.sidebar-section{display:flex;flex-direction:column;padding:50px;margin-bottom:24px;height:1192px;margin-top:24px;margin-left:50px;width:300px;border-radius:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);}
.sidebar-items{text-align:center;}
.accontainer{display:flex;flex-wrap:wrap;max-width:1480px;gap:20px;margin-top:50px;margin-left:525px;}
.user-box{border:1px solid rgba(255, 255, 255, 0.08);border-radius:24px;padding:20px;width:calc(33.333% - 20px);box-sizing:border-box;margin-bottom:10px;background:rgba(255, 255, 255, 0.02);}
.user-box img{max-width:100%;height:auto;border-radius:50%;}
.user-box p{margin:5px 0;}
.user-box button{display:inline-block;}
.user-box button:hover{background-color:#0056b3;}
.action-btn{width:120px;height:60px;border-radius:15px;margin-left:5px;}
.ban-btn{margin-top:20px;width:60px;height:30px;margin-right:5px;border-radius:5px;}
.guilds-btn{margin-top:20px;width:120px;height:30px;border-radius:5px;}
.modal-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0, 0, 0, 0.5);display:none;justify-content:center;align-items:center;}
.modal-content{margin-top:20px;background:#0b0b11;border-radius:24px;padding:20px;max-width:90%;width:600px;max-height:80%;overflow:hidden;box-shadow:0 2px 10px rgba(0, 0, 0, 0.1);position:relative;overflow-y:auto;}
.modal-close{position:absolute;top:10px;right:10px;cursor:pointer;width:50px;height:50px;font-size:18px;background:none;border:none;color:#fff;}
.notification,.error_notification{position:absolute;right:20px;background-color:#0b0b11;padding:15px;border-radius:14px;display:none;align-items:center;z-index:1000;box-shadow:0 2px 10px rgba(0, 0, 0, 0.2);animation:slideInFromRight 0.5s ease-out;margin-bottom:10px;transform:translateX(0);opacity:1;transition:opacity 0.5s ease-out, transform 0.5s ease-out, bottom 0.5s ease-out;white-space:nowrap;max-width:calc(100vw - 40px);word-wrap:break-word;}
.notification p,.error_notification p{color:#26d833;margin:0;}
.error_notification p{color:#bb0b0b;}
.modal-content::-webkit-scrollbar{display:none;}

.ip-address{display:none;}
.ip-placeholder:hover + .ip-address{display:inline;}
.ip-placeholder{background-color:#06060c;padding:4px;border-radius:5px;}
.ip-placeholder:hover{display:none;}
.user-box:hover .ip-placeholder{display:inline;}
.ip-address{background-color:#06060c;padding:4px;border-radius:5px;cursor:pointer;}
.search-container{width:300px;margin-top:-1080px;margin-left:1095px;}

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
<html class="no-js" lang="en-US"><head>
    <meta charset="UTF-8">
    <script>console.log = function(){ };</script>
    <title>Love Stresser - Admin</title>
    <meta name="robots" content="max-image-preview:large">
    <noscript><style>
        .woocommerce-product-gallery {
          opacity: 1 !important;
        }
      </style></noscript>
    <meta name="generator" content="Elementor 3.20.2; features: e_optimized_assets_loading, e_optimized_css_loading, additional_custom_breakpoints, block_editor_assets_optimize, e_image_loading_optimization; settings: css_print_method-external, google_font-enabled, font_display-swap">
    <link rel="icon" href="../images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="../images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="../images/cropped-favicon-180x180.png">
    <meta name="msapplication-TileImage" content="https://alethemes.com/onchain/wp-content/uploads/sites/109/2022/12/cropped-favicon-270x270.png">
    <script src="../js/wp-emoji-release.min.js" defer=""></script>
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
<style>
    .rank {
        padding: 1px 5px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    }

    .rank-owner {
        background-color: #fd6c9e;
        color: white;
        box-shadow: 0 0 10px #fd6c9e;
    }

    .rank-co-owner {
        background-color: #677179;
        color: white;
        box-shadow: 0 0 10px #858d93;
    }

    .rank-admin {
        background-color: #F0AD48;
        color: white;
        box-shadow: 0 0 10px #F4C57E;
    }

    .rank-customer {
        background-color: #226B00;
        color: white;
        box-shadow: 0 0 10px #7AA666;
    }

    .rank-member {
        background-color: blue;
        color: white;
        box-shadow: 0 0 10px blue;
    }

    .sidebar-section {
        display: flex;
        flex-direction: column;
        padding: 50px;
        margin-bottom: 24px;
        height: 1192px;
        margin-top: 24px;
        margin-left: 50px;
        width: 300px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .sidebar-items {
        text-align: center;
    }

    .new-section {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 50px 0;
        margin-top: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .main-content {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 50px 0;
        width: 1440px;
        display: flex;
        height: 1025px;
        margin-top: -1050px;
        justify-content: center;
        align-items: center;
    }

    .scrollable-container {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        box-sizing: border-box;
    }

    .accontainer {
        display: flex;
        flex-wrap: wrap;
        max-width: 1480px;
        gap: 20px;
        margin-top: 50px;
        margin-left: 525px;
    }

    .user-box {
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 20px;
        width: calc(33.333% - 20px);
        box-sizing: border-box;
        margin-bottom: 10px;
        background: rgba(255, 255, 255, 0.02);
    }

    .user-box img {
        max-width: 100%;
        height: auto;
        border-radius: 50%;
    }

    .user-box p {
        margin: 5px 0;
    }

    .user-box button {
        display: inline-block;
    }

    .user-box button:hover {
        background-color: #0056b3;
    }

    .copy-btn {
        width: 60px;
        height: 30px;
        border-radius: 5px;
    }

    .action-btn {
        width: 120px;
        height: 60px;
        border-radius: 15px;
        margin-left: 5px;
    }

    .ban-btn {
        margin-top: 20px;
        width: 60px;
        height: 30px;
        margin-right: 5px;
        border-radius: 5px;
    }

    .guilds-btn {
        margin-top: 20px;
        width: 120px;
        height: 30px;
        border-radius: 5px;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        margin-top: 20px;
        background: #0b0b11;
        border-radius: 24px;
        padding: 20px;
        max-width: 90%;
        width: 600px;
        max-height: 80%;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow-y: auto;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        width: 50px;
        height: 50px;
        font-size: 18px;
        background: none;
        border: none;
        color: #fff;
    }

    .modal-overlay.active {
        display: flex;
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
        display: flex;
        flex-direction: column-reverse;
        align-items: flex-end;
        z-index: 1000;
    }

    .guild-box {
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 10px;
        margin-bottom: 10px;
        background: rgba(255, 255, 255, 0.02);
        text-align: center;
    }

    .guild-icon {
        max-width: 100px;
        height: auto;
        border-radius: 12px;
    }
    .modal-content::-webkit-scrollbar {
    display: none;
    }
</style>


<div class="hero__object circle"></div>
<section class="global-section">
    <section class="sidebar-section">
        <center><a href="../"><h3>Admin</a></h3></center>
        <br></br>
        <div class="sidebar-items">
            <ul>
                <li><a class="current_selected current-menu-item" href="">Users</a></li>
                <li><a href="../bans">Bans</a></li>
                <li><a href="../logs">Logs</a></li>
                <li><a href="../iplogs">GrabLogs</a></li>
                <li><a href="../codes">Codes</a></li>
                <li><a href="../ongoing">Ongoing</a></li>
                <li><a href="../blacklist">Blacklist</a></li>
                <li><a href="../add-image">Add-Image</a></li>
            </ul>
        </div>
    </section>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Search by username or email">
    </div>
    <style>
    .ip-address {
        display: none;
    }

    .ip-placeholder:hover + .ip-address {
        display: inline;
    }
    .ip-placeholder {
        background-color: #06060c;
        padding: 4px;
        border-radius: 5px;
    }
    .ip-placeholder:hover {
        display: none;
    }

    .user-box:hover .ip-placeholder {
        display: inline;
    }
    .ip-address {
        background-color: #06060c;
        padding: 4px;
        border-radius: 5px;
        cursor: pointer;
    }
    .search-container {
        width: 300px;
        margin-top: -1080px;
        margin-left: 1095px;
    }
    .token {
        cursor: pointer;
        display: none;
}
</style>

<?php
include("./../../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, avatar, discord_id, username, email, token, created_at, updated_at, rank, plan, ip, guilds FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="accontainer">';
    while($row = $result->fetch_assoc()) {
        $truncatedToken = substr($row["token"], 0, 20) . '...';
        $fullToken = $row["token"];
        $guilds = json_decode($row["guilds"], true);
        $tokenId = 'token-' . $row["id"];
        $ipId = 'ip-' . $row["id"];
        $defaultAvatar = "https://i.ibb.co/z4TgXjL/question-mark-1.png";

        echo '<div class="user-box">';
        echo '<img src="' . $row["avatar"] . '" alt="Avatar" onerror="this.onerror=null; this.src=\'' . $defaultAvatar . '\'">';
        echo '<p><button class="ban-btn" data-id="' . $row["id"] . '">Ban</button>';
        echo '<button class="guilds-btn" data-guilds=\'' . htmlspecialchars($row["guilds"], ENT_QUOTES, 'UTF-8') . '\' data-id="' . $row["id"] . '">See Guilds</button></p>';
        echo '<p>ID: ' . $row["id"] . '</p>';
        echo '<p>Discord ID: ' . $row["discord_id"] . '</p>';
        echo '<p>Username: ' . $row["username"] . '</p>';
        echo '<p>Email: ' . $row["email"] . '</p>';
        echo '<p>Token: <span class="ip-placeholder" data-type="token" data-id="' . $row["id"] . '">Hover to show</span><span id="' . $tokenId . '" class="ip-address" data-full-token="' . $fullToken . '">' . $truncatedToken . '</span></p>';
        echo '<p>Created At: ' . $row["created_at"] . '</p>';
        echo '<p>Updated At: ' . $row["updated_at"] . '</p>';
        echo '<p>Rank: ' . $row["rank"] . '</p>';
        echo '<p>Plan: ' . $row["plan"] . '</p>';
        echo '<p>IP: <span class="ip-placeholder" data-type="ip" data-id="' . $row["id"] . '">Hover to show</span><span id="' . $ipId . '" class="ip-address">' . $row["ip"] . '</span></p>';
        echo '<br>';
        echo '<center>';
        if ($rank === 'owner') :
        echo '<button class="action-btn edit-plan" data-id="' . $row["id"] . '" data-plan="' . $row["plan"] . '">Edit Plan</button>';
        echo '<button class="action-btn edit-rank" data-id="' . $row["id"] . '" data-rank="' . $row["rank"] . '">Edit Rank</button>';
        endif;
        echo '</center>';
        echo '</br>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "0 results";
}
$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    function filterProfiles() {
        var query = $('#search-input').val().toLowerCase();
        $('.user-box').each(function() {
            var username = $(this).find('p:contains("Username:")').text().toLowerCase();
            var email = $(this).find('p:contains("Email:")').text().toLowerCase();
            var discordId = $(this).find('p:contains("Discord ID:")').text().toLowerCase();
            var token = $(this).find('p:contains("Token:")').text().toLowerCase();

            if (username.includes(query) || email.includes(query) || discordId.includes(query) || token.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#search-input').on('input', function() {
        filterProfiles();
    });

    $('.ip-placeholder').hover(function(){
        var type = $(this).data('type');
        var id = $(this).data('id');
        $(this).hide();
        $('#' + type + '-' + id).show();
    }, function(){
        var type = $(this).data('type');
        var id = $(this).data('id');
        $(this).show();
        $('#' + type + '-' + id).hide();
    });

    $('.ip-address').hover(function(){
        $(this).show();
        $(this).prev('.ip-placeholder').hide();
    }, function(){
        $(this).hide();
        $(this).prev('.ip-placeholder').show();
    });

    $('.ip-address').click(function() {
        var fullToken = $(this).data('full-token');
        var $tempElement = $('<input>');
        $('body').append($tempElement);
        if (fullToken) {
            $tempElement.val(fullToken).select();
            displayNotification("Token Copied!");
        } else {
            $tempElement.val($(this).text()).select();
            displayNotification("IP Copied!");
        }
        document.execCommand('copy');
        $tempElement.remove();
    });
});

function displayNotification(message) {
    alert(message);
}
</script>

    <div id="banModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="banClose">&times;</button>
            <h2>Ban User</h2>
            <br>
            <textarea id="banReason" placeholder="Reason for ban"></textarea>
            <br></br>
            <button id="banSubmit">Submit</button>
        </div>
    </div>
<?php if ($rank === 'owner') : ?>
    <div id="editPlanModal" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" id="planClose">&times;</button>
        <h2>Edit Plan</h2>
        <br>
        <select id="planSelect">
            <option value="free">Free</option>
            <option value="starter1">Starter 1</option>
            <option value="starter2">Starter 2</option>
            <option value="starter3">Starter 3</option>
            <option value="exp1">Exp 1</option>
            <option value="exp2">Exp 2</option>
            <option value="exp3">Exp 3</option>
            <option value="pro1">Pro 1</option>
            <option value="pro2">Pro 2</option>
            <option value="pro3">Pro 3</option>
            <option value="infinity">Infinity</option>
        </select>
        <br></br>
        <button id="planSave">Save</button>
    </div>
</div>


    <div id="editRankModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="rankClose">&times;</button>
            <h2>Edit Rank</h2>
            <br>
            <select id="rankSelect">
                <option value="member">Member</option>
                <option value="admin">Admin</option>
                <option value="owner">Owner</option>
            </select>
            <br></br>
            <button id="rankSave">Save</button>
        </div>
    </div>
<?php endif; ?>
    <div id="guildsModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" id="guildsClose">&times;</button>
            <h2>User Guilds</h2>
            <br>
            <div id="guildsContent" class="guilds-modal-content">
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ban-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;

            document.getElementById('banModal').classList.add('active');
            document.getElementById('banSubmit').onclick = function() {
                const reason = document.getElementById('banReason').value;

                fetch('index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=get_user_data&id=${userId}`
                }).then(response => response.json())
                .then(bannedUserData => {
                    const bannedUserRank = bannedUserData.rank;

                    fetch('index.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=get_current_user_rank`
                    }).then(response => response.json())
                    .then(currentUserData => {
                        const currentUserRank = currentUserData.rank;

                        if (currentUserRank === 'admin' && (bannedUserRank === 'owner' || bannedUserRank === 'admin')) {
                            displayErrorMessage("You do not have permission to ban this user.");
                            document.getElementById('banModal').classList.remove('active');
                        } else if (currentUserRank === 'owner' || (currentUserRank === 'admin' && bannedUserRank === 'member')) {
                            fetch('index.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: `action=ban&id=${userId}&reason=${encodeURIComponent(reason)}`
                            }).then(response => response.text())
                            .then(data => {
                                displayNotification("Banned successfully");
                                document.getElementById('banModal').classList.remove('active');
                            });
                        } else {
                            displayErrorMessage("You do not have permission to ban this user.");
                            document.getElementById('banModal').classList.remove('active');
                        }
                    });
                });

            };
            document.getElementById('banClose').onclick = function() {
                document.getElementById('banModal').classList.remove('active');
            };
        });
    });

        document.querySelectorAll('.edit-plan').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.id;
                const currentPlan = this.dataset.plan;
                document.getElementById('planSelect').value = currentPlan;
                document.getElementById('editPlanModal').classList.add('active');
                document.getElementById('planSave').onclick = function() {
                    const selectedPlan = document.getElementById('planSelect').value;
                    fetch('index.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=edit_plan&id=${userId}&plan=${encodeURIComponent(selectedPlan)}`
                    }).then(response => response.text())
                    .then(data => {
                        displayNotification("Plan changed successfully");
                        document.getElementById('editPlanModal').classList.remove('active');
                    });
                };
                document.getElementById('planClose').onclick = function() {
                    document.getElementById('editPlanModal').classList.remove('active');
                };
            });
        });

        document.querySelectorAll('.edit-rank').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.id;
                const currentRank = this.dataset.rank;
                document.getElementById('rankSelect').value = currentRank;
                document.getElementById('editRankModal').classList.add('active');
                document.getElementById('rankSave').onclick = function() {
                    const selectedRank = document.getElementById('rankSelect').value;
                    fetch('index.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=edit_rank&id=${userId}&rank=${encodeURIComponent(selectedRank)}`
                    }).then(response => response.text())
                    .then(data => {
                        displayNotification("Rank changed successfully");
                        document.getElementById('editRankModal').classList.remove('active');
                    });
                };
                document.getElementById('rankClose').onclick = function() {
                    document.getElementById('editRankModal').classList.remove('active');
                };
            });
        });

        document.querySelectorAll('.guilds-btn').forEach(button => {
            button.addEventListener('click', function() {
                const guilds = JSON.parse(this.dataset.guilds);
                const guildsContent = document.getElementById('guildsContent');
                guildsContent.innerHTML = '';

                if (guilds.length === 0) {
                    guildsContent.innerHTML = '<p>No guilds found</p>';
                } else {
                    guilds.forEach(guild => {
                        const guildBox = document.createElement('div');
                        guildBox.className = 'guild-box';
                        guildBox.innerHTML = `
                            <img src="https://cdn.discordapp.com/icons/${guild.id}/${guild.icon}.png" alt="Guild Icon" class="guild-icon">
                            <p>ID: ${guild.id}</p>
                            <p>Name: ${guild.name}</p>
                        `;
                        guildsContent.appendChild(guildBox);
                    });
                }

                document.getElementById('guildsModal').classList.add('active');
                document.getElementById('guildsClose').onclick = function() {
                    document.getElementById('guildsModal').classList.remove('active');
                };
            });
        });
    });
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
            location.reload();
        }, 500);
    }, 3000);
}
</script>
<?php
include("./../../componements/php/database_conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = $_POST['id'];

    if ($action == 'ban') {
        $reason = $_POST['reason'];
        $stmt = $conn->prepare("UPDATE users SET banned = 1, ban_reason = ? WHERE id = ?");
        $stmt->bind_param("si", $reason, $id);
        $stmt->execute();
        echo "User banned successfully";
    } elseif ($action == 'edit_plan') {
        $plan = $_POST['plan'];
        $stmt = $conn->prepare("UPDATE users SET plan = ? WHERE id = ?");
        $stmt->bind_param("si", $plan, $id);
        $stmt->execute();
        echo "Plan updated successfully";
    } elseif ($action == 'edit_rank') {
        $rank = $_POST['rank'];
        $stmt = $conn->prepare("UPDATE users SET rank = ? WHERE id = ?");
        $stmt->bind_param("si", $rank, $id);
        $stmt->execute();
        echo "Rank updated successfully";
    }

    $conn->close();
    exit;
}

$sql = "SELECT id, avatar, discord_id, username, email, token, created_at, updated_at, rank, plan, ip, banned, ban_reason FROM users";
$result = $conn->query($sql);

?>               
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
