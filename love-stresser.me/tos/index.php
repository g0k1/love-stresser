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
if (isset($_COOKIE['LS_ASP'])) {
    $token = $_COOKIE['LS_ASP'];
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

} else {
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
<!DOCTYPE html>
<html class="no-js" lang="en-US">
  <head>
    <meta charset="UTF-8" />
    <script>console.log = function(){ };</script>
    <title>Love Stresser - TOS</title>
    <meta name="robots" content="max-image-preview:large" />
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
    <style>
body{--wp--preset--color--black:#000000;--wp--preset--color--cyan-bluish-gray:#abb8c3;--wp--preset--color--white:#ffffff;--wp--preset--color--pale-pink:#f78da7;--wp--preset--color--vivid-red:#cf2e2e;--wp--preset--color--luminous-vivid-orange:#ff6900;--wp--preset--color--luminous-vivid-amber:#fcb900;--wp--preset--color--light-green-cyan:#7bdcb5;--wp--preset--color--vivid-green-cyan:#00d084;--wp--preset--color--pale-cyan-blue:#8ed1fc;--wp--preset--color--vivid-cyan-blue:#0693e3;--wp--preset--color--vivid-purple:#9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple:linear-gradient(           135deg,           rgba(6, 147, 227, 1) 0%,           rgb(155, 81, 224) 100%         );--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan:linear-gradient(           135deg,           rgb(122, 220, 180) 0%,           rgb(0, 208, 130) 100%         );--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange:linear-gradient(           135deg,           rgba(252, 185, 0, 1) 0%,           rgba(255, 105, 0, 1) 100%         );--wp--preset--gradient--luminous-vivid-orange-to-vivid-red:linear-gradient(           135deg,           rgba(255, 105, 0, 1) 0%,           rgb(207, 46, 46) 100%         );--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray:linear-gradient(           135deg,           rgb(238, 238, 238) 0%,           rgb(169, 184, 195) 100%         );--wp--preset--gradient--cool-to-warm-spectrum:linear-gradient(           135deg,           rgb(74, 234, 220) 0%,           rgb(151, 120, 209) 20%,           rgb(207, 42, 186) 40%,           rgb(238, 44, 130) 60%,           rgb(251, 105, 98) 80%,           rgb(254, 248, 76) 100%         );--wp--preset--gradient--blush-light-purple:linear-gradient(           135deg,           rgb(255, 206, 236) 0%,           rgb(152, 150, 240) 100%         );--wp--preset--gradient--blush-bordeaux:linear-gradient(           135deg,           rgb(254, 205, 165) 0%,           rgb(254, 45, 45) 50%,           rgb(107, 0, 62) 100%         );--wp--preset--gradient--luminous-dusk:linear-gradient(           135deg,           rgb(255, 203, 112) 0%,           rgb(199, 81, 192) 50%,           rgb(65, 88, 208) 100%         );--wp--preset--gradient--pale-ocean:linear-gradient(           135deg,           rgb(255, 245, 203) 0%,           rgb(182, 227, 212) 50%,           rgb(51, 167, 181) 100%         );--wp--preset--gradient--electric-grass:linear-gradient(           135deg,           rgb(202, 248, 128) 0%,           rgb(113, 206, 126) 100%         );--wp--preset--gradient--midnight:linear-gradient(           135deg,           rgb(2, 3, 129) 0%,           rgb(40, 116, 252) 100%         );--wp--preset--font-size--small:13px;--wp--preset--font-size--medium:20px;--wp--preset--font-size--large:36px;--wp--preset--font-size--x-large:42px;--wp--preset--spacing--20:0.44rem;--wp--preset--spacing--30:0.67rem;--wp--preset--spacing--40:1rem;--wp--preset--spacing--50:1.5rem;--wp--preset--spacing--60:2.25rem;--wp--preset--spacing--70:3.38rem;--wp--preset--spacing--80:5.06rem;--wp--preset--shadow--natural:6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep:12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp:6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined:6px 6px 0px -3px rgba(255, 255, 255, 1),           6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp:6px 6px 0px rgba(0, 0, 0, 1);}
.header__button{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);width:204px;height:50px;position:relative;display:flex;align-items:center;justify-content:center;border-radius:24px;}
.header__button a{display:flex;align-items:center;justify-content:center;text-decoration:none;background:#06060C;width:200px;height:46px;position:absolute;border-radius:24px;border:none;}
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
body,div,span,p,ul,li,a,img,footer,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
.story img{max-width:100%;height:auto;}
.head .head__subtitle,.head .head__title,.head .head__description{opacity:0;}
.roadmap__image{min-width:395px;min-height:395px;}
.roadmap__image .roadmap__object{animation:circlethree 12s ease-in-out infinite;}
.roadmap__image img{position:absolute;animation:circletwo 17s ease-in-out infinite;}
}

@media all{
html,body{box-sizing:border-box;margin:0;padding:0;width:100vw;background:#06060c;position:relative;max-width:100%;overflow-x:hidden;font-family:"Urbanist", sans-serif;}
*,*:before,*:after{box-sizing:inherit;margin:0;padding:0;color:#fff;list-style-type:none;}
*::placeholder{font-size:16px;}
a{font-family:"Urbanist", sans-serif;text-decoration:none;cursor:pointer;}
a{cursor:pointer;}
.container{display:flex;align-items:flex-start;flex-direction:row;flex-wrap:wrap;max-width:1440px;width:100%;height:100%;margin:0 auto;position:relative;}
@media (max-width: 1480px){
.container{padding:0 20px;}
}
.head{display:flex;flex-direction:column;}
.head__subtitle{margin-bottom:8px;}
.head__subtitle p{font-style:normal;font-weight:700;font-size:18px;line-height:22px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255, 255, 255, 0.64);}
.head__title p{font-weight:700;font-size:48px;line-height:56px;}
.head__title p span{background:-webkit-linear-gradient(57.75deg, #f70fff 14.44%, #2c63ff 85.65%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.head__description{margin-top:24px;}
.head__description p{font-style:normal;font-weight:600;font-size:16px;line-height:24px;color:rgba(255, 255, 255, 0.8);}
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
.nav__list .menu-item{position:relative;display:flex;align-items:center;justify-content:center;}
.nav__list .menu-item a:hover{color:#d8d8d8;}
.nav__list .menu-item a{display:flex;align-items:center;justify-content:center;gap:8px;}
.header__divider{height:30px;width:1px;background-color:#7b7474;}
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
.team{margin-bottom:100px;}
.team__wrapper{width:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:48px;}
.team__head{display:flex;align-items:center;width:100%;}
.team__list{display:grid;width:100%;gap:24px;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));}
.person{display:flex;align-items:center;justify-content:space-between;flex-direction:column;flex-grow:1;border-radius:24px;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);}
.person__image{border-radius:24px;width:100%;position:relative;padding:0 0 100% 0;}
.person__image img{position:absolute;object-fit:cover;left:0;top:0;width:100%;border-radius:24px;}
.person__tag{position:absolute;top:16px;left:16px;align-items:center;justify-content:flex-start;gap:16px;font-weight:600;font-size:16px;line-height:19px;}
.person__tag p{padding:8px 16px;background-color:#2c63ff;border-radius:50px;}
.person__info{display:flex;align-items:center;flex-direction:column;width:100%;padding:24px;gap:16px;}
.person__name{width:100%;text-align:center;}
.person__name p{text-align:center;font-style:normal;font-weight:700;font-size:18px;line-height:24px;}
.person__desctiption{width:100%;text-align:center;}
.person__desctiption p{height:48px;text-align:center;font-style:normal;font-weight:500;font-size:18px;line-height:24px;text-overflow:ellipsis;overflow:hidden;color:rgba(255, 255, 255, 0.64);}
.roadmap{margin-bottom:100px;}
.roadmap__wrapper{display:flex;flex-direction:column;width:100%;}
.roadmap__header{display:flex;width:100%;justify-content:space-between;flex-wrap:wrap;}
.roadmap__image{position:absolute;width:min-content;right:0;}
.roadmap__image img{position:relative;z-index:2;max-width:unset!important;}
.roadmap__object{bottom:0;right:0;}
.roadmap__head{display:flex;width:100%;margin-bottom:30px;position:relative;z-index:3;}
.roadmap__list{display:flex;width:100%;flex-direction:column;gap:24px;position:relative;z-index:3;}
.roadmap__row{display:flex;align-items:center;justify-content:center;width:100%;flex-wrap:wrap;padding:10px 40px;min-height:270px;}
.roadmap__col{display:flex;height:100%;width:50%;min-width:500px;gap:24px;}
.roadmap__top-left{display:flex;align-items:flex-start;justify-content:flex-start;}
.roadmap__top-right{display:flex;align-items:flex-start;justify-content:flex-end;}
.roadmap__bottom-left{display:flex;align-items:flex-end;justify-content:flex-start;}
.roadmap__bottom-right{display:flex;align-items:flex-end;justify-content:flex-end;}
.roadmap__center{display:flex;align-items:center;justify-content:center;}
.road-item{display:flex;align-items:center;justify-content:center;max-width:580px;position:relative;width:100%;gap:32px;flex-wrap:wrap;}
.road-item__circle{display:flex;align-items:center;justify-content:center;flex-direction:column;border-radius:50%;width:184px;height:184px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.02);box-shadow:none;backdrop-filter:blur(12px);position:relative;gap:8px;}
.road-item__circle-active{background:rgba(255, 255, 255, 0.02);border:1px solid rgba(44, 99, 255, 0.24);box-shadow:inset 0 0 32px rgba(44, 99, 255, 0.84);}
.road-item__circle-active .road-item__quart p{color:#2c63ff;}
.road-item__circle-active::before{content:"";width:inherit;height:inherit;position:absolute;left:calc(50% - 184px / 2 + 70px);top:calc(50% - 184px / 2);background:#2c63ff;opacity:0.64;filter:blur(74px);}
.road-item__quart p{font-style:normal;font-weight:700;font-size:32px;line-height:40px;}
.road-item__content{display:flex;flex-direction:column;flex:1 1;padding:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:24px;gap:8px;min-width:260px;}
.road-item__title p{font-style:normal;font-weight:700;font-size:24px;line-height:32px;}
.road-item__description{font-style:normal;font-weight:500;font-size:16px;line-height:24px;color:rgba(255, 255, 255, 0.8);}
@media (max-width: 1200px){
.roadmap__row{height:auto;gap:24px;}
.roadmap__col{width:100%;}
}
@media (max-width: 768px){
.roadmap__head{margin-bottom:250px;}
.roadmap__image{left:0;margin:auto;top:150px;}
.road-item{min-width:300px;}
.roadmap__col{min-width:300px;}
}
.footer{margin:140px 0 100px 0;}
.footer__wrapper{display:flex;flex-direction:column;padding:48px;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:24px;gap:48px;width:100%;}
.copyright{display:flex;align-items:center;justify-content:space-between;width:100%;flex-wrap:wrap-reverse;gap:24px;}
.copyright__nav{display:flex;align-items:center;gap:48px;}
.copyright__nav a{font-style:normal;font-weight:600;font-size:16px;line-height:19px;}
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

body{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:none;font-weight:500;line-height:26px;background-color:#06060c;background-repeat:repeat;background-position:top center;background-attachment:scroll;background-size:cover;}
.header__button_a{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);width:50px;height:50px;position:relative;display:flex;align-items:center;justify-content:center;border-radius:24px;}
.header__button_a a{display:flex;align-items:center;justify-content:center;text-decoration:none;background:#06060C;width:46px;height:46px;position:absolute;border-radius:24px;border:none;}
.header__button_a img{width:100%;height:100%;border-radius:50%;object-fit:cover;}
.dropdown-menu{display:none;position:absolute;top:100%;margin-top:10px;right:0;width:120px;border:1px solid rgba(255, 255, 255, 0.08);background:rgb(11 11 17);backdrop-filter:blur(12px);border-radius:12px;padding:12px;box-shadow:0 4px 6px rgba(0, 0, 0, 0.1);margin-left:91.6%;}
.dropdown-menu a{display:block;padding:8px 12px;color:#fff;text-align:center;border-radius:10px;text-decoration:none;}
.dropdown-menu a:hover{background:rgba(255, 255, 255, 0.1);}
.dropdown-separator{border-top:1px solid #ddd;margin:5px auto;width:60px;}

@keyframes circlethree{0%{transform:rotate(0deg) translateX(19px) rotate(0deg);}100%{transform:rotate(360deg) translateX(19px) rotate(-360deg);}}
@keyframes circletwo{0%{transform:rotate(0deg) translateX(22px) rotate(0deg);}100%{transform:rotate(360deg) translateX(22px) rotate(-360deg);}}

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
  </head>
  <body
    data-rsssl="1"
    class="home page-template page-template-template-landing page-template-template-landing-php page page-id-93 theme-onchain woocommerce-js elementor-default elementor-kit-6 elementor-page elementor-page-93"
  >
    <main>
    <?php if (!isset($_COOKIE['LS_ASP']) || empty($_COOKIE['LS_ASP'])): ?>
    <header class="header">
        <div class="container">
          <div id="header__row" class="header__row">
            <a href="https://<?php echo $root_domain ?>/" class="header__logo">
              <img src="./images/logo.png" alt="logo" />
            </a>
            <div id="header__burger" class="header__burger">
              <span></span>
            </div>
            <div id="header__menu" class="header__menu">
              <center>
                <nav class="header__nav nav">
                  <ul id="menu-header-menu" class="menu nav__list">
                    <li id="menu-item-99" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107">
                      <a href="../home">HOME</a>
                    </li>
                    <li id="menu-item-107" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-93 current_page_item menu-item-99">
                      <a class="current_selected current-menu-item" href="../tos">TOS</a>
                    </li>
                    <li id="menu-item-107" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107">
                      <a href="<?php echo $server_full_link ?>">DISCORD</a>
                    </li>
                  </ul>
                </nav>
              </center>
              <span class="header__divider"></span>
              <div class="header__button">
                <a href="../authentication/authorization.php"
                  >Login</a
                >
              </div>
            </div>
          </div>
        </div>
      </header>
    <?php else: ?>
    <header class="header">
        <div class="container">
          <div id="header__row" class="header__row">
            <a href="https://<?php echo $root_domain ?>/" class="header__logo">
              <img src="./images/logo.png" alt="logo" />
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
              <div class="header__button_a">
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
            </div>
          </div>
        </div>
      </header>
    <?php endif; ?>
      <section
        class="story post-93 page type-page status-publish hentry"
        id="post-93"
        data-post-id="93"
      >
        <div
          data-elementor-type="wp-page"
          data-elementor-id="93"
          class="elementor elementor-93"
        >
          <section
            class="elementor-section elementor-top-section elementor-element elementor-element-823b18a elementor-section-full_width elementor-section-height-default elementor-section-height-default"
            data-id="823b18a"
            data-element_type="section"
          >
            <div class="elementor-container elementor-column-gap-default">
              <div
                class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4e43c55"
                data-id="4e43c55"
                data-element_type="column"
              >
                <div class="elementor-widget-wrap elementor-element-populated">
                  <div
                    class="elementor-element elementor-element-0e679ca elementor-widget elementor-widget-onchain_hero"
                    data-id="0e679ca"
                    data-element_type="widget"
                    data-widget_type="onchain_hero.default"
                  >
                  <div
                    class="elementor-element elementor-element-d273a56 elementor-widget elementor-widget-onchain_shop"
                    data-id="d273a56"
                    data-element_type="widget"
                    data-widget_type="onchain_shop.default"
                  >
                  </div>
                  <div
                    class="elementor-element elementor-element-892bd52 elementor-widget elementor-widget-onchain_blog"
                    data-id="892bd52"
                    data-element_type="widget"
                    data-widget_type="onchain_blog.default"
                  >
                  </div>
                  <div
                    class="elementor-element elementor-element-6b6a065 elementor-widget elementor-widget-onchain_about"
                    data-id="6b6a065"
                    data-element_type="widget"
                    data-widget_type="onchain_about.default"
                  >
                  </div>
                 
                 
                 
                  <div class="elementor-widget-container">
  <section class="roadmap">
    <div class="container">
      <div class="roadmap__wrapper">
        <div class="roadmap__header">
          <div class="roadmap__head head">
            <div class="head__subtitle">
              <p>OUR ROADMAP</p>
            </div>
            <div class="head__title">
              <p>
                Onchain Strategy
                <span>&amp; Project Plan</span>
              </p>
            </div>
            <div class="head__description">
              <p>
                Our Path to Success in the Crypto and NFT Markets includes Innovative Solutions for the Emerging Crypto and NFT Landscape
              </p>
            </div>
          </div>
          <div class="roadmap__image">
            <img decoding="async" src="images/rocket.png" alt="Onchain Strategy <span>&amp; Project Plan</span>" />
            <div class="roadmap__object circle"></div>
          </div>
        </div>
        <div class="roadmap__list">
          <div class="roadmap__row">
            <div class="roadmap__col roadmap__center">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-1</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>No Refunds</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      All transactions and payments made for DDoS plans provided by "LoveStresser" are non-refundable. By using our services, you agree that no refunds will be given for any reason, except in the event that our service is unavailable for more than 7 days.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="roadmap__row">
            <div class="roadmap__col roadmap__top-left">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-2</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>Non-responsibility for Acts</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      "LoveStresser" cannot be held responsible for actions taken by users in the context of attacks carried out by them. Users assume full responsibility for their actions and their consequences. Any actual activity using these concepts is prohibited and illegal.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="roadmap__col roadmap__bottom-right">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-3</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>Code Protection Policy</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      Copying, reproducing, or using "LoveStresser"'s HTML, JS code, etc., without permission from the founders is strictly prohibited. Any violation of this clause will result in consequences.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="roadmap__row">
            <div class="roadmap__col roadmap__center">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-4</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>LoveStresser Name/Image Usage Policy</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      The use of the name or image of LoveStresser is strictly prohibited without authorization from the founders. Any unauthorized use will result in appropriate legal action.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="roadmap__row">
            <div class="roadmap__col roadmap__bottom-left">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-5</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>Non-Attack Policy</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      It is strictly prohibited to use the stresser service to launch attacks against the team or infrastructure associated with the service itself.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="roadmap__col roadmap__top-right">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-6</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>Prohibition of Requesting Ranks</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      Users are strictly prohibited from soliciting or requesting special privileges, including ranks or additional access, within LoveStresser.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="roadmap__row">
            <div class="roadmap__col roadmap__center">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-7</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>Compliance with Rules and Terms of Service</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      Users are required to adhere to LoveStresser's rules and terms of service at all times. Failure to comply with these rules may result in account termination and other appropriate actions.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="roadmap__col roadmap__top-right">
              <div class="roadmap__item road-item">
                <div class="road-item__circle road-item__circle-active">
                  <div class="road-item__quart">
                    <p>N-8</p>
                  </div>
                  <div class="road-item__year"></div>
                </div>
                <div class="road-item__content">
                  <div class="road-item__title">
                    <p>Service Usage Policy</p>
                  </div>
                  <div class="road-item__description">
                    <p>
                      The attacking service provided by "LoveStresser" is to be used only with explicit consent from the target. The goal should be to test the network stability and security of the consenting party. Unauthorized use against any entity that has not given consent is strictly prohibited and will be considered a violation of our terms of service.
                    </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

                 
                 
                 
                 
                 
                 
                 
                  <div
                    class="elementor-element elementor-element-0ecc368 elementor-widget elementor-widget-onchain_team"
                    data-id="0ecc368"
                    data-element_type="widget"
                    data-widget_type="onchain_team.default"
                  >
                    <div class="elementor-widget-container">
                      <section class="team">
                        <div class="container">
                          <div class="team__wrapper">
                            <div class="team__head head">
                              <div class="head__subtitle">
                                <p>OUR TEAM</p>
                              </div>
                              <div class="head__title">
                                <p>Meet the most promising <span>Team</span></p>
                              </div>
                              <div class="head__description">
                                <p>
                                  Meet our awesome team who are standing behind
                                  all of this magic.
                                </p>
                              </div>
                            </div>
                            <div class="team__list">
                              <div class="team__item person">
                                <div class="person__image">
                                  <img
                                    decoding="async"
                                    src="https://cdn.discordapp.com/avatars/1257787373928976444/b7d7bbdd123d0b2e8a13c2e20c0876ba.webp?size=1024&format=webp&width=0&height=256"
                                    alt="Meandoyou"
                                  />
                                  <div class="person__tag">
                                    <p>Founder</p>
                                  </div>
                                </div>
                                <div class="person__info">
                                  <div class="person__name">
                                    <p>Meandoyou</p>
                                  </div>
                                  <div class="person__desctiption">
                                    
                                    <p>
                                      Owner of LoveStresser 
                                    </p>
                                    
                                  </div>
                                </div>
                              </div>
                              <div class="team__item person">
                                <div class="person__image">
                                  <img
                                    decoding="async"
                                    src="https://cdn.discordapp.com/avatars/804987124234977311/7c2a86688c80634819c66f52525ab003.webp?size=1024&format=webp&width=0&height=256"
                                    alt="StingAving"
                                  />
                                  <div class="person__tag">
                                    <p>Founder</p>
                                  </div>
                                </div>
                                <div class="person__info">
                                  <div class="person__name">
                                    <p>StingAving</p>
                                  </div>
                                  <div class="person__desctiption">
                                    
                                    <p>
                                      Owner of LoveStresser 
                                    </p>
                                    
                                  </div>
                                 
                                  

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                  <div
                    class="elementor-element elementor-element-b0cf7e0 elementor-widget elementor-widget-onchain_logos"
                    data-id="b0cf7e0"
                    data-element_type="widget"
                    data-widget_type="onchain_logos.default"
                  >
                  </div>

                  <div
                    class="elementor-element elementor-element-5f7ec8e elementor-widget elementor-widget-onchain_roadmap"
                    data-id="5f7ec8e"
                    data-element_type="widget"
                    data-widget_type="onchain_roadmap.default"
                  >
                    
                  </div>
                  <div
                    class="elementor-element elementor-element-c3aca87 elementor-widget elementor-widget-onchain_banner"
                    data-id="c3aca87"
                    data-element_type="widget"
                    data-widget_type="onchain_banner.default"
                  >
                  </div>
                  <div
                    class="elementor-element elementor-element-d59f3e3 elementor-widget elementor-widget-onchain_faq"
                    data-id="d59f3e3"
                    data-element_type="widget"
                    data-widget_type="onchain_faq.default"
                  >
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
          ajaxurl: "https:\/\/alethemes.com\/onchain\/wp-admin\/admin-ajax.php",
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
    <script
      src="js/order-attribution.min.js"
      id="wc-order-attribution-js"
    ></script>
    <script src="js/imagesloaded.min.js" id="imagesloaded-js"></script>
    <script src="js/masonry.min.js" id="masonry-js"></script>
    <script src="js/jquery.appear.js" id="jquery-appear-js"></script>
    <script src="js/scripts.min.js" id="onchain-scripts-js"></script>
    <script id="ale-load-more-js-extra">
      var aleloadmore = {
        nonce: "87bf26812e",
        url: "https:\/\/alethemes.com\/onchain\/wp-admin\/admin-ajax.php",
        button_text: "explore more",
        maxpage: "0",
        query: [],
      };
    </script>
    <script src="js/load-more.js" id="ale-load-more-js"></script>
    <script defer="" src="js/forms.js" id="mc4wp-forms-api-js"></script>
    <script
      src="js/webpack.runtime.min.js"
      id="elementor-webpack-runtime-js"
    ></script>
    <script
      src="js/frontend-modules.min.js"
      id="elementor-frontend-modules-js"
    ></script>
    <script src="js/waypoints.min.js" id="elementor-waypoints-js"></script>
    <script src="js/core.min.js" id="jquery-ui-core-js"></script>
    <script id="elementor-frontend-js-before">
      var elementorFrontendConfig = {
        environmentMode: {
          edit: false,
          wpPreview: false,
          isScriptDebug: false,
        },
        i18n: {
          shareOnFacebook: "Share on Facebook",
          shareOnTwitter: "Share on Twitter",
          pinIt: "Pin it",
          download: "Download",
          downloadImage: "Download image",
          fullscreen: "Fullscreen",
          zoom: "Zoom",
          share: "Share",
          playVideo: "Play Video",
          previous: "Previous",
          next: "Next",
          close: "Close",
          a11yCarouselWrapperAriaLabel:
            "Carousel | Horizontal scrolling: Arrow Left & Right",
          a11yCarouselPrevSlideMessage: "Previous slide",
          a11yCarouselNextSlideMessage: "Next slide",
          a11yCarouselFirstSlideMessage: "This is the first slide",
          a11yCarouselLastSlideMessage: "This is the last slide",
          a11yCarouselPaginationBulletMessage: "Go to slide",
        },
        is_rtl: false,
        breakpoints: { xs: 0, sm: 480, md: 768, lg: 1025, xl: 1440, xxl: 1600 },
        responsive: {
          breakpoints: {
            mobile: {
              label: "Mobile Portrait",
              value: 767,
              default_value: 767,
              direction: "max",
              is_enabled: true,
            },
            mobile_extra: {
              label: "Mobile Landscape",
              value: 880,
              default_value: 880,
              direction: "max",
              is_enabled: false,
            },
            tablet: {
              label: "Tablet Portrait",
              value: 1024,
              default_value: 1024,
              direction: "max",
              is_enabled: true,
            },
            tablet_extra: {
              label: "Tablet Landscape",
              value: 1200,
              default_value: 1200,
              direction: "max",
              is_enabled: false,
            },
            laptop: {
              label: "Laptop",
              value: 1366,
              default_value: 1366,
              direction: "max",
              is_enabled: false,
            },
            widescreen: {
              label: "Widescreen",
              value: 2400,
              default_value: 2400,
              direction: "min",
              is_enabled: false,
            },
          },
        },
        version: "3.20.2",
        is_static: false,
        experimentalFeatures: {
          e_optimized_assets_loading: true,
          e_optimized_css_loading: true,
          additional_custom_breakpoints: true,
          e_swiper_latest: true,
          block_editor_assets_optimize: true,
          "ai-layout": true,
          "landing-pages": true,
          e_image_loading_optimization: true,
        },
        urls: {
          assets:
            "https:\/\/alethemes.com\/onchain\/wp-content\/plugins\/elementor\/assets\/",
        },
        swiperClass: "swiper",
        settings: { page: [], editorPreferences: [] },
        kit: {
          active_breakpoints: ["viewport_mobile", "viewport_tablet"],
          global_image_lightbox: "yes",
          lightbox_enable_counter: "yes",
          lightbox_enable_fullscreen: "yes",
          lightbox_enable_zoom: "yes",
          lightbox_enable_share: "yes",
          lightbox_title_src: "title",
          lightbox_description_src: "description",
        },
        post: {
          id: 93,
          title: "Onchain%20%E2%80%93%20Crypto%20Theme",
          excerpt: "",
          featuredImage: false,
        },
      };
    </script>
    <script src="js/frontend.min.js" id="elementor-frontend-js"></script>
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
  </body>
</html>
