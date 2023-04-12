<?php if ($block->name != ''): ?>
    <h2 class="post__title"><?php echo $block->name ?></h2>
<?php endif ?>

<?php if ($block->info != ''): ?>
    <iframe style="margin-bottom:20px;" title="YouTube video player" class="youtube-player" type="text/html"  data-src="<?php echo str_replace("watch?v=", "embed/", $block->info) ?>" frameborder="0" allowFullScreen allow="autoplay; fullscreen"></iframe>
<?php endif ?>

