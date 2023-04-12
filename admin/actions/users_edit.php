<?php

$user = false;

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {

    $id = (int) $_GET['id'];
    $user = $U->getUser($id);

}

if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['id'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $login = isset($_POST['login']) ? $mysql->escapeString($_POST['login']) : '';
    $firstname = isset($_POST['firstname']) ? $mysql->escapeString($_POST['firstname']) : '';
    $lastname = isset($_POST['lastname']) ? $mysql->escapeString($_POST['lastname']) : '';
    $role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : $U::AUTHOR;

    if(isset($_POST['password']) && ($_POST['password'] === $_POST['confirm'])){
        $password = $mysql->escapeString(password_hash($_POST['password'], PASSWORD_BCRYPT));
        $mysql->runQuery("UPDATE `users` SET `password` = '{$password}' WHERE `id` = '{$id}'");
    }

    $mysql->runQuery("UPDATE `users` SET `login` = '{$login}', `firstname` = '{$firstname}', `lastname` = '{$lastname}', `role_id` = '{$role_id}' WHERE `id` = '{$id}'");

    $res = $mysql->getQuery("SELECT * FROM `users` WHERE `id` = '{$id}'");
    foreach ($res as $item) $user = $item;

    redirectTo(getUrl('page=users'));

}

if (!$user) redirectTo(getUrl('page=users'));