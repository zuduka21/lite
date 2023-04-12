<?php

if (isset($_POST['action']) && $_POST['action'] == 'add') {

    $mysql->runQuery("INSERT INTO `users` SET `login` = 'user'");
    redirectTo(getUrl('page=users'));

}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
    redirectTo(getURL('page=login'));
}

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    if(isset($_POST['login']) && isset($_POST['password'])):
        $user = $U->getUserByLogin($_POST['login']);
        if($user):
            if(password_verify($_POST['password'], $user->password)):
                login($user->login, (int)$user->id, $user->password);
            else:
                setError('ERROR: Invalid password or username');
            endif;
        else:
            setError('ERROR: Invalid password or username');
        endif;
    else:
        setError('ERROR: Invalid password or username');
    endif;

}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {

    $id = (int) $_GET['id'];
    $mysql->runQuery("DELETE FROM `users` WHERE `id` = '{$id}'");
    $mysql->runQuery("UPDATE `articles` SET `user_id` = 1 WHERE `user_id` = '{$id}'");
    redirectTo(getUrl('page=users'));

}
