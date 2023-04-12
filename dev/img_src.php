<?php

    require_once "functions.php";

    $sql = "SELECT * FROM `images` WHERE 
            `article_id` > 0 AND `source` = '' AND `article_id` IN (SELECT `id` FROM `articles` WHERE `is_deleted` = 0 AND `category_id` <> 55 AND `category_id` = 46) 
           ";
    $res = $mysql->getQuery($sql);    
    $count = count($res);
    
    if (rand(0,1) == 0) $count = 0;
    
    if ($count == 0) {
        $sql = "SELECT * FROM `images` WHERE 
                `article_id` > 0 AND `source` = '' AND `article_id` IN (SELECT `id` FROM `articles` WHERE `is_deleted` = 0 AND (`category_id` <> 55 OR `article_id` > 2000)) 
              ";
        $res = $mysql->getQuery($sql);    
        $count = count($res);
    }

    $sql = "{$sql} ORDER BY `article_id` DESC, `photo_id` ASC LIMIT 1";

    if (isset($_GET['type']) && $_GET['type'] == 'post') {
        if (!isset($_GET['aid']) || !isset($_GET['pid']) || !isset($_GET['link'])) die('error');
        
        $article_id = (int) $_GET['aid'];
        $photo_id = (int) $_GET['pid'];
        $link = $mysql->escapeString(urldecode($_GET['link']));
        $source_orig = urldecode($_GET['source']);
        $source = $source_orig;
        //$source = trim(preg_replace('/[^\p{Cyrillic}a-z0-9.,-_ \s_-]+/u', '', $source_orig));
        $source_orig = $mysql->escapeString($source_orig);
        $source = $mysql->escapeString($source);
        
        if ($source == '') $source = "pinterest.com";
        
        $mysql->runQuery("UPDATE `images` SET `source` = '{$source}', `source_orig` = '{$source_orig}', `source_url` = '{$link}' WHERE `article_id` = '{$article_id}' AND `photo_id` = '{$photo_id}'");
        
        $res = $mysql->getQuery($sql);    
        $url = "";
        foreach ($res as $i) $url = "https://yandex.ru/images/search?rpt=imageview&url=https://lafoy.ru/photo_l/foto-{$i->article_id}-{$i->photo_id}.jpg";
        
        if ($url != "") {
            echo "<a id='lid' href='{$url}' rel='noopener noreferrer nofollow'>{$count}</a>";
            echo "<script>";
            echo "document.getElementById('lid').click();";
            echo "</script>";
        } else {
            echo "<a id='lid' href='/img_src.php' rel='noopener noreferrer nofollow'>0</a>";
            echo "<script>";
            echo "document.getElementById('lid').click();";
            echo "</script>";
        }
        
        exit;
    }

    /*
    if (isset($_GET['type']) && $_GET['type'] == 'fix') {
        $n = 0;
        $res = $mysql->getQuery("SELECT * FROM `images` WHERE `source` <> ''");
        foreach ($res as $i) {
            $source = trim(preg_replace('/[^\p{Cyrillic}a-z0-9.,-_ \s_-]+/u', '', $i->source));
            if ($source != $i->source) {
                $n ++;
                $source = $mysql->escapeString($source);
                $source_orig = $mysql->escapeString($i->source_orig);
                $mysql->runQuery ("UPDATE `images` SET `source` = '{$source}' WHERE (`article_id` = {$i->article_id} AND `photo_id` = {$i->photo_id}) OR `source_orig` = '{$source_orig}'");
                error_log ($i->article_id . " :: " . $source . " :: " . $i->source . "\n");
                if ($n > 1) break;
            }
        }
    }
    */
    
    if (isset($_GET['type']) && $_GET['type'] == 'get_image') {
        
        $res = $mysql->getQuery($sql);    
        $url = "";
        foreach ($res as $i) $url = "https://yandex.ru/images/search?rpt=imageview&url=https://lafoy.ru/photo_l/foto-{$i->article_id}-{$i->photo_id}.jpg";
        
        die($url);
    }

    $res = $mysql->getQuery($sql);
    
    $url = "";
    foreach ($res as $i) $url = "https://yandex.ru/images/search?rpt=imageview&url=https://lafoy.ru/photo_l/foto-{$i->article_id}-{$i->photo_id}.jpg";
    
    if ($url != "") {
        echo "<a id='lid' href='{$url}' rel='noopener noreferrer nofollow'>{$count}</a>";
        echo "<script>";
        echo "document.getElementById('lid').click();";
        echo "</script>";
        exit;
    }
    
?>
<html>
    <head>
        <meta http-equiv="refresh" content="60" />
    </head>
    <br /><br /><br />
    <p style="text-align:center">No photos. Auto reload page after 1 min [<?php echo date("Y-m-d H:i:s", date("U") + 60) ?>].</p>
</head>