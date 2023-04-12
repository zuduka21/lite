<?php

    $article = false;
  
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        
        $id = (int) $_GET['id'];
        $article = $A->getArticle($id);
        
    }
    
    if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['id'])) {
        
        $id = isset($_POST['id']) ? (int) $_POST['id'] : '';
        $name = isset($_POST['name']) ? $mysql->escapeString($_POST['name']) : '';
        $category_id = isset($_POST['category_id']) ? $mysql->escapeString($_POST['category_id']) : '';

        $meta_title = isset($_POST['meta_title']) ? $mysql->escapeString($_POST['meta_title']) : '';
        $meta_description = isset($_POST['meta_description']) ? $mysql->escapeString($_POST['meta_description']) : '';
        $meta_keywords = isset($_POST['meta_keywords']) ? $mysql->escapeString($_POST['meta_keywords']) : '';

        $url = isset($_POST['url']) ? $mysql->escapeString($_POST['url']) : '';
        $author = isset($_POST['author']) ? $mysql->escapeString($_POST['author']) : '';
        $photo_source = isset($_POST['photo_source']) ? $mysql->escapeString($_POST['photo_source']) : '';
        
        if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != '') {
            $uploaddir = __DIR__ . "/../img/{$id}";
            @mkdir($uploaddir);
            $uploadfile = $uploaddir . "/0.jpg";

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                @unlink($uploaddir . "/0_l.jpg");
                @unlink($uploaddir . "/0_s.jpg");
            } else {
                setError("Не удалось загрузить файл");
            }
        }
        
        $mysql->runQuery("UPDATE `articles` SET `name` = '{$name}', `category_id` = '{$category_id}', `url` = '{$url}', `meta_title` = '{$meta_title}', `meta_description` = '{$meta_description}', `meta_keywords` = '{$meta_keywords}', `author` = '{$author}', `photo_source` = '{$photo_source}', `is_changed` = 1 WHERE `id` = '{$id}'");
        
        if (isset($_POST['is_special']) && $_POST['is_special'] == 'on') {
            $mysql->runQuery("UPDATE `articles` SET `is_special` = 0");
            $mysql->runQuery("UPDATE `articles` SET `is_special` = 1 WHERE `id` = '{$id}'");
        }
        
        $mysql->runQuery("UPDATE `articles` SET `is_for_zen` = 0 WHERE `id` = '{$id}'");
        if (isset($_POST['is_for_zen']) && $_POST['is_for_zen'] == 'on') {
            $mysql->runQuery("UPDATE `articles` SET `is_for_zen` = 1 WHERE `id` = '{$id}'");
        }

        $mysql->runQuery("UPDATE `articles` SET `is_yandex` = 0 WHERE `id` = '{$id}'");
        if (isset($_POST['is_yandex']) && $_POST['is_yandex'] == 'on') {
            $mysql->runQuery("UPDATE `articles` SET `is_yandex` = 1 WHERE `id` = '{$id}'");
        }
        
        //$mysql->runQuery("DELETE FROM `articles_memory` WHERE `id` = '{$id}'");
        //$mysql->runQuery("INSERT INTO `articles_memory` SELECT * FROM `articles` WHERE `id` = '{$id}'");
        //$mysql->runQuery("DELETE FROM `blocks_memory` WHERE `article_id` = '{$id}'");
        //$mysql->runQuery("INSERT INTO `blocks_memory` SELECT * FROM `blocks` WHERE `article_id` = '{$id}'");
        //$A->purgeCache($id);
        
        $article = $A->getArticle($id);

        setSuccess('Изменения успешно сохранены');
    }
    
    if (!$article) redirectTo(getBackUrl());

