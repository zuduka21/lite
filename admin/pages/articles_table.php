<div class="col-md-12">
    <table class="table table-bordered table-hover table-striped table-sm">
        <thead>
            <tr>
                <th width="100">Дата</th>
                <?php if($U->isAdmin()): ?>
                <th width="80" >Мета</th>
                <th width="80" >Блоки</th>
                <?php endif; ?>
                <th>Название поста</th>
                <th class="text-center">Автор</th>
                <th>Категория</th>
                <th width="280"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($collection as $item): ?>
                <?php $a = $A->getArticle($item->id) ?>
                <tr  <?php echo ($U->isAdmin() && $a->is_reviewed) ? 'class="reviewed"' : 'class="not_reviewed"' ?>>
                    <td class="text-center"><?php echo date("d.m.Y", $a->date) ?></td>
                    <?php if($U->isAdmin()): ?>
                    <td class="text-center icon"><a href="<?php echo getUrl("page=article&subpage=meta&action=edit&id={$a->id}") ?>">📜</a></td>
                    <td class="text-center icon"><a href="<?php echo getUrl("page=article&subpage=edit&action=edit&id={$a->id}") ?>">🖼</a></td>
                    <?php endif; ?>
                    <td><a href="<?php echo getUrl("page=article&subpage=edit&action=edit&id={$a->id}") ?>"><?php echo ($a->name ?: '—') ?></a></td>
                    <td class="text-center">
                        <?php if($a->user_id): ?>
                            <a href="<?php echo getUrl("page=users&subpage=article&user_id={$a->user_id}") ?>" target="_blank"><?php echo $U->getName($a->user_id) ?></a>
                        <?php else: ?>
                            —
                        <?php endif ?>
                    </td>
                    <td><?php echo $a->category ? $a->category->name : 'Без категории' ?></td>
                    <td class="text-center">
                        <a href="http://dev.lafoy.ru/<?php echo $a->url ?>-<?php echo $a->id ?>" target="_blank" class="btn btn-secondary btn-sm active" role="button" aria-pressed="true">Предпросмотр</a>
                        <?php if (($a->is_published == 0 || $a->is_changed == 1) && $U->isAdmin()): ?>
                            <a href="<?php echo getUrl("page=article&subpage=edit&action=publish&id={$a->id}") ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Опубликовать</a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

