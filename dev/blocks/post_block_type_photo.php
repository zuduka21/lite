<?php $caption = $block->info != '' ? $block->info : (isset($global_photos["{$article->id}_{$block->id}"]) ? $global_photos["{$article->id}_{$block->id}"]->source : '') ?>
<?php if ($block->photo != ''): ?>
    <div class="dayg"></div>
    <?php /*<div class="post__wrapperImg<?php if ($block->info != ""): ?> mb<?php endif ?>" itemscope itemtype="http://schema.org/ImageObject" <?php if ($block->info != ""): ?>data-caption="© <?php echo $block->info ?>"<?php endif ?>>*/ ?>
    <figure class="post__wrapperImg" itemscope itemtype="http://schema.org/ImageObject">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo $block->photo_l ?>" data-src-s="<?php echo $block->photo_s ?>" title="<?php echo $block->name ?>" alt="<?php echo $block->name ?>" class="post__img lazyload" data-image="<?php echo $block->id ?>">
        <meta itemprop="name" content="<?php echo $block->name ?>" />
        <link itemprop="contentUrl" href="<?php echo $block->photo_l ?>" />
        <?php if ($caption != ''): ?><figcaption class="post__imgCaption">© <?php echo $caption ?></figcaption><?php endif ?>
    </figure>
    <?php /*</div> */ ?>
    <div class="dayg"></div>
<?php endif ?>