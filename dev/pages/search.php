<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $global_site_name ?></title>
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="copyright" content="">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex">

    <link rel="alternate" type="application/rss+xml" title="RSS <?php echo $global_site_name ?>" href="<?php echo getURL('rss.xml') ?>" />
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
          <!-- /.btn headerMobileBtnMenu header__mobileBtnMenu -->

          <?php include __DIR__ . "/../blocks/header__specialProject.php" ?>

          <a href="<?php echo getURL() ?>" class="logo header__logo" title="">
            <img src="<?php echo getURL('img/logo--black.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img">
          </a>
          <!-- /.logo header__logo -->

          <?php include __DIR__ . "/../blocks/header__soc.php" ?>

          <span class="btn headerMobileBtnSearch header__mobileBtnSearch">
            <i class="icon icon--bigSearch"></i>
          </span>
          <!-- /.btn headerMobileBtnSearch header__mobileBtnSearch -->
        </div>
        <!-- /.container header__container -->
      </div>
      <!-- /.header__top -->

      <div class="header__bottom">
        <div class="container header__container">

          <?php include __DIR__ . "/../blocks/header__menu.php" ?>

          <div class="btn btn--white headerBtnSearch header__btnSearch">
            <i class="icon icon--smallSearch btnSearch__icon"></i>
          </div>
          <!-- /.btn btn--white headerBtnSearch header__btnSearch -->
        </div>
        <!-- /.container header__container -->
      </div>
      <!-- /.header__bottom -->
    </header>
    <!-- /.header -->

    <div class="contentBlock" data-sticky-container>
      <div class="container contentBlock__container">
        <section class="category contentBlock__wrapper">
          <h1 class="category__title">Результаты поиска по '<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>'</h1>

<script>
  (function() {
    var cx = '000844626752157105736:h88ua06b16i';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:searchresults-only></gcse:searchresults-only>

<style>
    .cse .gsc-control-cse, .gsc-control-cse {
        padding:0; width:100%;font-family: "Lafoy-Roboto";
    }
    .gsc-result .gs-title {
        font-size: 1.7rem !important; height: 1.4em;line-height:2rem;
    }
    .gs-webResult .gs-snippet, .gs-imageResult .gs-snippet, .gs-fileFormatType {
        line-height: 2rem; font-size: 1.3rem; font-family: "Lafoy-Roboto";
    }
    .gs-webResult div.gs-visibleUrl-long {
        padding-bottom: 1rem;
    }
    .gs-no-results-result .gs-snippet, .gs-error-result .gs-snippet {
        border: 0;background: transparent;
    }
    
    .category__title {
        line-height: 4.6rem;
    }
</style>
        </section>
        <!-- /.category contentBlock__wrapper -->

        <aside class="sidebar contentBlock__sidebar">

          <?php //include __DIR__ . "/../blocks/sidebar__Banner1.php" ?>

          <?php //include __DIR__ . "/../blocks/sidebar__articles.php" ?>

          <?php include __DIR__ . "/../blocks/sidebar__Banner2.php" ?>
          
        </aside>

      </div>
      <!-- /.container contentBlock__container -->
    </div>
    <!-- /.contentBlock -->

    <?php include __DIR__ . "/../blocks/footer.php" ?>

    <div class="btn btn--radius btnToUp">
      <div class="icon icon--arrowTop"></div>
    </div>
    <!-- /.btn btn--radius btnToUp -->
  </div>
  <!-- /.page -->

  <?php include __DIR__ . "/../blocks/modalSearch.php" ?>
  <?php include __DIR__ . "/../blocks/modalMobileMenu.php" ?>

  <script>
      function _addJS (url) {
          var e = document.createElement("script");
          e.src = url;
          e.async = 1;
          document.head.appendChild(e);
      }
  </script>

  <script src="<?php echo getURL('js/libs.min.js') ?>" onload="_addJS('<?php echo getURL('js/common.js') ?>');"></script>

</body>

</html>
