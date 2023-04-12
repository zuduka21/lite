<?php $text = $block->info ?>
<?php $text = str_replace("/photo/", "/photo_l/", $text) ?>
<?php $text = preg_replace('/class=".*?"/', '', $text) ?>
<?php $text = preg_replace('/title=".*?"/', '', $text) ?>
<?php $text = preg_replace('/style=".*?"/', '', $text) ?>
<?php //$text = preg_replace('/data-image=".*?"/', '', $text) ?>
<?php //$text = preg_replace('/data-src=".*?"/', '', $text) ?>
<?php //$text = preg_replace('/data-src-s=".*?"/', '', $text) ?>
<?php $text = preg_replace('/\s+>/', '>', $text) ?>
<?php $text = trim($text) ?>
<?php if ($block->info != ''): ?>
    <?php echo $text ?>
<?php endif ?>
