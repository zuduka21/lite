<!DOCTYPE html>
<html ⚡ lang="ru">
<?php $article = getArticle() ?>
<?php $related_articles = getRelatedArticles($article->id) ?>
<?php $parent_cat = $A->getCategory($article->category->parent_id) ?>
<head>
    <meta charset="UTF-8">
    <title><?php echo $article->meta_title ?></title>
    <meta name="description" content="<?php echo $article->meta_description ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="<?php echo $article->author ?>">
    <meta name="copyright" content="LAFOY.RU">
    <meta name="google" content="notranslate">

    <link rel="preload" href="<?php echo $article->cover_s ?>" as="image"/>
    <style amp-custom>
      <?php
      include __DIR__ . "/../../css/amp/style.css";
      include __DIR__ . "/../../css/amp/post.css";
      ?>
    </style>

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
    <meta property="og:image" content="<?php echo $article->cover_l ?>">
    <meta property="og:type" content="article">

    <!--[if lt IE 8]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please upgrade your browser.</p>
    <![endif]-->
    <script async="" src="https://cdn.ampproject.org/v0.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async custom-element="amp-form" src = "https://cdn.ampproject.org/v0/amp-form-0.1.js"> </script>
    <script async custom-element="amp-script" src="https://cdn.ampproject.org/v0/amp-script-0.1.js"></script>
    <script async custom-element="amp-list" src="https://cdn.ampproject.org/v0/amp-list-0.1.js"></script>
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
</head>

<body<?php echo ($global_site_is_dev === true ? ' class="is_dev"' : '');?>>
  <amp-auto-ads type="adsense" data-ad-client="ca-pub-7129845194257634"></amp-auto-ads>
  <amp-script src="<?php echo getURL('js/amp/common.js') ?>">
    <div class="page post">
      
        <?php include __DIR__ . "/../../blocks/amp/header.php" ?>

        <?php 

        $cur_title = $article->meta_title;
        include __DIR__ . "/../../blocks/amp/analitycs.php"; 

        ?>

        <div class="contentBlock<?php echo ($article->is_yandex ? ' yandex_only' : '')?>" data-sticky-container>
            <div class="container contentBlock__container">
                <div class="contentBlock__wrapper">
                    <section class="post contentBlock__content" itemscope itemtype="http://schema.org/Article">
                        <h1 class="post__mainTitle" itemprop="headline"><?php echo $article->name ?></h1>

                        <div class="postInforamtion post__inforamtion">
                            <?php $article->category->url = str_replace($article->category->_url, 'amp/'.$article->category->_url, $article->category->url); ?>
                            <span class="postInforamtion__type"><a href="<?php echo $article->category->url ?>" class="postInforamtion__link"><?php echo $article->category->name ?></a></span>

                            <span class="postInforamtion__date"><?php echo date("d.m.Y", $article->date) ?></span>

                            <span class="postInforamtion__author"><?php echo $article->author ?></span>
                        </div>

                        <meta itemprop="image" content="<?php echo $article->cover_l ?>" />
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

                        <div itemprop="articleBody">
                            <?php if ($article->cover != '' && (int)$article->blocks[0]->type !== 9): ?>
                                <div class="post__wrapperImg" data-caption="">
                                    <amp-img src="<?php echo $article->cover_l ?>" title="<?php echo $article->name ?>" alt="<?php echo $article->name ?>" class="post__img" layout="responsive"></amp-img>
                                </div>
                            <?php endif ?>

                            <?php foreach ($article->blocks as $block): ?>
                                <?php
                                    //$block->info = setSizesForHtmlStr($block->info);
                                ?>
                                <?php $block->info = post_nofollow($block->info); ?>
                                <?php if ($block->type == 1) include __DIR__ . "/../../blocks/amp/post_block_type_h2.php" ?>
                                <?php if ($block->type == 6) include __DIR__ . "/../../blocks/amp/post_block_type_h3.php" ?>
                                <?php if ($block->type == 2) include __DIR__ . "/../../blocks/amp/post_block_type_text.php" ?>
                                <?php if ($block->type == 3) include __DIR__ . "/../../blocks/amp/post_block_type_photo.php" ?>
                                <?php if ($block->type == 4) include __DIR__ . "/../../blocks/amp/post_block_type_video.php" ?>
                                <?php //if ($block->type == 5) include __DIR__ . "/../../blocks/amp/post_block_type_ads.php" ?>
                                <?php if ($block->type == 7) include __DIR__ . "/../../blocks/amp/post_block_type_product.php" ?>
                                <?php if ($block->type == 8) include __DIR__ . "/../../blocks/amp/post_block_type_instagram.php" ?>
                                <?php if ($block->type == 9) include __DIR__ . "/../../blocks/amp/post_block_type_article.php" ?>

                            <?php endforeach ?>

                                                        
                        </div>

                        <?php //include __DIR__ . "/../../blocks/amp/post_block_type_ads.php" ?>

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
                            <?php if ($block->type == 20) include __DIR__ . "/../../blocks/amp/post_block_type_microdata_howto.php" ?>
                            <?php if ($block->type == 21) include __DIR__ . "/../../blocks/amp/post_block_type_microdata_recipe.php" ?>
                        <?php endforeach ?>
                        <?php include __DIR__ . "/../../blocks/amp/post__repost.php" ?>

                        <?php //include __DIR__ . "/../../blocks/amp/post__comments.php" ?>

                        <?php //include __DIR__ . "/../../blocks/amp/post__more.php" ?>

                        
                    </section>
                      
                    <amp-list id="recipesAscList" height="800" width="1280" layout="responsive" src="//<?php echo $_SERVER['SERVER_NAME']?>/index.php?type=post_related&amp=1&id=<?php echo $related_articles[0]->id ?>&except=<?php echo $article->id?>" binding="refresh" load-more="auto">
                      <template type="amp-mustache">
                          {{{desc}}}
                      </template>
                    </amp-list>
                </div>
            </div>
        </div>

        <?php include __DIR__ . "/../../blocks/amp/footer.php" ?>

    </div>


  <?php include __DIR__ . "/../../blocks/amp/modalSearch.php" ?>
  <?php include __DIR__ . "/../../blocks/amp/modalMobileMenu.php" ?>
  </amp-script>

  

</body>

</html>
