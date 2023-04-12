<div class="col-md-12">

    <h3>Пользователи сайта</h3>

    <form role="form" class="form-inline" action="<?php echo getUrl('page=users') ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden"  name="action" value="add">
                <button type="submit" class="btn btn-primary">➕ Добавить пользователя</button>
            </div>
        </div>
    </form>
</div>

<p>&nbsp;</p>

<div class="col-md-12">
    <table class="table table-bordered table-hover table-striped table-sm">
        <thead>
        <tr>
            <th width="250">Логин</th>
            <th>ФИО</th>
            <th>Роль</th>
            <th width="80">Записи</th>
            <th class="text-center">Дата</th>
            <th width="80"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($U->getUsers() as $user): ?>
            <tr>
                <td><?php echo $user->login ?></td>
                <td><?php echo $U->getName($user->id) ?></td>
                <td><?php echo $U->getRole($user->role_id) ?></td>
                <td class="text-center"><a href="<?php echo getUrl('page=users&subpage=article&user_id=' . $user->id) ?>"><?php echo count($A->getArticlesByUser($user->id)) ?></a></td>
<!--                <td class="text-center">--><?php //echo date_format(date_create($user->date_added), "d.m.Y") ?><!--</td>-->
                <td class="text-center"><?php echo $user->date_added ?></td>
                <td class="text-center">
                    <a href="<?php echo getUrl("page=users&subpage=edit&action=edit&id={$user->id}") ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Редактировать</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

</div>

