<?php
    ob_start();

    require_once "functions.php";
    //print_r($_GET); die();
    $is_can_show = true;
    $is_cache_enabled = $global_is_cache_enabled;

    $amp_prefix = getAMPPrefix();

    if(page_is_amp() && !isAMPEnabled()) {
        $url = str_replace($amp_prefix, "", getUrl($_SERVER['REQUEST_URI']));
        redirectTo($url);
    }

    if ($is_can_show && getPageType() == 'post') {
        $article = getArticle();

        if ($article === false){
            include (returnError (404));
            exit();
        }else{
            if (trim($_SERVER['REQUEST_URI'], "/") !=  "{$article->_url}-{$article->id}" && trim($_SERVER['REQUEST_URI'], "/") !=  "amp/{$article->_url}-{$article->id}") {
                redirectTo($article->url);
            }

            header("Link: <" . getURL('css/style.css') . ">; rel=preload; as=style", false);
            header("Link: <" . getURL('css/fonts.css') . ">; rel=preload; as=style", false);
            header("Link: <" . getURL('js/libs.min.js') . ">; rel=preload; as=script", false);
            header("Link: <" . getURL('js/common.js') . ">; rel=preload; as=script", false);
            header("Link: <https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js>; rel=preload; as=script", false);
            header("Link: <https://yandex.ru/ads/system/context.js>; rel=preload; as=script", false);
            //header("Link: <https://www.googletagmanager.com/gtag/js?id=UA-47915019-7>; rel=preload; as=script", false);
            header("Link: <https://mc.yandex.ru/metrika/tag.js>; rel=preload; as=script", false);
            
            header("Link: <" . getURL('/img/pbg.png') . ">; rel=preload; as=image", false);
            header("Link: <" . getURL('/img/header__bottomBg.png') . ">; rel=preload; as=image", false);
            header("Link: <" . getURL('img/logo--black.png') . ">; rel=preload; as=image", false);
            header("Link: <" . $article->cover_s . ">; rel=preload; as=image", false);
            //header("Link: <" . $article->cover_l . ">; rel=preload; as=image", false);

            //header("Link: <" . getURL('fonts/heuristica-regular_f878d290b83aeb1326bbb08aade50274.woff') . ">; rel=preload; as=font", false);
            //header("Link: <" . getURL('fonts/KFOlCnqEu92Fr1MmWUlfBBc4.woff2') . ">; rel=preload; as=font", false);

            include "pages".$amp_prefix."/post.php";
            $is_can_show = false;
        }

    }

    if($is_can_show && getPageType() == 'post_related') {
        header('Access-Control-Allow-Origin: *');

        $article = getArticle();
        if ($article === false){
            return false;
            die();
        }
        
        include "pages".$amp_prefix."/post_related.php";
        $is_can_show = false;
    }

    if($is_can_show && getPageType() == 'post_random') {
        $article = $A->getRandomArticle(1, json_decode($_GET['exclude_id']));
            if ($article === false){
                return false;
                die();
            }
        header('Content-Type: application/json');
        echo json_encode($article);
        die();
        $is_can_show = false;
    }

    if ($is_can_show && getPageType() == 'post_turbo') {
        $article = getArticle();
        include "pages/post_turbo.php";    
        $is_can_show = false;
    }

    if ($is_can_show && getPageType() == 'category') {
        $category = getCategory();
        if ($category === false){
            header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
            include (returnError (404));
            exit();
        }else{
            if(isset($_GET['page']) && (int)$_GET['page'] === 1){
                $actual_link = $global_site_url . $_SERVER['REQUEST_URI'];

                if($actual_link !== $category->url){
                    redirectTo($category->url);
                }
            }

            header("Link: <" . getURL('css/style.css') . ">; rel=preload; as=style", false);
            header("Link: <" . getURL('css/fonts.css') . ">; rel=preload; as=style", false);
            header("Link: <" . getURL('js/libs.min.js') . ">; rel=preload; as=script", false);
            header("Link: <" . getURL('js/common.js') . ">; rel=preload; as=script", false);
            header("Link: <https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js>; rel=preload; as=script", false);
            header("Link: <https://yandex.ru/ads/system/context.js>; rel=preload; as=script", false);
            //header("Link: <https://www.googletagmanager.com/gtag/js?id=UA-47915019-7>; rel=preload; as=script", false);
            header("Link: <https://mc.yandex.ru/metrika/tag.js>; rel=preload; as=script", false);           
            header("Link: <" . getURL('img/logo--black.png') . ">; rel=preload; as=image", false);

            include "pages".$amp_prefix."/category.php";
            
            $is_can_show = false;
        }

    }

    if ($is_can_show && getPageType() == 'post_relative') {
        include "pages/post_relative.php";
        $is_can_show = false;
        $is_cache_enabled = false;
    }

    if ($is_can_show && getPageType() == 'post_sidebar') {
        include "pages/post_sidebar.php";
        $is_can_show = false;
        $is_cache_enabled = false;
    }

    if ($is_can_show && getPageType() == 'sitemap') {
        header("Content-type: text/xml");
        include "pages/sitemap.php";
        $is_can_show = false;
    }

    if ($is_can_show && getPageType() == 'rss') {
        header("Content-type: text/xml");
        include "pages/rss.php";
        $is_can_show = false;
    }

    if ($is_can_show && getPageType() == 'rss_turbo') {
        header("Content-type: text/xml");
        include "pages/rss_turbo.php";
        $is_can_show = false;
    }

    if ($is_can_show && getPageType() == 'rss_zen') {
        header("Content-type: text/xml");
        include "pages/rss_zen.php";
        $is_can_show = false;
    }

    if ($is_can_show){
        if(isset($_GET['page']) && (int)$_GET['page'] === 1){
            redirectTo(getURL());
        }

        header("Link: <" . getURL('css/style.css') . ">; rel=preload; as=style", false);
        header("Link: <" . getURL('css/fonts.css') . ">; rel=preload; as=style", false);
        header("Link: <" . getURL('js/libs.min.js') . ">; rel=preload; as=script", false);
        header("Link: <" . getURL('js/common.js') . ">; rel=preload; as=script", false);
        header("Link: <https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js>; rel=preload; as=script", false);
        header("Link: <https://yandex.ru/ads/system/context.js>; rel=preload; as=script", false);
        //header("Link: <https://www.googletagmanager.com/gtag/js?id=UA-47915019-7>; rel=preload; as=script", false);
        header("Link: <https://mc.yandex.ru/metrika/tag.js>; rel=preload; as=script", false);       
        header("Link: <" . getURL('img/logo--black.png') . ">; rel=preload; as=image", false);

        include "pages".$amp_prefix."/index.php";
    }

    $content = ob_get_contents();
    ob_end_clean();
    
    $content = str_replace("foto-2253-0.jpg", "foto-2253-0.jpg?1", $content);   //tmp
    $content = str_replace("samye-krasivye-goroda-rossii-953-38111.jpg", "samye-krasivye-goroda-rossii-953-38111.jpg?1", $content);   //tmp
    if (isset($article) && $article->id == 2730) $content = str_replace("/foto-", "/photo-", $content);
    if (isset($article) && $article->id == 2732) $content = str_replace("/foto-", "/photo-", $content);
    
    if (getPageType() == 'post' || getPageType() == 'post_related') $content = updateImageSizes($content, (isset($article) ? $article->id : 0));
    if (getPageType() == 'post' || getPageType() == 'post_related') $content = updateImageCaption($content, (isset($article) ? $article->id : 0));
    if (getPageType() == 'post' || getPageType() == 'post_related') $content = insertRelativeLinks($content, (isset($article) ? $article->id : 0), 'post');

    if ($global_site_is_dev === true) {
        $s = str_replace ("dev.", "", $global_site_url);
        $content = str_replace($s, $global_site_url, $content);
    } else {
        $s = str_replace ("lafoy", "dev.lafoy", $global_site_url);
        $content = str_replace($s, $global_site_url, $content);
    }
        

    echo $global_site_is_dev === true ? $content : $content;
    
    if (!$global_site_is_dev && getPageType() == 'post' && $is_cache_enabled) {

        @mkdir (__DIR__ . "/cache");
        if(!page_is_amp()) {
            @file_put_contents(__DIR__ . "/cache/{$article->_url}-{$article->id}.html", $content);
        } else {
            @mkdir (__DIR__ . "/cache/" . $amp_prefix);
            @file_put_contents(__DIR__ . "/cache/{$amp_prefix}/{$article->_url}-{$article->id}.html", $content);
        }
    }
    