<?php if ($block->photo != ''): ?>
    <div class="post__wrapperImg<?php if ($block->info != ""): ?> mb<?php endif ?>" itemscope itemtype="http://schema.org/ImageObject" <?php if ($block->info != ""): ?>data-caption="© <?php echo $block->info ?>"<?php endif ?>>
    	<amp-img src="<?php echo $block->photo_l ?>" srcset="<?php echo $block->photo_l ?> 750w, <?php echo $block->photo_s ?> 450w" title="<?php echo $block->name ?>" alt="<?php echo $block->name ?>" class="categoryPost__img" layout="responsive"></amp-img>
        <meta itemprop="name" content="<?php echo $block->name ?>" />
        <link itemprop="contentUrl" href="<?php echo $block->photo_l ?>" />
    </div>
<?php endif ?>