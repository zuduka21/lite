<?php 
    include "functions.php";
    include "login.php";
    
    if (isset($_POST['type']) && $_POST['type'] == 'update_category_sort') {
      
        $id = isset($_POST['id']) ? $_POST['id'] : false;
        if ($id === false) die();
      
        $value = isset($_POST['value']) ? $_POST['value'] : false;
        if ($value === false) die();
      
        $mysql->runQuery("UPDATE `categories` SET `sort` = '{$value}' WHERE `id` = '{$id}'");
        
    }
    
    if (isset($_POST['type']) && $_POST['type'] == 'update_config') {

        $key = isset($_POST['key']) ? $mysql->escapeString($_POST['key']) : false;
        if (!$key) die();

        $value = isset($_POST['value']) ? $_POST['value'] : false;
        if ($value === false) die();

        $mysql->setConfig($key, $value);
    }