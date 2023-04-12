<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo getCurrentPage() == 1 ? ($global_site_name . " - " . $global_meta_title) : getCurrentPage() . " страница - " . $global_site_name ?></title>
    <meta name="description" content="<?php echo getCurrentPage() == 1 ? $global_meta_description : getCurrentPage() . " страница - " . $global_meta_description ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="robots" content="max-image-preview:large" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LAFOY.RU">
    <meta name="copyright" content="LAFOY.RU">
    <meta name="google" content="notranslate">
    <meta name="generator" content="WordPress 5.9.2" />

    <?php

    $ampIndexUrl = getAMPIndex();
    ?>
    <?php if (isAMPEnabled()): ?><link rel="amphtml" href="<?=$ampIndexUrl?>" /><?php endif ?>
    <link rel="canonical" href="<?php echo getURL() ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS <?php echo $global_site_name ?>" href="<?php echo getURL('rss.xml') ?>" />
    <link href="<?php echo getURL('css/style.css') ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo getURL('css/style.css') ?>">
    <link href="<?php echo getURL('css/fonts.css') ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo getURL('css/fonts.css') ?>">
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

          <?php include __DIR__ . "/../blocks/header__specialProject.php" ?>

          <?php if(getCurrentPage() > 1){ ?>
          <a href="<?php echo getURL() ?>" class="logo header__logo">
            <img src="<?php echo getURL('img/logo--black.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img" width="241" height="54">
          </a>
          <?php }else{ ?>
          <span class="logo header__logo">
            <img src="<?php echo getURL('img/logo--black.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img" width="241" height="54">
          </span>
          <?php } ?>


          <?php include __DIR__ . "/../blocks/header__soc.php" ?>

          <span class="btn headerMobileBtnSearch header__mobileBtnSearch">
            <i class="icon icon--bigSearch"></i>
          </span>
        </div>
      </div>

      <div class="header__bottom">
        <div class="container header__container">

          <?php include __DIR__ . "/../blocks/header__menu.php" ?>

          <div class="btn btn--white headerBtnSearch header__btnSearch">
            <i class="icon icon--smallSearch btnSearch__icon"></i>
          </div>
        </div>
      </div>
    </header>
   <?php $articles = $A->getArticles(getCurrentPage(), $global_count_posts_in_category) ?>
    <?php if(!empty($articles)) { ?>
    <div class="contentBlock" data-sticky-container>
      <div class="container contentBlock__container">
        <section class="category contentBlock__wrapper">
          <h1 class="category__title">Полезные советы и идеи</h1>

          <?php for ($_i = 1; $_i <= $global_count_blocks_in_category; $_i++): ?>
          
              <?php if (isset($articles[0 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                  <div class="category__row">
                      <?php $article = $articles[0 + ($_i - 1) * $global_count_posts_in_block] ?>
                      <?php include __DIR__ . "/../blocks/category__post_big.php" ?>
                  </div>
              <?php endif ?> 

              <?php if (isset($articles[1 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                  <div class="category__row">
                      <?php if (isset($articles[1 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                          <?php $article = $articles[1 + ($_i - 1) * $global_count_posts_in_block] ?>
                          <?php include __DIR__ . "/../blocks/category__post_small.php" ?>
                      <?php endif ?> 
                      
                      <?php if (isset($articles[2 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                          <?php $article = $articles[2 + ($_i - 1) * $global_count_posts_in_block] ?>
                          <?php include __DIR__ . "/../blocks/category__post_small.php" ?>
                      <?php endif ?> 
                  </div>
              <?php endif ?> 

              <?php if (isset($articles[3 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                  <div class="category__row">
                      <?php if (isset($articles[3 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                          <?php $article = $articles[3 + ($_i - 1) * $global_count_posts_in_block] ?>
                          <?php include __DIR__ . "/../blocks/category__post_small.php" ?>
                      <?php endif ?> 
                  
                      <?php if (isset($articles[4 + ($_i - 1) * $global_count_posts_in_block])): ?> 
                          <?php $article = $articles[4 + ($_i - 1) * $global_count_posts_in_block] ?>
                          <?php include __DIR__ . "/../blocks/category__post_small.php" ?>
                      <?php endif ?> 
                  </div>
              <?php endif ?> 
          <?php endfor ?> 

          <?php $count = $A->getCountArticles() ?>
          <?php include __DIR__ . "/../blocks/category__pagination.php" ?>

        </section>

        <aside class="sidebar contentBlock__sidebar">

          <?php //include __DIR__ . "/../blocks/sidebar__Banner1.php" ?>

          <?php //include __DIR__ . "/../blocks/sidebar__articles.php" ?>
          
          <?php include __DIR__ . "/../blocks/sidebar__Banner2.php" ?>
          
        </aside>

      </div>
    </div>
    <?php }else{ ?>

        <?php
        http_response_code(404);
        include __DIR__ . "/../blocks/error__block.php" ?>
    <?php } ?>

    <?php include __DIR__ . "/../blocks/footer.php" ?>

    <div class="btn btn--radius btnToUp">
      <div class="icon icon--arrowTop"></div>
    </div>
  </div>

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
