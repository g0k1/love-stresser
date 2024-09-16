<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
include("../componements/php/discord_server.php");
function isMobileDevice() {
    return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $_SERVER['HTTP_USER_AGENT']);
}

if (isMobileDevice()) {
    header("Location: ../invalid");
    exit();
}

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
include("../componements/php/root_domain.php");
$total_attacks = 0;
$users_number = 0;

if (isset($_COOKIE['LS_ASP']) && !empty($_COOKIE['LS_ASP'])) {
    header("Location: ../hub");
    exit();
} else {
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
}
?>
<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v9/invites/$serverInviteCode?with_counts=true&with_expiration=true");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$memberCount = isset($data['approximate_member_count']) ? $data['approximate_member_count'] : "Error !";
?>
<!DOCTYPE html>
<html class="no-js" lang="en-US">
  <head>
  <script>console.log = function(){ };</script>
    <meta charset="UTF-8"/>
    <title>Love Stresser - Home</title>
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
    <meta property="og:title" content="Love Stresser - The best website for DDoS." />
    <meta property="og:description" content="Love Stresser is a DDoS platform for L4 and L7 attacks, we're offering you the best power at affordable prices." />
    <meta property="og:url" content="https://<?php echo $root_domain ?>/" />
    <meta property="og:type" content="website" />
  </head>
  <style>
@media all{
article,footer,header,nav,section{display:block;}
html{-webkit-tap-highlight-color:rgba(0, 0, 0, 0);-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
body,div,span,h1,p,ul,li,a,img,label,article,footer,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,input{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
img{border:0;}
.story h1{font-size:50px;}
.story h1{text-transform:none;margin-bottom:20px;}
.story a{color:inherit;}
.story a:link,.story a:visited,.story a:hover,.story a:active{text-decoration:none;}
.story img{max-width:100%;height:auto;}
.head .head__subtitle,.head .head__title,.head .head__description,.hero__title,.hero__subtitle,.hero__buttons{opacity:0;}
.animated{animation-name:fadeInUp;-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;}
}

@media all{
html,body{box-sizing:border-box;margin:0;padding:0;width:100vw;background:#06060C;position:relative;max-width:100%;overflow-x:hidden;font-family:'Urbanist', sans-serif;}
*,*:before,*:after{box-sizing:inherit;margin:0;padding:0;color:#fff;list-style-type:none;}
*::placeholder{font-size:16px;}
a{font-family:'Urbanist', sans-serif;text-decoration:none;cursor:pointer;}
a{cursor:pointer;}
.container{display:flex;align-items:flex-start;flex-direction:row;flex-wrap:wrap;max-width:1440px;width:100%;height:100%;margin:0 auto;position:relative;}
@media (max-width: 1480px){
.container{padding:0 20px;}
}
.cta-button{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);width:204px;height:50px;position:relative;display:flex;align-items:center;justify-content:center;border-radius:24px;}
.cta-button a{display:flex;align-items:center;justify-content:center;text-decoration:none;background:#06060C;width:200px;height:46px;position:absolute;border-radius:24px;border:none;}
a.cta{display:flex;align-items:center;}
a.cta img{margin-left:10px;}
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
.current-menu-item{font-weight:900;}
.nav__list .menu-item{position:relative;display:flex;align-items:center;justify-content:center;}
.nav__list .menu-item a:hover{color:#d8d8d8;}
.nav__list .menu-item a{display:flex;align-items:center;justify-content:center;gap:8px;}
.header__divider{height:30px;width:1px;background-color:#7b7474;}
.header__button{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);width:204px;height:50px;position:relative;display:flex;align-items:center;justify-content:center;border-radius:24px;}
.header__button a{display:flex;align-items:center;justify-content:center;text-decoration:none;background:#06060C;width:200px;height:46px;position:absolute;border-radius:24px;border:none;}
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
input{width:100%;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);border-radius:12px;padding:16px 24px;font-size:16px;line-height:22px;font-family:'Urbanist', sans-serif;}
.hero__object{animation:zoom ease-out;animation-delay:0.4s;animation-duration:1.5s;top:-160px;left:260px;z-index:1;}
.hero__wrapper{width:100%;display:flex;height:100%;justify-content:space-between;}
.hero__content{display:flex;justify-content:flex-end;width:50%;height:100%;flex-direction:column;gap:24px;z-index:2;position:relative;}
.hero__title{margin-bottom:16px;}
.hero__title h1{color:#fff;font-size:120px;line-height:130px;position:relative;}
.stroke-double{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.stroke-double:before{content:attr(title);position:absolute;background-clip:text;-webkit-background-clip:text;-webkit-text-stroke:2px #932cff;top:-30px;left:0;right:0;z-index:-1;height:80px;overflow:hidden;opacity:0.45;}
.stroke-double:after{content:attr(title);position:absolute;background-clip:text;-webkit-background-clip:text;-webkit-text-stroke:2px #3f0fff;top:-60px;left:0;right:0;z-index:-2;height:80px;overflow:hidden;opacity:0.27;}
.hero__subtitle{margin-bottom:46px;}
.hero__subtitle p{font-family:'Urbanist', sans-serif;font-style:normal;font-weight:500;font-size:20px;color:rgba(255, 255, 255, 0.64);line-height:36px;}
.hero__buttons{display:flex;align-items:center;justify-content:flex-start;width:100%;flex-wrap:wrap;gap:48px;}
.hero__image{position:absolute;right:0;width:80%;display:flex;align-items:flex-end;justify-content:flex-end;height:100%;padding-top:100px;padding-right:40px;}
.hero__image img{font-size:0;height:100%;}
.hero__buttons .cta-button{box-shadow:0 16px 24px rgb(247 15 255 / 48%);}
@media (max-width: 992px){
.hero{height:auto;padding-top:180px;}
.hero__content{width:100%;}
.hero__content > *{text-align:center;align-items:center;justify-content:center;}
}
@media (max-width: 768px){
.hero{height:auto;padding-top:180px;}
.hero__content{width:100%;}
.hero__title h1{font-size:72px;line-height:72px;top:20px;}
.stroke-double:after{top:-35px;}
.stroke-double:before{top:-20px;}
}
@media (max-width: 480px){
.hero__content{align-items:center;}
.hero__title h1{font-size:48px;}
.hero__image img{right:-100%;position:relative;}
}
.stats{width:100%;margin-bottom:100px;}
.stats__row{display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));grid-auto-flow:row;width:100%;gap:30px;}
.stats__item{display:flex;align-items:center;justify-content:center;flex-direction:column;height:186px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(2px);border-radius:24px;gap:16px;}
.stats__count{width:100%;}
.stats__count p{font-style:normal;font-weight:700;font-size:48px;text-align:center;line-height:56px;}
.stats__title{width:100%;}
.stats__title p{font-weight:700;font-size:16px;line-height:19px;text-align:center;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255, 255, 255, 0.64);}
.news_widget{margin-bottom:100px;}
.news__wrapper{width:100%;display:flex;flex-direction:column;gap:48px;}
.news__head{display:flex;align-items:center;}
.blog{display:grid;grid-template-columns:repeat(auto-fit, minmax(350px, 1fr));gap:24px;}
.blog .blog__item{max-width:464px;}
.blog__item{display:flex;align-items:center;justify-content:center;position:relative;flex-grow:1;border-radius:24px;}
.blog__tags{display:flex;flex-wrap:wrap;width:100%;align-items:center;gap:8px;margin-bottom:10px;justify-content:flex-start;max-height:255px;overflow:hidden;}
.blog__tag{padding:8px 16px;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:50px;}
.blog__tag p{font-style:normal;font-weight:600;font-size:16px;line-height:19px;}
.blog__info{display:flex;flex-direction:column;gap:8px;width:100%;}
.blog__date p{font-style:normal;font-weight:600;font-size:16px;line-height:24px;}
.blog__title{width:100%;}
.blog__title p{font-style:normal;font-weight:700;font-size:24px;line-height:32px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:100%;}
.features{margin-bottom:100px;}
.features__wrapper{display:flex;flex-direction:column;align-items:center;width:100%;gap:48px;}
.features__head{width:100%;display:flex;align-items:center;}
.features__list{display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));width:100%;gap:24px;}
.features__item{display:flex;flex-direction:column;flex-wrap:wrap;padding:24px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);}
.features__icon{width:148px;height:148px;border-radius:24px;margin-bottom:24px;position:relative;}
.features__icon img{object-fit:cover;position:absolute;left:0;top:0;width:100%;}
.features__title{margin-bottom:8px;}
.features__title p{font-style:normal;font-weight:700;font-size:24px;line-height:32px;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;}
.features__description p{font-style:normal;font-weight:600;font-size:16px;line-height:24px;color:rgba(255, 255, 255, 0.8);}
.faq__wrapper{display:flex;flex-direction:column;justify-content:center;gap:48px;width:100%;}
.faq__head{align-items:center;}
.accordion__panel{display:flex;flex-direction:column;padding:24px;margin-bottom:24px;border:1px solid rgba(255, 255, 255, 0.08);border-radius:24px;line-height:32px;}
.accordion input{display:none;}
.accordion label{display:flex;align-items:baseline;justify-content:space-between;column-gap:24px;padding-block:7px;font-size:24px;font-weight:700;cursor:pointer;color:white;transition:color 0.25s;}
.accordion input:checked + label .close{display:block;}
.accordion input:checked + label .open{display:none;}
.accordion .close{display:none;}
.accordion input:checked ~ .accordion__body{height:max-content;}
.accordion input:checked ~ .accordion__body .accordion__answer{opacity:1;transform:scale(1);}
.accordion__body{height:0;overflow:hidden;transition:height 0.25s ease-in-out;}
.accordion__answer{padding-top:5px;padding-bottom:7px;opacity:0;transform:scale(0);transform-origin:top left;transition:opacity 0.75s, transform 0.15s;font-size:16px;font-weight:400;line-height:24px;}
.footer{margin:140px 0 100px 0;}
.footer__wrapper{display:flex;flex-direction:column;padding:48px;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:24px;gap:48px;width:100%;}
.footer__body{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;width:100%;gap:24px;}
.footer__about{display:flex;flex-direction:column;width:33%;gap:24px;}
.footer__logo{border-radius:8px;}
.footer__description p{font-style:normal;font-weight:600;font-size:16px;line-height:24px;color:rgba(255, 255, 255, 0.8);}
.footer__social{display:flex;align-items:center;gap:16px;}
.footer__social-item{width:40px;height:40px;background:rgba(255, 255, 255, 0.02);backdrop-filter:blur(12px);border-radius:12px;display:flex;align-items:center;justify-content:center;}
.footer__social-item img{width:20px;}
.footer__devider{width:100%;height:1px;background-color:rgba(255, 255, 255, 0.08);}
@media (max-width: 992px){
.footer__body{gap:48px;}
.footer__about{width:100%;}
}
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
  </style>
  <body
    data-rsssl="1"
    class="home page-template page-template-template-landing page-template-template-landing-php page page-id-93 theme-onchain woocommerce-js elementor-default elementor-kit-6 elementor-page elementor-page-93"
  >
    <main>
      <header class="header">
        <div class="container">
          <div id="header__row" class="header__row">
            <a href="https://<?php echo $root_domain ?>/" class="header__logo">
              <img
                src="./images/logo.png"
                alt="logo"
              />
            </a>
            <div id="header__burger" class="header__burger">
              <span></span>
            </div>
            <div id="header__menu" class="header__menu">
            <center>
              <nav class="header__nav nav">
                <ul id="menu-header-menu" class="menu nav__list">
                  <li
                    id="menu-item-99"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-93 current_page_item menu-item-99"
                  >
                    <a href="https://<?php echo $root_domain ?>/home/" class="current_selected"
                      >HOME</a
                    >
                  </li>
                  <li
                    id="menu-item-107"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107"
                  >
                    <a href="../tos">TOS</a> 
                  </li>
                  <li
                    id="menu-item-107"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107"
                  >
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
                    <div class="elementor-widget-container">
                      <section class="hero">
                        <div class="container">
                          <div class="hero__object circle"></div>
                          <div class="hero__wrapper">
                            <div class="hero__content">
                              <div class="hero__title">
                                <h1 id="title" title="">
                                  <span title="LoveStresser" class="stroke-double"
                                    >LoveStresser</span
                                  >
                                  <div class="head__title">
                                    <p><span class="version"></span></p>
                                  </div>
                                  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                  <script>
                                    $(document).ready(function() {
                                        function fetchLatestVersion() {
                                            $.getJSON('latest_version.json', function(data) {
                                                var latestVersion = data.version;
                                                $('.version').text(latestVersion);
                                            })
                                            .fail(function() {
                                                console.log('Failed to fetch latest version from JSON file');
                                            });
                                        }

                                        fetchLatestVersion();
                                        setInterval(fetchLatestVersion, 60000);
                                    });
                                </script>
                                </h1>
                              </div>
                              <div class="hero__subtitle">
                                <p>
                                Love Stresser is a DDoS platform for L4 and L7 attacks, we're offering you the best power at affordable prices.
                                </p>
                              </div>
                              <div class="hero__buttons">
                                <div class="cta-button">
                                  <a
                                    href="../authentication/authorization.php"
                                    >Login</a
                                  >
                                </div>
                                <a
                                  class="cta"
                                  href="<?php echo $server_full_link ?>"
                                  rel="nofollow"s
                                  target="_blank"
                                  >Discord
                                  <img
                                    decoding="async"
                                    src="images/arrow-right.svg"
                                    alt="category"
                                /></a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="hero__image">
                          <img
                            decoding="async"
                            src="images/header-bg-1.png"
                            alt="Solana NFT"
                          />
                        </div>
                      </section>
                    </div>
                  </div>
                  <div
                    class="elementor-element elementor-element-23b0621 elementor-widget elementor-widget-onchain_stats"
                    data-id="23b0621"
                    data-element_type="widget"
                    data-widget_type="onchain_stats.default"
                  >
                    <div class="elementor-widget-container">
                      <section class="stats">
                        <div class="container">
                          <div class="stats__row">
                            <div class="stats__item">
                              <div class="stats__count">
                                <p>+ <?php echo $memberCount;?></p>
                              </div>
                              <div class="stats__title">
                                <p>Discord members</p>
                              </div>
                            </div>
                            <div class="stats__item">
                              <div class="stats__count">
                                <p>+ 20</p>
                              </div>
                              <div class="stats__title">
                                <p>Attack methods</p>
                              </div>
                            </div>
                            <div class="stats__item">
                              <div class="stats__count">
                                <p>+ <?php echo $users_number; ?></p>
                              </div>
                              <div class="stats__title">
                                <p>Users</p>
                              </div>
                            </div>
                            <div class="stats__item">
                              <div class="stats__count">
                                <p>+ <?php echo $total_attacks; ?></p>
                              </div>
                              <div class="stats__title">
                                <p>launched attacks</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                  <div
                    class="elementor-element elementor-element-d273a56 elementor-widget elementor-widget-onchain_shop"
                    data-id="d273a56"
                    data-element_type="widget"
                    data-widget_type="onchain_shop.default"
                  >
                   
                  
                  <div class="elementor-widget-container">
                      <section class="features">
                        <div class="container">
                          <div class="features__wrapper">
                            <div class="features__head head">
                              <div class="head__subtitle">
                                <p>FEATURES</p>
                              </div>
                              <div class="head__title">
                                <p>Some reasons to <span>Choose Us</span></p>
                              </div>
                              <div class="head__description">
                              </div>
                            </div>
                            <div class="features__list">
                              <div class="features__item">
                                <div class="features__icon">
                                  <img
                                    decoding="async"
                                    src="images/reason1.png"
                                    alt="ByPassing Method"
                                  />
                                </div>
                                <div class="features__title">
                                  <p>Bypassing Method</p>
                                </div>
                                <div class="features__description">
                                  <p></p>
                                  <p>

                                  Love-Stresser offers advanced methods capable of bypassing the protections put in place by various anti-DDoS security services, including Cloudflare and OVH. This allows your attacks to remain effective, even in the face of the most robust and popular security solutions.
                                  </p>
                                  <p></p>
                                </div>
                              </div>
                              <div class="features__item">
                                <div class="features__icon">
                                  <img
                                    decoding="async"
                                    src="images/reason2.png"
                                    alt="24/7 support"
                                  />
                                </div>
                                <div class="features__title">
                                  <p>24/7 support</p>
                                </div>
                                <div class="features__description">
                                  <p></p>
                                  <p>
                                  Love-Stresser offers customer support 24 hours a day, 7 days a week. Regardless of the time of day or day of the week, a dedicated team is always on hand to answer users' questions and resolve their problems. With this support service, users can be assured of fast and efficient assistance at all times.
                                  </p>
                                  <p></p>
                                </div>
                              </div>
                              <div class="features__item">
                                <div class="features__icon">
                                  <img
                                    decoding="async"
                                    src="images/reason4.png"
                                    alt="Easy and secure payment"
                                  />
                                </div>
                                <div class="features__title">
                                  <p>Easy and secure payment</p>
                                </div>
                                <div class="features__description">
                                  <p></p>
                                  <p>
Love-Stresser offers easy and secure payment options. Thanks to Selllix , users can make their payments with complete peace of mind. Whether by PayPal or other payment methods, Love-Stresser guarantees the protection of its customers' personal and financial information.
                                  </p>
                                  <p></p>
                                </div>
                              </div>
                              <div class="features__item">
                                <div class="features__icon">
                                  <img
                                    decoding="async"
                                    src="images/reason5.png"
                                    alt="High-performance method"
                                  />
                                </div>
                                <div class="features__title">
                                  <p>High-performance method</p>
                                </div>
                                <div class="features__description">
                                  <p></p>
                                  <p>
                                  Love-Stresser uses powerful methods to bypass the anti-DDoS protections of many security services, including Cloudflare and OVH. 
                                  </p>
                                  <p></p>
                                </div>
                              </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                  <div
                    class="elementor-element elementor-element-892bd52 elementor-widget elementor-widget-onchain_blog"
                    data-id="892bd52"
                    data-element_type="widget"
                    data-widget_type="onchain_blog.default"
                  >
                  <?php
include("../componements/php/database_conn.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT title, type, content, date FROM announcements ORDER BY date DESC");
    $stmt->execute();

    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($announcements) > 0) {
        echo '<div class="elementor-widget-container">';
        echo '<section class="news news_widget">';
        echo '<div class="container">';
        echo '<div class="news__wrapper">';
        echo '<div class="news__head head">';
        echo '<div class="head__subtitle"><p>NEWS</p></div>';
        echo '<div class="head__title"><p>Love Stresser <span>News</span></p></div>';
        echo '<div class="head__description"></div>';
        echo '</div>';
        echo '<div class="news__list blog">';

        foreach ($announcements as $announcement) {
            echo '<a href="" class="blog__item">';
            echo '<div class="features__item">';
            echo '<div class="blog__tags">';
            echo '<div class="blog__tag"><p>' . htmlspecialchars($announcement['type']) . '</p></div>';
            echo '</div><br>';
            echo '<div class="blog__info">';
            echo '<div class="blog__date"><p>' . htmlspecialchars($announcement['date']) . '</p></div>';
            echo '<div class="blog__title"><p>' . htmlspecialchars($announcement['title']) . '</p></div>';
            echo '<p>' . htmlspecialchars($announcement['content']) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }

        echo '</div>';

        if (count($announcements) > 3) {
            echo '<div class="slider-controls">';
            echo '<button class="prev-slide">Previous</button>';
            echo '<button class="next-slide">Next</button>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
        echo '</div>'; 
    } else {
        echo '<div class="elementor-widget-container">';
        echo '<section class="news news_widget">';
        echo '<div class="container">';
        echo '<div class="news__wrapper">';
        echo '<div class="news__head head">';
        echo '<div class="head__subtitle"><p>NEWS</p></div>';
        echo '<div class="head__title"><p>Love Stresser <span>News</span></p></div>';
        echo '<div class="head__description"></div>';
        echo '</div>';
        echo '<div class="news__list blog">';
        echo '<p><center>No news to display</center></p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
        echo '</div>';
    }

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  if ($('.news__list .blog__item').length > 3) {
    $('.news__list').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      prevArrow: $('.prev-slide'),
      nextArrow: $('.next-slide'),
    });
  }
});
</script>
                          
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                    <div class="elementor-widget-container">
                      <section class="faq">
                        <div class="container">
                          <div class="faq__wrapper">
                            <div class="faq__head head">
                              <div class="head__subtitle">
                                <p>Questions</p>
                              </div>
                              <div class="head__title">
                                <p>Here are the most frequently asked <span>questions</span></p>
                              </div>
                              <div class="head__description">
                              </div>
                            </div>

                            <div class="accordion">
                              <article class="accordion__panel">
                                <input
                                  type="radio"
                                  id="accordion-question-1"
                                  name="accordion"
                                  checked=""
                                />
                                <label for="accordion-question-1"
                                  >What is Love Stresser? 
                                  <i class="open"
                                    ><img
                                      decoding="async"
                                      src="images/arrow-down.svg"
                                      alt="icon"
                                  /></i>
                                  <i class="close"
                                    ><img
                                      decoding="async"
                                      src="images/arrow-up.svg"
                                      alt="icon"
                                  /></i>
                                </label>
                                <div class="accordion__body">
                                  <div class="accordion__answer">
                                    <p>
                                    Love Stresser is an online service that allows you to carry out Layer 4 and 7 denial of service attacks at a low price but with great power.
                                    </p>
                                  </div>
                                </div>
                              </article>
                              <article class="accordion__panel">
                                <input
                                  type="radio"
                                  id="accordion-question-2"
                                  name="accordion"
                                  checked=""
                                />
                                <label for="accordion-question-2"
                                  >How can I pay for a plan on Love Stresser?
                                  <i class="open"
                                    ><img
                                      decoding="async"
                                      src="images/arrow-down.svg"
                                      alt="icon"
                                  /></i>
                                  <i class="close"
                                    ><img
                                      decoding="async"
                                      src="images/arrow-up.svg"
                                      alt="icon"
                                  /></i>
                                </label>
                                <div class="accordion__body">
                                  <div class="accordion__answer">
                                    <p>
                                    You can buy a plan by logging on to love stresser in the section called "shop".
                                    </p>
                                  </div>
                                </div>
                              </article>
                            </div>
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
            <div class="footer__body">
              <div class="footer__about">
                <a href="https://<?php echo $root_domain ?>/home/" class="footer__logo">
                  <img
                    src="images/logo_footer.png"
                    srcset="images/logo_footer2x.png 2x"
                    alt="logo"
                    class="footer__logo"
                  />
                </a>

                <div class="footer__description">
                  <p>
                  Love Stresser is a DDoS platform for L4 and L7 attacks, we're offering you the best power at affordable prices.
                  </p>
                </div>

                <div class="footer__social">
                  <a href="<?php echo $server_full_link ?>" target="_blank" class="footer__social-item">
                    <img src="images/discord.svg" alt="icon" />
                  </a>
                </div>
              </div>

            </div>
            <div class="footer__devider"></div>
            <div class="footer__copyright copyright">
              <div class="copyright__main">
                Copyright Love Stresser &copy 2024 All rights reserved.
              </div>
              <ul id="menu-footer-two" class="copyright__nav">
                <li
                  id="menu-item-112"
                  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-112"
                >
                  <a rel="nofollow" href="../tos">TOS</a>
                </li>
              
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </main>
    <script src="js/imagesloaded.min.js" id="imagesloaded-js"></script>
    <script src="js/jquery.appear.js" id="jquery-appear-js"></script>
    <script src="js/scripts.min.js" id="onchain-scripts-js"></script>
    <script>
function isAllowedShortcut(event) {
    if (event.ctrlKey) {
        if (event.key === 'c' || event.key === 'v' || event.key === 'x') {
            return true;
        }
    }
    return false;
}
function handleKeyDown(event) {
    if ((event.ctrlKey && !isAllowedShortcut(event)) || event.key === 'F12') {
        event.preventDefault();
        window.location.href = 'https://youtu.be/dQw4w9WgXcQ';
    }
}
function handleContextMenu(event) {
    event.preventDefault();
}

document.addEventListener('keydown', handleKeyDown);
document.addEventListener('contextmenu', handleContextMenu);

    </script>
  </body>
</html>
