<?php
session_start();
include("../componements/php/discord_server.php");
include("../componements/php/database_conn.php");
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
    $current_stats = isset($stats[$user_plan]) ? $stats[$user_plan] : [];

    date_default_timezone_set('Europe/Paris');

    $stmt = $conn->prepare("SELECT email, id, discord_id, username, created_at, updated_at, rank, profile_type, profile_background FROM users WHERE token = ?");
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
        $user_name = htmlspecialchars($row["username"]);
        $created_at_formatted = htmlspecialchars($created_at->format('Y-m-d H:i:s'));
        $updated_at_formatted = htmlspecialchars($updated_at->format('Y-m-d H:i:s'));
        $rank = htmlspecialchars($row["rank"]);
        $profile_type = htmlspecialchars($row["profile_type"]);
        $profile_background = htmlspecialchars($row["profile_background"]);
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
<html class="no-js" lang="en-US"><head>
    <meta charset="UTF-8">
    <script>console.log = function(){ };</script>
    <title>Love Stresser - Profile</title>
    <meta name="robots" content="max-image-preview:large">
    <meta name="generator" content="Elementor 3.20.2; features: e_optimized_assets_loading, e_optimized_css_loading, additional_custom_breakpoints, block_editor_assets_optimize, e_image_loading_optimization; settings: css_print_method-external, google_font-enabled, font_display-swap">
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
    <meta name="msapplication-TileImage" content="https://alethemes.com/onchain/wp-content/uploads/sites/109/2022/12/cropped-favicon-270x270.png">
    <script src="js/wp-emoji-release.min.js" defer=""></script>
    <style>
body{--wp--preset--color--black:#000000;--wp--preset--color--cyan-bluish-gray:#abb8c3;--wp--preset--color--white:#ffffff;--wp--preset--color--pale-pink:#f78da7;--wp--preset--color--vivid-red:#cf2e2e;--wp--preset--color--luminous-vivid-orange:#ff6900;--wp--preset--color--luminous-vivid-amber:#fcb900;--wp--preset--color--light-green-cyan:#7bdcb5;--wp--preset--color--vivid-green-cyan:#00d084;--wp--preset--color--pale-cyan-blue:#8ed1fc;--wp--preset--color--vivid-cyan-blue:#0693e3;--wp--preset--color--vivid-purple:#9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple:linear-gradient(           135deg,           rgba(6, 147, 227, 1) 0%,           rgb(155, 81, 224) 100%         );--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan:linear-gradient(           135deg,           rgb(122, 220, 180) 0%,           rgb(0, 208, 130) 100%         );--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange:linear-gradient(           135deg,           rgba(252, 185, 0, 1) 0%,           rgba(255, 105, 0, 1) 100%         );--wp--preset--gradient--luminous-vivid-orange-to-vivid-red:linear-gradient(           135deg,           rgba(255, 105, 0, 1) 0%,           rgb(207, 46, 46) 100%         );--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray:linear-gradient(           135deg,           rgb(238, 238, 238) 0%,           rgb(169, 184, 195) 100%         );--wp--preset--gradient--cool-to-warm-spectrum:linear-gradient(           135deg,           rgb(74, 234, 220) 0%,           rgb(151, 120, 209) 20%,           rgb(207, 42, 186) 40%,           rgb(238, 44, 130) 60%,           rgb(251, 105, 98) 80%,           rgb(254, 248, 76) 100%         );--wp--preset--gradient--blush-light-purple:linear-gradient(           135deg,           rgb(255, 206, 236) 0%,           rgb(152, 150, 240) 100%         );--wp--preset--gradient--blush-bordeaux:linear-gradient(           135deg,           rgb(254, 205, 165) 0%,           rgb(254, 45, 45) 50%,           rgb(107, 0, 62) 100%         );--wp--preset--gradient--luminous-dusk:linear-gradient(           135deg,           rgb(255, 203, 112) 0%,           rgb(199, 81, 192) 50%,           rgb(65, 88, 208) 100%         );--wp--preset--gradient--pale-ocean:linear-gradient(           135deg,           rgb(255, 245, 203) 0%,           rgb(182, 227, 212) 50%,           rgb(51, 167, 181) 100%         );--wp--preset--gradient--electric-grass:linear-gradient(           135deg,           rgb(202, 248, 128) 0%,           rgb(113, 206, 126) 100%         );--wp--preset--gradient--midnight:linear-gradient(           135deg,           rgb(2, 3, 129) 0%,           rgb(40, 116, 252) 100%         );--wp--preset--font-size--small:13px;--wp--preset--font-size--medium:20px;--wp--preset--font-size--large:36px;--wp--preset--font-size--x-large:42px;--wp--preset--spacing--20:0.44rem;--wp--preset--spacing--30:0.67rem;--wp--preset--spacing--40:1rem;--wp--preset--spacing--50:1.5rem;--wp--preset--spacing--60:2.25rem;--wp--preset--spacing--70:3.38rem;--wp--preset--spacing--80:5.06rem;--wp--preset--shadow--natural:6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep:12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp:6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined:6px 6px 0px -3px rgba(255, 255, 255, 1),           6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp:6px 6px 0px rgba(0, 0, 0, 1);}

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
body,div,span,h5,p,ul,li,a,img,footer,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
.story h5{text-transform:none;margin-bottom:20px;}
.story img{max-width:100%;height:auto;}
.head .head__subtitle,.head .head__title,.head .head__description{opacity:0;}
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
.hero__object{animation:zoom ease-out;animation-delay:0.4s;animation-duration:1.5s;top:-160px;left:260px;z-index:1;}
.hero__wrapper{width:100%;display:flex;height:100%;justify-content:space-between;}
@media (max-width: 992px){
.hero{height:auto;padding-top:180px;}
}
@media (max-width: 768px){
.hero{height:auto;padding-top:180px;}
}
.features__head{width:100%;display:flex;align-items:center;}
.features__item{display:flex;flex-direction:column;flex-wrap:wrap;padding:24px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);}
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
.elementor-screen-only{position:absolute;top:-10000em;width:1px;height:1px;margin:-1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);border:0;}
.elementor *,.elementor :after,.elementor :before{box-sizing:border-box;}
.elementor img{height:auto;max-width:100%;border:none;border-radius:0;box-shadow:none;}
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
.elementor-93 .elementor-element.elementor-element-4e43c55 > .elementor-element-populated{margin:0px 0px 0px 0px;--e-column-margin-right:0px;--e-column-margin-left:0px;padding:0px 0px 0px 0px;}
}
.notification,.error_notification{position:absolute;right:20px;background-color:#0b0b11;padding:15px;border-radius:14px;display:none;align-items:center;z-index:1000;box-shadow:0 2px 10px rgba(0, 0, 0, 0.2);animation:slideInFromRight 0.5s ease-out;margin-bottom:10px;transform:translateX(0);opacity:1;transition:opacity 0.5s ease-out, transform 0.5s ease-out, bottom 0.5s ease-out;white-space:nowrap;max-width:calc(100vw - 40px);word-wrap:break-word;}
.notification p,.error_notification p{color:#26d833;margin:0;}
.error_notification p{color:#bb0b0b;}

@keyframes zoom{0%{width:40px;height:40px;top:50px;left:20px;}100%{width:240px;height:240px;top:-160px;left:260px;}}
@keyframes slideInFromRight{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}
body{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:none;font-weight:500;line-height:26px;background-color:#06060c;background-repeat:repeat;background-position:top center;background-attachment:scroll;background-size:cover;}
.profile_container {
    display: flex;
    gap: 20px;
}

.member {
    padding: 24px;
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    width: 400px;
}
.modal-member {
    padding: 24px;
    margin-left: 20px;
    margin-top: 20px;
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    width: 400px;
    margin-bottom: 20px;
    transition:all 0.3s ease;
}
.modal-content {
    overflow: auto;
}
.modal-grid::-webkit-scrollbar {
  width: 12px;
}

.modal-grid::-webkit-scrollbar-track {
  background: #0a0a0a;
  border-radius: 8px;
}

.modal-grid::-webkit-scrollbar-thumb {
  background: #1d1d1d;
  border-radius: 8px;
}

.modal-grid::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.modal-grid {
  scrollbar-width: thin;
  scrollbar-color: #1d1d1d #0a0a0a;
}
.modal-grid {
    overflow: auto;
    margin-top: 40px;
}
.modal-grid::-webkit-scrollbar {
    display: none;
}
.member2 {
    padding: 24px;
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    width: 1000px;
}
.modal-member img{margin:2.5em;width:150px;aspect-ratio:1;border-radius:.375em;box-shadow:1px 1px #000c;filter:url('https://'<?php echo $root_domain ?>'/members/#shadow');}
.member img{margin:2.5em;width:150px;aspect-ratio:1;border-radius:.375em;box-shadow:1px 1px #000c;filter:url('https://'<?php echo $root_domain ?>'/members/#shadow');}
.member-wrapper{position:relative;display:inline-block;margin:20px;padding:20px;border-radius:10px;}
.member-wrapper::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;border-radius:10px;background:transparent;z-index:-1;transition:all 0.5s ease-in-out;}
.member-wrapper:hover::before{animation:spin 2s linear infinite;}
.member img{margin:2.5em;width:150px;aspect-ratio:1;border-radius:.375em;box-shadow:1px 1px #000c;filter:url('https://'<?php echo $root_domain ?>'/members/#shadow');}
.member h5{color:#fff;margin:10px 0;}h5{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.img_profile{display:flex;justify-content:center;align-items:center;}
.img_profile img{border-radius:15px;overflow:hidden;border:1px solid rgba(255, 255, 255, 0.08);}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}
.rank-admin{background-color: #956cfd;color: white;box-shadow: 0 0 10px #956cfd;}
.rank {
    padding: 1px 5px;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}
.rank-owner{background-color:#fd6c9e;color:white;box-shadow:0 0 10px #fd6c9e;}
.rank-member{background-color:#6cc0fd;color:white;box-shadow:0 0 10px #6cc0fd;}
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
.ribbon-wrapper {
  width: 110px;
  height: 110px;
  overflow: hidden;
  position: absolute;
  top: -1px;
  left: -1px;
}

.ribbon {
  font: bold 18px sans-serif;
  color: #333;
  text-align: center;
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  position: relative;
  padding: 10px 0;
  top: 20px;
  left: -40px;
  width: 164px;
  background-color: #ebb134;
  color: #fff;
}
select {
    scrollbar-width: thin;
    scrollbar-color: #444 #222;
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
input, select {
    transition: border-color 0.3s ease;
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
.button-ga542 {
    width: 64px;
    height: 42px;
}
.button-ga543 {
    width: 220px;
    height: 42px;
}
        .slider-images {
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }
        .slider-image {
            width: 100%;
            height: auto;
            position: absolute;
            top: 0;
            left: 0;
        }
        .arrow {
            position: absolute;
            top: 50%;
            width: 40px;
            height: 40px;
            background: none;
            color: #fff;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 100;
        }
        .prev {
            left: 10px;
            transform: translateY(-50%);
        }
        .next {
            right: 10px;
            transform: translateY(-50%);
        }
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    overflow: auto;
}
.dnmodal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    overflow: auto;
}
.dnmodal-content {
    background-color: #06060c;
    border-radius: 24px;
    margin-top: 400px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    padding: 20px;
    width: 800px;
    max-width: 800px;
    max-height: 400px;
    position: relative;
    margin-top: 400px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.modal-content {
    background-color: #06060c;
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    padding: 20px;
    width: 90%;
    max-width: 90%;
    max-height: 90%;
    position: relative;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.modal-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    height: 100%;
    overflow-y: auto;
    width: 1400px;
}

.modal-image {
    background-size: cover;
    background-position: center;
    height: 100px;
    position: relative;
}

.overlay {
    position: absolute;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    width: 100%;
    text-align: center;
    padding: 10px;
}

.close {
    position: absolute;
    top: 10px;
    right: 25px;
    color: #fff;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: white;
    text-decoration: none;
    cursor: pointer;
}
.open-modal-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.04);
    backdrop-filter: blur(12px);
    color: white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.select-background-btn {
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
    width: 84px;
    height: 52px;
}
.modal-member:hover{transform:scale(1.05);}

.open-modal-btn:hover {
    background-color: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
} 
.sinput {
    width: 900px;
    height: 50px;
}
.display_name_h5 {
    display: flex;
    justify-content: center;
    text-align: center;
    padding : 5px;
}   
.sselect {
    width: 450px;
    height: 50px;
}
.elementor *, .elementor :after, .elementor :before {
    box-sizing: border-box;
}
input {
    transition: border-color 0.3s ease;
}
input {
    width: 100%;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    padding: 16px 24px;
    font-size: 16px;
    line-height: 22px;
    font-family: 'Urbanist', sans-serif;
}
.modal-header {
    display: flex;
    flex-direction: column;
    padding: 10px;
}

#search-bar {
    padding: 5px;
    margin-bottom: 10px;
}

#filter-select {
    padding: 5px;
}
.edit-display-name-icon {
    margin-left: 5px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                            
                                <div class="features__head head">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                    <div class="head__subtitle animated">
                                      <p>Welcome to</p>
                                    </div>
                                    <div class="head__title animated">
                                      <p>YOUR <span>PROFILE</span> PAGE</p>
                                    </div>
                                    <br></br>
                                    
                                    <?php
                                        include("../componements/php/plans.php");
include("../componements/php/database_conn.php");
                                        $plan_style = isset($plan_styles[$user_plan]['style']) ? $plan_styles[$user_plan]['style'] : '';

                                        $unwanted_styles = [
                                            '-webkit-background-clip: text;',
                                            'color: transparent;',
                                            'text-shadow: 0 0 5px rgba(255, 0, 255, 0.5);',
                                            'text-transform: uppercase;'
                                        ];

                                        foreach ($unwanted_styles as $style) {
                                            $plan_style = str_replace($style, '', $plan_style);
                                        }

                                        if (strtolower($user_plan) === 'infinity' || 
                                            in_array(strtolower($user_plan), ['starter3', 'starter2', 'starter1'])) {
                                            $plan_style .= ' color: #373636';
                                        }

                                        $member_background_style = "";

                                        if (strtolower($profile_type) === 'image' && !empty($profile_background)) {
                                            $member_background_style = "background-image: url('$profile_background'); background-size: cover; background-position: center;";
                                        }
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        $stmt = $conn->prepare("SELECT name, display_name FROM images");
                                            $backgrounds = [];
                                            if ($stmt) {
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $backgrounds[] = $row;
                                                }
                                            }
                                            ?>
                                  
                                  <?php
$token = isset($_COOKIE['LS_ASP']) ? $_COOKIE['LS_ASP'] : '';

$user_id = getUserIdFromToken($token);

$stmt = $conn->prepare("SELECT profile_background, plan, plan_expire, display_name, username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_background_url, $user_plan, $plan_expire, $display_name, $user_name);
$stmt->fetch();
$stmt->close();

$attackStmt = $conn->prepare("SELECT COUNT(*) FROM attack_logs WHERE user_id = ?");
$attackStmt->bind_param("i", $user_id);
$attackStmt->execute();
$attackStmt->bind_result($total_attacks);
$attackStmt->fetch();
$attackStmt->close();

if ($user_plan === 'free') {
    $updateStmt = $conn->prepare("UPDATE users SET profile_background = NULL WHERE id = ?");
    $updateStmt->bind_param("i", $user_id);
    $updateStmt->execute();
    $updateStmt->close();

    $profile_background_url = NULL;
}

function getUserIdFromToken($token) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    return $user_id;
}
?>
<?php
if ($profile_background_url) {
    $parsed_profile_background_url = parse_url(htmlspecialchars($profile_background_url, ENT_QUOTES, 'UTF-8'));
    $modified_profile_background_url = str_replace($parsed_profile_background_url['host'], $root_domain, htmlspecialchars($profile_background_url, ENT_QUOTES, 'UTF-8'));
} else {
    $modified_profile_background_url = './images/default-background.png';
}
?>
<div class="profile_container">
    <div class="member" id="member-background" style="background-size: cover; background-position: center; background-image: url('<?php echo $profile_background_url ? htmlspecialchars($profile_background_url, ENT_QUOTES, 'UTF-8') : './images/default-background.png'; ?>');">
    <?php if ($user_plan !== 'free'): ?>
            <button class="open-modal-btn"><i class="fas fa-search"></i></button>
    <?php endif; ?>
    <center><h5>ID : #<?php echo $id; ?></h5></center>
        <div class="img_profile">
            <img class="rounded-corners" src="<?php echo $avatar_url ? $avatar_url : './images/default-avatar.png'; ?>">
        </div>
        <br>

        <center>
        <h5 class="display_name_h5">
            <?php 
            $escaped_display_name = htmlspecialchars(strtoupper($display_name), ENT_QUOTES, 'UTF-8');
            $escaped_user_name = htmlspecialchars(strtoupper($user_name), ENT_QUOTES, 'UTF-8');
            
            echo $escaped_display_name ? $escaped_display_name : $escaped_user_name; 
            ?>
            <i class="fas fa-pencil-alt edit-display-name-icon" style="cursor: pointer;"></i>
        </h5>
            <h5><?php echo formatRank(strtoupper($rank)); ?></h5>
        </center>
        <br></br>
        <h5>Email: <?php echo $email; ?></h5>
        <h5>Discord ID: <?php echo $discord_id; ?></h5>
        <h5>Created At: <?php echo $created_at_formatted; ?></h5>
        <h5>Updated At: <?php echo $updated_at_formatted; ?></h5>

        <?php
        function formatRank($rank) {
            switch ($rank) {
                case 'OWNER':
                    return '<span class="rank rank-owner">' . htmlspecialchars($rank) . '</span>';
                case 'CO-OWNER':
                    return '<span class="rank rank-co-owner">' . htmlspecialchars($rank) . '</span>';
                case 'ADMIN':
                    return '<span class="rank rank-admin">' . htmlspecialchars($rank) . '</span>';
                case 'CUSTOMER':
                    return '<span class="rank rank-customer">' . htmlspecialchars($rank) . '</span>';
                case 'MEMBER':
                    return '<span class="rank rank-member">' . htmlspecialchars($rank) . '</span>';
                default:
                    return htmlspecialchars($rank);
            }
        }
        ?>

        <div class="ribbon-wrapper">
            <div class="ribbon" style="<?php echo $plan_style; ?>;">
                <?php echo strtoupper($user_plan) ?>
            </div>
        </div>
        <br>
        <?php if ($user_plan !== 'free'): ?>
        <center><button class="button-ga542" id="save-button">Save</button></center>
        <?php endif; ?>
        <div class="slider-container">
        <?php if ($user_plan !== 'free'): ?>
        <button class="arrow prev" onclick="changeBackground(-1)">&#10094;</button>
        <?php endif; ?>
            <div class="slider-images">
            <?php
                if ($user_plan !== 'free') {
                    $stmt = $conn->prepare("SELECT DISTINCT name, url FROM images");
                    if ($stmt) {
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $images = [];
                        while ($row = $result->fetch_assoc()) {
                            $images[] = $row;
                        }
                        foreach ($images as $index => $image) {
                            $parsed_image_url = parse_url(htmlspecialchars($image['url'], ENT_QUOTES, 'UTF-8'));
                            $modified_image_url = str_replace($parsed_image_url['host'], $root_domain, htmlspecialchars($image['url'], ENT_QUOTES, 'UTF-8'));

                            echo '<div class="slider-image" data-index="' . $index . '" data-name="' . htmlspecialchars($image['name'], ENT_QUOTES, 'UTF-8') . '" data-url="' . $modified_image_url . '"></div>';
                        }
                    }
                }
                ?>
            </div>
        <?php if ($user_plan !== 'free'): ?>
        <button class="arrow next" onclick="changeBackground(1)">&#10095;</button>
        <?php endif; ?>
        
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    var token = "<?php echo htmlspecialchars($_COOKIE['LS_ASP'], ENT_QUOTES, 'UTF-8'); ?>";
    var currentIndex = 0;
    var sliderImages = Array.from(document.querySelectorAll('.slider-image'));
    var userPlan = "<?php echo htmlspecialchars($user_plan, ENT_QUOTES, 'UTF-8'); ?>";

    function updateBackground(index) {
        var name = sliderImages[index].getAttribute('data-name');
        var url = sliderImages[index].getAttribute('data-url');

        document.getElementById('member-background').style.backgroundImage = 'url(' + url + ')';

        window.selectedBackground = name;
    }

    function changeBackground(direction) {
        currentIndex = (currentIndex + direction + sliderImages.length) % sliderImages.length;
        updateBackground(currentIndex);
    }

    function saveBackground() {
        var name = window.selectedBackground;
        if (!name) {
            displayErrorMessage("No background selected to save.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "change_background.php",
            data: {
                name: name,
                token: token
            },
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status !== 'success') {
                    displayErrorMessage("Error: " + jsonResponse.message);
                } else {
                    displayNotification("Background saved successfully!");
                }
            },
            error: function(xhr, status, error) {
                displayErrorMessage("An error occurred: " + error);
            }
        });
    }

    document.getElementById('save-button').addEventListener('click', saveBackground);

    function initializeBackground() {
        var profileBackground = "<?php echo htmlspecialchars($profile_background_url, ENT_QUOTES, 'UTF-8'); ?>";
        if (profileBackground) {
            document.getElementById('member-background').style.backgroundImage = 'url(' + profileBackground + ')';
        } else if (sliderImages.length > 0) {
            updateBackground(0);
        }
    }

    initializeBackground();

    if (userPlan === 'free') {
        document.querySelector('.slider-container').style.display = 'none';
    }
    </script>
                                        
<div class="member2">
<center>
    <h1>Account Information</h1>
    <center>
    <?php if (empty($plan_expire)): ?>
        <p>Your plan will <strong>never</strong> expire.</p>
    <?php else: ?>
        <p>Your plan expires on: <strong><?php echo htmlspecialchars(date('F j, Y', strtotime($plan_expire))); ?></strong></p>
    <?php endif; ?>

    <p>You launched <strong><?php echo htmlspecialchars($total_attacks); ?></strong> attacks!</p>

    <br></br>
</div>
<div id="image-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
            <center><h2>Images Library</h2><br></br></center>
            <input type="text" class="sinput" id="search-bar" placeholder="Search images by name..." />
            <center><label>Display :</label></center>
            <center><select class="sselect" id="filter-select">
                <option value="all">All</option>
                <option value="non-animated">Non-Animated Only</option>
                <option value="animated">Animated Only</option>
            </select></center>
        </div>
        <div class="modal-grid">
            <?php
            if ($user_plan !== 'free') {
                $stmt = $conn->prepare("SELECT DISTINCT name, display_name, url FROM images");
                if ($stmt) {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $images = [];
                    while ($row = $result->fetch_assoc()) {
                        $images[] = $row;
                    }
                    foreach ($images as $index => $image) {
                        $parsed_image_url = parse_url(htmlspecialchars($image['url'], ENT_QUOTES, 'UTF-8'));
                        $modified_image_url = str_replace($parsed_image_url['host'], $root_domain, htmlspecialchars($image['url'], ENT_QUOTES, 'UTF-8'));

                        $isAnimated = pathinfo($image['url'], PATHINFO_EXTENSION) === 'gif';
                        $imageClass = $isAnimated ? 'animated' : 'non-animated';
                        echo '<div class="modal-member ' . $imageClass . '" style="background-size: cover; background-position: center; background-image: url(' . $modified_image_url . ');">
                                  <center><div class="background-name" style="padding: 10px; width: 180px; border-radius: 24px; background-color: rgba(0, 0, 0, 0.5); color: white; font-weight: bold;">'
                                      . htmlspecialchars($image['display_name'], ENT_QUOTES, 'UTF-8') .
                                  '</div><br></center>
                                  <center><h5>ID : #' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . '</h5></center>
                                  <div class="img_profile">
                                      <img class="rounded-corners" src="' . htmlspecialchars($avatar_url, ENT_QUOTES, 'UTF-8') . '">
                                  </div>
                                  <br>
                                  <center>
                                      <h5>' . strtoupper(htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8')) . '</h5>
                                      <h5>' . formatRank(strtoupper(htmlspecialchars($rank, ENT_QUOTES, 'UTF-8'))) . '</h5>
                                  </center>
                                  <br></br>
                                  <h5>Email: ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</h5>
                                  <h5>Discord ID: ' . htmlspecialchars($discord_id, ENT_QUOTES, 'UTF-8') . '</h5>
                                  <h5>Created At: ' . htmlspecialchars($created_at_formatted, ENT_QUOTES, 'UTF-8') . '</h5>
                                  <h5>Updated At: ' . htmlspecialchars($updated_at_formatted, ENT_QUOTES, 'UTF-8') . '</h5>
                                  <div class="ribbon-wrapper">
                                      <div class="ribbon" style="' . htmlspecialchars($plan_style, ENT_QUOTES, 'UTF-8') . ';">
                                          ' . strtoupper(htmlspecialchars($user_plan, ENT_QUOTES, 'UTF-8')) . '
                                      </div>
                                  </div>
                                  <br>
                                  <center><button class="select-background-btn" 
                                      data-name="' . htmlspecialchars($image['name'], ENT_QUOTES, 'UTF-8') . '" 
                                      data-url="' . $modified_image_url . '">
                                  Select
                              </button></center>
                              </div>';
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
<center>
<div id="display-name-modal" class="dnmodal">
    <div class="dnmodal-content">
        <span class="close">&times;</span>
        <h2>Change Display Name</h2>
        <br></br>
        <input type="text" id="new-display-name" placeholder="Enter new display name" />
        <br></br>
        <li><button id="save-display-name" style="margin-right: 10px;" class="button-ga542">Save</button><button id="remove-display-name" class="button-ga543">Remove Display Name</button></li>
        <p id="display-name-error" style="color: red; display: none;"></p>
    </div>
</div>
        </center>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var displayNameModal = document.getElementById('display-name-modal');
    var editDisplayNameIcon = document.querySelector('.edit-display-name-icon');
    var closeModalBtn = displayNameModal.querySelector('.close');
    var saveDisplayNameBtn = document.getElementById('save-display-name');
    var removeDisplayNameBtn = document.getElementById('remove-display-name');
    var newDisplayNameInput = document.getElementById('new-display-name');
    var displayNameError = document.getElementById('display-name-error');
    var token = "<?php echo htmlspecialchars($_COOKIE['LS_ASP'], ENT_QUOTES, 'UTF-8'); ?>";
    editDisplayNameIcon.addEventListener('click', function() {
        displayNameModal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', function() {
        displayNameModal.style.display = 'none';
        displayNameError.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === displayNameModal) {
            displayNameModal.style.display = 'none';
            displayNameError.style.display = 'none';
        }
    });

    saveDisplayNameBtn.addEventListener('click', function() {
        var newDisplayName = newDisplayNameInput.value.trim();

        if (newDisplayName === '') {
            displayErrorMessage("Display name cannot be empty.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "update_display_name.php",
            data: {
                new_display_name: newDisplayName,
                token: token
            },
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status === 'success') {
                    location.reload();
                } else {
                    displayErrorMessage(jsonResponse.message);
                }
            },
            error: function(xhr, status, error) {
                displayErrorMessage("An error occurred: " + error);
            }
           });
        });


    removeDisplayNameBtn.addEventListener('click', function() {
            $.ajax({
                type: "POST",
                url: "remove_display_name.php",
                data: {
                    user_id: <?php echo json_encode($user_id); ?>
                },
                success: function(response) {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.status === 'success') {
                        location.reload();
                    } else {
                        displayErrorMessage(jsonResponse.message);
                    }
                },
                error: function(xhr, status, error) {
                    displayErrorMessage("An error occurred: " + error);
                }
            });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('image-modal');
    var openModalBtn = document.querySelector('.open-modal-btn');
    var closeBtn = document.querySelector('.modal .close');
    var searchBar = document.getElementById('search-bar');
    var filterSelect = document.getElementById('filter-select');

    openModalBtn.addEventListener('click', function() {
        preloadImages(function() {
            modal.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    function preloadImages(callback) {
        var images = document.querySelectorAll('.modal-member');
        var loadedCount = 0;

        if (images.length === 0) {
            callback();
            return;
        }

        images.forEach(function(imageDiv) {
            var imageUrl = imageDiv.style.backgroundImage.slice(5, -2);
            var img = new Image();
            img.src = imageUrl;

            img.onload = function() {
                loadedCount++;
                if (loadedCount === images.length) {
                    callback();
                }
            };

            img.onerror = function() {
                loadedCount++;
                if (loadedCount === images.length) {
                    callback();
                }
            };
        });
    }

    function filterImages() {
        var searchTerm = searchBar.value.toLowerCase();
        var filterOption = filterSelect.value;
        var images = document.querySelectorAll('.modal-member');

        images.forEach(function(image) {
            var imageName = image.querySelector('.background-name').textContent.toLowerCase();
            var isAnimated = image.classList.contains('animated');
            var matchesSearch = imageName.includes(searchTerm);
            var matchesFilter = (filterOption === 'all') ||
                                (filterOption === 'non-animated' && !isAnimated) ||
                                (filterOption === 'animated' && isAnimated);

            if (matchesSearch && matchesFilter) {
                image.style.display = '';
            } else {
                image.style.display = 'none';
            }
        });
    }

    searchBar.addEventListener('input', filterImages);
    filterSelect.addEventListener('change', filterImages);

    document.querySelectorAll('.select-background-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var imageName = button.getAttribute('data-name');
            var imageUrl = button.getAttribute('data-url');

            document.getElementById('member-background').style.backgroundImage = 'url(' + imageUrl + ')';

            $.ajax({
                type: "POST",
                url: "change_background.php",
                data: {
                    name: imageName,
                    token: "<?php echo htmlspecialchars($_COOKIE['LS_ASP'], ENT_QUOTES, 'UTF-8'); ?>"
                },
                success: function(response) {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.status === 'success') {
                        displayNotification('Background updated successfully!');
                    } else {
                        displayNotification('Error: ' + jsonResponse.message);
                    }
                },
                error: function(xhr, status, error) {
                    displayNotification('An error occurred: ' + error);
                }
            });

            modal.style.display = 'none';
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
                                    </div>
                                </div>
                        </div>
                  <div class="elementor-element elementor-element-d273a56 elementor-widget elementor-widget-onchain_shop" data-id="d273a56" data-element_type="widget" data-widget_type="onchain_shop.default">
                   
          
                      </div></div></div></div></section>
                      
                    </div>
                  
                  <div class="elementor-element elementor-element-6b6a065 elementor-widget elementor-widget-onchain_about" data-id="6b6a065" data-element_type="widget" data-widget_type="onchain_about.default">
                    <div class="elementor-widget-container">
                      
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