<?php
    $respArray = array(
        'items' => array(
        )
    );
    $related_articles = getRelatedArticles($article->id);
    $parent_cat = $A->getCategory($article->category->parent_id);
    ob_start();
?>
<section class="post contentBlock__content contentBlock__content_related" itemscope itemtype="http://schema.org/Article">
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
    <?php if ($parent_cat): ?>
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
                <amp-img layout="responsive" src="<?php echo $article->cover_l ?>" title="<?php echo $article->name ?>" alt="<?php echo $article->name ?>" class="post__img" ></amp-img>
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
            <?php //if ($block->type == 4) include __DIR__ . "/../../blocks/amp/post_block_type_video.php" ?>
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
<?php
$respArray['items'][0]['desc'] = ob_get_contents();
$respArray['items'][0]['desc'] = updateImageSizes($respArray['items'][0]['desc'], $article->id);
ob_end_clean();

$exceptArticleIdsArray = explode(',', $_GET['except']);

$nextArticleId = '';
foreach ($related_articles as $related_article) {
    if(!in_array($related_article->id, $exceptArticleIdsArray))
    {
        $nextArticleId = $related_article->id;
    }
}
$exceptArticleIdsArray[] = $nextArticleId;
$exceptArticleIds = implode(',', $exceptArticleIdsArray);

$respArray['load-more-src'] = '//'.$_SERVER['SERVER_NAME'].'/index.php?type=post_related&amp=1&id='.$nextArticleId.'&except='.$exceptArticleIds;

?>
<?=json_encode($respArray)?>