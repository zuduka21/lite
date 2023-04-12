<?php http_response_code(404); ?>
<?php require_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница не найдена - LAFOY</title>
    <meta name="description" content="Страница не найдена - ошибка 404">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="<?php echo $global_site_name ?>">
    <meta name="copyright" content="<?php echo $global_site_name ?>">
    <meta name="google" content="notranslate">

    <link href="<?php echo getURL('css/style.css') ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo getURL('css/style.css') ?>">
    <link href="<?php echo getURL('css/fonts.css') ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo getURL('css/fonts.css') ?>">
    <link rel="preload" href="<?php echo getURL('fonts/heuristica-regular_f878d290b83aeb1326bbb08aade50274.woff') ?>" as="font" crossorigin="anonymous" />
    <link rel="preload" href="<?php echo getURL('fonts/hinted-BebasNeue-Light.woff2') ?>" as="font" crossorigin="anonymous" />
    <link rel="preload" href="<?php echo getURL('js/libs.min.js') ?>" as="script"/>
    <link rel="preload" href="<?php echo getURL('js/common.js') ?>" as="script"/>

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
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body<?php echo ($global_site_is_dev === true ? ' class="is_dev"' : '');?>>
<div class="page">
    <header class="header">
        <div class="header__top">
            <div class="container header__container">
          <span class="btn headerMobileBtnMenu header__mobileBtnMenu">
            <i class="icon icon--hamburger"></i>
          </span>

                <?php include_once __DIR__ . "/blocks/header__specialProject.php" ?>

                <a href="<?php echo getURL() ?>" class="logo header__logo" title="">
                    <img src="<?php echo getURL('img/logo--black.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img">
                </a>

                <?php include_once __DIR__ . "/blocks/header__soc.php" ?>

                <span class="btn headerMobileBtnSearch header__mobileBtnSearch">
            <i class="icon icon--bigSearch"></i>
          </span>
            </div>
        </div>

        <div class="header__bottom">
            <div class="container header__container">

                <?php include_once __DIR__ . "/blocks/header__menu.php" ?>

                <div class="btn btn--white headerBtnSearch header__btnSearch">
                    <i class="icon icon--smallSearch btnSearch__icon"></i>
                </div>
            </div>
        </div>
    </header>

    <?php include_once __DIR__ . "/blocks/error__block.php" ?>

    <?php include_once __DIR__ . "/blocks/footer.php" ?>

    <div class="btn btn--radius btnToUp">
        <div class="icon icon--arrowTop"></div>
    </div>
</div>

<?php include_once __DIR__ . "/blocks/modalSearch.php" ?>
<?php include_once __DIR__ . "/blocks/modalMobileMenu.php" ?>

<script>
    function _addJS (url) {
        var e = document.createElement("script");
        e.src = url;
        e.async = 1;
        document.body.appendChild(e);
    }
</script>
<script src="<?php echo getURL('js/libs.min.js') ?>" onload="_addJS('<?php echo getURL('js/common.js') ?>');"></script>

</body>

</html>
<?php die() ?>