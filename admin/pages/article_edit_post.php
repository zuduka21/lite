<?php

$block->info = str_replace ("//lafoy.ru", "//dev.lafoy.ru", $block->info);
$block->info = str_replace (".jpg", ".jpg?" . date('U'), $block->info);
$block->info = str_replace (".png", ".png?" . date('U'), $block->info);
$block->info = str_replace (".gif", ".gif?" . date('U'), $block->info);
$block->info = str_replace ("'", "\'", $block->info);

?>
<div class="col-md-12">
    <form enctype="multipart/form-data"  role="form" class="form" action="<?php echo getUrl("page=article&subpage=edit&action=edit_post&id={$article->id}") ?>" method="POST">

        <input type="hidden" name="id" value="<?php echo $article->id ?>">
        <input type="hidden" name="block_id" value="<?php echo $block ? $block->id : 0 ?>">
        <input type="hidden" name="action" value="edit_post">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php if($article->name === 'Новый пост'): ?>
                        <textarea onkeyup="textAreaAdjust(this)" id="input_name" name="name" placeholder="<?php echo $article->name ?>"></textarea>
                    <?php else: ?>
                        <textarea onkeyup="textAreaAdjust(this)" id="input_name" name="name"><?php echo $article->name ?></textarea>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="row position-relative">
            <div class="col-md-10">
                <div class="form-group">
                    <label for="input_info">
                        Текст блока
                    </label>
                    <textarea type="text" class="form-control" id="input_info" name="info" style="height:230px"></textarea>
                </div>
            </div>
            <div class="col-md-2 sticky">
                <div class="sticky-button">
                    <button type="button" class="btn btn-primary btn-block btn-lg m-auto" id="update_button" data-toggle="modal" data-target=".modal-update">Обновить</button>
                    <?php if($U->isAdmin()): ?>
                        <button type="button" class="mt-10 btn btn-warning btn-block btn-lg" id="microdata_button" data-toggle="modal" data-target=".modal-microdata">Разметка</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <input type="hidden" id="input_sort"  name="sort" value = "<?php echo $block ? $block->sort : $A->getNewBlockNumber($article->id) ?>" <?php if (!$block): ?>readonly<?php endif ?>/>
            <input type="hidden" id="input_type"  name="type" value = "9"/>


            <div class="modal modal-update fade" tabindex="-1" role="dialog" aria-labelledby="Save" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Публикация</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="input_category">
                                            Категория
                                        </label>
                                        <select name="category_id" id="input_category" class="form-control">
                                            <?php foreach ($A->getCategories(['is_main' => true]) as $item): ?>
                                                <option <?php echo !empty($A->getCategories(['parent_id' => $item->id])) ? 'disabled' : '' ?> value="<?php echo $item->id ?>" <?php if($item->id == $article->category_id): ?>selected<?php endif ?>><?php echo $item->name ?></option>
                                                <?php foreach ($A->getCategories(['parent_id' => $item->id]) as $category): ?>
                                                    <option value="<?php echo $category->id ?>" <?php if($category->id == $article->category_id): ?>selected<?php endif ?>>— <?php echo $category->name ?></option>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_meta_title">
                                            Title
                                        </label>
                                        <textarea class="form-control" id="input_meta_title" name="meta_title"><?php echo $article->meta_title ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_meta_description">
                                            Meta Description
                                        </label>
                                        <textarea class="form-control" id="input_meta_description" name="meta_description"><?php echo $article->meta_description ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_url">
                                            ЧПУ-ссылка
                                        </label>
                                        <input type="text" class="form-control" id="input_url" name="url" value="<?php echo $article->url ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" id="is_special" name="is_special" <?php if ($article->is_special == 1): ?>checked<?php endif ?>/>
                                        <label class="form-check-label" for="is_special">
                                            Спецпроект
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" value="1" id="is_for_zen" name="is_for_zen" <?php if ($article->is_for_zen == 1): ?>checked<?php endif ?>/>
                                        <label class="form-check-label" for="is_for_zen">
                                            Дзен
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" value="1" id="is_yandex" name="is_yandex" <?php if ($article->is_yandex == 1): ?>checked<?php endif ?>/>
                                        <label class="form-check-label" for="is_yandex">
                                            Только яндекс
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <?php if (($U->isAdmin() && $article->is_changed)):?>
                                <a href="<?php echo getUrl("page=article&subpage=edit&action=publish&id={$article->id}") ?>" class="btn btn-secondary" role="button" aria-pressed="true">Опубликовать</a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Закрыть</button>
                            <!--                        <button type="button" onclick="generateMeta()" class="btn btn-sm btn-warning ml-auto">Сгенирировать мету</button>-->
                        </div>
                    </div>
                </div>
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
<script>
    function textAreaAdjust(element) {
        element.style.height = "1px";
        element.style.height = (25+element.scrollHeight)+"px";
    }

    $(document).ready(function () {
        textAreaAdjust(document.getElementById("input_name"));
        $('nav.navbar').removeClass('fixed-top static-top');
    });

    let article = {};
    let removeURL = '<?php echo getUrl("page=article&subpage=edit&action=remove_image&article_id={$article->id}") ?>';
    let name_changed = false;
    var first_image = 0;
    let replace_with = false;
    function initArticle(el = '#input_info') {

        $(el).parent().css({"width":750,"margin": '0 auto'});
        $(el).prev().hide();
        $('#input_name').parent().css({"width":750,"margin": '0 auto'}).parents('.col-md-8').removeClass('col-md-8').addClass('col-md-12');
        $('#input_name').addClass('post__mainTitle');
        $('#input_photo').parent('.form-group').hide();
        article = ArticleEditor(el,{
            css: '../css/article/',
            line: false,
            mobile: false,
            topbar: {
                shortcuts: false,
            },
            placeholder: 'Текст статьи...',
            content: '<?php echo $block ? str_replace(array("\r","\n"),"",$block->info) : ''?>',
            autosave: {
                url: '<?php echo getUrl("page=article&subpage=edit&action=autosave&id={$article->id}") ?>',
                method: 'post',
                data: {
                    id: <?php echo $article->id ?>,
                    type: 9,
                    elements: '#input_name',
                    sort: 1,
                    block_id: <?php echo $block->id ?>
                }
            },
            image: {
                upload: '<?php echo getUrl("page=article&subpage=edit&action=upload&id={$article->id}") ?>',
                data: {
                    id: <?php echo $article->id ?>,
                    url: '<?php echo $article->url ?>'
                },
                link: false
            },
            custom: {
                css: [
                    '../css/lafoy_article/fonts.css',
                    '../css/lafoy_article/style.css'
                ]
            },
            plugins: ['underline'],
            editor: {
                minHeight: '600px',
                maxWidth: '750px',
                minWidth: '750px'
            },

            outdent: false,
            indent: false,
            quote: false,
            grid: false,
            table: false,
            code: false,
            align: false,
            layer: false,
            deleted: false,
            outset: false,
            embed: false,
            addbarHide: ['image'],
            buttons: {
                tags: {
                    'u': ['underline']
                }
            },
            paste: {
                links: false,
                inlineTags:  ['a', 'br', 'strong', 'b', 'u', 'i']
            },
            format: ['p', 'h2', 'h3'],
            classes: {
                'p': 'post__text',
                'h2': 'post__title',
                'h3': 'post__title',
                'h4': 'post__title',
                'h5': 'post__title',
                'h6': 'post__title',
                'ul': 'post__ul',
                'ol': 'post__ol',
                'img': 'post__img lazyload',
                'figure': 'post__wrapperImg',
                'figcaption': 'post__imgCaption'
            },

            subscribe: {
                'editor.paste': function(article) {
                    article.params.$nodes.each(function($node) {
                        if($node.is('a')) {
                            let $url = $node.attr('href');
                            if($url.includes("youtube")){
                                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                                const match = $url.match(regExp);
                                let $src = match[2];
                                $node.after('<iframe src="//www.youtube.com/embed/' + $src +  '" width="760" height="426" frameborder="0" allowfullscreen="true"></iframe>')
                                $node.remove();
                            }
                        }
                        if($node.is('h1')) {
                            if(name_changed){
                                $node.replaceWith(function() {
                                    return '<h2>' + $node.text() + '</h2>';
                                });
                            }else{
                                name_changed = 1;
                                $('#input_name').val($node.text());
                                $node.remove();
                                textAreaAdjust(document.getElementById("input_name"));
                            }
                        }

                        if ($.trim($node.text()) == ""){
                            $node.remove();

                        }else{
                            $node.html($node.html().replace(/\s+/g,' '));
                            $node.removeAttr("align");
                        }
                    });
                },
                'image.upload': function(event) {
                    // let data = event.get('data');
                    // let instance = event.get('instance');
                    // let $image = instance.getImage();
                    // let titles = instance.dom('h2.post__title, h3.post__title');
                    // console.log($(instance.$block.nodes).parent().closest(":has(h3),:has(h2)").find('*:header').text());
                    // $image.attr('alt', 'qwerty');
                    // $image.attr('title', 'qwerty');
                },
                'image.remove': function(event) {
                    let $url = event.get('url');

                    $url = $url.substr(0, $url.lastIndexOf('.'));
                    let $image_id = $url.substring($url.lastIndexOf("-")).substring(1);

                    article.app.blocks.getBlocks().each(function($node) {
                        if($node.is('figure') && $node.children('img').attr('data-image') === $image_id) {
                            first_image = $node.children('img');
                            replace_with = $node.children('img').attr('data-image');
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: removeURL,
                        data:  {id: $image_id, replace_with: replace_with},
                        success: function (data) {
                            if(!data.error){
                                data.forEach(function (arr) {
                                    article.app.blocks.getBlocks().each(function($node) {
                                        if($node.is('figure') && parseInt($node.children('img').attr('data-image')) === parseInt(arr.replace_with)) {
                                            $node.children('img').data('image', arr.id);
                                            $node.children('img').attr('src', arr.url);
                                            $node.children('img').data('src', $node.children('img').attr('src').replace('/photo/', '/photo_l/'));
                                            $node.children('img').data('src-s', $node.children('img').attr('src').replace('/photo/', '/photo_s/'));
                                        }
                                    });
                                });

                            }
                        }
                    });
                },
                'autosave.send': function() {
                    article.app.blocks.getBlocks().each(function($node) {
                        if($node.is('figure')) {
                            let $text = $node.children('figcaption').text();
                            if(!$text.includes('©')){
                                $node.children('figcaption').text('© ' + $text);
                            }
                        }
                    })
                }
            }
        });
        article.app.control.add('image', {
            command: "image.popup",
        });
        article.app.control.add('trash', {
            command: "block.remove",
        });
    }

    initArticle('#input_info');

    function generateMeta() {
        loadMeta(true);
    }

    function loadMeta(recreate = false) {
        let $meta_description = $('#input_meta_description');
        let $meta_title = $('#input_meta_title');
        let $url = $('#input_url');
        let name = $('#input_name').val();
        let $blocks = article.app.blocks.getFirstLevel().nodes.reverse();
        let $meta_description_val = $meta_description.val();
        $blocks.forEach(function($node) {
            if($($node).is('p')) {
                $meta_description_val = $($node).text();
            }
        });

        if($meta_description.val().length === 0 || recreate) {
            $meta_description.val($meta_description_val);
        }
        if($meta_title.val().length === 0 || recreate) {
            $meta_title.val(name);
        }
        if($url.val().length === 0 || recreate) {
            $url.val(translit(name));
        }
    }

    function generateProperImages() {
        let $blocks = article.app.blocks.getBlocks();
        let h2_count = 0;
        let img_count = 0;
        $blocks.each(function($node) {
            if($node.is('h2')) {h2_count++; img_count = 0;};
            if($node.is('figure')) img_count++;
            
            if($node.is('figure')){
                let $title = '';

                if($node.prev('h2,h3,h4,h5,h6').length){
                    $title = $.trim($node.prev('h2,h3,h4,h5,h6').text().replace(/\d*[.]/g,''));
                }else{
                    $title = $.trim($('#input_name').val().replace(/\d*[.]/g,''));
                }
                // $node.attr('itemscope');
                // $node.attr('itemtype', 'http://schema.org/ImageObject');

                $node.children('img').attr('src', $node.children('img').attr('src').split('?')[0]);
                $node.children('img').data('src', $node.children('img').attr('src').replace('/photo/', '/photo_l/').replace('dev.', '').split('?')[0]);
                $node.children('img').data('src-s', $node.children('img').attr('src').replace('/photo/', '/photo_s/').replace('dev.', '').split('?')[0]);
                // if($node.children('img').attr('alt') !== $title && $node.children('img').attr('alt')){
                //     if($node.children('img').attr('alt').length){
                //         $node.children('img').attr('title', $node.children('img').attr('alt'));
                //     }
                // }else{
                $node.children('img').attr('alt', $title);
                $node.children('img').attr('title', $title);
                
                if (h2_count == 1 && img_count == 1) $node.children('img').attr('class', 'i_result');
                if (h2_count == 1 && img_count > 1) $node.children('img').attr('class', 'i_step');
                if (h2_count == 1 && img_count > 1) $node.attr('class', 'i_step');
                // }

                // $node.children('img').after('<meta itemprop="name" content="'+$title+'"/>');
                // $node.children('img').after('<link itemprop="contentUrl" href="'+$node.children('img').attr('src').replace('/photo/', '/photo_l/')+'"/>');
            }
        });
    }

    function isEmpty( el ){
        return !$.trim(el.html())
    }

    function removeSpaces() {
        let $blocks = article.app.blocks.getBlocks();
        $blocks.each(function($node) {
            $node.find('b br').parents('b').after('</br>');
            $node.find('b br').parents('b').remove();
            $node.html($node.html().replace(/\&nbsp;/g, '').trim());

            if($node.is('p') || $node.is('h2') || $node.is('h3')){
                if (isEmpty($node)) {
                    $node.remove();
                }
            }

            if($node.find('b').length){
                if (isEmpty($node.children('b'))) {
                    $node.children('b').remove()
                }
            }

            if($node.children('u').length){
                if (isEmpty($node.children('u'))) {
                    $node.children('u').remove()
                }
            }

            if($node.children('i').length){
                if (isEmpty($node.children('i'))) {
                    $node.children('i').remove()
                }
            }

        })
    }

    // Update button prepare post for save
    $('#update_button').on('click', function (e) {
        if(!$('#input_name').val().length || !$(article.app.editor.getContent()).text().length){
            alert('Ошибка: Не заполнен заголовок или тело статьи');
            e.stopPropagation();
        }else{
            removeSpaces();
            generateProperImages();
            loadMeta();
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
<style>
    form{
        font-size: 50%;
    }
    .sticky {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
    }
    .sticky-button {
        position: -webkit-sticky;
        position: sticky;
        top: 20px;
        padding: 0 15px;
    }
    .post__mainTitle{
        color: #222222;
        font-family: "Lafoy-Heuristica";
        font-weight: normal;
        line-height: 2.2rem;
        border: 0;
        outline: 0;
        word-break: break-word;
        margin: 0 auto;
        overflow: hidden;
        display: block;
        resize: none;
        width: 560px;
    }

    .post__mainTitle {
        margin-right: auto;
        margin-bottom: 1rem;
        margin-left: auto;
        text-align: center;
        font-size: 2.6rem;
    }
    .arx-editor-container {
        border: none;
    }
    .arx-path {
        display: none;
    }
    .arx-button[data-name="mobile"], .arx-button[data-name="deleted"], .arx-button[data-name="duplicate"], .arx-button[data-name="trash"]:first-child, .arx-button[data-name="outdent"],  .arx-button[data-name="indent"] {
        display: none;
    }
</style>
