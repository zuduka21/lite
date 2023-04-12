
<div class="col-md-12">
    <h3>Блоки <span class="badge badge-secondary"><?php echo $article->name ?></span></h3>
    <form enctype="multipart/form-data"  role="form" class="form" action="<?php echo getUrl("page=article&subpage=edit&action=edit&id={$article->id}") ?>" method="POST">

        <input type="hidden" name="id" value="<?php echo $article->id ?>">
        <input type="hidden" name="block_id" value="<?php echo $block ? $block->id : 0 ?>">
        <input type="hidden" name="action" value="edit">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="input_name">
                        Название блока / Alt фото
                    </label>
                    <input type="text" class="form-control" id="input_name"  name="name" value = "<?php echo $block ? $block->name : '' ?>" />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="input_photo">
                        Фото
                    </label>
                    <input type="file" class="form-control" id="input_photo" name="photo[]" <?php echo $block ? '' : 'multiple' ?>/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group text-right">
                    <?php if ($block && $block->photo): ?>
                        <img class="cover" src="<?php echo $block->photo ?>?<?php echo date('U') ?>" />
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="input_info">
                        Текст блока
                    </label>
                    <textarea type="text" class="form-control" id="input_info" name="info" style="height:230px"><?php echo $block ? $block->info : '' ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="input_sort">
                        Номер блока
                    </label>
                    <input type="text" class="form-control" id="input_sort"  name="sort" value = "<?php echo $block ? $block->sort : $A->getNewBlockNumber($article->id) ?>" <?php if (!$block): ?>readonly<?php endif ?>/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="input_type">
                        Тип блока
                    </label>
                    <select class="form-control" name="type" id="input_type" onchange="changeType(this.value)">
                        <?php foreach ($A->getBlockTypes() as $id=>$b): ?>
                            <?php if($id !== 9): ?>
                            <option value="<?php echo $id ?>" <?php if($block && $id == $block->type): ?>selected<?php endif ?>><?php echo $b ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6" id="url_container" style="display:<?php echo $block && $block->type == 7 ? 'block' : 'none' ?>">
            <div class="form-group">
                <label for="input_info">
                    URL товара
                </label>
                <input type="text" class="form-control" id="url"  name="url" value = "<?php echo $block ? $block->url : '' ?>" />
            </div>
        </div>
            <div class="col-md-2">
                <div style="width:10px;height:30px;"></div>
                <button type="submit" class="btn btn-primary"><?php echo $block ? 'Обновить' : 'Добавить блок' ?></button>
            </div>
            <div class="col-md-6 text-right">
                <div style="width:10px;height:30px;"></div>
                <?php if ($block): ?>
                    <a href="<?php echo getUrl("page=article&subpage=edit&action=delete_block&id={$article->id}&block_id={$block->id}") ?>" class="btn btn-danger active" role="button" aria-pressed="true">Удалить блок</a>
                <?php endif ?>
            </div>
        </div>
    </form>
    <br />
    <hr />
    <br />
</div>
<?php if($U->isAdmin()):?>
    <?php $collection = $article->blocks ?>
    <?php if (count($collection) > 0 ): ?>
        <?php include "article_blocks.php" ?>
        <div class="col-md-12">
            <br /><hr /><br />
        </div>
    <?php endif ?>
<?php endif ?>
