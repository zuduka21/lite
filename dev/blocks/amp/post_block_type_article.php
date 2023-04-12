<?php $text = $block->info;
/*
$text = preg_replace(
    '/<img.*?src="([^"]*)".*?width="([^"]*)".*?height="([^"]*)".*?alt="([^"]*)".*?title="([^"]*)">/', 
    '<amp-img src="$1" width="$2" height="$3" alt="$4" title="$5" layout="responsive"></amp-img>', 
    $text
);
*/
$text = preg_replace(
    '/<img.*?data-src="([^"]*).*?data-src-s="([^"]*).*?alt="([^"]*)".*?title="([^"]*)">/', 
    '<amp-img class="contain" src="$1" srcset="$1 750w, $2 450w" alt="$3" title="$4" layout="responsive"></amp-img>', 
    $text
);

?>
<?php $text = str_replace("\xEF\xBB\xBF",'',$text); ?>
<?php if ($block->info != ''): ?>
    <?php echo $text ?>
<?php endif ?>
