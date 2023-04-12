<script async="" src="//www.instagram.com/embed.js"></script>

<?php if ($block->name != ''): ?>
    <h2 class="post__title"><?php echo $block->name ?></h2>
<?php endif ?>

<?php if ($block->info != ''): ?>
	<?php
	$matches = array();
	$pattern = '/^.*//instagram.com/p/(.*)​/.*$/';
	preg_match($pattern, $block->info, $matches);
	?>
    <amp-instagram data-shortcode="<?php echo $matches[1]?>" width="1" height="1" layout="responsive"></amp-instagram>
<?php endif ?>

