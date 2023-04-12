<div class="col-md-12">

    <h3>Категории сайта</h3>

    <form role="form" class="form-inline" action="<?php echo getUrl('page=categories') ?>" method="POST">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden"  name="action" value="add">
            <button type="submit" class="btn btn-primary">➕ Создать категорию</button>        
        </div>
    </div>
    </form>
</div>
    
<p>&nbsp;</p>

<div class="col-md-12">
    <table class="table table-bordered table-hover table-striped table-sm">
        <thead>
            <tr>
                <th width="50">⬆️⬇️</th>
                <th width="80">Мета</th>
                <th>Название категории</th>
                <th width="80"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($collection as $item): ?>
                <?php if($item->is_main): ?>
                    <tr>
                        <td class="text-center"><input value="<?php echo $item->sort ?>" style="width:50px"  class="text-right" onblur="updateCategorySort('<?php echo $item->id ?>', this.value)" /></td>
                        <td class="text-center icon"><a href="<?php echo getUrl("page=categories&subpage=edit&action=edit&id={$item->id}") ?>">📜</a></td>
                        <td class="font-weight-bold"><?php echo $item->name ?></td>
                        <td class="text-center">
                            <a class = "icon" href="#" data-container="body" data-toggle="popover" data-placement="top" data-content="Удалить? <a href='<?php echo getUrl("page=categories&action=delete&id={$item->id}") ?>'>ДА</a>" data-html=true>❌</a>
                        </td>
                    </tr>
                    <?php foreach ($A->getCategories(['parent_id' => $item->id]) as $category): ?>
                        <tr>
                            <td class="text-center"><input value="<?php echo $category->sort ?>" style="width:50px"  class="text-right" onblur="updateCategorySort('<?php echo $category->id ?>', this.value)" /></td>
                            <td class="text-center icon"><a href="<?php echo getUrl("page=categories&subpage=edit&action=edit&id={$category->id}") ?>">📜</a></td>
                            <td> — <?php echo $category->name ?></td>
                            <td class="text-center">
                                <a class = "icon" href="#" data-container="body" data-toggle="popover" data-placement="top" data-content="Удалить? <a href='<?php echo getUrl("page=categories&action=delete&id={$category->id}") ?>'>ДА</a>" data-html=true>❌</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
    
    function updateCategorySort(id, value) {
        $.post( "./post.php", { type: "update_category_sort", id: id,  value: value} )
          .done(function( data ) {
          });
    }
</script>
