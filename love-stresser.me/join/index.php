<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
include("../componements/php/discord_server.php");
if (isset($_COOKIE['LS_ASP']) && !empty($_COOKIE['LS_ASP'])) {
    $token = $_COOKIE['LS_ASP'];
    
	include("../componements/php/database_conn.php");
	include("../componements/php/discord_server.php");

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT guilds FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($guilds);
    $stmt->fetch();
    $stmt->close();
    
    $guilds_array = json_decode($guilds, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $guilds_array = explode(',', $guilds);
    }

    if (in_array("1245354780507770962", $guilds_array)) {
        header("Location: ../hub");
        exit();
    }
    $conn->close();
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
<!DOCTYPE html>
<html class="no-js" lang="en-US">
  <head>
  <script>console.log = function(){ };</script>
    <meta charset="UTF-8" />
    <title>LoveStresser - JOIN</title>
    <meta name="robots" content="max-image-preview:large" />
	<link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
  </head>
  <style>
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
.circle{width:240px;height:240px;position:absolute;border-radius:50%;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);}
.circle::before{content:'';width:100%;top:initial;bottom:initial;left:initial;right:initial;position:absolute;height:100%;border-radius:50%;background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);opacity:0.84;filter:blur(100px);}
.hero{height:800px;position:relative;margin-bottom:100px;display:flex;}
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
}

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
                                  <span class="stroke-double"
                                    >Hummm...</span
                                  >
                                </h1>
                              </div>
                              <div class="hero__subtitle">
                                <p>
                                We'd love to have you on our Discord server! Join us to get full access to this website.
                                </p>
                              </div>
                              <div class="hero__buttons">
                                <div class="cta-button">
                                  <a
                                    href="<?php echo $server_full_link ?>"
                                    >Join our discord</a
                                  >
                                </div>
								<div class="cta-button">
                                  <a
                                    href="../logout"
                                    >Logout</a
                                  >
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="hero__image">
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
    </main>
  </body>
</html>
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
