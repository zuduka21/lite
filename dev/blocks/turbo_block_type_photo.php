<?php $caption = $block->info != '' ? $block->info : (isset($global_photos["{$article->id}_{$block->id}"]) ? $global_photos["{$article->id}_{$block->id}"]->source : '') ?>
<?php if ($block->photo != ''): ?>
<figure>
    <img src="<?php echo $block->photo_l ?>">
    <?php if ($caption != ""): ?><figcaption>Фото: <?php echo $caption ?></figcaption><?php endif ?>
</figure>
<?php endif ?>