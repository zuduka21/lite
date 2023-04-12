<!DOCTYPE html>
<html lang="ru">
<?php $article = getArticle() ?>
<?php $related_articles = getRelatedArticles($article->id) ?>
<?php $parent_cat = $A->getCategory($article->category->parent_id) ?>
<head>
    <meta charset="UTF-8">
    <title><?php echo $article->meta_title ?></title>
    <meta name="description" content="<?php echo $article->meta_description ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="robots" content="max-image-preview:large" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="<?php echo $article->author ?>">
    <meta name="copyright" content="LAFOY.RU">
    <meta name="google" content="notranslate">
    <meta name="generator" content="WordPress 5.9.2" />

    <link rel="preload" href="<?php echo $article->cover_s ?>" as="image"/>
    <link href="<?php echo getURL('css/style.css') ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo getURL('css/style.css') ?>">
    <link href="<?php echo getURL('css/fonts.css') ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo getURL('css/fonts.css') ?>">

    <?php
      $ampUrl = str_replace($article->_url, 'amp/' . $article->_url, $article->url);
    ?>
    <?php if (isAMPEnabled()): ?><link rel="amphtml" href="<?php echo $ampUrl ?>" /><?php endif ?>
    <link rel="canonical" href="<?php echo $article->url ?>"/>
    <link rel="alternate" type="application/rss+xml" title="RSS <?php echo $global_site_name ?>" href="<?php echo getURL('rss.xml') ?>" />

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

    <meta property="og:url" content="<?php echo $article->url ?>">
    <meta property="og:title" content="<?php echo $article->meta_title ?>">
    <meta property="og:description" content="<?php echo $article->meta_description ?>">
    <meta property="og:image" content="<?php echo $article->cover_b ?>">
    <meta property="og:type" content="article">

    <!--[if lt IE 8]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please upgrade your browser.</p>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>body {} .post__wrapperImg {background-image: url(/img/pbg.png)}</style>

    <script type="application/ld+json">
    {
     "@context": "http://schema.org",
     "@type": "BreadcrumbList",
     "itemListElement":
     [
      {
       "@type": "ListItem",
       "position": 1,
       "item":
       {
        "@id": "<?php echo getURL() ?>",
        "url": "<?php echo getURL() ?>",
        "name": "Главная"
        }
      },
      <?php if($parent_cat): ?>
      {
      "@type": "ListItem",
      "position": 2,
      "item":
       {
         "@id": "<?php echo $parent_cat->url ?>",
         "url": "<?php echo $parent_cat->url ?>",
         "name": "<?php echo $parent_cat->name ?>"
       }
      },
      <?php endif; ?>
      {
      "@type": "ListItem",
      "position": <?=$parent_cat ? 3 : 2?>,
      "item":
       {
         "@id": "<?php echo $article->category->url ?>",
         "url": "<?php echo $article->category->url ?>",
         "name": "<?php echo $article->category->name ?>"
       }
      },
      {
       "@type": "ListItem",
      "position": <?=$parent_cat ? 4 : 3?>,
      "item":
       {
         "@id": "<?php echo $article->url ?>",
         "url": "<?php echo $article->url ?>",
         "name": "<?php echo $article->name ?>"
       }
      }
     ]
    }
    </script>

    <script> window.article_id || (window.article_id = <?php echo $article->id ?>); </script>    
</head>

<body<?php echo ($global_site_is_dev === true ? ' class="is_dev"' : '');?>>
<div class="page post">
    <header class="header">
        <div class="header__top">
            <div class="container header__container">
          <span class="btn headerMobileBtnMenu header__mobileBtnMenu">
            <i class="icon icon--hamburger"></i>
          </span>

                <?php include __DIR__ . "/../blocks/header__specialProject.php" ?>

                <a href="<?php echo getURL() ?>" class="logo header__logo" title="">
                    <img src="<?php echo getURL('img/logo--black.png') ?>" alt="LAFOY - Полезные советы и идеи для жизни" title="LAFOY - Полезные советы и идеи для жизни" class="logo__img" width="241" height="54">
                </a>

                <?php include __DIR__ . "/../blocks/header__soc.php" ?>

                <span class="btn headerMobileBtnSearch header__mobileBtnSearch">
            <i class="icon icon--bigSearch"></i>
          </span>
            </div>
        </div>

        <div class="header__bottom" style='background-image: url(<?php echo getURL('img/header__bottomBg.png') ?>);background-repeat: repeat-x;'>
            <div class="container header__container">

                <?php include __DIR__ . "/../blocks/header__menu.php" ?>

                <div class="btn btn--white headerBtnSearch header__btnSearch">
                    <i class="icon icon--smallSearch btnSearch__icon"></i>
                </div>
            </div>
        </div>
    </header>

    <?php //include __DIR__ . "/../blocks/post__mobileBanner_top.php" ?>

    <div class="contentBlock<?php echo ($article->is_yandex ? ' yandex_only' : '')?>" data-sticky-container>
        <div class="container contentBlock__container">
            <div class="contentBlock__wrapper">
                <section class="post contentBlock__content" itemscope itemtype="http://schema.org/Article">
                    <h1 class="post__mainTitle" itemprop="headline"><?php echo $article->name ?></h1>

                    <div class="postInforamtion post__inforamtion">
                        <span class="postInforamtion__type"><a href="<?php echo $article->category->url ?>" class="postInforamtion__link"><?php echo $article->category->name ?></a></span>

                        <span class="postInforamtion__date"><?php echo date("d.m.Y", $article->date) ?></span>

                        <span class="postInforamtion__author"><?php echo $article->author ?></span>
                    </div>

                    <meta itemprop="image" content="<?php echo $article->cover_b ?>" />
                    <meta itemprop="name" content="<?php echo $article->meta_title ?>" />
                    <meta itemprop="description" content="<?php echo $article->meta_description ?>" />
                    <?php if($parent_cat): ?>
                        <meta itemprop="articleSection" content="<?=$parent_cat->name?>"/>
                    <?php endif; ?>
                    <meta itemprop="articleSection" content="<?php echo $article->category->name ?>"/>
                    <meta itemprop="identifier" content="<?php echo $article->id ?>"/>
                    <meta itemprop="dateModified" content="<?php echo date(DateTime::ISO8601, $article->date) ?>" />
                    <meta itemprop="datePublished" content="<?php echo date(DateTime::ISO8601, $article->date) ?>" />
                    <link itemprop="url" href="<?php echo $article->url ?>" />
                    <meta itemprop="mainEntityOfPage" content="<?php echo $article->url ?>" />

                    <?php $global_photos = $A->getArticlePhotos($article->id) ?>
                    <?php //print_r ($global_photos); die() ?>
                    <div itemprop="articleBody">
                        <?php if ($article->cover != '' && (int)$article->blocks[0]->type !== 9): ?>
                            <?php $caption = isset($global_photos["{$article->id}_0"]) ? $global_photos["{$article->id}_0"]->source : '' ?>
                            <figure class="post__wrapperImg">
                                <img src="<?php echo $article->cover_s ?>" data-src="<?php echo $article->cover_l ?>" data-src-s="<?php echo $article->cover_s ?>" title="<?php echo $article->name ?>" alt="<?php echo $article->name ?>" class="post__img lazyload">
                                <?php if ($caption != ''): ?><figcaption class="post__imgCaption">© <?php echo $caption ?></figcaption><?php endif ?>
                            </figure>
                        <?php endif ?>

                        <?php foreach ($article->blocks as $block): ?>
                            <?php $block->info = post_nofollow($block->info); ?>
                            <?php if ($block->type == 1) include __DIR__ . "/../blocks/post_block_type_h2.php" ?>
                            <?php if ($block->type == 6) include __DIR__ . "/../blocks/post_block_type_h3.php" ?>
                            <?php if ($block->type == 2) include __DIR__ . "/../blocks/post_block_type_text.php" ?>
                            <?php if ($block->type == 3) include __DIR__ . "/../blocks/post_block_type_photo.php" ?>
                            <?php if ($block->type == 4) include __DIR__ . "/../blocks/post_block_type_video.php" ?>
                            <?php //if ($block->type == 5) include __DIR__ . "/../blocks/post_block_type_ads.php" ?>
                            <?php if ($block->type == 7) include __DIR__ . "/../blocks/post_block_type_product.php" ?>
                            <?php if ($block->type == 8) include __DIR__ . "/../blocks/post_block_type_instagram.php" ?>
                            <?php if ($block->type == 9) include __DIR__ . "/../blocks/post_block_type_article.php" ?>

                        <?php endforeach ?>

                        <div class="mobile_ad"></div>
                    </div>

                    <?php //include __DIR__ . "/../blocks/post_block_type_ads.php" ?>

                    <div itemprop="author" itemscope="" itemtype="http://schema.org/Person">
                        <meta itemprop="name" content="<?php echo $article->author ?>">
                    </div>

                    <div itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization">
                        <meta itemprop="name" content="LAFOY.RU">
                        
                        <link itemprop="url" href="<?php echo $global_site_url ?>" />
                        <link itemprop="sameAs" href="<?php echo $global_soc_vk ?>" />
                        <link itemprop="sameAs" href="<?php echo $global_soc_twitter ?>" />
                        <link itemprop="sameAs" href="<?php echo $global_soc_fb ?>" />
                        <link itemprop="sameAs" href="<?php echo $global_soc_pinterest ?>" />
                        <link itemprop="sameAs" href="https://zen.yandex.ru/lafoy.ru" />
                        
                        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                            <link itemprop="url" href="<?php echo getUrl("/img/logo--black.png") ?>" />
                        </div>
                    </div>
                    <?php foreach ($article->blocks as $block): ?>
                        <?php if ($block->type == 20) include __DIR__ . "/../blocks/post_block_type_microdata_howto.php" ?>
                        <?php if ($block->type == 21) include __DIR__ . "/../blocks/post_block_type_microdata_recipe.php" ?>
                    <?php endforeach ?>
                    <?php include __DIR__ . "/../blocks/post__repost.php" ?>

                    <?php //include __DIR__ . "/../blocks/post__comments.php" ?>

                    <?php //include __DIR__ . "/../blocks/post__more.php" ?>

                </section>
            </div>
            <aside class="sidebar contentBlock__sidebar">

                <?php //include __DIR__ . "/../blocks/sidebar__Banner2.php" ?>

                <?php include __DIR__ . "/../blocks/sidebar__Banner2.php" ?>

            </aside>
        </div>
    </div>

    <?php include __DIR__ . "/../blocks/footer.php" ?>

</div>

<?php include __DIR__ . "/../blocks/modalSearch.php" ?>
<?php include __DIR__ . "/../blocks/modalMobileMenu.php" ?>

<script>
    var related_articles = <?php echo json_encode($related_articles) ?>;
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
