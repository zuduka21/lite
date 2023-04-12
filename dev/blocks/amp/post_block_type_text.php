<?php $text = nl2br($block->info) ?>
<?php $text = str_replace("\n", "", $text) ?>
<?php $text = str_replace("\r", "", $text) ?>
<?php $text = str_replace("<br /><br />", "</p><p class='post__text'>", $text) ?>

<?php $text = str_replace("<ul><br />", "<ul>", $text) ?>
<?php $text = str_replace("<ol><br />", "<ol>", $text) ?>
<?php $text = str_replace("</li><br />", "</li>", $text) ?>

<?php $text = str_replace("<ul>", "</p><ul>", $text) ?>
<?php $text = str_replace("</ul>", "</ul><p class='post__text'>", $text) ?>
<?php $text = str_replace("<ol>", "</p><ol>", $text) ?>
<?php $text = str_replace("</ol>", "</ol><p class='post__text'>", $text) ?>

<?php if ($block->info != ''): ?>
    <p class="post__text"><?php echo $text ?></p>
<?php endif ?>
