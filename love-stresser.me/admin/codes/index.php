<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
$file = '../../authentication/handler/status/status.json';
$status = json_decode(file_get_contents($file), true);
if ($status['status'] === 'offline') {
    include('../../help/cgu/index.php');
    die();
} else {
}
?>
<?php
include("../../componements/php/root_domain.php");
include("./../../componements/php/database_conn.php");
include("./../../componements/php/unauthorized.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_COOKIE['LS_ASP'])) {
    $token = $_COOKIE['LS_ASP'];
    
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
    $user_rank = getUserRank($conn, $token);
    
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
    $avatar_url = getUserAvatar($conn, $token);
   
    if ($user_rank !== 'owner') {
        header('Location: ../../home');
        exit();
    }
} else {
    header('Location: ../../home');
    exit();
}

function generateRandomCode() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ($i = 0; $i < 4; $i++) {
        if ($i > 0) {
            $code .= '-';
        }
        for ($j = 0; $j < 5; $j++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
    }
    return $code;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['plan']) && isset($_POST['number']) && isset($_POST['duration_value']) && isset($_POST['duration_unit'])) {
        $plan = $_POST['plan'];
        $number = intval($_POST['number']);
        $duration_value = intval($_POST['duration_value']);
        $duration_unit = $_POST['duration_unit'];
        $is_sellix = isset($_POST['is_sellix']) ? 1 : 0;

        $unit_abbr = '';
        switch ($duration_unit) {
            case 'mi':
                $unit_abbr = 'mi';
                break;
            case 'ho':
                $unit_abbr = 'ho';
                break;
            case 'da':
                $unit_abbr = 'da';
                break;
            case 'mo':
                $unit_abbr = 'mo';
                break;
            case 'ye':
                $unit_abbr = 'ye';
                break;
        }
        $duration = $duration_value . ' ' . $unit_abbr;

        if ($number > 1000) {
            $message = "Number exceeds the maximum limit of 1000. Please enter a number less than or equal to 1000.";
        } else {
            $stmt = $conn->prepare("INSERT INTO plan_codes (code, plan, duration, redeemed, is_sellix) VALUES (?, ?, ?, 0, ?)");
            $stmt->bind_param("sssi", $code, $plan, $duration, $is_sellix);

            for ($i = 0; $i < $number; $i++) {
                $code = generateRandomCode();
                if ($stmt->execute()) {
                    $message = "Codes created successfully!";
                } else {
                    $message = "Error creating code: " . $stmt->error;
                    break;
                }
            }

            $stmt->close();
        }
    }

    if (isset($_POST['delete_codes'])) {
        $sql = "DELETE FROM plan_codes WHERE redeemed = 0";

        if ($conn->query($sql) === TRUE) {
            $message = "All non-redeemed codes have been deleted.";
        } else {
            $message = "Error deleting codes: " . $conn->error;
        }
    }
}

$non_redeemed_codes = [];
$sellix_codes = [];
$result = $conn->query("SELECT code, plan, duration, is_sellix FROM plan_codes WHERE redeemed = 0 ORDER BY plan, duration");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['is_sellix']) {
            $sellix_codes[] = $row;
        } else {
            $non_redeemed_codes[] = $row;
        }
    }
}

$conn->close();

function getReadableDuration($duration) {
    $unit = substr($duration, -2);
    $value = substr($duration, 0, -3);

    switch ($unit) {
        case 'mi':
            return $value . ' minutes';
        case 'ho':
            return $value . ' hours';
        case 'da':
            return $value . ' days';
        case 'mo':
            return $value . ' months';
        case 'ye':
            return $value . ' years';
        default:
            return $duration;
    }
}

include("../../componements/php/plans.php");

function getPlanStyle($plan) {
    global $plan_styles;
    return isset($plan_styles[$plan]) ? $plan_styles[$plan]['style'] : '';
}

function convertToMinutes($duration) {
    $value = intval(substr($duration, 0, -3));
    $unit = substr($duration, -2);

    switch ($unit) {
        case 'mi':
            return $value;
        case 'ho':
            return $value * 60;
        case 'da':
            return $value * 1440;
        case 'mo':
            return $value * 43200;
        case 'ye':
            return $value * 525600;
        default:
            return 0;
    }
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
body,div,span,h2,h3,ul,li,a,img,strong,form,label,header,nav,section{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;list-style:none;}
:focus{outline:0;}
img{vertical-align:middle;outline:0;}
html,body,textarea,input{-webkit-text-size-adjust:none;}
html{overflow-x:hidden;}
body{text-align:left;overflow:hidden;}
a{text-decoration:none;cursor:pointer;transition:color 100ms linear;}
strong{font-weight:bold;}
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

.sidebar-section{display:flex;flex-direction:column;padding:50px;margin-bottom:24px;height:1192px;margin-top:24px;margin-left:50px;width:300px;border-radius:24px;background:rgba(255, 255, 255, 0.02);border:1px solid rgba(255, 255, 255, 0.08);}
.sidebar-items{text-align:center;}
textarea{width:100%;height:150px;resize:vertical;margin-bottom:20px;margin-top:10px;overflow:auto;}
textarea::-webkit-scrollbar{display:none;}
input,select{margin-top:5px;}
h2{margin-bottom:10px;}
.coder1{padding:24px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);width:1440px;position:relative;box-sizing:border-box;margin-top:-1030px;display:flex;flex-direction:column;justify-content:space-between;min-height:400px;margin-bottom:50px;}
.coder1 label{position:absolute;left:24px;}
.coder1 select,.coder1 input{margin-top:40px;}
.coder2{padding:24px;border-radius:24px;border:1px solid rgba(255, 255, 255, 0.08);backdrop-filter:blur(12px);width:1440px;position:relative;box-sizing:border-box;display:flex;flex-direction:column;justify-content:space-between;min-height:500px;margin-bottom:50px;}
select{text-transform:uppercase;font-weight:bold;}
select option{text-transform:uppercase;font-weight:bold;}
.delete-button{background-color:red;color:white;border:none;border-radius:12px;width:400px;cursor:pointer;position:relative;}
.submission_button{border-radius:12px;}

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
                                    </style>

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
                                            <li><a class="current_selected current-menu-item" href="">Codes</a></li>
                                            <li><a href="../ongoing">Ongoing</a></li>
                                            <li><a href="../blacklist">Blacklist</a></li>
                                            <li><a href="../add-image">Add-Image</a></li>
                                          </ul>
                                      </div>
                              </section>

                              <center>
                                
                              <div class="coder1">
    <h2>Create a New Code</h2>
    <br></br>
    <form method="post" action="./">
        <label for="plan">Plan:</label>
        <select id="plan" name="plan" required>
            <option value="starter1">starter1</option>
            <option value="starter2">starter2</option>
            <option value="starter3">starter3</option>
            <option value="exp1">exp1</option>
            <option value="exp2">exp2</option>
            <option value="exp3">exp3</option>
            <option value="pro1">pro1</option>
            <option value="pro2">pro2</option>
            <option value="pro3">pro3</option>
            <option value="infinity">infinity</option>
        </select>
        <br></br>
        <label for="number">Number:</label>
        <input type="number" placeholder="1-1000" id="number" name="number" min="1" max="1000" required>
        <br></br>
        <label for="duration_value">Duration:</label>
        <input type="number" id="duration_value" name="duration_value" min="1" required>
        <select id="duration_unit" name="duration_unit" required>
            <option value="mi">Minutes</option>
            <option value="ho">Hours</option>
            <option value="da">Days</option>
            <option value="mo">Months</option>
            <option value="ye">Years</option>
        </select>
        <br></br>
        <li>
        <label for="is_sellix">Is Sellix Code: <input type="checkbox" class="check-css-x6" id="is_sellix" name="is_sellix"></label>
        </li>
        <?php if ($message) { echo "<p>$message</p>"; } ?>
        <br></br>
        <button class="submission_button" type="submit">Create Code</button>
    </form>
</div>
    
<div class="coder2">
    <h2>Available Codes</h2>
    <form id="delete-form" method="post" action="./" style="">
        <input type="hidden" name="delete_codes" value="1">
    </form>
    <br></br>
    <?php 
if (!empty($non_redeemed_codes) || !empty($sellix_codes)) {
    $codes_by_plan = [];
    $sellix_codes_by_plan = [];

    foreach ($non_redeemed_codes as $code) {
        $plan = $code['plan'];
        $duration = $code['duration'];
        
        $readable_duration = getReadableDuration($duration);

        if (!isset($codes_by_plan[$plan])) {
            $codes_by_plan[$plan] = [];
        }
        
        if (!isset($codes_by_plan[$plan][$readable_duration])) {
            $codes_by_plan[$plan][$readable_duration] = [];
        }
        
        $codes_by_plan[$plan][$readable_duration][] = $code['code'];
    }

    foreach ($sellix_codes as $code) {
        $plan = $code['plan'];
        $duration = $code['duration'];
        
        $readable_duration = getReadableDuration($duration);

        if (!isset($sellix_codes_by_plan[$plan])) {
            $sellix_codes_by_plan[$plan] = [];
        }
        
        if (!isset($sellix_codes_by_plan[$plan][$readable_duration])) {
            $sellix_codes_by_plan[$plan][$readable_duration] = [];
        }
        
        $sellix_codes_by_plan[$plan][$readable_duration][] = $code['code'];
    }

    $plan_order = ['starter1', 'starter2', 'starter3', 'exp1', 'exp2', 'exp3', 'pro1', 'pro2', 'pro3', 'infinity'];

    foreach ($plan_order as $plan) {
        if (isset($codes_by_plan[$plan])) {
            echo '<h3 style="' . getPlanStyle($plan) . '">' . htmlspecialchars(strtoupper($plan)) . '</h3>';
            $durations = array_keys($codes_by_plan[$plan]);
            usort($durations, function($a, $b) {
                return convertToMinutes($a) - convertToMinutes($b);
            });
            
            foreach ($durations as $duration) {
                $codes = $codes_by_plan[$plan][$duration];
                $code_count = count($codes);
                ?>
                <div>
                    <br></br>
                    <strong>DURATION: <?php echo htmlspecialchars($duration); ?> (<?php echo $code_count; ?> codes)</strong>
                    <textarea readonly onclick="this.select()"><?php echo htmlspecialchars(implode("\n", $codes)); ?></textarea>
                </div>
                <?php
            }
        }
    }

    if (!empty($sellix_codes_by_plan)) {
        echo '<h2>Sellix Codes</h2>';
        foreach ($plan_order as $plan) {
            if (isset($sellix_codes_by_plan[$plan])) {
                echo '<h3 style="' . getPlanStyle($plan) . '">' . htmlspecialchars(strtoupper($plan)) . ' (Sellix)</h3>';
                $durations = array_keys($sellix_codes_by_plan[$plan]);
                usort($durations, function($a, $b) {
                    return convertToMinutes($a) - convertToMinutes($b);
                });
                
                foreach ($durations as $duration) {
                    $codes = $sellix_codes_by_plan[$plan][$duration];
                    $code_count = count($codes);
                    ?>
                    <div>
                        <br></br>
                        <strong>DURATION: <?php echo htmlspecialchars($duration); ?> (<?php echo $code_count; ?> Sellix codes)</strong>
                        <textarea readonly onclick="this.select()"><?php echo htmlspecialchars(implode("\n", $codes)); ?></textarea>
                    </div>
                    <?php
                }
            }
        }
    }

} else {
    echo '<p>No codes available.</p>';
}
?>

        <center>
            <button class="delete-button" onclick="deleteNonRedeemedCodes()">Delete all available codes</button>
        </center>
        <script>
            function deleteNonRedeemedCodes() {
                if (confirm("Are you sure you want to delete all non-redeemed codes? This action cannot be undone.")) {
                    document.getElementById("delete-form").submit();
                }
            }
        </script>
    </div>
    </center>
                              </section>

                          </div>
                        </div>    
    </main>
</body></html>
