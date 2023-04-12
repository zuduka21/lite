<h2><?php echo $block->name ?></h2>

<?php if ($block->photo != ''): ?><figure><img src="<?php echo $block->photo ?>"></figure><?php endif ?>

<?php if ($block->info != ''): ?><p><?php echo nl2br($block->info) ?></p><?php endif ?>

<?php if ($block->url != ''): ?>
    <?php $url = "https://alitems.com/g/1e8d1144942e3b32a9d316525dc3e8/?ulp=" . urlencode($block->url) . "&subid={$article->id}&subid1={$block->id}"  ?>
    <p><a href="<?php echo $global_site_url ?>/prod.php?q=<?php echo base64_encode($url) ?>" target="_blank">Купить</a></p>
<?php endif ?>
