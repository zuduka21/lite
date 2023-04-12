<?php

    ini_set ("mbstring.encoding_translation", "Off");

    include __DIR__ . "/config.php";
    include __DIR__ . "/src/Mysql.class.php";
    include __DIR__ . "/src/Article.class.php";
    include __DIR__ . "/src/SimpleImage.class.php";

    if ($global_site_is_dev === true) include __DIR__ . "/login.php";
    
    $config_pages = array('new', 'published', 'old', 'categories', 'article');
    $mysql = new Mysql($global_database_login, $global_database_password, $global_database_name);
    $A = new Article($mysql, $global_site_is_dev);

    $global_now = date('U');
    $global_success_msg = '';
    $global_error_msg = '';
    $global_banner_id = 0;
    
    function getID() {
        return isset($_GET['id']) ? $_GET['id'] : 0;
    }
    
    function getParamURL() {
        return isset($_GET['url']) ? $_GET['url'] : 0;
    }
    
    function getCurrentPage() {
        return isset($_GET['page']) ? (int)$_GET['page'] : 1;
    }

    function isAMPEnabled()
    {
        return false;
    }

    function getAMPIndex()
    {
        $ampHtml = getURL().'/amp';
        if(getCurrentPage()>1)
        {
            $ampHtml .= '/'.getCurrentPage();
        }
        return $ampHtml;
    }

    function page_is_amp(){
        if(isset($_GET['amp']) && $_GET['amp']==1)
        {
            return true;
        }

        return false;
    }

    function getAMPPrefix(){
        if(page_is_amp())
        {
            return '/amp';
        }

        return '';

    }
    
    function getPageType() {
        return isset($_GET['type']) ? $_GET['type'] : '';
    }
    
    $inc_reviews = true;
    function getArticle() { 
        global $A;
        global $inc_reviews;
        
        $ret = $A->getArticle(getID(), $inc_reviews);
        $inc_reviews = false;
        return $ret;
    }

    function getRelatedArticles($id) {
        global $A;

        $ret = $A->getRelatedArticles($id);
        return $ret;
    }
    
    function getCategory() { 
        global $A;
        
        return $A->getCategoryByURL(getParamURL());
    }
    
    function getCategoryID() { 
        return isset($_GET['category']) && (int) $_GET['category'] > 0 ? (int) $_GET['category'] : 0;
    }

    function getBackUrl() {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : getUrl();
    }
    
    function getURL($params = '')
    {
        global $global_site_url;
        global $global_site_version;
                
        $ret = $global_site_url . '/' . $params;
        $ret = str_replace ("://", "@", $ret);
        $ret = str_replace ("//", "/", $ret);
        $ret = str_replace ("@", "://", $ret);

        $ret = str_replace ("common.js", "common_{$global_site_version}.js", $ret);
        $ret = str_replace ("share.js", "share_{$global_site_version}.js", $ret);
        $ret = str_replace ("style.css", "style_{$global_site_version}.css", $ret);
        
        return trim($ret, "/");
    }

    function redirectTo($url) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: {$url}");
        die();
    }
    
    function minify_output($buffer){
        $search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
        $replace = array('>','<','\\1');
        if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) {
            $buffer = preg_replace($search, $replace, $buffer);
        }
        return $buffer;
    }

    function getBannerID() {
        global $global_banner_id;
        $global_banner_id ++;
        return "bnr_{$global_banner_id}";
    }

    function returnError($error) {
        switch ($error) {
            case(404):
                @file_put_contents(__DIR__ . "/404.html", file_get_contents('http://dev.lafoy.ru/qwerty'));

                return __DIR__ . "/404.php";
                break;
            default:
                header($_SERVER["SERVER_PROTOCOL"] . " {$error} Not Found");
                header("Location: /{$error}.html");
                die();
        }
    }

    function post_nofollow($text = '') {
        $text = preg_replace_callback('~<(a\s[^>]+)>~isU', "cb2", $text);
        return $text;
    }

    function cb2($match) {
        list($original, $tag) = $match;   // regex match groups

        $blog_url = getURL();

        if (strpos($tag, "nofollow, noopener, noreferrer")) {
            return $original;
        }else {
            return "<$tag rel='nofollow, noopener, noreferrer'>";
        }
    }

    function innerHTML(\DOMElement $element)
    {
        $doc = $element->ownerDocument;
    
        $html = '';
    
        foreach ($element->childNodes as $node) {
            $html .= $doc->saveHTML($node);
        }
    
        return $html;
    }

    function str_between(string $string, string $start, string $end, bool $includeDelimiters = false, int &$offset = 0): ?string
    {
        if ($string === '' || $start === '' || $end === '') return null;
    
        $startLength = strlen($start);
        $endLength = strlen($end);
    
        $startPos = strpos($string, $start, $offset);
        if ($startPos === false) return null;
    
        $endPos = strpos($string, $end, $startPos + $startLength);
        if ($endPos === false) return null;
    
        $length = $endPos - $startPos + ($includeDelimiters ? $endLength : -$startLength);
        if (!$length) return '';
    
        $offset = $startPos + ($includeDelimiters ? 0 : $startLength);
    
        $result = substr($string, $offset, $length);
    
        return ($result !== false ? $result : null);
    }

    function str_between_all(string $string, string $start, string $end, bool $includeDelimiters = false, int &$offset = 0): ?array
    {
        $strings = [];
        $length = strlen($string);
    
        while ($offset < $length)
        {
            $found = str_between($string, $start, $end, $includeDelimiters, $offset);
            if ($found === null) break;
    
            $strings[] = $found;
            $offset += strlen($includeDelimiters ? $found : $start . $found . $end); // move offset to the end of the newfound string
        }
    
        return $strings;
    }

    function updateImageSizes($html, $aid = 0) {
        
        global $mysql;
        global $A;
        
        $max_width = 750;
        
        $photos = array();
        if ($aid > 0) $photos = $A->getArticlePhotos($aid);
        
        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        
        $images = $doc->getElementsByTagName('img');
        foreach ($images as $n=>$image) {
            $path = $image->getAttribute('data-src');
            if ($path != '' && (strpos($path, "photo_l") || strpos($path, "photo_b")) ) {
                $path_info =  parse_url($path, PHP_URL_PATH);
                $tmp = str_replace (".jpg", "", $path_info);
                $tmp = explode("-", $tmp);
                $photo_id = (int) trim($tmp[count($tmp) - 1]);
                $article_id = (int) trim($tmp[count($tmp) - 2]);
                
                if (isset($photos["{$article_id}_{$photo_id}"])) {
                    $width = $photos["{$article_id}_{$photo_id}"]->width;
                    $height = $photos["{$article_id}_{$photo_id}"]->height;
                } else {
                    $file = __DIR__ . "/i/{$article_id}/{$photo_id}" . '.jpg';
                    list ($width, $height) = getimagesize($file);
                    $mysql->runQuery("INSERT INTO `images` SET `article_id` = '{$article_id}', `photo_id` = '{$photo_id}', `width` = '{$width}', `height` = '{$height}'");
                }
                
                $w = $width <= $max_width ? $width : $max_width;
                $h = $width <= $max_width ? $height : round($height * $max_width / $width);
                
                $html = str_replace('data-src="' . $path . '"', 'data-src="' . $path . '" width="' . $w . '" height="' . $h . '"', $html);
            }
        }
        /*
        $images = $doc->getElementsByTagName('amp-img');
        foreach ($images as $n=>$image) {
            $path = $image->getAttribute('src');
            if ($path != '' && (strpos($path, "photo_l") || strpos($path, "photo_s"))) {
                $path_info =  parse_url($path, PHP_URL_PATH);
                $tmp = str_replace (".jpg", "", $path_info);
                $tmp = explode("-", $tmp);
                $photo_id = (int) trim($tmp[count($tmp) - 1]);
                $article_id = (int) trim($tmp[count($tmp) - 2]);
                
                if (isset($photos["{$article_id}_{$photo_id}"])) {
                    $width = $photos["{$article_id}_{$photo_id}"]->width;
                    $height = $photos["{$article_id}_{$photo_id}"]->height;
                } else {
                    $file = __DIR__ . "/i/{$article_id}/{$photo_id}" . '.jpg';
                    list ($width, $height) = getimagesize($file);
                    $mysql->runQuery("INSERT INTO `images` SET `article_id` = '{$article_id}', `photo_id` = '{$photo_id}', `width` = '{$width}', `height` = '{$height}'");
                }
                
                $w = $width <= $max_width ? $width : $max_width;
                $h = $width <= $max_width ? $height : round($height * $max_width / $width);
                
                $html = str_replace('src="' . $path . '"', 'src="' . $path . '" width="' . $w . '" height="' . $h . '" sizes="' . $w . 'w, ' . $h . 'h"', $html);
            }
        }
        */

        return $html;
    } 
    
    function updateImageCaption($html, $aid = 0) {
        
        global $mysql;
        global $A;
        
        $photos = array();
        if ($aid > 0) $photos = $A->getArticlePhotos($aid);
        
        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();

        //Источники фото
        
        if ($aid > 0) {
            $images = $doc->getElementsByTagName('figure');
            foreach ($images as $n=>$image) {
                $img = $image->getElementsByTagName('img');
                $caption = $image->getElementsByTagName('figcaption');
    
                $photo_id = -1;
                foreach ($img as $i) $photo_id = $i->getAttribute('data-image');
                $src = '';
                foreach ($caption as $i) $src = $i->textContent;
                $src = trim(str_replace ("©", "", $src));
                $src = trim(str_replace ("Фото:", "", $src));
                
                /*
                if ($photo_id >= 0 && $src != '' && isset($photos["{$aid}_{$photo_id}"]) && $src != $photos["{$aid}_{$photo_id}"]->source) {
                    $src = $mysql->escapeString($src);
                    $mysql->runQuery("UPDATE `images` SET `source` = '{$src}' WHERE `article_id` = '{$aid}' AND `photo_id` = '{$photo_id}'");
                }
                */
                if ($photo_id >= 0 && $src == '' && isset($photos["{$aid}_{$photo_id}"]) && $photos["{$aid}_{$photo_id}"]->source != '') {
                    $tmp = explode("data-image=\"{$photo_id}\"", $html);
                    if (isset($tmp[1])) {
                        $tmp = explode(">", $tmp[1]);
                        if (isset($tmp[0]) && $tmp[1]) {
                            $html = str_replace ($tmp[0], $tmp[0] . "><figcaption class=\"post__imgCaption\">Фото: " . $photos["{$aid}_{$photo_id}"]->source . "</figcaption", $html);
                        }
                    }
                }
                //print_r($photo_id);
                //print_r($src);
                //die();
            }
        }

        $html = str_replace('<figure', "\n<figure", $html);
        $html = str_replace('<figcaption', "\n<figcaption", $html);
        $html = str_replace('<br clear="all">', '<br />', $html);
        $html = str_replace('data-caption="©', 'data-caption="Фото:', $html);
        $html = str_replace('"post__imgCaption">©', '"post__imgCaption">Фото:', $html);
        $html = str_replace('<figcaption>©', '<figcaption>Фото:', $html);
        $html = str_replace("        ©", 'Фото:', $html);

        return $html;
    } 

    function remote_file_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if( $httpCode == 200 ){return true;}
    }

    function setSizesForHtmlStr($infoStr){
        
        preg_match_all('/<img src=("[^"]*")/i', $infoStr, $infoImgUrls);
        foreach ($infoImgUrls[1] as $infoImgUrl) {
            $infoImgUrl = str_replace('"', '', $infoImgUrl);
            $infoImgSize = getimagesize($infoImgUrl);
            if($infoImgSize)
            {
                $infoStr = str_replace(
                    '<img src="'.$infoImgUrl.'"', 
                    '<img src="'.$infoImgUrl.'" '.$infoImgSize[3], 
                    $infoStr
                );
            }
            
            
        }

        return $infoStr;
    }
    
    function insertRelativeLinks ($html, $aid, $type = 'post') {
      
        global $mysql;
        global $A;
        
        if ($aid == 0) return $html;

        $count = 4;
        
        $photos = $A->getRelatedArticles($aid);

        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        if (strpos($html, "<body")) { 
            $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        } else {
            $doc->loadHTML("<html lang='ru'><head><meta charset='UTF-8'></head><body>" . $html . "</body></html>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        }
        $errors = libxml_get_errors();
        
        $el = $doc->getElementsByTagName('h2');
        $c = count($el);
        $last = 0;
        for ($i = 0; $i <= $count + 1; $i++) {
            foreach ($el as $n=>$e) {
                if ($i == floor(($count+1) * $n / $c) && $i > 0 && $i > $last) {
                    
                    $l = $A->getRelativeArticle($aid, $i);
                    
                    if ($l && $type == 'post') {
                        if(page_is_amp())
                        {
                            $l->amp_url = str_replace($l->_url, 'amp/' . $l->_url, $l->url);

                            $link = "<p class=\"post__text related\"><a href=\"{$l->amp_url}\" title=\"{$l->meta_title}\">{$l->name}</a><a class=\"relatedImg\" href=\"{$l->amp_url}\"><amp-img width=\"750\" height=\"500\" src=\"{$l->cover_l}\" srcset=\"{$l->cover_l} 750w, {$l->cover_s} 450w\" layout=\"responsive\"></amp-img></a></p>";
                        }else{
                            $link = "<p class=\"post__text related\"><a href=\"{$l->url}\" title=\"{$l->meta_title}\">{$l->name}</a><img class=\"lazyload\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=\" data-src=\"{$l->cover_s}\" onclick=\"location.href='{$l->url}';\"></p>";
                        }
                        
                    
                        $last = $i;
                        $class = $e->getAttribute('class');
                        $html = str_replace("<h2 class=\"{$class}\">{$e->textContent}</h2>", "{$link}<h2 class=\"{$class}\">{$e->textContent}</h2>", $html);
                    }
                      
                    if ($l && $type == 'turbo') {
                        $link = "<div data-block=\"feed\" data-layout=\"vertical\" data-title=\"\"><div data-block=\"feed-item\" data-title=\"{$l->name}\" data-description=\"\" data-href=\"{$l->url}\" data-thumb=\"{$l->cover_s}\" data-thumb-position=\"right\" data-thumb-ratio=\"4x3\"></div></div>";
                    
                        $last = $i;
                        $html = str_replace("<h2>{$e->textContent}</h2>", "{$link}<h2>{$e->textContent}</h2>", $html);
                    }

                }
            }
        }
        //return count($images);
        return $html;
    }
    