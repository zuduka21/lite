<div class="col-md-12">

    <h3>Новые посты</h3>
    <?php if(!$U->isEditor()): ?>
        <form role="form" class="form-inline" action="<?php echo getUrl('page=new') ?>" method="POST">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden"  name="action" value="add">
                    <button type="submit" class="btn btn-primary">➕ Создать пост</button>
                </div>
            </div>
        </form>
    <?php endif;?>
</div>

<p>&nbsp;</p>

<?php include "articles_table.php" ?>
