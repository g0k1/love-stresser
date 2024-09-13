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
    <title>LoveStresser - 404</title>
    <meta name="robots" content="max-image-preview:large" />
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <style id="wp-emoji-styles-inline-css">
      img.wp-smiley,
      img.emoji {
        display: inline !important;
        border: none !important;
        box-shadow: none !important;
        height: 1em !important;
        width: 1em !important;
        margin: 0 0.07em !important;
        vertical-align: -0.1em !important;
        background: none !important;
        padding: 0 !important;
      }
    </style>
    <style id="classic-theme-styles-inline-css">
      .wp-block-button__link {
        color: #fff;
        background-color: #32373c;
        border-radius: 9999px;
        box-shadow: none;
        text-decoration: none;
        padding: calc(0.667em + 2px) calc(1.333em + 2px);
        font-size: 1.125em;
      }
      .wp-block-file__button {
        background: #32373c;
        color: #fff;
        text-decoration: none;
      }
    </style>
    <style id="global-styles-inline-css">
      body {
        --wp--preset--color--black: #000000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #ffffff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(
          135deg,
          rgba(6, 147, 227, 1) 0%,
          rgb(155, 81, 224) 100%
        );
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(
          135deg,
          rgb(122, 220, 180) 0%,
          rgb(0, 208, 130) 100%
        );
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(
          135deg,
          rgba(252, 185, 0, 1) 0%,
          rgba(255, 105, 0, 1) 100%
        );
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(
          135deg,
          rgba(255, 105, 0, 1) 0%,
          rgb(207, 46, 46) 100%
        );
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(
          135deg,
          rgb(238, 238, 238) 0%,
          rgb(169, 184, 195) 100%
        );
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(
          135deg,
          rgb(74, 234, 220) 0%,
          rgb(151, 120, 209) 20%,
          rgb(207, 42, 186) 40%,
          rgb(238, 44, 130) 60%,
          rgb(251, 105, 98) 80%,
          rgb(254, 248, 76) 100%
        );
        --wp--preset--gradient--blush-light-purple: linear-gradient(
          135deg,
          rgb(255, 206, 236) 0%,
          rgb(152, 150, 240) 100%
        );
        --wp--preset--gradient--blush-bordeaux: linear-gradient(
          135deg,
          rgb(254, 205, 165) 0%,
          rgb(254, 45, 45) 50%,
          rgb(107, 0, 62) 100%
        );
        --wp--preset--gradient--luminous-dusk: linear-gradient(
          135deg,
          rgb(255, 203, 112) 0%,
          rgb(199, 81, 192) 50%,
          rgb(65, 88, 208) 100%
        );
        --wp--preset--gradient--pale-ocean: linear-gradient(
          135deg,
          rgb(255, 245, 203) 0%,
          rgb(182, 227, 212) 50%,
          rgb(51, 167, 181) 100%
        );
        --wp--preset--gradient--electric-grass: linear-gradient(
          135deg,
          rgb(202, 248, 128) 0%,
          rgb(113, 206, 126) 100%
        );
        --wp--preset--gradient--midnight: linear-gradient(
          135deg,
          rgb(2, 3, 129) 0%,
          rgb(40, 116, 252) 100%
        );
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
        --wp--preset--spacing--20: 0.44rem;
        --wp--preset--spacing--30: 0.67rem;
        --wp--preset--spacing--40: 1rem;
        --wp--preset--spacing--50: 1.5rem;
        --wp--preset--spacing--60: 2.25rem;
        --wp--preset--spacing--70: 3.38rem;
        --wp--preset--spacing--80: 5.06rem;
        --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
        --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1),
          6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
      }
      :where(.is-layout-flex) {
        gap: 0.5em;
      }
      :where(.is-layout-grid) {
        gap: 0.5em;
      }
      body .is-layout-flow > .alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
      }
      body .is-layout-flow > .alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
      }
      body .is-layout-flow > .aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
      }
      body .is-layout-constrained > .alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
      }
      body .is-layout-constrained > .alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
      }
      body .is-layout-constrained > .aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
      }
      body
        .is-layout-constrained
        > :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
        max-width: var(--wp--style--global--content-size);
        margin-left: auto !important;
        margin-right: auto !important;
      }
      body .is-layout-constrained > .alignwide {
        max-width: var(--wp--style--global--wide-size);
      }
      body .is-layout-flex {
        display: flex;
      }
      body .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
      }
      body .is-layout-flex > * {
        margin: 0;
      }
      body .is-layout-grid {
        display: grid;
      }
      body .is-layout-grid > * {
        margin: 0;
      }
      :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
      }
      :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
      }
      :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
      }
      :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
      }
      .has-black-color {
        color: var(--wp--preset--color--black) !important;
      }
      .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }
      .has-white-color {
        color: var(--wp--preset--color--white) !important;
      }
      .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
      }
      .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
      }
      .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
      }
      .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }
      .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
      }
      .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
      }
      .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
      }
      .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }
      .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
      }
      .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
      }
      .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }
      .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
      }
      .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
      }
      .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
      }
      .has-luminous-vivid-orange-background-color {
        background-color: var(
          --wp--preset--color--luminous-vivid-orange
        ) !important;
      }
      .has-luminous-vivid-amber-background-color {
        background-color: var(
          --wp--preset--color--luminous-vivid-amber
        ) !important;
      }
      .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
      }
      .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
      }
      .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
      }
      .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }
      .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
      }
      .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
      }
      .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }
      .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
      }
      .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
      }
      .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
      }
      .has-luminous-vivid-orange-border-color {
        border-color: var(
          --wp--preset--color--luminous-vivid-orange
        ) !important;
      }
      .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }
      .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
      }
      .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
      }
      .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
      }
      .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }
      .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
      }
      .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(
          --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple
        ) !important;
      }
      .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(
          --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan
        ) !important;
      }
      .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(
          --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange
        ) !important;
      }
      .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(
          --wp--preset--gradient--luminous-vivid-orange-to-vivid-red
        ) !important;
      }
      .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(
          --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray
        ) !important;
      }
      .has-cool-to-warm-spectrum-gradient-background {
        background: var(
          --wp--preset--gradient--cool-to-warm-spectrum
        ) !important;
      }
      .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
      }
      .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
      }
      .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
      }
      .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
      }
      .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
      }
      .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
      }
      .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
      }
      .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
      }
      .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
      }
      .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
      }
      .wp-block-navigation a:where(:not(.wp-element-button)) {
        color: inherit;
      }
      :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
      }
      :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
      }
      :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
      }
      :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
      }
      .wp-block-pullquote {
        font-size: 1.5em;
        line-height: 1.6;
      }
    </style>
    <link
      rel="stylesheet"
      id="woocommerce-layout-css"
      href="home/css/woocommerce-layout.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="woocommerce-smallscreen-css"
      href="home/css/woocommerce-smallscreen.css"
      media="only screen and (max-width: 768px)"
    />
    <link
      rel="stylesheet"
      id="woocommerce-general-css"
      href="home/css/woocommerce.css"
      media="all"
    />
    <style id="woocommerce-inline-inline-css">
      .woocommerce form .form-row .required {
        visibility: visible;
      }
    </style>
    <link
      rel="stylesheet"
      id="onchain_styles-css"
      href="home/css/ale_styles.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="onchain_builder-css"
      href="home/css/onchain_main.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="onchain-google-font-one-css"
      href="//fonts.googleapis.com/css2?family=Urbanist%3Awght%40400%3B500%3B600%3B700&amp;subset=latin%2Clatin-ext&amp;display=swap&amp;ver=1.0.0"
      media="all"
    />
    <link
      rel="stylesheet"
      id="elementor-icons-css"
      href="home/css/elementor-icons.min.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="elementor-frontend-css"
      href="home/css/frontend-lite.min.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="swiper-css"
      href="home/css/swiper.min.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="elementor-post-6-css"
      href="home/css/post-6.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="elementor-global-css"
      href="home/css/global.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="elementor-post-93-css"
      href="home/css/post-93.css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="google-fonts-1-css"
      href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;display=swap&amp;ver=6.4.5"
      media="all"
    />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <script src="home/js/jquery.min.js" id="jquery-core-js"></script>
    <script src="home/js/jquery-migrate.min.js" id="jquery-migrate-js"></script>
    <script
      src="home/js/jquery.blockUI.min.js"
      id="jquery-blockui-js"
      defer=""
      data-wp-strategy="defer"
    ></script>
    <script id="wc-add-to-cart-js-extra">
      var wc_add_to_cart_params = {
        ajax_url: "\/onchain\/wp-admin\/admin-ajax.php",
        wc_ajax_url: "\/onchain\/?wc-ajax=%%endpoint%%",
        i18n_view_cart: "View cart",
        cart_url: "https:\/\/alethemes.com\/onchain\/cart-2\/",
        is_cart: "",
        cart_redirect_after_add: "no",
      };
    </script>
    <script
      src="home/js/add-to-cart.min.js"
      id="wc-add-to-cart-js"
      defer=""
      data-wp-strategy="defer"
    ></script>
    <script
      src="home/js/js.cookie.min.js"
      id="js-cookie-js"
      defer=""
      data-wp-strategy="defer"
    ></script>
    <script id="woocommerce-js-extra">
      var woocommerce_params = {
        ajax_url: "\/onchain\/wp-admin\/admin-ajax.php",
        wc_ajax_url: "\/onchain\/?wc-ajax=%%endpoint%%",
      };
    </script>
    <script
      src="home/js/woocommerce.min.js"
      id="woocommerce-js"
      defer=""
      data-wp-strategy="defer"
    ></script>
    <link
      rel="https://api.w.org/"
      href="https://alethemes.com/onchain/wp-json/"
    />
    <link
      rel="alternate"
      type="application/json"
      href="https://alethemes.com/onchain/wp-json/wp/v2/pages/93"
    />
    <link
      rel="EditURI"
      type="application/rsd+xml"
      title="RSD"
      href="https://alethemes.com/onchain/xmlrpc.php?rsd"
    />
    <meta name="generator" content="WordPress 6.4.5" />
    <meta name="generator" content="WooCommerce 8.7.0" />
    <link rel="canonical" href="https://alethemes.com/onchain/" />
    <link rel="shortlink" href="https://alethemes.com/onchain/" />
    <link
      rel="alternate"
      type="application/json+oembed"
      href="https://alethemes.com/onchain/wp-json/oembed/1.0/embed?url=https%3A%2F%2Falethemes.com%2Fonchain%2F"
    />
    <link
      rel="alternate"
      type="text/xml+oembed"
      href="https://alethemes.com/onchain/wp-json/oembed/1.0/embed?url=https%3A%2F%2Falethemes.com%2Fonchain%2F&amp;format=xml"
    />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1"
    />
    <link rel="pingback" href="https://alethemes.com/onchain/xmlrpc.php" />

    <style>
      body {
        font-size: 16px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: none;
        font-weight: 500;
        line-height: 26px;
        background-color: #06060c;
        background-repeat: repeat;
        background-position: top center;
        background-attachment: scroll;
        background-size: cover;
      }

      h1 {
        font-size: 120px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: uppercase;
        font-weight: 700;
        line-height: normal;
      }
      h2 {
        font-size: 40px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: uppercase;
        font-weight: 700;
        line-height: normal;
      }
      h3 {
        font-size: 30px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: uppercase;
        font-weight: 700;
        line-height: normal;
      }
      h4 {
        font-size: 20px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: uppercase;
        font-weight: 700;
        line-height: normal;
      }
      h5 {
        font-size: 16px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: uppercase;
        font-weight: 700;
        line-height: normal;
      }
      h6 {
        font-size: 14px;
        font-style: normal;
        color: #ffffff;
        font-family: Urbanist;
        text-transform: uppercase;
        font-weight: 700;
        line-height: normal;
      }

      .font_one,
      input[type="submit"],
      .delizioso_link_text,
      .delizioso_menu_list
        .menu_list_centered
        .menu_list_items
        .item_container
        .top_line
        .price,
      .woocommerce .products div.product .price,
      .woocommerce
        .products
        div.product
        .title_and_cart
        .cart_button_container
        .added_to_cart,
      .woocommerce #respond input#submit,
      .woocommerce a.button,
      .woocommerce button.button,
      .woocommerce input.button {
        font-family: Urbanist;
      }
    </style>
    <noscript
      ><style>
        .woocommerce-product-gallery {
          opacity: 1 !important;
        }
      </style></noscript
    >
    <meta
      name="generator"
      content="Elementor 3.20.2; features: e_optimized_assets_loading, e_optimized_css_loading, additional_custom_breakpoints, block_editor_assets_optimize, e_image_loading_optimization; settings: css_print_method-external, google_font-enabled, font_display-swap"
    />
    <link rel="icon" href="home/images/cropped-favicon-32x32.png" sizes="32x32" />
    <link
      rel="icon"
      href="home/images/cropped-favicon-192x192.png"
      sizes="192x192"
    />
    <link rel="apple-touch-icon" href="home/images/cropped-favicon-180x180.png" />
    <meta
      name="msapplication-TileImage"
      content="https://alethemes.com/onchain/wp-content/uploads/sites/109/2022/12/cropped-favicon-270x270.png"
    />
    <script src="home/js/wp-emoji-release.min.js" defer=""></script>
  </head>
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
                                  <span title="ERROR 403" class="stroke-double"
                                    >ERROR 403</span
                                  >
                                </h1>
                              </div>
                              <div class="hero__subtitle">
                                <p>
                                What are you doing? You are not allowed to access this page!
                                </p>
                              </div>
                              <div class="hero__buttons">
                                <div class="cta-button">
                                  <a
                                    href="../home"
                                    >Go Home</a
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
                  <div
                    class="elementor-element elementor-element-23b0621 elementor-widget elementor-widget-onchain_stats"
                    data-id="23b0621"
                    data-element_type="widget"
                    data-widget_type="onchain_stats.default"
                  >
                  </div>
                  <div
                    class="elementor-element elementor-element-d273a56 elementor-widget elementor-widget-onchain_shop"
                    data-id="d273a56"
                    data-element_type="widget"
                    data-widget_type="onchain_shop.default"
                  >
                  <div
                    class="elementor-element elementor-element-892bd52 elementor-widget elementor-widget-onchain_blog"
                    data-id="892bd52"
                    data-element_type="widget"
                    data-widget_type="onchain_blog.default"
                  >
                  <div
                    class="elementor-element elementor-element-6b6a065 elementor-widget elementor-widget-onchain_about"
                    data-id="6b6a065"
                    data-element_type="widget"
                    data-widget_type="onchain_about.default"
                  >
                    <div class="elementor-widget-container">
                      
                    </div>
                  </div>
                  <div
                    class="elementor-element elementor-element-0ecc368 elementor-widget elementor-widget-onchain_team"
                    data-id="0ecc368"
                    data-element_type="widget"
                    data-widget_type="onchain_team.default"
                  > 
                  <div
                    class="elementor-element elementor-element-b0cf7e0 elementor-widget elementor-widget-onchain_logos"
                    data-id="b0cf7e0"
                    data-element_type="widget"
                    data-widget_type="onchain_logos.default"
                  >
                  </div>
                  <div
                    class="elementor-element elementor-element-ea9b844 elementor-widget elementor-widget-onchain_features"
                    data-id="ea9b844"
                    data-element_type="widget"
                    data-widget_type="onchain_features.default"
                  >
                    
                  </div>
                  
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
        c = c.replace(/woocommerce-no-home/js/, "woocommerce-js");
        document.body.className = c;
      })();
    </script>
    <script src="home/js/sourcebuster.min.js" id="sourcebuster-js-js"></script>
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
      src="home/js/order-attribution.min.js"
      id="wc-order-attribution-js"
    ></script>
    <script src="home/js/imagesloaded.min.js" id="imagesloaded-js"></script>
    <script src="home/js/masonry.min.js" id="masonry-js"></script>
    <script src="home/js/jquery.appear.js" id="jquery-appear-js"></script>
    <script src="home/js/scripts.min.js" id="onchain-scripts-js"></script>
    <script id="ale-load-more-js-extra">
      var aleloadmore = {
        nonce: "87bf26812e",
        url: "https:\/\/alethemes.com\/onchain\/wp-admin\/admin-ajax.php",
        button_text: "explore more",
        maxpage: "0",
        query: [],
      };
    </script>
    <script src="home/js/load-more.js" id="ale-load-more-js"></script>
    <script defer="" src="home/js/forms.js" id="mc4wp-forms-api-js"></script>
    <script
      src="home/js/webpack.runtime.min.js"
      id="elementor-webpack-runtime-js"
    ></script>
    <script
      src="home/js/frontend-modules.min.js"
      id="elementor-frontend-modules-js"
    ></script>
    <script src="home/js/waypoints.min.js" id="elementor-waypoints-js"></script>
    <script src="home/js/core.min.js" id="jquery-ui-core-js"></script>
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
          title: "lovestresser",
          excerpt: "",
          featuredImage: false,
        },
      };
    </script>
    <script src="home/js/frontend.min.js" id="elementor-frontend-js"></script>
  </body>
</html>
<style>
  html,
body {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
	width: 100vw;
	background: #06060C;
	position: relative;
	max-width: 100%;
	overflow-x: hidden;
	font-family: 'Urbanist', sans-serif;
}

*,
*:before,
*:after {
	box-sizing: inherit;
	margin: 0;
	padding: 0;
	color: #fff;
	list-style-type: none;
}

*::placeholder {
	font-size: 16px;
}


a,
button {
	font-family: 'Urbanist', sans-serif;
	text-decoration: none;
	cursor:pointer;
}

a {
	cursor: pointer;
}

.overflow-hidden {
	overflow: hidden;
}

.button {
	cursor: pointer;
}

.container {
	display: flex;
	align-items: flex-start;
	flex-direction: row;
	flex-wrap: wrap;
	max-width: 1440px;
	width: 100%;
	height: 100%;
	margin: 0 auto;
	position: relative;
}

@media (max-width: 1480px) {
	.container {
		padding: 0 20px;
	}
}

.cta-button {
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	width: 204px;
	height: 50px;
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 24px;
}

.cta-button a {
	display: flex;
	align-items: center;
	justify-content: center;
	text-decoration: none;
	background: #06060C;
	width: 200px;
	height: 46px;
	position: absolute;
	border-radius: 24px;
	border: none;
}

a.cta {
	display: flex;
	align-items: center;
}

a.cta img {
	margin-left: 10px;
}

/* section title, subtitle & description */
.head {
	display: flex;
	flex-direction: column;
}

.head__subtitle {
	margin-bottom: 8px;
}

.head__subtitle p {
	font-style: normal;
	font-weight: 700;
	font-size: 18px;
	line-height: 22px;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: rgba(255, 255, 255, 0.64);
}

.head__title {
}

.head__title p {
	font-weight: 700;
	font-size: 48px;
	line-height: 56px;
}

.head__title p span {
	background: -webkit-linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

.head__description {
	margin-top: 24px;
}

.head__description p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

.circle {
	width: 240px;
	height: 240px;
	position: absolute;
	border-radius: 50%;
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);;
}

.circle::before {
	content: '';
	width: 100%;
	top: initial;
	bottom: initial;
	left: initial;
	right: initial;
	position: absolute;
	height: 100%;
	border-radius: 50%;
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	opacity: 0.84;
	filter: blur(100px);
}

.header {
	width: 100%;
	position: absolute;
	top: 24px;
	z-index: 4;
}

.header__row {
	width: 100%;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 24px;
	height: 100px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 24px;
	flex-wrap: wrap;
	transition: all 0.7s ease-out;
}

.header__row-active {
	margin: -24px -20px;
	height: calc(100vh);
	width: calc(100vw);
	transition: all 0.7s ease-out;
	border-radius: 0;
}

.header__logo {
}

.header__burger {
	display: flex;
	align-items: center;
	justify-content: center;
	height: 32px;
	width: 32px;
	position: relative;
}

.header__burger span {
	width: 100%;
	height: 3px;
	background: #fff;
	border-radius: 50px;
	transition: all .5s ease-out;
}

.header__burger span:before {
	content: '';
	position: absolute;
	transform: translateY(-10px);
	width: 100%;
	height: 3px;
	background: #fff;
	border-radius: 50px;
	transition: all .5s ease-out;
}

.header__burger span:after {
	content: '';
	position: absolute;
	transform: translateY(10px);
	width: 100%;
	height: 3px;
	background: #fff;
	border-radius: 50px;
	transition: all .5s ease-out;
}

.header__burger-active span {
	background: transparent;
	transition: all .5s ease-out;
}

.header__burger-active span:before {
	content: '';
	position: absolute;
	width: 100%;
	height: 3px;
	background: #fff;
	border-radius: 50px;
	transform: rotate(45deg);
	transition: all .5s ease-out;
}

.header__burger-active span:after {
	content: '';
	position: absolute;
	width: 100%;
	height: 3px;
	background: #fff;
	border-radius: 50px;
	transform: rotate(-45deg);
	transition: all .5s ease-out;
}

.header__menu {
	display: flex;
	align-items: center;
	gap: 48px;
	height: 100%;
}

.nav__list {
	display: flex;
	flex-direction: row;
	gap: 48px;
	align-items: center;
	position: relative;
}

.current-menu-item {
	font-weight: 900;
}

.nav__list .menu-item {
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
}

.nav__list .menu-item-has-children > a::after {
	content:"";
	width: 24px;
	height: 25px;
	display: block;
	background: url('../images/arrow.svg') center center no-repeat;
}
.nav__list .sub-menu .menu-item-has-children > a::after {
	content:"";
	width: 24px;
	height: 25px;
	display: block;
	background: url('../images/arrow-right.svg') center center no-repeat;
}
.nav__list .menu-item a:hover {
	color: #d8d8d8;
}

.nav__list .menu-item:hover > .sub-menu {
	display: flex;
}

.nav__list .menu-item a {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
}

.nav__list .menu-item a i {
	display: flex;
	width: 24px;
	height: 24px;
	background: #2C63FF;
	border-radius: 2px;
}

.nav__list .sub-menu {
	display: none;
	flex-direction: column;
	position: absolute;
	top: 70px;
	border-radius: 24px;
	width: max-content;
	padding: 24px 32px;
	gap: 24px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
}
.nav__list .sub-menu:before {
	content: '';
	position: absolute;
	width: 100%;
	height: 50px;
	top: -50px;
	left: 0;
}

.nav__list .sub-menu .menu-item {
	position: relative;
}

.nav__list .sub-menu .menu-item .sub-menu {
	display: none;
}

.nav__list .sub-menu .menu-item .sub-menu:before {
	width: 42px;
	left: -42px;
	top: -10%;
	height: 120%;
}

.nav__list .sub-menu .menu-item:hover > .sub-menu {
	display: flex;
}

.nav__list .sub-menu .menu-item .sub-menu {
	border-radius: 24px;
	top: -20px;
	right: auto;
	left: calc(100% + 42px)
}

.header__divider {
	height: 30px;
	width: 1px;
	background-color: #7b7474;
}

.header__button {
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	width: 204px;
	height: 50px;
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 24px;
}

.header__button a {
	display: flex;
	align-items: center;
	justify-content: center;
	text-decoration: none;
	background: #06060C;
	width: 200px;
	height: 46px;
	position: absolute;
	border-radius: 24px;
	border: none;
}

@media (min-width: 991px) {
	.header__burger {
		display: none;
	}
}

@media (max-width: 992px) {
	.nav {
		width: 100%;
		max-height: calc(100vh - 330px);
		overflow-y: auto;
	}

	.nav__list {
		gap: 24px;
	}

	.sub-menu .menu-item {
		display: flex;
		flex-direction: column;
		gap: 24px;
		align-items: flex-start;
		padding-left: 24px;
	}

	.menu-item {
		flex-direction: column;
		gap: 12px;
		align-items: flex-start;
	}

	.sub-menu {
		position: relative;
		padding: 0;
		top: 0;
		left: 0;
		right: 0;
		background: none;
		backdrop-filter: none;
	}

	.sub-menu .menu-item .sub-menu {
		display: flex;
		top: 0;
		left: 0;
		right: 0;
		padding: 0;
	}

	.sub-menu {
		display: flex;
	}

	.header__row {
		padding: 33px 24px;
		align-items: flex-start;
		overflow: hidden;
	}

	.header__row-active {
		padding: 57px 48px;
		align-items: flex-start;
	}

	.header__menu {
		width: 100%;
		flex-direction: column;
		align-items: flex-start;
		margin-top: 48px;
	}

	.nav__list {
		width: 100%;
		flex-direction: column;
		align-items: flex-start;
	}

	.header__divider {
		height: 1px;
		width: 100%;
	}
}

.hero {
	height: 800px;
	position: relative;
	margin-bottom: 100px;
	display: flex;
}

.first_heading {
	margin-top: 184px;
	width: 100%;
	margin-bottom: 100px;
	position: relative;
}

.first__wrapper {
	display: flex;
	width: 100%;
	justify-content: space-between;
	position: relative;
}

.first__content {
	display: flex;
	padding: 40px 0;
	flex-direction: column;
	gap: 24px;
	width: 50%;
}


.first__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 120px;
	line-height: 148px;
}

.first__subtitle {
	margin-bottom: 24px;
}

.first__subtitle p {
	font-style: normal;
	font-weight: 500;
	font-size: 20px;
	line-height: 36px;
	color: rgba(255, 255, 255, 0.64);
}

.first__added {
	display: flex;
	width: 100%;
}


.first__image {
	display: flex;
	align-items: center;
	justify-content: center;
	width: min-content;
	height: min-content;
	position: absolute;
	top:-100px;
	right:0;
}
.first__image.title_widget {
	top:0;
}
.contact_block .first__image {
	top:0;
}
.first__image img {
	position: relative;
	z-index: 2;
	max-width: none!important;
}
.error_img {
	margin-top: -100px;
}
.first__object {
	bottom: 0;
	right: 0;
}

@media (max-width: 992px) {
	.first__wrapper {
		flex-wrap: wrap;
		align-items: center;
		justify-content: center;

	}

	.first__content {
		width: 100%;
	}

	.first__content > * {
		text-align: center;
		align-items: center;
		justify-content: center;
	}
}

@media (max-width: 768px) {
	.first__title p {
		font-size: 64px;
	}
}

@media (max-width: 480px) {
	.first__content {
		align-items: center;
	}

	.first__title p {
		font-size: 48px;
	}
}

.form {
	display: flex;
	flex-direction: column;
	gap: 24px;
	width: 100%;
}

.form__row {
	display: flex;
	width: 100%;
	align-items: center;
	gap: 24px;
	flex-wrap: wrap;
}

.form__input {
	display: flex;
	align-items: center;
	flex: 1 1;
	min-width: 200px;
}

.form__input label {
	width: 100%;
}

select {
	width: 100%;
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
	border-radius: 12px;
	padding: 16px 24px;
	font-size: 16px;
	line-height: 22px;
}
select option {
	color:#333;
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
.sidebar .form__row {
	flex-direction: column;
}
.form__area {
	width: 100%;
}

.form__aria label {
	width: 100%;
}

textarea {
	width: 100%;
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
	border-radius: 12px;
	padding: 16px 24px;
	height: 148px;
	font-size: 16px;
	line-height: 22px;
	font-family: 'Urbanist', sans-serif;
}
.form__submit {
	margin-top: 24px;
}

button,.submitsearch {
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 100px;
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
	cursor:pointer
}

.form__submit button span {
	display: flex;
	align-items: center;
	justify-content: center;
	width: calc(100% - 4px);
	height: calc(100% - 4px);
	border-radius: inherit;
	background: #06060C;
	box-shadow: inset 0 8px 16px rgba(44, 99, 255, 0.48);
}
.woocommerce div.product p.price, .woocommerce div.product span.price {
	color:#FFF;
}
.top_shop_archive {
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-wrap: wrap;
	margin-bottom: 48px;
}
.top_shop_archive::before, .top_shop_archive::after {
	display: none;
}
.top_shop_archive .woocommerce-notices-wrapper {
	width: 100%;
}
.woocommerce-result-count,.woocommerce .woocommerce-ordering {
	margin-bottom: 0;
}
.ale_pagination {
	margin-top: 48px;
}
.ale_pagination .all_pages {
	display: flex;
	align-items: center;
	justify-content: flex-start;
}
.ale_pagination .all_pages a,.ale_pagination .all_pages span {
	display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 24px;
    padding: 16px 32px;
    gap: 8px;
    transition: all 300ms ease;
	font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 19px;
    color: rgba(255, 255, 255, 0.8);
	margin-right: 10px;
}
.ale_pagination .all_pages .current {
	background: #2C63FF;
	border-color: #2C63FF;
	transition:all 300ms ease;
}
@media (max-width: 768px) {
	.form__submit {
		width: 100%;
	}

	.form__submit button {
		width: 100%;
	}
}

.hero__object {
	animation: zoom ease-out;
	animation-delay: 0.4s;
	animation-duration: 1.5s;
	top: -160px;
	left: 260px;
	z-index: 1;
}

@keyframes zoom {
	0% {
		width: 40px;
		height: 40px;
		top: 50px;
		left: 20px;
	}
	100% {
		width: 240px;
		height: 240px;
		top: -160px;
		left: 260px;
	}
}

.hero__body {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	height: 100%;
}

.hero__wrapper {
	width: 100%;
	display: flex;
	height: 100%;
	justify-content: space-between;
}

.hero__content {
	display: flex;
	justify-content: flex-end;
	width: 50%;
	height: 100%;
	flex-direction: column;
	gap: 24px;
	z-index: 2;
	position: relative;
}

.hero__title {
	margin-bottom: 16px;
}

.hero__title h1 {
	color: #fff;
	font-size: 120px;
	line-height: 130px;
	position: relative;
}

.stroke-double {
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	background-clip: text;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

.stroke-double:before {
	content: attr(title);
	position: absolute;
	background-clip: text;
	-webkit-background-clip: text;
	-webkit-text-stroke: 2px #932cff;
	top: -30px;
	left: 0;
	right: 0;
	z-index: -1;
	height: 80px;
	overflow: hidden;
	opacity: 0.45;
}

.stroke-double:after {
	content: attr(title);
	position: absolute;
	background-clip: text;
	-webkit-background-clip: text;
	-webkit-text-stroke: 2px #3f0fff;
	top: -60px;
	left: 0;
	right: 0;
	z-index: -2;
	height: 80px;
	overflow: hidden;
	opacity: 0.27;
}

.hero__subtitle {
	margin-bottom: 46px;
}

.hero__subtitle p {
	font-family: 'Urbanist', sans-serif;
	font-style: normal;
	font-weight: 500;
	font-size: 20px;
	color: rgba(255, 255, 255, 0.64);
	line-height: 36px;
}

.hero__buttons {
	display: flex;
	align-items: center;
	justify-content: flex-start;
	width: 100%;
	flex-wrap: wrap;
	gap: 48px;
}

.hero__buttons input {
	width: 100%;
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
	border-radius: 12px;
	padding: 16px 24px;
}

.hero__image {
	position: absolute;
	right: 0;
	width: 80%;
	display: flex;
	align-items: flex-end;
	justify-content: flex-end;
	height: 100%;
	padding-top: 100px;
	padding-right: 40px;
}

.hero__image img {
	font-size: 0;
	height: 100%;
}

.hero__buttons .cta-button {
	box-shadow: 0 16px 24px rgb(247 15 255 / 48%);
}

@media (max-width: 992px) {
	.hero {
		height: auto;
		padding-top: 180px;
	}

	.hero__content {
		width: 100%;
	}

	.hero__content > * {
		text-align: center;
		align-items: center;
		justify-content: center;
	}
}

@media (max-width: 768px) {
	.hero {
		height: auto;
		padding-top: 180px;
	}

	.hero__content {
		width: 100%;
	}

	.hero__title h1 {
		font-size: 72px;
		line-height: 72px;
		top: 20px;
	}

	.stroke-double:after {
		top: -35px;
	}

	.stroke-double:before {
		top: -20px;
	}
}

@media (max-width: 480px) {
	.hero__content {
		align-items: center;
	}

	.hero__title h1 {
		font-size: 48px;
	}

	.hero__image img {
		right: -100%;
		position: relative;
	}
}

.stats {
	width: 100%;
	margin-bottom: 100px;
}

.stats__row {
	display: grid;
	grid-template-columns:  repeat(auto-fit, minmax(300px, 1fr));
	grid-auto-flow: row;
	width: 100%;
	gap: 30px;
}

.stats__item {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	height: 186px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(2px);
	border-radius: 24px;
	gap: 16px;
}

.stats__count {
	width: 100%;
}

.stats__count p {
	font-style: normal;
	font-weight: 700;
	font-size: 48px;
	text-align: center;
	line-height: 56px;
}

.stats__title {
	width: 100%;
}

.stats__title p {
	font-weight: 700;
	font-size: 16px;
	line-height: 19px;
	text-align: center;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: rgba(255, 255, 255, 0.64);
}

.products {
	width: 100%;
	margin-bottom: 100px;
	background-image: linear-gradient(180deg, #06060C 0%, rgba(6, 6, 12, 0.01) 47.37%, rgba(6, 6, 12, 0.84) 73%, #06060C 100%),
	url('../images/collection_background.png');
	
	background-size: cover;
}

.products__wrapper {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
	width: 100%;
	flex-direction: column;
	gap: 48px;

}
.products__wrapper > .woocommerce {
	width: 100%;
}

.products__header {
	display: flex;
	align-items: flex-end;
	justify-content: space-between;
	width: 100%;
	flex-wrap: wrap;
	gap: 24px;
}

.woocommerce span.onsale {
	border-radius:0;
	top:0;
	left:0;
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	font-size: 1em;
	border-top-left-radius:22px;
	border-bottom-right-radius:22px;
}

.tabs__list {
	display: flex;
	align-items: center;
	justify-content: flex-end;
	flex-wrap: wrap;
	gap: 8px;
}

.tabs__item {
	display: flex;
	align-items: center;
	justify-content: center;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	padding: 16px 32px;
	gap: 8px;
	transition:all 300ms ease;
}

.tabs__item:hover {
	background: #2C63FF;
	border-color: #2C63FF;
	transition:all 300ms ease;
}

.tabs__icon {
	font-size: 20px;
	width: 20px;
	height: 20px;
	border-radius: 50%;
}

.tabs__name p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
	color: rgba(255, 255, 255, 0.8);
}

.products__list {
	width: 100%;
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
	gap: 24px;
}

.products__list > .product {
	width: 100%;
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	flex-direction: column;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 24px;
}
.entry-summary .product_title {
	font-size: 40px;
	margin-bottom: 24px;
}
.woocommerce-product-details__short-description {
	margin-bottom: 24px;
}
.woocommerce .quantity .qty {
	min-width: 100px;
}
.woocommerce div.product form.cart div.quantity {
	margin-right: 24px;
}
.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
    box-shadow: 0 16px 24px rgb(247 15 255 / 48%);
	border-radius: 26px;
	height: 56px;
}
.product_meta > span {
	display: block;
}
.product_meta a {
	color:#F70FFF;
	transition:all 300ms ease;
}
.product_meta a:hover {
	color:#2C63FF;
	transition:all 300ms ease;
}
.woocommerce-message {
	border-top-color: #2C63FF;
}
.woocommerce-message::before {
	color:#2C63FF;
}
.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
	background:#2C63FF;
	color:#FFF;
}
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover {
	background:#F70FFF;
	color:#FFF;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
	background-color: #2C63FF;
	border-color:#2C63FF;
	color:#FFF;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li {
	background-color: rgba(255,255,255,0.05);
	color:rgba(255, 255, 255, 0.64);
	border-color:rgba(255,255,255,0.05);
}
.woocommerce div.product .woocommerce-tabs ul.tabs {
	padding-left: 0;
}
.woocommerce div.product .woocommerce-tabs ul.tabs::before {
	border-bottom-color: rgba(255,255,255,0.05);
}
.woocommerce div.product .woocommerce-tabs ul.tabs li {
	margin:0;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li::before {
	display: none;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li::after {
	display: none;
}
.woocommerce-error, .woocommerce-info, .woocommerce-message {
	background-color: rgba(255,255,255,0.05);
	color:rgba(255, 255, 255, 0.64);
}
.woocommerce div.product .woocommerce-tabs .panel {
	margin-bottom: 48px;
}
.woocommerce div.product .woocommerce-tabs .panel p {
	font-size: 18px;
	margin-bottom: 24px;
}
#review_form_wrapper {
	max-width: 600px;
}
.woocommerce #review_form #respond p {
	margin-bottom: 24px;
}
.comment-form-cookies-consent {
	text-align: left;
}
.comment-form-cookies-consent input {
	width: auto;
	display: inline-block;
}
.comment-form-cookies-consent label {
	display: inline!important;
}
.woocommerce #review_form #respond p label {
	display: block;
	margin-bottom: 10px;
}
.woocommerce div.product .woocommerce-tabs .panel h2 {
	font-size: 30px;
}
.related.products {
	margin-bottom: 0;
}
#review_form .comment-reply-title {
	font-size: 30px;
	margin-bottom: 24px;
	font-weight: 700;
	display: block;
	margin-top: 48px;
}
.woocommerce-product-gallery__image img {
	border-radius:26px!important;
}
.woocommerce #reviews #comments ol.commentlist li {
	list-style: none;
}
.woocommerce #reviews #comments ol.commentlist li img.avatar {
	width: 60px;
	border-radius: 100%;
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	border:0;
}
.woocommerce #reviews #comments ol.commentlist li .comment-text {
	margin-left: 80px;
}
.woocommerce #reviews #comments ol.commentlist li .comment-text {
	border-color:rgba(255,255,255,0.05);
}
.woocommerce .star-rating::before {
	color:#F70FFF;
}
.woocommerce .star-rating span::before {
	color:#F70FFF;
}
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta {
	font-size: 1em;
}
#add_payment_method table.cart td.actions .coupon .input-text, .woocommerce-cart table.cart td.actions .coupon .input-text, .woocommerce-checkout table.cart td.actions .coupon .input-text {
	width: 150px;
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
	border-radius: 12px;
	padding: 16px 24px;
	font-size: 16px;
	line-height: 22px;
	margin-right: 15px;
}
.woocommerce .cart .button, .woocommerce .cart input.button {
	height: 56px;
	border-radius: 26px;
}
#add_payment_method table.cart img, .woocommerce-cart table.cart img, .woocommerce-checkout table.cart img {
	width: 100px;
}
#add_payment_method table.cart .product-thumbnail, .woocommerce-cart table.cart .product-thumbnail, .woocommerce-checkout table.cart .product-thumbnail {
	width: 130px;
}
.product-remove {
	width: 40px;
}
.woocommerce a.remove {
	color:#F70FFF!important;
}
.woocommerce a.remove:hover {
	background: #F70FFF!important;
}
.select2-container--default .select2-selection--single {
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 12px;
	
}
.select2-dropdown {
	background: #0d0d13;
	border: 1px solid rgba(255, 255, 255, 0.08);
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
	line-height: 52px;
	color:#FFF;
	padding-left: 24px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
	height: 52px;
}
.select2-container .select2-selection--single {
	height: 52px;
}
.select2-container--default .select2-results__option[aria-selected=true], .select2-container--default .select2-results__option[data-selected=true] {
	background: #000;
}
.select2-container--default .select2-search--dropdown .select2-search__field {
	background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    padding: 16px 24px;
    font-size: 16px;
    line-height: 22px;
    font-family: 'Urbanist', sans-serif;
}
.woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register {
	border: 1px solid rgba(255, 255, 255, 0.08);
}
.woocommerce-form-coupon button.button  {
	height: 53px;
}
#customer_details {
	margin-bottom: 48px;
}
#add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment {
	background: rgba(255,255,255,0.05);
}
#add_payment_method #payment ul.payment_methods, .woocommerce-cart #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods {
	padding: 48px;
}
.woocommerce-checkout #payment div.form-row.place-order {
	padding: 48px;
}
.checkout  ul,.checkout ol {
	margin-left: 0;
}
.product__image {
	width: 100%;
	position: relative;
	padding: 0 0 100% 0;
}

.product__image img {
	position: absolute;
	object-fit: cover;
	border-radius: 24px!important;
	left: 0;
	top: 0;
	width: 100%;
}

.product__content {
	display: flex;
	align-items: flex-start;
	width: 100%;
	gap: 16px;
	flex-direction: column;
	padding: 24px;
}

.product__title {
	width: 100%;
}

.product__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 18px;
	line-height: 24px;
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
}

.product__devider {
	width: 100%;
	height: 1px;
	background-color: rgba(255, 255, 255, 0.08);;
}

.product__footer {
	display: flex;
	align-items: center;
	justify-content: space-between;
	width: 100%;
}

.product__price {
}

.product__price p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}
.product__price ins {
	text-decoration: none!important;
}
.product__price del {
	opacity:0.25!important;
}

.wish {
	display: flex;
	gap: 10px;
	align-items: center;
}
.product__wish  a.button {
	background: transparent!important;
	color:#FFF!important;
	font-size: inherit!important;
	font-weight: inherit!important;
	padding: 0!important;
	transition:all 300ms ease;
}
.product__wish  a:hover {
	opacity:0.7;
	transition:all 300ms ease;
}
.woocommerce a.added_to_cart {
	padding-top: 0!important;
}
.woocommerce #respond input#submit.loading::after, .woocommerce a.button.loading::after, .woocommerce button.button.loading::after, .woocommerce input.button.loading::after {
	top: 0!important;
    right: 110%!important;
}

.wish__icon {
	width: 20px;
	height: 20px;
}

.wish__icon img {
	width: 100%;
}

.wish__count p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}

.products__footer {
	width: 100%;
}
.archive_pagination {
	height: 120px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 20px;
	width: 100%;
	font-size: 20px;
	transition: all 0.4s ease-out;
}
.archive_pagination .all_pages a,.archive_pagination .all_pages span {
	margin-left: 10px;
	margin-right: 10px;
}
.archive_pagination a:hover {
	color:#F70FFF;
}
.archive_pagination .current {
	color: #2C63FF;
}
.main-btn {
	height: 120px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 10px;
	width: 100%;
	transition: all 0.4s ease-out;
}

.main-btn:hover {
	border: 1px solid rgba(255, 255, 255, 0.4);
	background: rgba(255, 255, 255, 0.05);
}

.main-btn__name {
}

.main-btn__name p {
	font-style: normal;
	font-weight: 600;
	font-size: 18px;
	line-height: 22px;
}

.main-btn__icon {
	display: flex;
	width: 20px;
	height: 20px;
}


@media (max-width: 992px) {
	.tabs__list {
		justify-content: flex-start;
	}
}
.news_widget {
	margin-bottom: 100px;
}
.news__wrapper {
	width: 100%;
	display: flex;
	flex-direction: column;
	gap: 48px;
}
.news__btn {
	cursor: pointer;
}
.news__header {
	width: 100%;
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
	gap: 24px;
}

.news__head {
	display: flex;
	align-items: center;
}

.news__footer.archive_page {
	margin-top: 48px;
}

.news__footer {
	width: 100%;
}

.blog {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
	gap: 24px;
}

.blog .blog__item {
	max-width: 464px;
}

.blog__item {
	display: flex;
	align-items: center;
	justify-content: center;
	position: relative;
	flex-grow: 1;
	border-radius: 24px;
}

.blog__image {
	width: 100%;
	height: 100%;
	text-align: center;
	border-radius: 24px!important;
	position: relative;
	padding: 0 0 86% 0;
	background: rgba(255,255,255,0.05);
}

.blog__image img {
	border-radius: 24px!important;
	font-size: 0;
	position: absolute;
	top: 0;
	left: 0;
	object-fit: cover;
	width: 100%;
}

.blog__content {
	position: absolute;
	width: 100%;
	height: 100%;
	padding: 24px;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: space-between;
}

.blog__tags {
	display: flex;
	flex-wrap: wrap;
	width: 100%;
	align-items: center;
	gap: 8px;
	margin-bottom: 10px;
	justify-content: flex-start;
	max-height: 255px;
	overflow: hidden;
}

.blog__tag {
	padding: 8px 16px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 50px;
}

.blog__tag p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
}

.blog__info {
	display: flex;
	flex-direction: column;
	gap: 8px;
	width: 100%;
}

.blog__date {
}

.blog__date p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}

.blog__title {
	width: 100%;
}

.blog__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 24px;
	line-height: 32px;
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
	width: 100%;
}

.meet {
	margin-bottom: 100px;
}

.meet__wrapper {
	display: grid;
	width: 100%;
	gap: 64px;
	grid-template-columns:  repeat(auto-fit, minmax(400px, 1fr));
}

.meet__social img {
	max-width: unset!important;
	height: unset!important;
}

.social {
	display: flex;
	flex-direction: column;
	gap: 24px;
	min-width: 350px;
}

.social__item {
	display: flex;
	width: 100%;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	padding: 24px;
	gap: 24px;
}

.social__icon {
	display: flex;
}

.social__icon img {
	max-width: 64px;
	max-height: 64px;
}

.social__body {
	display: flex;
	flex-direction: column;
	gap: 16px;
	flex-grow: 1;
}

.social__title {
}

.social__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 32px;
	line-height: 40px;
}

.social__subtitle {
}

.social__subtitle p {

	font-style: normal;
	font-weight: 600;
	font-size: 18px;
	line-height: 32px;
	color: rgba(255, 255, 255, 0.64);
}

.social__link {
	display: flex;
	height: 100%;

}

.social__link img {
	display: flex;
	max-width: 24px;
	max-height: 24px!important;
}

.meet__body {
	display: flex;
	flex-direction: column;
	gap: 48px;
}

.meet__image {
	position: relative;
	width: min-content;
}

.meet__image img {
	position: relative;
	z-index: 2;
	max-width: unset!important;
	height: unset!important;
}

.meet__object {
	bottom: 0;
	right: 0;
}

@media (max-width: 992px) {
	.social {
		order: 2;
	}

	.meet__body {
		order: 1;
	}
}

@media (max-width: 480px) {
	.meet__wrapper {
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
	}

	.social {
		min-width: 200px;
	}

	.meet__body {
		min-width: 200px;
	}
}

.team {
	margin-bottom: 100px;
}

.team__wrapper {
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	gap: 48px;
}

.team__head {
	display: flex;
	align-items: center;
	width: 100%;
}

.team__list {
	display: grid;
	width: 100%;
	gap: 24px;
	grid-template-columns:  repeat(auto-fit, minmax(300px, 1fr));
}

.team__item {
}

.person {
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-direction: column;
	flex-grow: 1;
	border-radius: 24px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
}

.person__image {
	border-radius: 24px;
	width: 100%;
	position: relative;
	padding: 0 0 100% 0;
}

.person__image img {
	position: absolute;
	object-fit: cover;
	left: 0;
	top: 0;
	width: 100%;
	border-radius: 24px;
}

.person__tag {
	position: absolute;
	top: 16px;
	left: 16px;
	align-items: center;
	justify-content: flex-start;
	gap: 16px;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
}

.person__tag p {
	padding: 8px 16px;
	background-color: #2C63FF;
	border-radius: 50px;
}

.person__info {
	display: flex;
	align-items: center;
	flex-direction: column;
	width: 100%;
	padding: 24px;
	gap: 16px;
}

.person__name {
	width: 100%;
	text-align: center;
}

.person__name p {
	text-align: center;
	font-style: normal;
	font-weight: 700;
	font-size: 18px;
	line-height: 24px;
}

.person__desctiption {
	width: 100%;
	text-align: center;
}

.person__desctiption p {
	height: 48px;
	text-align: center;
	font-style: normal;
	font-weight: 500;
	font-size: 18px;
	line-height: 24px;
	text-overflow: ellipsis;
	overflow: hidden;
	color: rgba(255, 255, 255, 0.64);
}

.person__social {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	gap: 16px;
}

.person__social i {
	width: 24px;
	height: 24px;
	background-color: #2C63FF;
	border-radius: 8px;
}

.person__social img {
	width: 16px;
	margin: 4px;
}

.partener {
	margin-bottom: 100px;
}

.partener__wrapper {
	width: 100%;
}

.partener__list {
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	padding: 42px 24px;
	width: 100%;
	display: grid;
	gap: 24px;
	grid-template-columns:  repeat(auto-fit, minmax(120px, 1fr));
}

.partener__logo {
	height: 48px;
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.partener__logo img {
}

.features {
	margin-bottom: 100px;
}

.features__wrapper {
	display: flex;
	flex-direction: column;
	align-items: center;
	width: 100%;
	gap: 48px;
}

.features__head {
	width: 100%;
	display: flex;
	align-items: center;
}

.features__list {
	display: grid;
	grid-template-columns:  repeat(auto-fit, minmax(300px, 1fr));
	width: 100%;
	gap: 24px;
}

.features__item {
	display: flex;
	flex-direction: column;
	flex-wrap: wrap;
	padding: 24px;
	border-radius: 24px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
}


.features__icon {
	width: 148px;
	height: 148px;
	border-radius: 24px;
	margin-bottom: 24px;
	position: relative;
}

.features__icon img {
	object-fit: cover;
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
}

.features__title {
	margin-bottom: 8px;
}

.features__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 24px;
	line-height: 32px;
	text-overflow: ellipsis;
	overflow: hidden;
	white-space: nowrap;
}

.features__description {
}

.features__description p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

.roadmap {
	margin-bottom: 100px;
}

.roadmap__wrapper {
	display: flex;
	flex-direction: column;
	width: 100%;
}

.roadmap__header {
	display: flex;
	width: 100%;
	justify-content: space-between;
	flex-wrap: wrap;
}

.roadmap__image {
	position: absolute;
	width: min-content;
	right: 0;
}

.roadmap__image img {
	position: relative;
	z-index: 2;
	max-width: unset!important;
}

.roadmap__object {
	bottom: 0;
	right: 0;
}

.roadmap__head {
	display: flex;
	width: 100%;
	margin-bottom: 30px;
	position: relative;
	z-index: 3;
}

.roadmap__list {
	display: flex;
	width: 100%;
	flex-direction: column;
	gap: 24px;
	position: relative;
	z-index: 3
}

.roadmap__row {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	flex-wrap: wrap;
	padding: 10px 40px;
	min-height: 270px;
}

.roadmap__row-revers {
	flex-wrap: wrap-reverse;
}

.roadmap__col {
	display: flex;
	height: 100%;
	width: 50%;
	min-width: 500px;
	gap: 24px;
}

.roadmap__top-left {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
}

.roadmap__top-right {
	display: flex;
	align-items: flex-start;
	justify-content: flex-end;
}

.roadmap__bottom-left {
	display: flex;
	align-items: flex-end;
	justify-content: flex-start;
}

.roadmap__bottom-right {
	display: flex;
	align-items: flex-end;
	justify-content: flex-end;
}

.roadmap__center {
	display: flex;
	align-items: center;
	justify-content: center;
}

.roadmap__item {
}

.road-item {
	display: flex;
	align-items: center;
	justify-content: center;
	max-width: 580px;
	position: relative;
	width: 100%;
	gap: 32px;
	flex-wrap: wrap;
}

.road-item__circle {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	border-radius: 50%;
	width: 184px;
	height: 184px;
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.02);
	box-shadow: none;
	backdrop-filter: blur(12px);
	position: relative;
	gap: 8px;
}

.road-item__circle-active {
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(44, 99, 255, 0.24);
	box-shadow: inset 0 0 32px rgba(44, 99, 255, 0.84);
}

.road-item__circle-active .road-item__quart p {
	color: #2C63FF;
}

.road-item__circle-active::before {
	content: '';
	width: inherit;
	height: inherit;
	position: absolute;
	left: calc(50% - 184px / 2 + 70px);
	top: calc(50% - 184px / 2);
	background: #2C63FF;
	opacity: 0.64;
	filter: blur(74px);
}

.road-item__quart {
}

.road-item__quart p {
	font-style: normal;
	font-weight: 700;
	font-size: 32px;
	line-height: 40px;
}

.road-item__year {
}

.road-item__year p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

.road-item__content {
	display: flex;
	flex-direction: column;
	flex: 1 1;
	padding: 24px;
	background: rgba(255, 255, 255, 0.02);
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
	border-radius: 24px;
	gap: 8px;
    min-width: 260px;
}

.road-item__title {
}

.road-item__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 24px;
	line-height: 32px;
}

.road-item__description {
	font-style: normal;
	font-weight: 500;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 1200px) {
	.roadmap__row {
		height: auto;
		gap: 24px;
	}

	.roadmap__col {
		width: 100%;
	}
}

@media (max-width: 768px) {
	.roadmap__head {
		margin-bottom: 250px;
	}

	.roadmap__image {
		left: 0;
		margin: auto;
		top: 150px;
	}

	.road-item {
		min-width: 300px;
	}

	.roadmap__col {
		min-width: 300px;
	}
}

.discord {
	position: relative;
	z-index: 2;
	padding: 100px 0;
	margin-bottom: 100px;
	background-size: 100% 100%;
	background: url('../images/discord_background.png') no-repeat bottom;
	background-size: cover;
}

.discord__wrapper {
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 24px;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	width: 100%;
	padding: 80px 24px;
	gap: 48px;
}

.discord__head {
	width: 100%;
	align-items: center;
}

.discord__join {
	width: 100%;
	align-items: center;
	justify-content: center;
	display: flex;
}

.discord__join a {
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 100px;
	font-style: normal;
	font-weight: 600;
	font-size: 18px;
	line-height: 22px;
	color: #FFFFFF;
	border: none;
	height: 62px;
	width: 220px;
	background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
	box-shadow: 0 16px 24px rgba(247, 15, 255, 0.48);
}

.discord__join a span {
	display: flex;
	align-items: center;
	justify-content: center;
	width: calc(100% - 4px);
	height: calc(100% - 4px);
	border-radius: inherit;
	background: #06060C;
	box-shadow: inset 0 8px 16px rgba(44, 99, 255, 0.48);
	gap: 16px;
}

.discord__join img {
	width: 20px;
}

.discord__circle {
	z-index: -1;
	top: -110px;
	left: 34px;
}

.discord__image {
	position: absolute;
	z-index: 3;
	top: -135px;
	left: 120px;
	width: 394px;
	height: 394px;
	border-radius: 24px;
}

.discord__image img {
	width: 100%;
	height: 100%;
	font-size: 0;
}

.faq__wrapper {
	display: flex;
	flex-direction: column;
	justify-content: center;
	gap: 48px;
	width: 100%;
}

.faq__head {
	align-items: center;
}

.accordion__panel {
	display: flex;
	flex-direction: column;
	padding: 24px;
	margin-bottom: 24px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	line-height: 32px;
}

.accordion input {
	display: none;
}

.accordion label {
	display: flex;
	align-items: baseline;
	justify-content: space-between;
	column-gap: 24px;
	padding-block: 7px;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
	color: white;
	transition: color 0.25s;
}

.accordion input:checked + label .close {
	display: block;
}

.accordion input:checked + label .open {
	display: none;
}

.accordion .close {
	display: none;
}

.accordion input:checked ~ .accordion__body {
	height: max-content;
}

.accordion input:checked ~ .accordion__body .accordion__answer {
	opacity: 1;
	transform: scale(1);
}

.accordion__body {
	height: 0;
	overflow: hidden;
	transition: height 0.25s ease-in-out;
}

.accordion__answer {
	padding-top: 5px;
	padding-bottom: 7px;
	opacity: 0;
	transform: scale(0);
	transform-origin: top left;
	transition: opacity 0.75s, transform 0.15s;
	font-size: 16px;
	font-weight: 400;
	line-height: 24px;
}

.footer {
	margin: 140px 0 100px 0;
}

.footer__wrapper {
	display: flex;
	flex-direction: column;
	padding: 48px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 24px;
	gap: 48px;
	width: 100%;
}

.footer__body {
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	flex-wrap: wrap;
	width: 100%;
	gap: 24px;
}

.footer__about {
	display: flex;
	flex-direction: column;
	width: 33%;
	gap: 24px;
}

.footer__logo {
	border-radius: 8px;
}

.footer__description p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

.footer__social {
	display: flex;
	align-items: center;
	gap: 16px;
}

.footer__social-item {
	width: 40px;
	height: 40px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 12px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.footer__social-item img {
	width: 20px;
}

.footer__nav {
	display: flex;
	flex-direction: column;
	gap: 24px;
}

.footer__head {
	margin-bottom: 8px;

}

.footer__head p {
	font-weight: 700;
	font-size: 18px;
	line-height: 22px;
	letter-spacing: 0.08em;
	text-transform: uppercase;
}

.footer__nav-list {
	display: flex;
	flex-direction: column;
	gap: 24px;
}
.footer__nav-list  a {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
	text-decoration: none;
}

.footer__newsletter {
	display: flex;
	flex-direction: column;
	width: 33%;
	gap: 24px;
}

.footer__form {
	display: flex;
	gap: 16px;
}

.footer__form label {
	display: flex;
	flex-grow: 1;
}

.footer__form label input {
	height: 50px;
	display: flex;
	flex-grow: 1;
}

.footer__form button {
	height: 50px;
	width: 135px;
}

.footer .form__submit button span {
	box-shadow: none;
}

.footer .form__submit {
	margin: auto;
	display: flex;
	flex: 1 0;
}

.footer .form__submit button {
	box-shadow: none;
}

.footer__devider {
	width: 100%;
	height: 1px;
	background-color: rgba(255, 255, 255, 0.08);
}

@media (max-width: 992px) {

	.footer__body {
		gap: 48px;
	}

	.footer__about {
		width: 100%;
	}

	.footer__nav {
		width: 100%;
	}

	.footer__newsletter {
		width: 100%;
	}
}

@media (max-width: 768px) {
	.footer__form {
		flex-direction: column;
	}

	.footer__form button {
		width: 100%;
	}
}

.copyright {
	display: flex;
	align-items: center;
	justify-content: space-between;
	width: 100%;
	flex-wrap: wrap-reverse;
	gap: 24px;
}

.copyright__main {
}

.copyright__main p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}

.copyright__nav {
	display: flex;
	align-items: center;
	gap: 48px;
}

.copyright__nav a {
	text-decoration: none;
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
}

@media (max-width: 992px) {
	.copyright {
		align-items: center;
		justify-content: center;
		width: 100%;
	}
}


/*----------------Blog Page------------------*/

.featured_article {
	width: 100%;
	margin-bottom: 100px;
}

.featured_article__wrapper {
	display: grid;
	grid-template-columns:  repeat(auto-fit, minmax(500px, 1fr));
	flex-wrap: wrap-reverse;
	gap: 42px;
}

.featured_article__image {
	position: relative;
	padding: 0 0 68% 0;
}

.featured_article__image img {
	object-fit: cover;
	top: 0;
	left: 0;
	position: absolute;
	border-radius: 24px!important;
	font-size: 0;
	width: 100%;
}

.featured_article__content {
	display: flex;
	flex-direction: column;
	padding: 24px;
	gap: 24px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
}

.featured_article__head {
	display: flex;
	align-items: center;
	justify-content: space-between;
	width: 100%;
}

.featured_article__tags {
	display: flex;
	align-items: center;
	gap: 8px;
}

.featured_article__tag {
	padding: 8px 16px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 50px;
}

.featured_article__tag p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
}

.featured_article__date {
}

.featured_article__date p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}

.featured_article__body {
	display: flex;
	flex-direction: column;
	width: 100%;
	gap: 16px;
}

.featured_article__title {
}

.featured_article__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 40px;
	line-height: 48px;
}

.featured_article__text {
}

.featured_article__text p {
	font-style: normal;
	font-weight: 500;
	font-size: 20px;
	line-height: 36px;
	color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 768px) {
	.featured_article__wrapper {
		grid-template-columns:  repeat(auto-fit, minmax(350px, 1fr))
	}
}

@media (max-width: 480px) {
	.featured_article__wrapper {
		grid-template-columns:  repeat(auto-fit, minmax(250px, 1fr))
	}
}


/*------------Contact Page-----------------*/

.help {
	margin-bottom: 100px;
}

.help__wrapper {
	display: flex;
	flex-direction: column;
	align-items: center;
	width: 100%;
	gap: 48px;
}

.help__head {
	width: 100%;
	display: flex;
	align-items: center;
}

.help__list {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
	width: 100%;
	gap: 24px;
}

.help__item {
	display: flex;
	flex-direction: column;
	flex-wrap: wrap;
	padding: 24px;
	border-radius: 24px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	backdrop-filter: blur(12px);
}

.help__icon {
	width: 148px;
	height: 148px;
	border-radius: 24px;
	background-color: #7b7474;
	margin-bottom: 24px;
}

.help__icon i {
}

.help__title {
	margin-bottom: 8px;
}

.help__title p {
	font-style: normal;
	font-weight: 700;
	font-size: 24px;
	line-height: 32px;
	text-overflow: ellipsis;
	overflow: hidden;
	white-space: nowrap;
}

.help__description {
}

.help__description p {
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

/*-------------POST_PAGE---------------*/
.page_container {
	width: 100%;
	margin-bottom: 48px;
}
.post_heading {
	margin-top: 156px;
    width: 100%;
    height: 200px;
    margin-bottom: 48px;
}
.post_heading.with_image {
	height: 500px;
}

.post__wrapper {
	width: 100%;
	height: 100%;
	position: relative;
	border-radius: 24px;
}
.post_heading.with_image .post__image {
	padding: 0 0 34.7% 0;
}
.post__image {
	width: 100%;
	position: relative;
	border-radius: 24px;
	background: rgba(255, 255, 255, 0.02);;
	padding: 0 0 13.7% 0;
}

.post__image img {
	top: 0;
	left: 0;
	width: 100%;
	border-radius: 24px;
	height: 100%;
	position: absolute;
	object-fit: cover;
	font-size: 0;
}

.post__content {
	position: absolute;
	width: 100%;
	height: 100%;
	padding: 32px;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: space-between;
	top: 0;
}

.post__top {
	display: flex;
	align-items: center;
	justify-content: space-between;
	width: 100%;
}

.post__tags {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
	max-height: 85px;
	overflow: hidden;
}

.post__tag {
	padding: 8px 16px;
	background: rgba(255, 255, 255, 0.02);
	backdrop-filter: blur(12px);
	border-radius: 16px;
}

.post__tag p {
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
}

.post__date {
}

.post__date p {
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}

.post__info {
	display: flex;
	width: 100%;
}

.post__title {
	width: 100%;
}

.post__title p {
	font-weight: 700;
	font-size: 40px;
	line-height: 48px;
	overflow: hidden;
	width: 100%;
	text-overflow: ellipsis;
}

.post-main {
	width: 100%;
}

.post-main__wrapper {
	display: flex;
	gap: 48px;
	flex-wrap: wrap;
	width: 100%;
}

.post-main__content {
	display: flex;
	flex: 1 0 calc(100% - 368px);
	min-width: 400px;
	flex-direction: column;
}

.post-main__article {
	width: 100%;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	padding: 32px;
	margin-bottom: 48px;
}
.post-main__article .story p {
	margin-bottom: 24px;
}
.post-main__article p {
	font-weight: 500;
	font-size: 16px;
	line-height: 32px;
	color: rgba(255, 255, 255, 0.8);
}

.post-main__divider {
	width: 100%;
	height: 1px;
	background: rgba(255, 255, 255, 0.08);
	margin: 32px 0;
}
.post-main__comments .post-main__divider {
	margin: 8px 0;
}
.comment-respond .head__title small {
	font-size: 14px;
	font-weight: 400;
}
.post-main__tags {
	width: 100%;
	display: flex;
	align-items: center;
	flex-wrap: wrap;
	gap: 8px;
}

.post-main__tags a {
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	padding: 16px 32px;
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
	color: rgba(255, 255, 255, 0.8);
	transition:all 300ms ease;
}
.post-main__tags a:hover {
	background:#2C63FF;
	border-color:#2C63FF;
	transition:all 300ms ease;
}

.post-main__actions {
	width: 100%;
	display: flex;
	align-items: center;
	margin-bottom: 48px;
	gap: 48px;
}

.post-main__prev {
	display: flex;
	flex-grow: 1;
}

.post-main__prev a {
	width: 100%;
	font-weight: 600;
	font-size: 18px;
	line-height: 22px;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 48px 0;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	position: relative;	
	transition:all 300ms ease;
}
.post-main__prev a:hover {
	border-color:#2C63FF;
	transition:all 300ms ease;
}
.post-main__prev a::before {
	content:"";
	width: 24px;
	height: 25px;
	background: url('../images/arrow-right.svg') center center no-repeat;
	margin-right: 10px;
	transform: rotate(180deg);
}
.post-main__next {
	display: flex;
	flex-grow: 1;
}

.post-main__next a {
	width: 100%;
	font-weight: 600;
	font-size: 18px;
	line-height: 22px;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 48px 0;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	position: relative;
	transition:all 300ms ease;
}
.post-main__next a:hover {
	border-color:#2C63FF;
	transition:all 300ms ease;
}
.post-main__next a::after {
	content:"";
	width: 24px;
	height: 25px;
	background: url('../images/arrow-right.svg') center center no-repeat;
	margin-left: 10px;
}

.post-main__comments {
}
.comment.depth-2 {
	margin-top: 24px;
}
.comments {
	display: flex;
	width: 100%;
	flex-direction: column;
	gap: 32px;
}

.comments__head {
	display: flex;
	align-items: center;
	width: 100%;
	gap: 24px;
}


.comments__title p {
	font-weight: 700;
	font-size: 48px;
	line-height: 56px;
}

.comments__count p {
	font-weight: 700;
	font-size: 48px;
	line-height: 56px;
	color: rgba(255, 255, 255, 0.08);
}

.comments__list {
	display: flex;
	width: 100%;
}

.comments__main {
	display: flex;
	flex-direction: column;
	width: 100%;
	gap: 24px;
}

.comments__item {
	padding: 32px;
	gap: 32px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	display: flex;
	width: 100%;
}

.comments__avatar {
	width: 80px;
	min-width: 80px;
	height: 80px;
	border-radius: 24px;
	background: #d8d8d8;
}
.comments__avatar img {
	border-radius: 24px;
}

.comments__body {
	display: flex;
	flex-grow: 1;
	flex-direction: column;
	gap: 24px;
	max-width: calc(100% - 144px);
}

.comments__top {
	display: flex;
	align-items: center;
	justify-content: space-between;
	width: 100%;
}

.comments__name {
}

.comments__name p {
	font-weight: 700;
	font-size: 18px;
	line-height: 24px;
}

.comments__date {
}

.comments__date p {
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
}

.comments__text {
}

.comments__text p {
	font-weight: 600;
	font-size: 16px;
	line-height: 24px;
	color: rgba(255, 255, 255, 0.8);
}

.comments__footer {
}

.comments__replay {
}

.comments__replay a {
	font-weight: 600;
	font-size: 18px;
	line-height: 22px;
}

.comments__item_reply {
	margin-left: 15%;
	width: auto;
	flex-grow: 1;
}

.post-main__replay {
}

.replay {
}

.replay__head {
}

.replay__form {
	margin: 32px 0;
	padding: 32px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
}

.post-main__sidebar {
}

.sidebar {
	width: 320px;
}

.sidebar__block {
	padding: 24px;
	gap: 24px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
	display: flex;
	flex-direction: column;
}

.sidebar__title {
	width: 100%;
}

.sidebar__title p {
	font-weight: 700;
	font-size: 18px;
	line-height: 22px;
	letter-spacing: 0.08em;
	text-transform: uppercase;
}
.sidebar__block .wp-block-group__inner-container h2 {
	font-weight: 700;
	font-size: 18px;
	line-height: 22px;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	margin-bottom: 24px;
}

.sidebar__body {
	display: flex;
	width: 100%;
}

.sidebar__list {
	display: flex;
	width: 100%;
	flex-direction: column;
	gap: 24px;
}

.sidebar__list_item {
	display: flex;
	width: 100%;
	align-items: center;
	justify-content: space-between;
}

.sidebar__list_title {
	flex-grow: 1;
}

.sidebar__list_title p {
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
	width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
}

.sidebar__list_count {
	padding: 4px 8px;
	background: #2C63FF;
	border-radius: 12px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.sidebar__list_count p {
	font-weight: 600;
	font-size: 12px;
	line-height: 16px;
}

.sidebar__tags {
	display: flex;
	width: 100%;
	flex-wrap: wrap;
	gap: 8px;
}

.sidebar__tag {
	padding: 16px 32px;
	border: 1px solid rgba(255, 255, 255, 0.08);
	border-radius: 24px;
}

.sidebar__tag p {
	font-weight: 600;
	font-size: 16px;
	line-height: 19px;
	color: rgba(255, 255, 255, 0.8);
}
</style>
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