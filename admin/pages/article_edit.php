<?php $collection = $article->blocks ?>
<?php if(!$block):?>
<?php foreach ($collection as $block):
    if ((int)$block->type === 9) {
        $article_type = true;
        break;
    }else{
        $article_type = false;
    }
endforeach;?>
<?php else:?>
<?php $article_type = true; ?>
<?php endif;?>
<?php if($article_type): ?>
    <?php include 'article_edit_post.php' ?>
<?php else: ?>
    <?php include 'article_edit_block.php' ?>
<?php endif; ?>

<div class="col-md-12">
    <h4>Редактируемый пост</h4>
    <br />
</div>
<?php $collection = array($article) ?>
<?php include "articles_table.php" ?>
