<!DOCTYPE html>
<html ⚡ lang="ru">
<?php $category = getCategory() ?>
<head>
    <meta charset="UTF-8">
    <title><?php echo getCurrentPage() == 1 ? $category->meta_title : getCurrentPage() . " страница - " . $category->meta_title ?></title>
    <meta name="description" content="<?php echo $category->meta_description ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LAFOY.RU">
    <meta name="copyright" content="LAFOY.RU">
    <meta name="google" content="notranslate">

    <link rel="canonical" href="<?php echo $category->url ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS <?php echo $global_site_name ?>" href="<?php echo getURL('rss.xml') ?>" />
    <style amp-custom>
      <?php
      include __DIR__ . "/../../css/amp/style.css";
      include __DIR__ . "/../../css/amp/index.css";
      include __DIR__ . "/../../css/amp/pagination.css";
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

      $cur_title = $category->meta_title;
      include __DIR__ . "/../../blocks/amp/analitycs.php"; 

      ?>
      
      <?php $articles = $A->getArticlesByCategory($category->id, getCurrentPage(), $global_count_posts_in_category) ?>
      <?php if(!empty($articles)):?>
      <div class="contentBlock" data-sticky-container>
        <div class="container contentBlock__container">
          <section class="category contentBlock__wrapper">
            <h1 class="category__title"><?php echo $category->name ?></h1>
           <?php foreach ($articles as $article): ?>
                <?php include __DIR__ . "/../../blocks/amp/category__post_big.php" ?>
            <?php endforeach ?> 

            <?php $count = $A->getCountArticlesByCategory($category->id) ?>
            <?php include __DIR__ . "/../../blocks/amp/category__pagination.php" ?>
          
          </section>

        </div>
      </div>
        <?php else: ?>

        <?php
          http_response_code(404);
          include __DIR__ . "/../../blocks/amp/error__block.php"; ?>
        <?php endif; ?>

        <?php include __DIR__ . "/../../blocks/amp/footer.php" ?>

      <div class="btn btn--radius btnToUp">
        <div class="icon icon--arrowTop"></div>
      </div>
    </div>

    <?php include __DIR__ . "/../../blocks/amp/modalSearch.php" ?>
    <?php include __DIR__ . "/../../blocks/amp/modalMobileMenu.php" ?>
  </amp-script>
</body>

</html>
