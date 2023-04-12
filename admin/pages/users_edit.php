<div class="col-md-12">

    <h3>Информация о пользователе</h3>
    <form enctype="multipart/form-data"  role="form" class="form" action="<?php echo getUrl('page=users&subpage=edit&action=edit') ?>" method="POST">

        <input type="hidden" name="id" value="<?php echo $user->id ?>">
        <input type="hidden" name="action" value="edit">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input_login">
                        Логин
                    </label>
                    <input type="text" class="form-control" id="input_login"  name="login" value = "<?php echo $user->login ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input_firstname">
                        Имя
                    </label>
                    <input type="text" class="form-control" id="input_firstname"  name="firstname" value = "<?php echo $user->firstname ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input_lastname">
                        Фамилия
                    </label>
                    <input type="text" class="form-control" id="input_lastname"  name="lastname" value = "<?php echo $user->lastname ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input_password">
                        Новый пароль
                    </label>
                    <input type="password" class="form-control" id="input_password"  name="password"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input_confirm">
                        Подтверждение пароля
                    </label>
                    <input type="password" class="form-control" id="input_confirm"  name="confirm"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input_role_id">
                        Роль
                    </label>
                    <select class="form-control" name="role_id" id="input_role_id">
                        <option value="1"<?php echo ((int)$user->role_id === $U::ADMINISTRATOR) ? ' selected' : '' ?>>Админ</option>
                        <option value="2"<?php echo ((int)$user->role_id === $U::AUTHOR) ? ' selected' : '' ?>>Автор</option>
                        <option value="3"<?php echo ((int)$user->role_id === $U::EDITOR) ? ' selected' : '' ?>>Редактор</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            <?php if((int)$user->id !== 1):?>
            <div class="col-md-2 text-right">
                <a href="<?php echo getUrl("page=users&action=delete&id={$user->id}") ?>" class="btn btn-danger active" role="button" aria-pressed="true">Удалить пользователя</a>
            </div>
            <?php endif; ?>
        </div>
    </form>
    <br />
    <hr />
    <br />
</div>


<div class="col-md-12">
    <h4>Записи пользователи</h4>
    <br />
</div>
<?php $collection = $A->getArticlesByUser($user->id) ?>
<?php include "articles_table.php" ?>
