<?php $text = nl2br($block->info) ?>
<?php $text = str_replace("\n", "", $text) ?>
<?php $text = str_replace("\r", "", $text) ?>
<?php $text = str_replace("<br /><br />", "</p><div class='dayg'></div><p class='post__text'>", $text) ?>

<h3 class="post__secondaryTitle"><?php echo $block->name ?></h3>
<div class="dayg"></div>

<?php if ($block->info != ''): ?>
    <p class="post__text"><?php echo $text ?></p>
<?php endif ?>
