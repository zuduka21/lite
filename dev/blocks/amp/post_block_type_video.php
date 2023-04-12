<?php if ($block->name != ''): ?>
    <h2 class="post__title"><?php echo $block->name ?></h2>
<?php endif ?>

<?php if ($block->info != ''): ?>

<?php
    parse_str( parse_url( $block->info, PHP_URL_QUERY ), $videoVars );
?>
    <?php /*
    <amp-state id="video<?php echo $block->id ?>">
        <script type="application/json">
            { "items":  [{"id": "<?php echo $videoVars['v']?>"}]}
        </script>
    </amp-state>
    <amp-list src="amp-state:video<?php echo $block->id ?>" layout="responsive" width="480" height="270">
        <template type="amp-mustache">
            <amp-youtube width="480" height="270" layout="responsive" data-videoid="{{id}}"></amp-youtube>
        </template>
    </amp-list>
    */ ?>

    <amp-youtube data-videoid="<?php echo $videoVars['v']?>" layout="responsive" width="480" height="270"></amp-youtube>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<?php endif ?>

