<h2 class="post__title"><?php echo $block->name ?></h2>

<?php if ($block->photo != ''): ?>
    <div class="post__wrapperImg" data-caption="">
        <img src="<?php echo $block->photo ?>" title="<?php echo $block->name ?>" alt="<?php echo $block->name ?>" class="post__img">
    </div>
<?php endif ?>

          
<?php if ($block->info != ''): ?>
    <p class="post__text"><?php echo nl2br($block->info) ?></p>
<?php endif ?>

<?php if ($block->url != ''): ?>
    <?php $url = "https://alitems.com/g/1e8d1144942e3b32a9d316525dc3e8/?ulp=" . urlencode($block->url) . "&subid={$article->id}&subid1={$block->id}"  ?>
    <p class="post__text product_text"><a class="product_button" href="/prod.php?q=<?php echo base64_encode($url) ?>" rel="nofollow, noopener, noreferrer" target="_blank">Купить</a></p>
<?php endif ?>
