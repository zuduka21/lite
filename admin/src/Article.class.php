<?php

class Article
{
    private $mysql;
    private $categories = array();
    private $expire_time = 63072000; //2 years

    public function __construct ($mysql)
    {
        date_default_timezone_set ('Europe/Moscow');

        $this->mysql = $mysql; 
    }
    
    public function getBlockTypes() {
        return array (
            3 => 'Фото',
            1 => 'H2',
            6 => 'H3',
            2 => 'Текст',
            4 => 'Видео',
            5 => 'Реклама',
            7 => 'Товар',
            8 => 'Instagram',
            9 => 'Запись'
        );
    }

    public function getMicrodataTypes() {
        return array (
            20 => 'HowTo',
            21 => 'Recipe'
        );
    }
    
    function getBlockType($id) {
        $types = $this->getBlockTypes();
        return isset($types[$id]) ? $types[$id] : '';
    }
    
    public function getCategories($params = []) {
        if (count($this->categories) == 0){
            $categories = [];
            $data = '';
            if(!empty($params)):
                $data = 'WHERE ';
                foreach ($params as $key => $param) {
                    $data .= '`' . $key . "`='" .  $param . "'";
                }
            endif;

            $res = $this->mysql->getQuery("SELECT * FROM  `categories` " . $data . " ORDER BY `categories`.`sort` ASC");

            foreach ($res as $i) $categories[$i->id] = $i;
            return $categories;
        }
    }
    
    public function getCategory($id) {
        $ret = false;
        $res = $this->mysql->getQuery("SELECT * FROM  `categories`  WHERE `id` = '{$id}'");
        if ($res && isset($res[0])) {
            $ret = $res[0];
        }

        return $ret;
    }

    public function getCategoriesCount() {
        global $mysql;

        $ret = 0;
        $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `categories`");

        foreach ($res as $item) $ret = $item->c;

        return $ret;
    }


    public function getUserArticlesCount($user_id) {
        global $mysql;

        $ret = 0;

        $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `articles` WHERE `user_id` = '{$user_id}' AND `is_deleted` = 0");

        foreach ($res as $item) $ret = $item->c;

        return $ret;
    }

    public function getNewArticlesCount($user_id = 0) {
        global $mysql;

        $ret = 0;

        if($user_id):
            $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `articles` WHERE `user_id` = '{$user_id}' AND `is_published` = 0 AND `is_deleted` = 0 AND `is_reviewed` = 0");
        else:
            $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `articles` WHERE `is_published` = 0 AND `is_deleted` = 0 AND `is_reviewed` = 0");
        endif;

        foreach ($res as $item) $ret = $item->c;

        return $ret;
    }

    public function getReviewedArticlesCount() {
        global $mysql;

        $ret = 0;
        $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `articles` WHERE `is_published` = 0 AND `is_reviewed` = 1 AND `is_deleted` = 0 ");

        foreach ($res as $item) $ret = $item->c;

        return $ret;
    }

    public function getOldArticlesCount() {
        global $mysql;
        
        $ret = 0;
        $date = date("U") - $this->expire_time;
        $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `articles` WHERE `is_published` = 0 AND `is_deleted` = 0 AND `date` < {$date}");
        
        foreach ($res as $item) $ret = $item->c;
        
        return $ret;
    }

    public function getPublishedArticlesCount() {
        global $mysql;
        
        $ret = 0;
        $res = $mysql->getQuery("SELECT COUNT(`id`) as `c` FROM `articles` WHERE `is_published` = 1 AND `is_deleted` = 0 ");
        
        foreach ($res as $item) $ret = $item->c;
        
        return $ret;
    }

    public function getArticlesByUser($user_id = 1) {
        return $this->mysql->getQuery("SELECT * FROM `articles` WHERE `user_id` = '{$user_id}' AND `is_deleted` = 0 ORDER BY `id` DESC");
    }

    public function getNewArticlesByUser($user_id = 1) {
        return $this->mysql->getQuery("SELECT * FROM `articles` WHERE `user_id` = '{$user_id}' AND `is_published` = 0 AND `is_reviewed` = 0 AND `is_deleted` = 0 ORDER BY `id` DESC");
    }

    public function getNewArticles() {
        return $this->mysql->getQuery("SELECT * FROM `articles` WHERE `is_published` = 0 AND `is_reviewed` = 0 AND `is_deleted` = 0 ORDER BY `id` DESC");
    }

    public function getReviewedArticles() {
        return $this->mysql->getQuery("SELECT * FROM `articles` WHERE `is_published` = 0 AND `is_reviewed` = 1  AND `is_deleted` = 0 ORDER BY `id` DESC");
    }
    
    public function getPublishedArticles() {
        return $this->mysql->getQuery("SELECT * FROM `articles` WHERE `is_published` = 1 AND `is_deleted` = 0 ORDER BY `id` DESC");
    }
    
    public function getOldArticles() {
        $date = date("U") - $this->expire_time;
        return $this->mysql->getQuery("SELECT * FROM `articles` WHERE `is_published` = 1 AND `is_deleted` = 0 AND `date` < {$date} ORDER BY `id` DESC");
    }
    
    public function getArticle($id) {
        
        $ret = false;
        $res = $this->mysql->getQuery("SELECT * FROM  `articles`  WHERE `id` = '{$id}' AND `is_deleted` = 0");
        if ($res && isset($res[0])) {
            $ret = $res[0];
            $ret->category = $this->getCategory($ret->category_id);
            $ret->cover = file_exists (__DIR__ . "/../img/{$ret->id}/0.jpg") ? "./img/{$ret->id}/0.jpg" : false;
            $ret->blocks = $this->getBlocks($id);
        }

        return $ret;
        
    }

    public function reviewArticle ($id) {
        $date  = date("U");
        if ($this->mysql->getConfig('update_post_date') == 1) {
            $this->mysql->runQuery("UPDATE `articles` SET `is_reviewed` = 1, `is_changed` = 1, `date` = '{$date}' WHERE `id` = '{$id}'");
        } else {
            $this->mysql->runQuery("UPDATE `articles` SET `is_reviewed` = 1, `is_changed` = 1 WHERE `id` = '{$id}'");
        }

    }

    public function saveMicrodata ($data) {
        $this->mysql->runQuery("DELETE FROM `blocks` WHERE `article_id` = '{$data['article_id']}' AND `type` = '{$data['type']}'");
        $this->mysql->runQuery("INSERT INTO `blocks` SET `article_id` = {$data['article_id']}, `info` = '{$this->mysql->escapeString($data['text'])}', `sort` = 99, `type` = {$data['type']}");
        return true;
    }

    public function publishArticle ($id) {
        $date = date("U");
        if ($this->mysql->getConfig('update_post_date') == 1) {
            $this->mysql->runQuery("UPDATE `articles` SET `is_published` = 1, `is_changed` = 0, `date` = '{$date}' WHERE `id` = '{$id}'");
        } else {
            $this->mysql->runQuery("UPDATE `articles` SET `is_published` = 1, `is_changed` = 0 WHERE `id` = '{$id}'");
        }
        
        $this->mysql->runQuery("DELETE FROM `articles_memory` WHERE `id` = '{$id}'");
        $this->mysql->runQuery("INSERT INTO `articles_memory` SELECT * FROM `articles` WHERE `id` = '{$id}'");
        $this->mysql->runQuery("DELETE FROM `blocks_memory` WHERE `article_id` = '{$id}'");
        $this->mysql->runQuery("INSERT INTO `blocks_memory` SELECT * FROM `blocks` WHERE `article_id` = '{$id}'");
        $this->mysql->runQuery("DELETE FROM `categories_memory`");
        $this->mysql->runQuery("INSERT IGNORE INTO `categories_memory` SELECT * FROM `categories`");

        $this->purgeCache($id, true);
    }
    
    public function deleteArticle ($id) {
        $this->mysql->runQuery("UPDATE `articles` SET `is_deleted` = 1 WHERE `id` = '{$id}'");

        $this->mysql->runQuery("DELETE FROM `articles_memory` WHERE `id` = '{$id}'");
        //$this->mysql->runQuery("INSERT INTO `articles_memory` SELECT * FROM `articles` WHERE `id` = '{$id}'");
        $this->purgeCache($id);

    }
    
    public function deleteBlock ($id) {
        $article_id = 0;
        $res = $this->mysql->getQuery("SELECT `article_id` FROM `blocks` WHERE `id` = '{$id}'");
        foreach ($res as $item) $article_id = $item->article_id;
        
        $this->mysql->runQuery("UPDATE `blocks` SET `is_deleted` = 1 WHERE `id` = '{$id}'");
        $this->mysql->runQuery("UPDATE `articles` SET `is_changed` = 1 WHERE `id` = '{$article_id}'");

    }
    
    public function getNewBlockNumber ($article_id) {
        $num = 0;
        $res = $this->mysql->getQuery("SELECT `sort` FROM `blocks` WHERE `article_id` = '{$article_id}' AND `is_deleted` = 0 ORDER BY `sort` DESC LIMIT 1");
        foreach ($res as $item) $num = $item->sort;
        
        $num += 10;
        
        return $num;
    }
    
    public function getBlock($id) {
        $ret = $this->mysql->getQuery("SELECT * FROM `blocks` WHERE `id` = '{$id}' AND `is_deleted` = 0");

        if ($ret)
        foreach ($ret as $item) {
            $item->photo = file_exists (__DIR__ . "/../img/{$item->article_id}/{$item->id}.jpg") ? "./img/{$item->article_id}/{$item->id}.jpg" : false;
        }
        
        return (isset($ret[0]) && $ret[0] !== false) ? $ret[0] : false;
    }

    public function getBlockByType($article_id = 0, $type = 0) {
        $ret = $this->mysql->getQuery("SELECT * FROM `blocks` WHERE `article_id` = '{$article_id}' AND `type` = '{$type}' AND `is_deleted` = 0");

        if ($ret):
            $ret[0]->info = json_decode($ret[0]->info, true);
            return (isset($ret[0]) && $ret[0] !== false) ? $ret[0] : false;
        else:
            return false;
        endif;
    }
    
    public function getBlocks($article_id) {
        $ret = $this->mysql->getQuery("SELECT * FROM `blocks` WHERE `article_id` = '{$article_id}' AND `is_deleted` = 0 ORDER BY `sort` ASC");

        if ($ret)
        foreach ($ret as $item) {
            $item->photo = file_exists (__DIR__ . "/../img/{$item->article_id}/{$item->id}.jpg") ? "./img/{$item->article_id}/{$item->id}.jpg" : false;
        }
        
        return $ret;
    }

    public function purgeCache($article_id, $all = false) {
        if ($all) {
            array_map('unlink', array_filter((array) glob(__DIR__ . "/../../live/cache/*.html")));
            array_map('unlink', array_filter((array) glob(__DIR__ . "/../../live/cache/amp/*.html")));
        } else {
            $ret = $this->mysql->getQuery("SELECT * FROM  `articles`  WHERE `id` = '{$article_id}'");
            if ($ret)
                foreach ($ret as $item) {
                    $filename = __DIR__ . "/../../live/cache/{$item->url}-{$item->id}.html";

                    if (file_exists($filename)) {
                        unlink($filename);
                    }

                    $filename = __DIR__ . "/../../live/cache/amp/{$item->url}-{$item->id}.html";

                    if (file_exists($filename)) {
                        unlink($filename);
                    }
                }
        }
    }
}