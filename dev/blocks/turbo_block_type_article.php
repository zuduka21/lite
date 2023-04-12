<?php $text = $block->info ?>

<?php preg_match_all('/<li class="noli">(.*?)<\/li>/s', $text, $matches); ?>
<?php $matches[1] = array_unique($matches[1]) ?>

<?php $text = str_replace("/photo/", "/photo_l/", $text) ?>
<?php $text = preg_replace('/class=".*?"/', '', $text) ?>
<?php $text = preg_replace('/title=".*?"/', '', $text) ?>
<?php $text = preg_replace('/style=".*?"/', '', $text) ?>
<?php //$text = preg_replace('/data-image=".*?"/', '', $text) ?>
<?php //$text = preg_replace('/data-src=".*?"/', '', $text) ?>
<?php //$text = preg_replace('/data-src-s=".*?"/', '', $text) // не убирать?>
<?php $text = preg_replace('/\s+>/', '>', $text) ?>
<?php $text = trim($text) ?>

<?php $text = str_replace("Тебе понадобится:", "<b>Тебе понадобится:</b>", $text) ?>
<?php $text = str_replace("Пошаговый рецепт:", "<b>Пошаговый рецепт:</b>", $text) ?>

<?php foreach ($matches[1] as $m) $text = str_replace("<li>{$m}</li>", "<li><em>{$m}</em></li>", $text) ?>

<?php /*ВРЕМЕННО !!!*/?>
<?php if ($article->id == 2615) $text = str_replace("/foto-", "/photo-", $text) ?>
<?php if ($article->id == 2615) $text = str_replace("ужасам...", "ужасам.", $text) ?>
<?php if ($article->id == 2750) $text = str_replace("/foto-", "/photo-", $text) ?>
<?php if ($article->id == 2730) $text = str_replace("/foto-", "/photo-", $text) ?>
<?php if ($article->id == 2732) $text = str_replace("/foto-", "/photo-", $text) ?>

<?php if ($block->info != ''): ?>
    <?php echo $text ?>
<?php endif ?>
