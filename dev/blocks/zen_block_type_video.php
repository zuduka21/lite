<?php if ($block->name != ''): ?>
    <h2><?php echo $block->name ?></h2>
<?php endif ?>

<?php if ($block->info != ''): ?>
    <figure>
        <video>
          <source src="<?php echo str_replace("watch?v=", "embed/", $block->info) ?>" type="">
        </video>
    </figure>
<?php endif ?>

