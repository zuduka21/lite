<?php ob_start() ?>
<?php $article = $item ?>
<?php $global_photos = $A->getArticlePhotos($article->id) ?>
<header>
    <h1><?php echo $article->name ?></h1>
    <?php if ($article->cover != '' && $article->blocks[0]->type != 9): ?>
        <?php $caption = isset($global_photos["{$article->id}_0"]) ? $global_photos["{$article->id}_0"]->source : '' ?>
        <figure><img src="<?php echo $article->cover_l ?>"><?php if ($caption != ""): ?><figcaption>Фото: <?php echo $caption ?></figcaption><?php endif ?></figure>
    <?php endif ?>
</header>
<div>
    <?php $photos = 0 ?>
    <?php foreach ($article->blocks as $block): ?>

        <?php if ($block->type == 1) include __DIR__ . "/../blocks/turbo_block_type_h2.php" ?>
        <?php if ($block->type == 6) include __DIR__ . "/../blocks/turbo_block_type_h3.php" ?>
        <?php if ($block->type == 2) include __DIR__ . "/../blocks/turbo_block_type_text.php" ?>
        <?php if ($block->type == 3 && $photos < 99) include __DIR__ . "/../blocks/turbo_block_type_photo.php" ?>
        <?php if ($block->type == 3) $photos ++ ?>
        <?php if ($block->type == 4) include __DIR__ . "/../blocks/turbo_block_type_video.php" ?>
        <?php if ($block->type == 7) include __DIR__ . "/../blocks/turbo_block_type_product.php" ?>
        <?php if ($block->type == 9) include __DIR__ . "/../blocks/turbo_block_type_article.php" ?>

    <?php endforeach ?>
        
</div>
<div data-block="share" data-network="facebook, vkontakte, twitter, odnoklassniki, telegram"></div>
<footer></footer>

<?php $content = ob_get_contents() ?>
<?php $content = "{$content}" ?>
<?php $content = updateImageSizes($content, (isset($article) ? $article->id : 0)); ?>
<?php $content = updateImageCaption($content, (isset($article) ? $article->id : 0)); ?>
<?php $content = insertRelativeLinks($content, (isset($article) ? $article->id : 0), 'turbo'); ?>
<?php ob_end_clean () ?>
<?php echo $content ?>
