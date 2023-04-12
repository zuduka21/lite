<?php

    $category = false;
  
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        
        $id = (int) $_GET['id'];
        $res = $mysql->getQuery("SELECT * FROM `categories` WHERE `id` = '{$id}'");
        foreach ($res as $item) $category = $item;
        
    }
    
    if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['id'])) {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $name = isset($_POST['name']) ? $mysql->escapeString($_POST['name']) : '';
        $is_main = isset($_POST['is_main']) ? (int) $_POST['is_main'] : 0;
        $parent_id = isset($_POST['parent_id']) ? (int) $_POST['parent_id'] : 0;
        $url = isset($_POST['url']) ? $mysql->escapeString($_POST['url']) : '';
        $meta_title = isset($_POST['meta_title']) ? $mysql->escapeString($_POST['meta_title']) : '';
        $meta_description = isset($_POST['meta_description']) ? $mysql->escapeString($_POST['meta_description']) : '';
        $meta_keywords = isset($_POST['meta_keywords']) ? $mysql->escapeString($_POST['meta_keywords']) : '';


        $mysql->runQuery("UPDATE `categories` SET `name` = '{$name}', `is_main` = '{$is_main}', `parent_id` = '{$parent_id}', `url` = '{$url}', `meta_title` = '{$meta_title}', `meta_description` = '{$meta_description}', `meta_keywords` = '{$meta_keywords}' WHERE `id` = '{$id}'");
        $res = $mysql->getQuery("SELECT * FROM `categories` WHERE `id` = '{$id}'");
        foreach ($res as $item) $category = $item;

        setSuccess('Изменения успешно сохранены');
    }
    
    if (!$category) redirectTo(getUrl('page=categories'));
