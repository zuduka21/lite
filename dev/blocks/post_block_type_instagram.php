<script async="" src="//www.instagram.com/embed.js"></script>

<?php if ($block->name != ''): ?>
    <h2 class="post__title"><?php echo $block->name ?></h2>
<?php endif ?>

<?php if ($block->info != ''): ?>
    <iframe style="margin-bottom:20px;" type="text/html"  data-src="<?php echo str_replace("//", "/", $block->info . "/embed/") ?>" allowtransparency="true" allowfullscreen="true" frameborder="0" height="876" data-instgrm-payload-id="instagram-media-payload-0" scrolling="no" style="background: white; max-width: 540px; width: calc(100% - 2px); border-radius: 3px; border: 1px solid rgb(219, 219, 219); box-shadow: none; display: block; margin: 0px 0px 12px; min-width: 326px; padding: 0px;"></iframe>
<?php endif ?>

