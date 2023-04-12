<?php

    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $mysql->runQuery("INSERT INTO `categories` SET `name` = 'Новая категория', `is_main` = 1");
        redirectTo(getUrl('page=categories'));

    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        
        $id = (int) $_GET['id'];
        $mysql->runQuery("DELETE FROM `categories` WHERE `id` = '{$id}'");
        
        redirectTo(getUrl('page=categories'));

    }
    
    $collection = $mysql->getQuery("SELECT * FROM `categories` ORDER BY `sort` ASC");