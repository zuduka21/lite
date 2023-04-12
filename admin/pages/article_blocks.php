<div class="col-md-12">
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th width="100">№</th>
                <th width="80" >Тип</th>
                <th>Название блока</th>
                <th width="150" >Фото</th>
                <th>Текст блока</th>
                <th width="100"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($collection as $n=>$item): ?>
                <tr>
                    <td class="text-center small"><?php echo $item->sort ?></td>
                    <td class="small"><b><i><?php echo $A->getBlockType($item->type) ?></i></b></td>
                    <td><?php echo $item->name ?></td>
                    <td>
                        <?php if ($item->photo): ?>
                            <img src="<?php echo $item->photo ?>?<?php echo date('U') ?>" style="width:150px;" />
                        <?php endif ?>
                    </td>
                    <td class="small"><?php echo nl2br($item->info) ?></td>
                    <td class="text-center">
                        <a href="<?php echo getUrl("page=article&subpage=edit&action=edit&id={$article->id}&block_id={$item->id}") ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Изменить блок</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

