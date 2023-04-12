<div class="col-md-12">

    <h3>Редактирование категории</h3>

    <form role="form" class="form" action="<?php echo getUrl("page=categories&subpage=edit&action=edit") ?>" method="POST">
    
    <input type="hidden" name="id" value="<?php echo $category->id ?>">
    <input type="hidden" name="action" value="edit">
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_category_name">
                    Название категории
                </label>
                <input type="text" class="form-control" id="input_category_name"  name="name" value = "<?php echo $category->name ?>" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="input_category_url">
                    ЧПУ
                </label>
                <input type="text" class="form-control" id="input_category_url" name="url" value = "<?php echo $category->url ?>" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group text-center">
                <label for="is_main">
                    Главная категория
                </label>
                <input type="checkbox" value="1" class="form-control" id="is_main" name="is_main"<?php echo ($category->is_main ? ' checked="checked"' : '') ?>/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group text-center">
                <label for="parent_id">
                    Родительская категория
                </label>
                <select name="parent_id" id="parent_id" class="form-control"<?php echo ($category->is_main) ? ' disabled readonly' : '' ?>>
                    <option value="0">--- Не выбрано ---</option>
                    <?php foreach ($A->getCategories(['is_main' => true]) as $item){ ?>
                        <option value="<?php echo $item->id ?>"<?php echo ($item->id === $category->parent_id) ? ' selected="selected"' : '' ?>><?php echo $item->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_category_meta_title">
                    Meta Title
                </label>
                <textarea type="text" class="form-control" id="input_category_meta_title" name="meta_title"><?php echo $category->meta_title ?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_category_meta_description">
                    Meta Description
                </label>
                <textarea type="text" class="form-control" id="input_category_meta_description" name="meta_description"><?php echo $category->meta_description ?></textarea>
            </div>
        </div>

        <textarea style="display:none;" id="input_category_meta_keywords" name="meta_keywords"><?php echo $category->meta_keywords ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Сохранить</button>        
        </div>
    </div>
    </form>
</div>


<script>
    $('#is_main').change(function() {
        if(this.checked) {
            $('#parent_id').attr('readonly', 'readonly');
            $('#parent_id').attr('disabled', 'disabled');
            $("#parent_id").val($("#parent_id option:first").val());
        }else{
            $('#parent_id').removeAttr('readonly');
            $('#parent_id').removeAttr('disabled');
        }
    });
</script>