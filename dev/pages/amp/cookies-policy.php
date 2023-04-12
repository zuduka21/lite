<?php require_once "../../functions.php"; ?>
<!DOCTYPE html>
<html ⚡ lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Политика использования файлов cookie</title>
    <meta name="description" content="Политика использования файлов cookie">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="<?php echo $global_site_name ?>">
    <meta name="copyright" content="<?php echo $global_site_name ?>">
    <link rel="canonical" href="<?php echo getURL() ?>/cookies-policy" />

    <style amp-custom>
      <?php
      include __DIR__ . "/../../css/amp/style.css";
      include __DIR__ . "/../../css/amp/static_page.css";
      ?>
    </style>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/x-icon" href="<?php echo getURL('favicon.ico') ?>">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta property="og:title" content="<?php echo $global_site_name ?>">
    <meta property="og:image" content="<?php echo getURL('/main_logo.png') ?>">

    <!--[if lt IE 8]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please upgrade your browser.</p>
    <![endif]-->
    <script async="" src="https://cdn.ampproject.org/v0.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async custom-element = "amp-form" src = "https://cdn.ampproject.org/v0/amp-form-0.1.js"> </script>
    <script async custom-element="amp-script" src="https://cdn.ampproject.org/v0/amp-script-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
</head>

<body<?php echo ($global_site_is_dev === true ? ' class="is_dev"' : '');?>>
    <amp-script src="<?php echo getURL('js/amp/common.js') ?>">
        <div class="page">
            <?php include __DIR__ . "/../../blocks/amp/header.php" ?>
            <?php 

            $cur_title = $global_site_name;
            include __DIR__ . "/../../blocks/amp/analitycs.php"; 

            ?>

            <?php include_once __DIR__ . "/../../blocks/amp/static_cookies_policy__block.php" ?>

            <?php include_once __DIR__ . "/../../blocks/amp/footer.php" ?>

            <div class="btn btn--radius btnToUp">
                <div class="icon icon--arrowTop"></div>
            </div>
        </div>

        <?php include_once __DIR__ . "/../../blocks/amp/modalSearch.php" ?>
        <?php include_once __DIR__ . "/../../blocks/amp/modalMobileMenu.php" ?>

    </amp-script>
</body>

</html>
<?php die() ?>