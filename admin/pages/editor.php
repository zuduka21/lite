<div class="col-md-12">
    <h3>Вставь текст статьи</h3>
    <form enctype="multipart/form-data"  role="form" class="form" action="<?php echo getUrl("page=editor") ?>" method="POST">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input_info">
                        Текст статьи
                    </label>
                    <textarea type="text" class="form-control" id="input_info" name="src" style="height:500px"><?php echo $article_src ? $article_src : '' ?></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="input_info">
                        HTML статьи
                    </label>
                    <textarea type="text" class="form-control" id="input_info" name="dst" style="height:500px"><?php echo $article_dst ? $article_dst : '' ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div style="width:10px;height:30px;"></div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </div>

    </form>
</div>

<style>
  .res {font-size: 14px;}
  .res h2 {font-size: 16px;}
  .res h3 {font-size: 14px;}
</style>
<div class="col-md-12 res"><br /><hr /><br /><?php echo $article_dst ? $article_dst : '' ?></div>