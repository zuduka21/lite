<?php $text = nl2br($block->info) ?>

<h2><?php echo $block->name ?></h2>

<?php if ($block->info != ''): ?>
    <p><?php echo $text ?></p>
<?php endif ?>
