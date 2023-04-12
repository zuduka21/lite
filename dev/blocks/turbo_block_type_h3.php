<?php $text = nl2br($block->info) ?>

<h3><?php echo $block->name ?></h3>

<?php if ($block->info != ''): ?>
    <p><?php echo $text ?></p>
<?php endif ?>
