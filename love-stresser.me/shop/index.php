<?php
session_start();
include("../componements/php/root_domain.php");
include("../componements/php/database_conn.php");
include("../componements/php/discord_server.php");
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
if (isset($_COOKIE['LS_ASP'])) {
    $token = $_COOKIE['LS_ASP'];
    $avatar_url = getUserAvatar($conn, $token);
    $rank = getUserRank($conn, $token);
    $current_plan = getUserPlan($conn, $token);
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
<?php
include("../componements/php/plans.php");
?>
<html class="no-js" lang="en-US"><head>
    <meta charset="UTF-8">
    <script>console.log = function(){ };</script>
    <title>Love Stresser - Shop </title>
    <meta name="robots" content="max-image-preview:large">
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
  <body data-rsssl="1" class="home page-template page-template-template-landing page-template-template-landing-php page page-id-93 theme-onchain woocommerce-js elementor-default elementor-kit-6 elementor-page elementor-page-93 e--ua-blink e--ua-opera e--ua-webkit" data-elementor-device-mode="desktop">
    <main>
    <div class="container">
    <div class="hero__object circle"></div>
<header class="header">
<style>

body{--wp--preset--color--black:#000000;--wp--preset--color--cyan-bluish-gray:#abb8c3;--wp--preset--color--white:#ffffff;--wp--preset--color--pale-pink:#f78da7;--wp--preset--color--vivid-red:#cf2e2e;--wp--preset--color--luminous-vivid-orange:#ff6900;--wp--preset--color--luminous-vivid-amber:#fcb900;--wp--preset--color--light-green-cyan:#7bdcb5;--wp--preset--color--vivid-green-cyan:#00d084;--wp--preset--color--pale-cyan-blue:#8ed1fc;--wp--preset--color--vivid-cyan-blue:#0693e3;--wp--preset--color--vivid-purple:#9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple:linear-gradient(           135deg,           rgba(6, 147, 227, 1) 0%,           rgb(155, 81, 224) 100%         );--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan:linear-gradient(           135deg,           rgb(122, 220, 180) 0%,           rgb(0, 208, 130) 100%         );--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange:linear-gradient(           135deg,           rgba(252, 185, 0, 1) 0%,           rgba(255, 105, 0, 1) 100%         );--wp--preset--gradient--luminous-vivid-orange-to-vivid-red:linear-gradient(           135deg,           rgba(255, 105, 0, 1) 0%,           rgb(207, 46, 46) 100%         );--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray:linear-gradient(           135deg,           rgb(238, 238, 238) 0%,           rgb(169, 184, 195) 100%         );--wp--preset--gradient--cool-to-warm-spectrum:linear-gradient(           135deg,           rgb(74, 234, 220) 0%,           rgb(151, 120, 209) 20%,           rgb(207, 42, 186) 40%,           rgb(238, 44, 130) 60%,           rgb(251, 105, 98) 80%,           rgb(254, 248, 76) 100%         );--wp--preset--gradient--blush-light-purple:linear-gradient(           135deg,           rgb(255, 206, 236) 0%,           rgb(152, 150, 240) 100%         );--wp--preset--gradient--blush-bordeaux:linear-gradient(           135deg,           rgb(254, 205, 165) 0%,           rgb(254, 45, 45) 50%,           rgb(107, 0, 62) 100%         );--wp--preset--gradient--luminous-dusk:linear-gradient(           135deg,           rgb(255, 203, 112) 0%,           rgb(199, 81, 192) 50%,           rgb(65, 88, 208) 100%         );--wp--preset--gradient--pale-ocean:linear-gradient(           135deg,           rgb(255, 245, 203) 0%,           rgb(182, 227, 212) 50%,           rgb(51, 167, 181) 100%         );--wp--preset--gradient--electric-grass:linear-gradient(           135deg,           rgb(202, 248, 128) 0%,           rgb(113, 206, 126) 100%         );--wp--preset--gradient--midnight:linear-gradient(           135deg,           rgb(2, 3, 129) 0%,           rgb(40, 116, 252) 100%         );--wp--preset--font-size--small:13px;--wp--preset--font-size--medium:20px;--wp--preset--font-size--large:36px;--wp--preset--font-size--x-large:42px;--wp--preset--spacing--20:0.44rem;--wp--preset--spacing--30:0.67rem;--wp--preset--spacing--40:1rem;--wp--preset--spacing--50:1.5rem;--wp--preset--spacing--60:2.25rem;--wp--preset--spacing--70:3.38rem;--wp--preset--spacing--80:5.06rem;--wp--preset--shadow--natural:6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep:12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp:6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined:6px 6px 0px -3px rgba(255, 255, 255, 1),           6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp:6px 6px 0px rgba(0, 0, 0, 1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}
.plan-content a{display:flex;align-items:center;justify-content:center;border-radius:10px;font-style:normal;font-weight:600;font-size:18px;line-height:22px;color:#FFFFFF;border:none;height:62px;width:154px;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);cursor:pointer;}

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
footer,header,nav{display:block;}
html{-webkit-tap-highlight-color:rgba(0, 0, 0, 0);-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
body,div,span,h2,p,ul,li,a,img,strong,form,label,footer,header,nav{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,input{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
strong{font-weight:bold;}
img{border:0;}
.head .head__subtitle,.head .head__title{opacity:0;}
.animated{animation-name:fadeInUp;-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;}
}

@media all{
html,body{box-sizing:border-box;margin:0;padding:0;width:100vw;background:#06060c;position:relative;max-width:100%;overflow-x:hidden;font-family:"Urbanist", sans-serif;}
*,*:before,*:after{box-sizing:inherit;margin:0;padding:0;color:#fff;list-style-type:none;}
*::placeholder{font-size:16px;}
a,button{font-family:"Urbanist", sans-serif;text-decoration:none;cursor:pointer;}
a{cursor:pointer;}
.container{display:flex;align-items:flex-start;flex-direction:row;flex-wrap:wrap;max-width:1440px;width:100%;margin:0 auto;position:relative;}
@media (max-width: 1480px){
.container{padding:0 20px;}
}
.head{display:flex;flex-direction:column;}
.head__subtitle{margin-bottom:8px;}
.head__subtitle p{font-style:normal;font-weight:700;font-size:18px;line-height:22px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255, 255, 255, 0.64);}
.head__title p{font-weight:700;font-size:48px;line-height:56px;}
.head__title p span{background:-webkit-linear-gradient(57.75deg, #f70fff 14.44%, #2c63ff 85.65%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.circle{width:240px;height:240px;position:absolute;border-radius:50%;background:linear-gradient(57.75deg, #f70fff 14.44%, #2c63ff 85.65%);}
.circle::before{content:"";width:100%;top:initial;bottom:initial;left:initial;right:initial;position:absolute;height:100%;border-radius:50%;background:linear-gradient(57.75deg, #f70fff 14.44%, #2c63ff 85.65%);opacity:0.84;filter:blur(100px);}
.header{width:100%;position:absolute;top:24px;z-index:4;}
.header__row{width:100%;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:24px;height:100px;display:flex;align-items:center;justify-content:space-between;padding:24px;flex-wrap:wrap;transition:all 0.7s ease-out;}
.header__burger{display:flex;align-items:center;justify-content:center;height:32px;width:32px;position:relative;}
.header__burger span{width:100%;height:3px;background:#fff;border-radius:50px;transition:all 0.5s ease-out;}
.header__burger span:before{content:"";position:absolute;transform:translateY(-10px);width:100%;height:3px;background:#fff;border-radius:50px;transition:all 0.5s ease-out;}
.header__burger span:after{content:"";position:absolute;transform:translateY(10px);width:100%;height:3px;background:#fff;border-radius:50px;transition:all 0.5s ease-out;}
.header__menu{display:flex;align-items:center;gap:48px;height:100%;}
.nav__list{display:flex;flex-direction:row;gap:48px;align-items:center;position:relative;}
.current-menu-item{font-weight:900;}
.nav__list .menu-item{position:relative;display:flex;align-items:center;justify-content:center;}
.nav__list .menu-item a:hover{color:#d8d8d8;}
.nav__list .menu-item a{display:flex;align-items:center;justify-content:center;gap:8px;}
.header__divider{height:30px;width:1px;background-color:#7b7474;}
.header__button{background:linear-gradient(57.75deg, #f70fff 14.44%, #2c63ff 85.65%);width:50px;height:50px;position:relative;display:flex;align-items:center;justify-content:center;border-radius:24px;}
.header__button a{display:flex;align-items:center;justify-content:center;text-decoration:none;background:#06060c;width:46px;height:46px;position:absolute;border-radius:24px;border:none;}
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
input{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;font-family:"Urbanist", sans-serif;}
button{display:flex;align-items:center;justify-content:center;border-radius:100px;font-style:normal;font-weight:600;font-size:18px;line-height:22px;color:#ffffff;border:none;height:62px;width:154px;background:linear-gradient(57.75deg, #f70fff 14.44%, #2c63ff 85.65%);cursor:pointer;}
.hero__object{animation:zoom ease-out;animation-delay:0.4s;animation-duration:1.5s;top:-160px;left:260px;z-index:1;}
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
h2{font-size:40px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}
.current_selected{text-decoration:underline;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.container2{display:grid;grid-template-columns:repeat(auto-fit, minmax(350px, 1fr));gap:20px;padding:20px;max-width:1440px;width:100%;margin:70px auto;}
.theplans{display:contents;}
.plan-wrapper{position:relative;display:inline-block;margin:20px;padding:20px;border-radius:10px;}
.plan-wrapper::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;border-radius:10px;background:transparent;z-index:-1;transition:all 0.5s ease-in-out;}
.plan-wrapper:hover::before{animation:spin 2s linear infinite;}
.plan:hover{transform:scale(1.05);}
.plan{padding:24px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);width:400px;position:relative;box-sizing:border-box;z-index:1;display:flex;flex-direction:column;justify-content:space-between;min-height:300px;height:500px;margin-bottom:50px;transition:all 0.3s ease;}
.coder{padding:24px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);width:610px;position:relative;box-sizing:border-box;display:flex;flex-direction:column;justify-content:space-between;min-height:300px;height:100px;margin-bottom:50px;}
.plan-content{display:flex;flex-direction:column;height:100%;}
.plan-description,.plan-info,.plan-button{margin-bottom:15px;}
.plan-description{flex:1;margin-bottom:-100px;}
.plan-info{flex:1;}
.plan-button{margin-top:auto;}
input{transition:border-color 0.3s ease;}
input:hover{border-color:rgba(255, 255, 255, 0.4);}
*,*:before,*:after{box-sizing:border-box;margin:0;padding:0;color:#fff;}
.features__head{margin-top:250px;}
.features__head{width:100%;display:flex;align-items:center;}
.current-plan-header{position:absolute;left:0;width:100%;background-color:white;text-align:center;font-weight:bold;color:black;padding:5px;box-sizing:border-box;}
.space{padding:25px;}
.spaceb{padding:10px;}
.buy-button{background-color:#007BFF;color:white;border:none;border-radius:10px;padding:10px 20px;cursor:pointer;font-size:16px;transition:background-color 0.3s ease;}
.buy-button:hover{background-color:#0056b3;}

.particles{position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:hidden;z-index:-1;}
.particle{position:absolute;width:8px;height:8px;border-radius:50%;opacity:0;pointer-events:none;background-color:transparent;animation:blink-fall 5s linear infinite;}

@-webkit-keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0, 100%, 0);transform:translate3d(0, 100%, 0);}to{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}}
@keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0, 100%, 0);transform:translate3d(0, 100%, 0);}to{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}}
@keyframes zoom{0%{width:40px;height:40px;top:50px;left:20px;}100%{width:240px;height:240px;top:-160px;left:260px;}}
@keyframes spin{100%{transform:rotate(360deg);}}
@keyframes blink-fall{0%{opacity:1;transform:translateY(-100px);}50%{opacity:0.5;transform:translateY(50%);}100%{opacity:0;transform:translateY(100%);}}

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
                                <a class="current_selected current-menu-item" href="">SHOP</a>
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
                          <div class="features__head head">
                              <div class="head__subtitle animated">
                                <p>Welcome to</p>
                              </div>
                              <div class="head__title animated">
                                <center><p>The <span>SHOP</span></p></center>
                                <br></br>
                              </div>
                              <div class="">
                              <?php
include("../componements/php/database_conn.php");

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

function parseDuration($duration) {
    $dateInterval = new DateInterval('P0D');
    
    $duration = trim($duration);
    if (preg_match('/(\d+)\s*(mi|ho|da|mo|ye)/', $duration, $matches)) {
        $value = intval($matches[1]);
        $unit = $matches[2];

        switch ($unit) {
            case 'mi':
                $dateInterval = new DateInterval('PT' . $value . 'M');
                break;
            case 'ho':
                $dateInterval = new DateInterval('PT' . $value . 'H');
                break;
            case 'da':
                $dateInterval = new DateInterval('P' . $value . 'D');
                break;
            case 'mo':
                $dateInterval = new DateInterval('P' . $value . 'M');
                break;
            case 'ye':
                $dateInterval = new DateInterval('P' . $value . 'Y');
                break;
        }
    }

    return $dateInterval;
}

$success_message = "";
$error_message = "";

if (isset($_POST['code']) && isset($_COOKIE['LS_ASP'])) {
    $code = $_POST['code'];
    $token = $_COOKIE['LS_ASP'];
    $user_id = getUserId($conn, $token);

    if ($user_id) {
        $stmt = $conn->prepare("SELECT redeemed, plan, duration FROM plan_codes WHERE code = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $stmt->bind_result($redeemed, $plan, $duration);
        $stmt->fetch();
        $stmt->close();

        if ($redeemed === 0) {
            $redeem_time = new DateTime();
            $interval = parseDuration($duration);
            $expire_time = $redeem_time->add($interval)->format('Y-m-d H:i:s');

            $stmt = $conn->prepare("UPDATE plan_codes SET redeemed = 1, user_id = ?, redeem_time = ? WHERE code = ?");
            $stmt->bind_param("iss", $user_id, $redeem_time->format('Y-m-d H:i:s'), $code);
            if ($stmt->execute()) {
                $stmt->close();

                $stmt = $conn->prepare("UPDATE users SET plan = ?, plan_expire = ? WHERE id = ?");
                $stmt->bind_param("ssi", $plan, $expire_time, $user_id);
                if ($stmt->execute()) {
                    $success_message = "<p style='color:green;'>That was a success, enjoy your new plan!</p>";
                } else {
                    $error_message = "<p style='color:red;'>Error updating user plan: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                $error_message = "<p style='color:red;'>Error redeeming code: " . $stmt->error . "</p>";
            }
        } else {
            $error_message = "<p style='color:orange;'>Invalid Code.</p>";
        }
    } else {
        $error_message = "<p style='color:red;'>Invalid user.</p>";
    }
}
if (isset($_COOKIE['LS_ASP'])) {
  $token = $_COOKIE['LS_ASP'];
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

  $show_warning = !empty($user_data['plan_expire']);
} else {
  $show_warning = false;
}

$conn->close();
?>
<form id="redeemForm" method="post" action="./">
    <center>
        <div class="coder">
            <label for="code">Redeem a code</label>
            <?php if ($show_warning): ?>
              <p style="color:red">WARNING! Redeeming a new code will replace your current active subscription.</p>
            <?php endif; ?>
            <input type="text" placeholder="XXXXX-XXXXX-XXXXX-XXXXX" id="code" name="code" required>
            <div id="message">
              <?php
              if ($success_message) {
                  echo "<center>$success_message</center>";
              } elseif ($error_message) {
                  echo "<center>$error_message</center>";
              }
              ?>
          </div>
            <center>
                <button class="buy-button" type="submit">Redeem</button>
            </center>
        </div>
    </center>
</form>
<div class="container2">
                            <div class="theplans">
                            <?php foreach ($plan_styles as $plan_name => $style): ?>
<div class="plan-wrapper">
    <div class="plan">
        <?php if ($plan_name === $current_plan): ?>
            <div class="current-plan-header">
                <p style="color:black"><strong style="color:black">Current Plan</strong></p>
            </div>
            <div class="space"></div>
        <?php endif; ?>
        <div class="plan-content">
            <center>
                <h2 style="<?php echo $plan_styles[$plan_name]['style']; ?>">
                    <?php echo ucfirst($plan_name); ?>
                    <div class="spaceb"></div>
                </h2>
            </center>
            <div class="plan-description">
                <p><?php echo $descriptions[$plan_name]; ?></p>
            </div>
            <div class="plan-info">
                <p><strong>Price:</strong> <?php echo $mprices[$plan_name]; ?></p>
                <p><strong>Concurents:</strong> <?php echo $stats[$plan_name]['Concurents']; ?></p>
                <p><strong>Max Time:</strong> <?php echo $stats[$plan_name]['Max Time']; ?> seconds</p>
                <p><strong>Methods:</strong> <?php echo $stats[$plan_name]['Methods']; ?></p>
                <p><strong>Daily Attacks Limit:</strong> <?php echo $stats[$plan_name]['Daily Attacks Limit']; ?></p>
            </div>
            <?php if ($plan_name === $current_plan): ?>
                <div class="plan-button">
                    <center><button class="buy-button" style="cursor: not-allowed">Owned</button></center>
                </div>
            <?php elseif ($plan_name === "free"): ?>
            <?php else: ?>
              <center>
              <a href="<?php echo $links[$plan_name]; ?>" class="buy-button" data-plan="<?php echo $plan_name; ?>" data-price="<?php echo $mprices[$plan_name]; ?>">
                Buy for <?php echo $mprices[$plan_name]; ?>
            </a>
            </center>
            <?php endif; ?>
            <div class="particles" data-color="<?php echo $plan_styles[$plan_name]['particleColor']; ?>"></div>
        </div>
    </div>
</div>

<?php endforeach; ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    function createParticleEffect(container, color) {
        const numParticles = 30; // 20 PARTICULES C'EST MIEUX C PLUS OPTI PLUS FLUIDE ET C'EST JOLI
        const containerWidth = container.offsetWidth;
        const containerHeight = container.offsetHeight;

        for (let i = 0; i < numParticles; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.backgroundColor = color;
            particle.style.left = Math.random() * containerWidth + 'px';
            particle.style.top = Math.random() * containerHeight + 'px';

            container.appendChild(particle);
            const animationDelay = Math.random() * 5;
            particle.style.animationDelay = `-${animationDelay}s`;
        }
    }

    document.querySelectorAll('.particles').forEach(particlesContainer => {
        const color = particlesContainer.getAttribute('data-color');
        if (color) {
            createParticleEffect(particlesContainer, color);
        }
    });
});
            </script>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

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