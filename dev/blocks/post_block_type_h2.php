<?php $text = nl2br($block->info) ?>
<?php $text = str_replace("\n", "", $text) ?>
<?php $text = str_replace("\r", "", $text) ?>
<?php $text = str_replace("<br /><br />", "</p><div class='dayg'></div><p class='post__text'>", $text) ?>

<h2 class="post__title"><?php echo $block->name ?></h2>
<div class="dayg"></div>

<?php if ($block->info != ''): ?>
    <p class="post__text"><?php echo $text ?></p>
<?php endif ?>
