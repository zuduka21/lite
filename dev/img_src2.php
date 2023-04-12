<?php

    include __DIR__ . "/config.php";
    include __DIR__ . "/src/Mysql.class.php";
    include __DIR__ . "/src/Article.class.php";
    include __DIR__ . "/src/SimpleImage.class.php";
    
    $mysql = new Mysql($global_database_login, $global_database_password, $global_database_name);

        $n = 0;
        $res = $mysql->getQuery("SELECT * FROM `images` WHERE `source` <> '' ORDER BY `article_id` DESC");
        foreach ($res as $i) {
            $source = trim(preg_replace('/[^\p{Cyrillic}a-z0-9.,-_ \s_-]+/u', '', $i->source));
            if ($source != $i->source) {
                $n ++;
                $source = $mysql->escapeString($source);
                $source_orig = $mysql->escapeString($i->source_orig);
                $mysql->runQuery ("UPDATE `images` SET `source` = '{$source}' WHERE (`article_id` = {$i->article_id} AND `photo_id` = {$i->photo_id}) OR `source_orig` = '{$source_orig}'");
                echo  ($i->article_id . " :: " . $source . " :: " . $i->source . "\n");
            }
        }
