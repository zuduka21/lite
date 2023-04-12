<?php

class Article
{
    private $mysql;
    private $categories = array();
    private $expire_time = 63072000; //2 years

    private $table_articles = 'articles';
    private $table_related_articles = 'relative_articles';
    private $table_categories = 'categories';
    private $table_blocks = 'blocks';
    
    private $is_getRelatedArticles_calculated = false;

    public function __construct ($mysql, $is_dev = true)
    {
        date_default_timezone_set ('Europe/Moscow');
        $this->mysql = $mysql; 
        
        if ($is_dev === false) {
            $this->table_articles = 'articles_memory';
            $this->table_related_articles = 'relative_articles_memory';
            $this->table_categories = 'categories_memory';
            $this->table_blocks = 'blocks_memory';
        }
                
        //$this->dev2live();
    }
    
    private function dev2live() {

        /*
        $from = date("U") - 5*24*3600;
        $to = date("U");
        
        $res = $this->mysql->getQuery("SELECT `id` FROM `articles`");
        foreach ($res as $item) {
            $d = rand($from, $to);
            $this->mysql->runQuery("UPDATE `articles` SET `date` = '{$d}' WHERE `id` = '{$item->id}'");
        }
        */
        
        /*
        $this->mysql->runQuery("DROP TABLE `articles_memory`");
        $this->mysql->runQuery("DROP TABLE `categories_memory`");
        $this->mysql->runQuery("DROP TABLE `blocks_memory`");
        
        $this->mysql->runQuery("CREATE TABLE `articles_memory` engine=MyISAM SELECT * FROM `articles` WHERE `is_deleted` = 0 AND `is_published` = 1");
        $this->mysql->runQuery("
            ALTER TABLE `articles_memory`
                ADD PRIMARY KEY (`id`),
                ADD KEY `sort` (`date`),
                ADD KEY `url` (`url`),
                ADD KEY `category_id` (`category_id`),
                ADD KEY `user_id` (`user_id`);
        ");
        $this->mysql->runQuery("
            ALTER TABLE `articles_memory` ADD FULLTEXT KEY `name` (`name`);
        ");

        $this->mysql->runQuery("CREATE TABLE `categories_memory` engine=MyISAM as SELECT * FROM `categories` WHERE `id` IN (SELECT DISTINCT `category_id` FROM `articles_memory`)");
        $this->mysql->runQuery("
            ALTER TABLE `categories_memory`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `name` (`name`),
                ADD KEY `sort` (`sort`),
                ADD KEY `url` (`url`),
                ADD KEY `is_main` (`is_main`),
                ADD KEY `parent_id` (`parent_id`);
        ");
        $this->mysql->runQuery("
            ALTER TABLE `categories_memory` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ");

        $this->mysql->runQuery("CREATE TABLE `blocks_memory` engine=MyISAM as SELECT * FROM `blocks` WHERE `is_deleted` = 0 AND `article_id` IN (SELECT `id` FROM `articles_memory`)");
        $this->mysql->runQuery("
            ALTER TABLE `relative_articles_memory`
                ADD PRIMARY KEY (`article_id`,`relative_id`),
                ADD KEY `article_id` (`article_id`),
                ADD KEY `relative_id` (`relative_id`),
                ADD KEY `is_link` (`is_link`);
        ");
        */
    }
    
    public function getBlockTypes() {
        return array (
            1 => 'H2',
            6 => 'H3',
            2 => 'Текст',
            3 => 'Фото',
            4 => 'Видео',
            5 => 'Реклама',
            9 => 'Запись',
        );
    }
    
    function getBlockType($id) {
        $types = $this->getBlockTypes();
        return isset($types[$id]) ? $types[$id] : '';
    }
    
    public function getArticlePhotos($id) {
        $ret = array();
        $res = $this->mysql->getQuery("SELECT `photo_id`, `width`, `height`, `source` FROM `images` WHERE `article_id` = '{$id}'");
        foreach ($res as $i) {
            if ($i->source == '.') $i->source = 'pinterest.com';
            $ret[$id . "_" . $i->photo_id] = $i;
        }
        return $ret;
    }
    
    public function getCategories($params = []) {
        $this->categories = [];
        if (count($this->categories) == 0) {
            $ids = array(-1);
            $res = $this->mysql->getQuery("SELECT DISTINCT `category_id` FROM  `{$this->table_articles}` WHERE `is_deleted` = 0");
            foreach ($res as $i) $ids[] = $i->category_id;
            $ids = implode(",", $ids);

            if(isset($params['menu']) && $params['menu']){
                $res = $this->mysql->getQuery("SELECT * FROM  `{$this->table_categories}` WHERE " . (isset($params['is_main']) && $params['is_main'] ? '`is_main` = ' . $params['is_main'] : '') . " ORDER BY `{$this->table_categories}`.`sort` ASC");
            }else{
                $res = $this->mysql->getQuery("SELECT * FROM  `{$this->table_categories}` WHERE `id` IN ({$ids}) " . (isset($params['is_main']) && $params['is_main'] ? ' AND `is_main` = ' . $params['is_main'] : '') . " ORDER BY `{$this->table_categories}`.`sort` ASC");
            }
            if(isset($params['posts']) && $params['posts']){
                $res = $this->mysql->getQuery("SELECT * FROM  `{$this->table_categories}`  ORDER BY `{$this->table_categories}`.`sort` ASC");
            }

            foreach ($res as $i) {
                if(!(int)$i->is_main):
                    $parent_category = $this->getCategory($i->parent_id);
                    $i->_url = $parent_category->_url . '/' . $i->url;
                    $i->url = getUrl($parent_category->_url . '/' . $i->url);
                else:
                    $i->_url = $i->url;
                    $i->url = getUrl($i->url);
                endif;

                $this->categories[$i->id] = $i;
            }
        }
        
        return $this->categories;
    }
    
    public function getCategory($id) {
        $res = $this->mysql->getQuery("SELECT * FROM  `{$this->table_categories}` WHERE `id` = '{$id}' ORDER BY `{$this->table_categories}`.`sort` ASC");
        if ($res && isset($res[0])):
            $ret = $res[0];
            if(!$ret->is_main):
                $parent_category = $this->getCategory($ret->parent_id);
                $ret->_url = $parent_category->_url . '/' . $ret->url;
                $ret->url = getUrl($parent_category->_url . '/' . $ret->url);
            else:
                $ret->_url = $ret->url;
                $ret->url = getUrl($ret->url);
            endif;
            return $ret;
        else:
            return false;
        endif;
    }

    public function getSubCategories($id) {
        $res = $this->mysql->getQuery("SELECT id FROM  `{$this->table_categories}` WHERE `parent_id` = '{$id}' ORDER BY `{$this->table_categories}`.`sort` ASC");
        $ret = array();
        foreach ($res as $item) $ret[] = $item->id;

        return $ret;
    }
    
    public function getCategoryByURL($url) {
        $categories = $this->getCategories(['posts' => true]);
        foreach ($categories as $item)

            if ($item->_url == $url):
                return $item;
            endif;
        return false;
    }
    
    public function getCountArticles() {
        $res = $this->mysql->getQuery("SELECT COUNT(`id`) as `c` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0");
        foreach ($res as $item) return $item->c;
        return 0;
    }
    
    public function getArticles ($page = 1, $limit = 10) {
        
        //$count = ceil ($this->getCountArticles() / $limit); 
        $l = (($page - 1) * $limit) . ", {$limit}";

        $ids = array(-1);
        $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 ORDER BY `date` DESC LIMIT {$l}");
        
        $ret = array();
        foreach ($res as $item) $ret[] = $this->getArticle($item->id);
        
        return $ret;
    }

    public function getRelatedArticles ($id)
    {
        $date = date("Y-m-d H:i:s", date("U") - 24*60*60);
        $date = date("Y-m-d H:i:s", date("U")); 

        $res = $this->mysql->getQuery("SELECT `id`, `name`, `meta_title`, `url`, `score`, `{$this->table_related_articles}`.`date` FROM `{$this->table_articles}`, `{$this->table_related_articles}` WHERE `article_id` = {$id} AND `is_deleted` = 0 AND `{$this->table_articles}`.`id` = `{$this->table_related_articles}`.`relative_id` ORDER BY `score` DESC");
        
        if (isset($res[0]) && $res[0]->date > $date) return $res;

        //Обновляем поле `help_search`
        $res = $this->mysql->getQuery("SELECT `article_id`, `info` FROM `{$this->table_blocks}` WHERE `type` = 21 AND `article_id` IN (SELECT `id` FROM `{$this->table_articles}` WHERE `help_search` = '')");
        foreach ($res as $i) {
            $d = @json_decode($i->info);
            if ($d && isset($d->category)) {
                $d->category = $this->mysql->escapeString($d->category);
                $this->mysql->runQuery("UPDATE `{$this->table_articles}` SET `help_search` = '{$d->category}' WHERE `id` = '{$i->article_id}'");
            }
        }


        $article = $this->getArticle($id);
        $title = $article->help_search . " " . $article->name;

        $replace_words = array("название", "год", "года", "названия", "описания", "описание", "самых", "самые", "красивых", "красивые", "оригинальных", "оригинальные", "вкусных", "вкусные", "идеи", "идей", "ярких", "яркие", "легких", "легкие", "простых", "простые", "быстрых", "быстрые", "фото", "топ", "свежих", "свежие", "фото-идей", "фото-идеи", "лучших", "лучшие", "очень", "приготовления", "эффективных", "эффективные", "каталог", "полезных", "полезные", "отличных", "отличные", "аппетитных", "аппетитные", "недорогие", "недорогих", "стильных", "стильные", "интересных", "интересные", "каталог", "в", "на", "из", "тебе", "для", "про", "которые", "которых", "что", "и", "по", "пошагово", "пошаговые", "пошаговых", "все", "руками", "своими", "сделать", "способ", "способов", "модные", "модных", "украсят", "любой", "вкуснейших", "каждый", "сможет", "сытных", "которые", "гурманов", "настоящих", "точно", "стоит", "каждому", "придутся", "пробовали", "покорят", "ароматные", "ароматом", "готовить", "захочешь", "съесть", "идеальной", "сочных", "сочный", "нежных", "нежный", "стол", "вкуснее", "тает", "рту", "действительно", "хочет", "что-то", "вкусненькое", "которых", "еще", "ели", "снова", "вкуснейшей", "справится", "любая", "хозяйка", "незабываемым", "незабываемый", "сделают", "съедаются", "последней", "крошки", "подчистую", "всегда", "нежнейшей", "семьи", "пышный", "сложно", "устоять", "которыми", "пробовали", "вкуснее", "действительно", "пышные", "сочной", "мягкой", "непременно", "удивят", "можно", "готовить", "тает", "рту", "влюбишься", "порадуют", "семью", "любит", "поесть", "шикарных", "бюджет", "гурманов", "настоящих", "отличных", "любой", "самой", "простых", "легких", "лучших", "потекут", "слюнки", "аппетитных", "захочется", "полюбит", "любимыми", "станут", "хочется", "домашним", "новенькое", "хозяйка", "справится", "времена", "думали", "последней", "крошки", "изумительных", "изумительные", "бесподобных", "исчезает", "стол", "стола", "прямо", "сейчас", "восторге", "разнообразных", "разнообразят", "невероятно", "оценит", "приготовить", "понравятся", "всей", "семье", "с", "из", "рецепт", "рецептов", "рецепты", "к", "для", "готовятся", "проще", "простого", "вы", "не", "готовили", "простых", "и", "вкусных", "аппетитных", "рецептов", "невероятно", "на", "любой", "вкус", "быстрых", "лучших", "которые", "разнообразят", "ваше", "меню", "каждый", "день", "для", "настоящих", "гурманов", "вы", "будете", "готовить", "снова", "отличных", "самых", "от", "которых", "у", "вас", "потекут", "слюнки", "как", "приготовить", "идеальный", "легко", "ты", "будешь", "в", "восторге", "стоит", "прямо", "сейчас", "всей", "семьи", "бюджет", "украсят", "стол", "сможет", "шикарных", "тех,", "кто", "любит", "вкусно", "поесть", "перед", "которыми", "невозможно", "устоять", "выручат", "ситуации", "хочется", "точно", "попробовать", "к", "празднику", "оригинальных", "съедаются", "подчистую", "всегда", "Обрадуют", "всю", "семью", "вкуснее", "еще", "не", "ели", "тают", "во", "рту", "получаются", "влюбитесь", "непременно", "удивят", "можно", "всё", "лето", "полюбите", "исчезают", "со", "стола", "за", "считаные", "минуты", "сложно", "вкусными", "бесподобных", "до", "последней", "крошки", "готовятся", "пару", "минут", "проще,", "чем", "думали", "аппетитнейших", "изумительных", "с", "справится", "любая", "хозяйка", "хочет", "что-нибудь", "новенькое", "способов", "вкусные", "понравятся", "домашним", "захочешь", "съесть", "круглый", "год", "придутся", "по", "вкусу", "каждому", "станут", "вашими", "любимыми", "полюбит", "вся", "семья", "семье", "захочется", "раз", "гости", "будут", "этого", "лета", "оценит", "который", "разнообразит", "Ваш", "летний", "под", "силу", "даже", "начинающим", "готовили", "самостоятельно", "проще", "простого", "очень", "просты", "приготовлении", "порадуют", "своим", "вкусом", "привычный", "рацион", "посмотреть");
        
        $replace_words = array_unique($replace_words);        
        
        for ($i = 2019; $i<=2030; $i++) $replace_words[] = (string) $i;

        $title = preg_replace('/\b(' . implode('|', $replace_words) . ')\b/u', '', mb_strtolower($title));
        $title = preg_replace('#[[:punct:]]#', '', $title);
        $title = preg_replace('/\d+/u', '', $title);
        $title = preg_replace('/\s+/', ' ', $title);
        if (preg_match('/[0-9]{4}+/', $article->name)):
            $annual_post = true;
        else:
            $annual_post = false;
        endif;

        $title = implode(" ", array_unique(explode(" ", $title)));
        //print_r($title); die();

        $date = date("Y-m-d H:i:s");

        $sql = "SELECT id, name, meta_title, url, 
                       ROUND(1000 * (5*MATCH(help_search) AGAINST('{$title}') + MATCH(name) AGAINST('{$title}') + MATCH(meta_description) AGAINST('{$title}'))) AS `score` 
                FROM  `{$this->table_articles}`
                WHERE is_deleted = 0 AND id <> '{$id}' AND `is_published` = 1 AND category_id = '{$article->category_id}'  ORDER BY score DESC LIMIT 15";

        $res = $this->mysql->getQuery($sql);
        //die($sql);

        if ($annual_post):
            foreach ($res as $key => $re) {
                if (preg_match('/[0-9]{4}+/', $re->name) || preg_match('/[0-9]{4}+/', $re->meta_title)){
                    array_splice($res, $key, 1);
                }
            }
        endif;
        foreach ($res as $re) {
            $this->mysql->runQuery ("INSERT INTO `{$this->table_related_articles}` SET `article_id` = '{$id}', `relative_id` = '{$re->id}', `score` = '{$re->score}', `date` = '{$date}'");
            $this->mysql->runQuery ("UPDATE `{$this->table_related_articles}` SET `score` = '{$re->score}', `date` = '{$date}' WHERE  `article_id` = '{$id}' AND `relative_id` = '{$re->id}'");
        }
        
        return $res;

    }

    function getRelativeArticle_old($aid, $n) {
        //$res = $this->mysql->getQuery("SELECT `relative_articles_memory`.*, `a`.`category_id`, `b`.`category_id` FROM `relative_articles_memory`, `articles_memory` as `a`, `articles_memory` as `b` WHERE `article_id` = `a`.`id` AND `relative_id` = `b`.`id`AND `a`.`category_id` <> `b`.`category_id`");
        //foreach ($res as $i) $this->mysql->runQuery("DELETE FROM `relative_articles_memory` WHERE `article_id` = '{$i->article_id}' AND `relative_id` = '{$i->relative_id}'");
        
        $this->getRelatedArticles($aid);
        
        $exclude = array(0);
        $res = $this->mysql->getQuery("SELECT `id` FROM `{$this->table_articles}` WHERE `name` LIKE '%2019%' OR `name` LIKE '%2020%' OR `name` LIKE '%2021%' OR `name` LIKE '%2022%' OR `name` LIKE '%2023%' OR `name` LIKE '%2024%' OR `name` LIKE '%2025%' OR `name` LIKE '%2026%' OR `name` LIKE '%2027%' OR `name` LIKE '%2028%' OR `name` LIKE '%2029%'");
        foreach ($res as $i) $exclude[] = $i->id;
        $exclude = implode(",", $exclude);
        
        $res = $this->mysql->getQuery("SELECT `relative_id` FROM `{$this->table_related_articles}` WHERE `article_id` = '{$aid}' AND `is_link` = '{$n}' AND `relative_id` NOT IN ({$exclude})");
        if (!$res || count($res) == 0) {
            $score = 100;
            $res = $this->mysql->getQuery("SELECT `relative_id` FROM `{$this->table_related_articles}` WHERE `article_id` = '{$aid}' AND `is_link` = 0 AND `score` > '{$score}' AND 
                                           `relative_id` NOT IN (SELECT `relative_id` FROM `{$this->table_related_articles}` WHERE `is_link` > 0 GROUP BY `relative_id` HAVING (COUNT(`relative_id`) >= 15)) AND
                                           `relative_id` NOT IN (SELECT `article_id` FROM `{$this->table_related_articles}` WHERE `is_link` > 0 AND `relative_id` = '{$aid}') AND
                                           `relative_id` NOT IN ({$exclude})
                                           ORDER BY `score` DESC LIMIT 1");
            if ($res) {
                $this->mysql->runQuery("UPDATE `{$this->table_related_articles}` SET `is_link` = '{$n}' WHERE `article_id` = '{$aid}' AND `relative_id` = '" . $res[0]->relative_id . "'");
            }
        }

        if ($res) {
            return $this->getArticle($res[0]->relative_id);
        } else {
            return false;
        }
    }

    function getRelativeArticle($aid, $n) {
        //$res = $this->mysql->getQuery("SELECT `relative_articles_memory`.*, `a`.`category_id`, `b`.`category_id` FROM `relative_articles_memory`, `articles_memory` as `a`, `articles_memory` as `b` WHERE `article_id` = `a`.`id` AND `relative_id` = `b`.`id`AND `a`.`category_id` <> `b`.`category_id`");
        //foreach ($res as $i) $this->mysql->runQuery("DELETE FROM `relative_articles_memory` WHERE `article_id` = '{$i->article_id}' AND `relative_id` = '{$i->relative_id}'");
        
        if (!$this->is_getRelatedArticles_calculated) {
            $this->is_getRelatedArticles_calculated = true;
            $this->getRelatedArticles($aid);
        }
        
        $exclude = array(0);
        //$res = $this->mysql->getQuery("SELECT `id` FROM `{$this->table_articles}` WHERE `name` LIKE '%2019%' OR `name` LIKE '%2020%' OR `name` LIKE '%2021%' OR `name` LIKE '%2022%' OR `name` LIKE '%2023%' OR `name` LIKE '%2024%' OR `name` LIKE '%2025%' OR `name` LIKE '%2026%' OR `name` LIKE '%2027%' OR `name` LIKE '%2028%' OR `name` LIKE '%2029%'");
        //foreach ($res as $i) $exclude[] = $i->id;
        $exclude = implode(",", $exclude);
        
        $res = $this->mysql->getQuery("SELECT `relative_id` FROM `{$this->table_related_articles}` WHERE `article_id` = '{$aid}'  AND `relative_id` NOT IN ({$exclude}) ORDER BY `score` DESC LIMIT 15");

        if ($res && isset($res[$n - 1])) {
            return $this->getArticle($res[$n - 1]->relative_id);
        } else {
            return false;
        }
    }

    public function getArticlesZen ($page = 1, $limit = 10) {
        
        //$count = ceil ($this->getCountArticles() / $limit); 
        $l = (($page - 1) * $limit) . ", {$limit}";

        $ids = array(-1);
        $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 AND `is_for_zen` = 1 ORDER BY `date` DESC LIMIT {$l}");
        
        $ret = array();
        foreach ($res as $item) $ret[] = $this->getArticle($item->id);
        
        return $ret;
    }
    
    public function getArticlesTurbo ($page = 1, $limit = 10) {
        
        //$count = ceil ($this->getCountArticles() / $limit); 
        $from = ($page - 1) * $limit;	
        $to = $from + $limit;	
        $ids = array(-1);
        if($page):
            $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 AND `id` >= '{$from}' AND `id` < '{$to}' ORDER BY `id` DESC");        
        else:
            $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 ORDER BY `id` DESC LIMIT {$limit}");
        endif;
        $ret = array();
        
        foreach ($res as $item) $ret[] = $this->getArticle($item->id);

        return $ret;
    }
    
    public function getSearch ($s, $limit = 10) {
        
        $s = $this->mysql->escapeString($s);
        $w = "`name` LIKE '%{$s}%' OR `meta_title` LIKE '%{$s}%'";
        
        $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE ({$w}) AND `is_deleted` = 0 ORDER BY `id` DESC LIMIT {$limit}");

        $ret = array();
        foreach ($res as $item) $ret[] = $this->getArticle($item->id);
        
        return $ret;
    }
    
    public function getCountArticlesByCategory($id) {
        $category = $this->getCategory($id);
        if($category->is_main):
            $categories = $this->getSubCategories($category->id);
            array_push($categories, $category->id);
            $categories =  implode("', '",$categories);
            $res = $this->mysql->getQuery("SELECT COUNT(`id`) as `c` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 AND `category_id` IN ('" . $categories . "')");
        else:
            $res = $this->mysql->getQuery("SELECT COUNT(`id`) as `c` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 AND `category_id` = '{$id}'");
        endif;

        foreach ($res as $item) return $item->c;
        return 0;
    }
    
    public function getArticlesByCategory ($id, $page = 1, $limit = 10) {
        
        //$count = ceil ($this->getCountArticlesByCategory($id) / $limit); 
        $l = (($page - 1) * $limit) . ", {$limit}";

        $ids = array(-1);
        $category = $this->getCategory($id);
        if($category->is_main):
            $categories = $this->getSubCategories($category->id);
            array_push($categories, $category->id);
            $categories =  implode("', '",$categories);
            $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `category_id` IN ('" . $categories . "') AND `is_deleted` = 0 ORDER BY `date` DESC LIMIT {$l}");
        else:
            $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `category_id` = '{$id}' AND `is_deleted` = 0 ORDER BY `date` DESC LIMIT {$l}");
        endif;

        $ret = array();
        foreach ($res as $item) $ret[] = $this->getArticle($item->id);
        return $ret;
    }
    
    public function getRelativeArticles ($id, $limit = 1) {
        $ids = array(-1);
        $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `id` < {$id} AND `is_deleted` = 0 ORDER BY `id` DESC LIMIT {$limit}");
        
        $ret = array();
        foreach ($res as $item) $ret[] = $this->getArticle($item->id);
        
        if (count($ret) < $limit) {
            
            $limit = $limit - count($ret);
            $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `id` > {$id} AND `is_deleted` = 0 ORDER BY `id` ASC LIMIT {$limit}");
            foreach ($res as $item) $ret[] = $this->getArticle($item->id);
            
        }
        
        return $ret;
    }
    
    public function getSpecialArticle () {

        $id = (getPageType() == 'post') ? getID() : 0;

        $res = $this->mysql->getQuery("SELECT `id` FROM  `{$this->table_articles}`  WHERE `id` <> '{$id}' AND `is_deleted` = 0 ORDER BY `is_special` DESC, `date` DESC LIMIT 1");
        
        $id = 0;
        foreach ($res as $item) $id = $item->id;
        
        return $id > 0 ? $this->getArticle($id) : false;
    }

    public function getRandomArticle ($limit = 1, $exclude_id = 0) {
        if(is_array($exclude_id)):
            $ids = implode($exclude_id, ',');
        else:
            $ids = $exclude_id;
        endif;

        $res = $this->mysql->getQuery("SELECT `id`, `meta_title`, `url` FROM  `{$this->table_articles}`  WHERE `is_deleted` = 0 AND `id` NOT IN ('{$ids}') ORDER BY RAND() LIMIT {$limit}");
        
        return $res;
    }
    
    public function getArticle($id, $inc_reviews = false) {

        $ret = false;
        $res = $this->mysql->getQuery("SELECT * FROM  `{$this->table_articles}`  WHERE `id` = '{$id}' AND `is_deleted` = 0");
        if ($res && isset($res[0])) {
          
            $ret = $res[0];

            //Prepare cover
            if (file_exists (__DIR__ . "/../i/{$ret->id}/0.jpg") && !file_exists (__DIR__ . "/../i/{$ret->id}/0_s.jpg")) {
                $image = new SimpleImage();
                $image->load(__DIR__ . "/../i/{$ret->id}/0.jpg");
                $image->resizeToWidth(450);
                $image->save(__DIR__ . "/../i/{$ret->id}/0_s.jpg", IMAGETYPE_JPEG, 85);

                $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg(__DIR__ . "/../i/{$ret->id}/0_s.jpg"));
            }
          
            if (file_exists (__DIR__ . "/../i/{$ret->id}/0.jpg") && !file_exists (__DIR__ . "/../i/{$ret->id}/0_l.jpg")) {
                $image = new SimpleImage();
                $image->load(__DIR__ . "/../i/{$ret->id}/0.jpg");
                $image->resizeToWidth(750);
                $image->save(__DIR__ . "/../i/{$ret->id}/0_l.jpg", IMAGETYPE_JPEG, 85);

                $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg(__DIR__ . "/../i/{$ret->id}/0_l.jpg"));
            }

            if (file_exists (__DIR__ . "/../i/{$ret->id}/0.jpg") && !file_exists (__DIR__ . "/../i/{$ret->id}/0_1200px.jpg")) {
                $image = new SimpleImage();
                $image->load(__DIR__ . "/../i/{$ret->id}/0.jpg");
                $image->forcedResizeToWidth(1200);
                $image->save(__DIR__ . "/../i/{$ret->id}/0_1200px.jpg", IMAGETYPE_JPEG, 85);

                $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg(__DIR__ . "/../i/{$ret->id}/0_1200px.jpg"));
            }

            $ret->_url = $ret->url;
            $ret->url = getUrl ($ret->url . "-" . $ret->id);
            $ret->category = $this->getCategory($ret->category_id);
            if((int)$ret->id > 1457):
                $ret->cover = file_exists (__DIR__ . "/../i/{$ret->id}/0.jpg") ? getUrl ("photo/foto-{$ret->id}-0.jpg") : getUrl ("/img/no_image.jpg");
                $ret->cover_b = file_exists (__DIR__ . "/../i/{$ret->id}/0_1200px.jpg") ? getUrl ("photo_b/foto-{$ret->id}-0.jpg") : $ret->cover;
                $ret->cover_l = file_exists (__DIR__ . "/../i/{$ret->id}/0_l.jpg") ? getUrl ("photo_l/foto-{$ret->id}-0.jpg") : $ret->cover;
                $ret->cover_s = file_exists (__DIR__ . "/../i/{$ret->id}/0_s.jpg") ? getUrl ("photo_s/foto-{$ret->id}-0.jpg") : $ret->cover;
                $ret->blocks = $this->getBlocks($id);
            else:
                $ret->cover = file_exists (__DIR__ . "/../i/{$ret->id}/0.jpg") ? getUrl ("photo/{$ret->photo_source}-{$ret->id}-0.jpg") : getUrl ("/img/no_image.jpg");
                $ret->cover_b = file_exists (__DIR__ . "/../i/{$ret->id}/0_1200px.jpg") ? getUrl ("photo_b/foto-{$ret->id}-0.jpg") : $ret->cover;
                $ret->cover_l = file_exists (__DIR__ . "/../i/{$ret->id}/0_l.jpg") ? getUrl ("photo_l/{$ret->photo_source}-{$ret->id}-0.jpg") : $ret->cover;
                $ret->cover_s = file_exists (__DIR__ . "/../i/{$ret->id}/0_s.jpg") ? getUrl ("photo_s/{$ret->photo_source}-{$ret->id}-0.jpg") : $ret->cover;
                $ret->blocks = $this->getBlocks($id, $ret->photo_source);

            endif;
        }
        
        if ($inc_reviews == true) {
            $this->mysql->runQuery("UPDATE `articles` SET `reviews` = `reviews` + 1 WHERE `id` = '{$id}'");
            $this->mysql->runQuery("UPDATE `articles_memory` SET `reviews` = `reviews` + 1 WHERE `id` = '{$id}'");
        }

        return $ret;
        
    }
    
    public function getBlocks($article_id, $url = 'foto') {
        $ret = $this->mysql->getQuery("SELECT * FROM `{$this->table_blocks}` WHERE `article_id` = '{$article_id}' AND `is_deleted` = 0 ORDER BY `sort` ASC");

        if ($ret)
        foreach ($ret as $item) {
            
            $src = __DIR__ . "/../i/{$item->article_id}/{$item->id}.jpg";
            $dst_l = __DIR__ . "/../i/{$item->article_id}/{$item->id}_l.jpg";
            $dst_s = __DIR__ . "/../i/{$item->article_id}/{$item->id}_s.jpg";
            //Prepare cover
            if (file_exists ($src) && !file_exists ($dst_s)) {
                $image = new SimpleImage();
                $image->load($src);
                $image->resizeToWidth(450);
                $image->save($dst_s, IMAGETYPE_JPEG, 85);

                $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg($dst_s));
            }
          
            if (file_exists ($src) && !file_exists ($dst_l)) {
                $image = new SimpleImage();
                $image->load($src);
                $image->resizeToWidth(750);
                $image->save($dst_l, IMAGETYPE_JPEG, 85);

                $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg($dst_l));
            }

            $item->photo = file_exists ($src) ? getUrl ("photo/{$url}-{$item->article_id}-{$item->id}.jpg") : getUrl ("/img/no_image.jpg");
            $item->photo_l = file_exists ($dst_l) ? getUrl ("photo_l/{$url}-{$item->article_id}-{$item->id}.jpg") : $item->photo;
            $item->photo_s = file_exists ($dst_s) ? getUrl ("photo_s/{$url}-{$item->article_id}-{$item->id}.jpg") : $item->photo;

        }
        
        return $ret;
    }
    
}
