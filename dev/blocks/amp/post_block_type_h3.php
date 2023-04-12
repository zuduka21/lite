<?php $text = nl2br($block->info) ?>
<?php $text = str_replace("\n", "", $text) ?>
<?php $text = str_replace("\r", "", $text) ?>
<?php $text = str_replace("<br /><br />", "</p><p class='post__text'>", $text) ?>

<h3 class="post__secondaryTitle"><?php echo $block->name ?></h3>

<?php if ($block->info != ''): ?>
    <p class="post__text"><?php echo $text ?></p>
<?php endif ?>
