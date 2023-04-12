<div class="col-md-12">

    <h3>Мета информация</h3>
    
    <form enctype="multipart/form-data"  role="form" class="form" action="<?php echo getUrl('page=article&subpage=meta&action=edit') ?>" method="POST">
    
    <input type="hidden" name="id" value="<?php echo $article->id ?>">
    <input type="hidden" name="author" value="<?php echo $article->author ?>">
    <input type="hidden" name="action" value="edit">
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="input_name">
                    Название поста (H1)
                </label>
                <input type="text" class="form-control" id="input_name"  name="name" value = "<?php echo $article->name ?>" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="input_category">
                    Категория
                </label>
                <select name="category_id" id="input_category" class="form-control">
                    <?php foreach ($A->getCategories(['is_main' => true]) as $item): ?>
                        <option value="<?php echo $item->id ?>" <?php if($item->id == $article->category_id): ?>selected<?php endif ?>><?php echo $item->name ?></option>
                        <?php foreach ($A->getCategories(['parent_id' => $item->id]) as $category): ?>
                            <option value="<?php echo $category->id ?>" <?php if($category->id == $article->category_id): ?>selected<?php endif ?>>— <?php echo $category->name ?></option>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="input_photo">
                    Фото обложки
                </label>
                <input type="file" class="form-control" id="input_photo" name="photo" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group text-right">
                <?php if ($article->cover): ?>
                    <img class="cover" src="<?php echo $article->cover ?>?<?php echo date('U') ?>" />
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_category_meta_title">
                    Meta Title
                </label>
                <textarea type="text" class="form-control" id="input_category_meta_title" name="meta_title"><?php echo $article->meta_title ?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_category_meta_description">
                    Meta Description
                </label>
                <textarea type="text" class="form-control" id="input_category_meta_description" name="meta_description"><?php echo $article->meta_description ?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_category_meta_keywords">
                    Meta Keywords
                </label>
                <textarea type="text" class="form-control" id="input_category_meta_keywords" name="meta_keywords"><?php echo $article->meta_keywords ?></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_url">
                    ЧПУ-ссылка
                </label>
                <input type="text" class="form-control" id="input_url"  name="url" value = "<?php echo $article->url ?>" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="input_photo_source">
                    URL-картинки
                </label>
                <input type="text" class="form-control" id="input_photo_source" name="photo_source"  value = "<?php echo $article->photo_source ?>" />
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group text-center">
                <label for="is_special">
                    Спецпроект
                </label>
                <input type="checkbox" class="form-control" id="is_special" name="is_special" <?php if ($article->is_special == 1): ?>checked<?php endif ?>/>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group text-center">
                <label for="is_for_zen">
                    Дзен
                </label>
                <input type="checkbox" class="form-control" id="is_for_zen" name="is_for_zen" <?php if ($article->is_for_zen == 1): ?>checked<?php endif ?>/>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group text-center">
                <label for="is_yandex">
                    Только яндекс
                </label>
                <input type="checkbox" class="form-control" id="is_yandex" name="is_yandex" <?php if ($article->is_yandex == 1): ?>checked<?php endif ?>/>
            </div>
        </div>
        <?php /*
        <div class="col-md-2">
            <div class="form-group">
                <label for="translit_ru">
                    Транслит
                </label>
                <input type="text" class="form-control" id="translit_ru" value="" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="translit_en">
                    Translit
                </label>
                <input type="text" class="form-control" id="translit_en" value="" />
            </div>
        </div>
        */ ?>
    </div>

    <div class="row">
        <div class="col-md-10">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <?php if($U->isAdmin()): ?>
                <button type="button" class="btn btn-warning" id="microdata_button" data-toggle="modal" data-target=".modal-microdata">Разметка</button>
            <?php endif; ?>
        </div>
        <div class="col-md-2 text-right">
            <a href="<?php echo getUrl("page=article&subpage=edit&action=delete&id={$article->id}") ?>" class="btn btn-danger active" role="button" aria-pressed="true">Удалить пост</a>
        </div>
    </div>
    </form>
    <div class="modal modal-microdata fade" tabindex="-1" role="dialog" aria-labelledby="Save" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Разметка</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?php echo getUrl("page=article&subpage=edit&action=save_microdata&article_id={$article->id}")?>" method="POST" id="microdata-form">
                                <div class="form-group">
                                    <label for="input-microdata-type">
                                        Тип разметки
                                    </label>
                                    <select name="type" id="input-microdata-type" class="form-control">
                                        <option value="0" selected hidden>Выбрать...</option>
                                        <?php foreach($A->getMicrodataTypes() as $type => $name): ?>
                                            <option value="<?=$type?>"><?=$name?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" form="microdata-form" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <br />
    <hr />
    <br />
</div>

    
<!--<div class="col-md-12">
    <h4>Редактируемый пост</h4>
    <br />
</div>
<?php /*$collection = array($article) */?>
--><?php /*include "articles_table.php" */?>

<script>
    $("#translit_ru").on("change", function () {
        $("#translit_en").val(translit($("#translit_ru").val()));
    });
    $("#input_name").on("change", function () {
        if ($("#input_url").val() == '') {
            $("#input_url").val(translit($("#input_name").val()));
        }
    });

    // Update microdata type
    $('#input-microdata-type').on('change', function (e) {
        let type = $(this).val();
        $('.microdata-input').remove();
        loadMicrodataType(type);
    });

    // Load microdata template
    function loadMicrodataType(type = 0) {
        $.ajax({
            type: "POST",
            url: '<?php echo getUrl("page=article&subpage=edit&action=load_microdata&article_id={$article->id}") ?>',
            data: {type: type},
            cache: true,
            async: true,
            success: function (data) {
                $('#microdata-form').append(data);
            }
        });
    }

    $('#microdata-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: $(this).prop('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: true,
            async: true,
            success: function (result) {
                $(".modal-microdata").modal('hide');
                alert(result);
            }
        });
    });

    /*$(".modal-microdata").on("hide.bs.modal", function (e) {
        if (!confirm('Вы точно сохранили изменения в разметке? 😊')) {
            e.preventDefault();
        }
    });*/
</script>
