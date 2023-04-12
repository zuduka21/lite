<div class="col-md-12">

    <h3>Конфиг</h3>

    <form role="form" class="form" action="<?php echo getUrl("page=config") ?>" method="POST">
    <input type="hidden" name="action" value="purge_cache">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сбросить кеш</button>
            </div>
        </div>
    </div>
    </form>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="input_info">
                    Обновлять дату поста
                </label>
                <input type='checkbox' onchange="updateConfigCheckbox('update_post_date', this.checked)" <?php echo $mysql->getConfig('update_post_date') == '1' ? 'checked' : '' ?>>
            </div>
        </div>
    </div>

</div>

<script>
    function updateConfigCheckbox (key, value) {
        value = value ? 1 : 0;
        $.post( "./post.php", { type: "update_config", key: key, value: value} );
    }

    function updateConfig (key, value) {
        $.post( "./post.php", { type: "update_config", key: key, value: value} );
    }
</script>