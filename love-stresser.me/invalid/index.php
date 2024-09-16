<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
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
    <title>LoveStresser - NOT ALLOWED</title>
    <meta name="robots" content="max-image-preview:large" />
    <link rel="icon" href="images/cropped-favicon-32x32.png" sizes="32x32">
    <link rel="icon" href="images/cropped-favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="images/cropped-favicon-180x180.png">
  </head>
<style>

body{--wp--preset--color--black:#000000;--wp--preset--color--cyan-bluish-gray:#abb8c3;--wp--preset--color--white:#ffffff;--wp--preset--color--pale-pink:#f78da7;--wp--preset--color--vivid-red:#cf2e2e;--wp--preset--color--luminous-vivid-orange:#ff6900;--wp--preset--color--luminous-vivid-amber:#fcb900;--wp--preset--color--light-green-cyan:#7bdcb5;--wp--preset--color--vivid-green-cyan:#00d084;--wp--preset--color--pale-cyan-blue:#8ed1fc;--wp--preset--color--vivid-cyan-blue:#0693e3;--wp--preset--color--vivid-purple:#9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple:linear-gradient(           135deg,           rgba(6, 147, 227, 1) 0%,           rgb(155, 81, 224) 100%         );--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan:linear-gradient(           135deg,           rgb(122, 220, 180) 0%,           rgb(0, 208, 130) 100%         );--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange:linear-gradient(           135deg,           rgba(252, 185, 0, 1) 0%,           rgba(255, 105, 0, 1) 100%         );--wp--preset--gradient--luminous-vivid-orange-to-vivid-red:linear-gradient(           135deg,           rgba(255, 105, 0, 1) 0%,           rgb(207, 46, 46) 100%         );--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray:linear-gradient(           135deg,           rgb(238, 238, 238) 0%,           rgb(169, 184, 195) 100%         );--wp--preset--gradient--cool-to-warm-spectrum:linear-gradient(           135deg,           rgb(74, 234, 220) 0%,           rgb(151, 120, 209) 20%,           rgb(207, 42, 186) 40%,           rgb(238, 44, 130) 60%,           rgb(251, 105, 98) 80%,           rgb(254, 248, 76) 100%         );--wp--preset--gradient--blush-light-purple:linear-gradient(           135deg,           rgb(255, 206, 236) 0%,           rgb(152, 150, 240) 100%         );--wp--preset--gradient--blush-bordeaux:linear-gradient(           135deg,           rgb(254, 205, 165) 0%,           rgb(254, 45, 45) 50%,           rgb(107, 0, 62) 100%         );--wp--preset--gradient--luminous-dusk:linear-gradient(           135deg,           rgb(255, 203, 112) 0%,           rgb(199, 81, 192) 50%,           rgb(65, 88, 208) 100%         );--wp--preset--gradient--pale-ocean:linear-gradient(           135deg,           rgb(255, 245, 203) 0%,           rgb(182, 227, 212) 50%,           rgb(51, 167, 181) 100%         );--wp--preset--gradient--electric-grass:linear-gradient(           135deg,           rgb(202, 248, 128) 0%,           rgb(113, 206, 126) 100%         );--wp--preset--gradient--midnight:linear-gradient(           135deg,           rgb(2, 3, 129) 0%,           rgb(40, 116, 252) 100%         );--wp--preset--font-size--small:13px;--wp--preset--font-size--medium:20px;--wp--preset--font-size--large:36px;--wp--preset--font-size--x-large:42px;--wp--preset--spacing--20:0.44rem;--wp--preset--spacing--30:0.67rem;--wp--preset--spacing--40:1rem;--wp--preset--spacing--50:1.5rem;--wp--preset--spacing--60:2.25rem;--wp--preset--spacing--70:3.38rem;--wp--preset--spacing--80:5.06rem;--wp--preset--shadow--natural:6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep:12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp:6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined:6px 6px 0px -3px rgba(255, 255, 255, 1),           6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp:6px 6px 0px rgba(0, 0, 0, 1);}

body{font-size:16px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:none;font-weight:500;line-height:26px;background-color:#06060c;background-repeat:repeat;background-position:top center;background-attachment:scroll;background-size:cover;}
h1{font-size:120px;font-style:normal;color:#ffffff;font-family:Urbanist;text-transform:uppercase;font-weight:700;line-height:normal;}

html,body{box-sizing:border-box;margin:0;padding:0;width:100vw;background:#06060C;position:relative;max-width:100%;overflow-x:hidden;font-family:'Urbanist', sans-serif;}
*,*:before,*:after{box-sizing:inherit;margin:0;padding:0;color:#fff;list-style-type:none;}
*::placeholder{font-size:16px;}
.container{display:flex;align-items:flex-start;flex-direction:row;flex-wrap:wrap;max-width:1440px;width:100%;height:100%;margin:0 auto;position:relative;}
@media (max-width: 1480px){
.container{padding:0 20px;}
}
.hero{height:800px;position:relative;margin-bottom:100px;display:flex;}
.hero__wrapper{width:100%;display:flex;height:100%;justify-content:space-between;}
.hero__content{display:flex;justify-content:flex-end;width:50%;height:100%;flex-direction:column;gap:24px;z-index:2;position:relative;}
.hero__title{margin-bottom:16px;}
.hero__title h1{color:#fff;font-size:120px;line-height:130px;position:relative;}
.stroke-double{background:linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.stroke-double:before{content:attr(title);position:absolute;background-clip:text;-webkit-background-clip:text;-webkit-text-stroke:2px #932cff;top:-30px;left:0;right:0;z-index:-1;height:80px;overflow:hidden;opacity:0.45;}
.stroke-double:after{content:attr(title);position:absolute;background-clip:text;-webkit-background-clip:text;-webkit-text-stroke:2px #3f0fff;top:-60px;left:0;right:0;z-index:-2;height:80px;overflow:hidden;opacity:0.27;}
.hero__subtitle{margin-bottom:46px;}
.hero__subtitle p{font-family:'Urbanist', sans-serif;font-style:normal;font-weight:500;font-size:20px;color:rgba(255, 255, 255, 0.64);line-height:36px;}
.hero__image{position:absolute;right:0;width:80%;display:flex;align-items:flex-end;justify-content:flex-end;height:100%;padding-top:100px;padding-right:40px;}
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
                          <div class="hero__wrapper">
                          <center>
                            <div class="hero__content">
                              <div class="hero__title">
                                <h1 id="title" title="">
                                  <span class="stroke-double"
                                    >PHONES ARE NOT ALLOWED!</span
                                  >
                                </h1>
                              </div>
                              <div class="hero__subtitle">
                                <p>
                                For security reasons, please use a computer to access this website! 
                                </p>
                              </div>
                            </div>
                            </center>
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
