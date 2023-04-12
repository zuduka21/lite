<?php $text = $block->info?>
<?php $text = str_replace('<p class="post__text">', "<div class='dayg'></div>\n<p class='post__text'>", $text)?>
<?php $text = str_replace('<h2 class="post__title">', "<div class='dayg'></div>\n<h2 class='post__title'>", $text)?>
<?php $text = str_replace('<h3 class="post__secondaryTitle">', "<div class='dayg'></div>\n<h3 class='post__secondaryTitle'>", $text)?>
<?php $text = str_replace('<figure class="post__wrapperImg">', "<div class='dayg'></div>\n<figure class='post__wrapperImg'>", $text)?>
<?php $text = "<div class=\"article_div\">" . $text . "</div>" ?>
<?php 

$text = replace_img_src($text);
$text = hrecipe_markup($text);

function replace_img_src($text) {
    $doc = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $doc->loadHTML('<html>' . $text .'</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $errors = libxml_get_errors();
    $tags = $doc->getElementsByTagName('img');

    $n = 0;
    foreach ($tags as $key => $tag) {
        $class = $tag->getAttribute('class');

        if (strpos($class, 'i_result') === false && strpos($class, 'i_step') === false){
            $new_src_url = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=';
            if ($n == 0) 
            {
                $new_src_url = $tag->getAttribute('data-src-s');
            }
            $tag->setAttribute('src', $new_src_url);
            $n ++;
        }
    }
    return utf8_decode(str_replace(array('<html>','</html>') , '' , $doc->saveHTML($doc->documentElement)));
}


function hrecipe_markup ($text) {
    $article = getArticle();

    $doc = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $doc->loadHTML('<html>' . $text .'</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $errors = libxml_get_errors();
    $tags = $doc->getElementsByTagName('*');

    $is_hrecipe = false;
    $is_ingredients = false;
    $is_instructions = false;
    $count_h2 = 0;
    $count_h3 = 0;
    $count_figcaption = 0;
    foreach ($tags as $key => $e) {
        $class = $e->getAttribute('class');
        $tag_name = $e->tagName;
        if (strpos($class, 'step_by_step') !== false){
            $is_hrecipe = true;
        }

        if ($tag_name == 'h2') $count_h2 ++; 
        if ($count_h2 == 1 && $tag_name == 'figcaption') $count_figcaption ++; 
    }

    if ($count_figcaption < 2) $is_hrecipe = false;

    $is_ingredients = false;
    $is_instructions = false;
    $count_h2 = 0;
    $count_h3 = 0;
    $count_figcaption = 0;

    if ($is_hrecipe)
    foreach ($tags as $key => $e) {
        $class = $e->getAttribute('class');
        $tag_name = $e->tagName;
        
        if ($tag_name == 'h2') $count_h2 ++; 
        if ($is_hrecipe && $count_h2 == 1 && strpos($class, 'h3') !== false) $count_h3 ++; 
        if ($is_hrecipe && $count_h2 == 1 && $tag_name == 'figcaption') $count_figcaption ++; 
        
        if ($is_hrecipe && strpos($class, 'article_div') !== false){
            $e->setAttribute('class', $class . ' hrecipe');
        }
        
        if ($is_hrecipe && strpos($class, 'step_by_step') !== false){
            $e->setAttribute('class', $class . ' instructions');
        }
        
        
        if ($is_hrecipe && $tag_name == 'figcaption' &&  $count_h2 == 1 && $count_figcaption == 1) {
            $html = innerHTML($e);
            $author = str_replace("Â", "", $html);
            $author = trim(str_replace("©", "", $author));
            
            $html = mb_convert_encoding("Фото: ", 'UTF-8', 'HTML-ENTITIES') . "<span class=\"author\">" . $author . "</span>";
            $tpl = new DOMDocument();
            $tpl->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            $new_e = $doc->createElement($e->nodeName, '');
            $new_e->appendChild($doc->importNode($tpl->getElementsByTagName('body')->item(0)->firstChild, TRUE));
            $new_e->setAttribute('class', $class);
            $e->parentNode->insertBefore($new_e, $e);
            $e->parentNode->removeChild($e);
        }
        
        if ($is_hrecipe && $tag_name == 'h2' &&  $count_h2 == 1) {
            
            $html = innerHTML($e);

            $html = "<span class=\"value-title\" title=\"". mb_convert_encoding($article->name, 'UTF-8', 'HTML-ENTITIES') ."\">" . $html . "</span>";
            $tpl = new DOMDocument();
            $tpl->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            $new_e = $doc->createElement($e->nodeName, '');
            $new_e->appendChild($doc->importNode($tpl->getElementsByTagName('body')->item(0)->firstChild, TRUE));
            $new_e->setAttribute('class', $class . ' fn');
            $e->parentNode->insertBefore($new_e, $e);
            $e->parentNode->removeChild($e);
        }
        
        
        if ($is_hrecipe && $tag_name == 'h1'){
            $e->setAttribute('class', $class . ' fn');
            $is_hrecipe = true;
        }

        if ($is_hrecipe && $count_h2 == 1 && $tag_name == 'img' && strpos($class, 'i_result') !== false){
            $e->setAttribute('class', $class . ' photo result-photo');
            $is_hrecipe = true;
        }

        if ($is_hrecipe && $count_h2 == 1 && $tag_name == 'img' && strpos($class, 'i_step') !== false){
            $e->setAttribute('class', $class . ' photo');
            $is_hrecipe = true;
        }

        if ($is_hrecipe && $tag_name == 'ul' &&  $count_h2 == 1) {
            $e->setAttribute('class', $class . ' ingredients');
            $is_ingredients = true;
        }
        
        if ($is_hrecipe && $is_ingredients && $tag_name == 'li' &&  $count_h2 == 1) {
            $e->setAttribute('class', $class . ' ingredient');
        }

        if ($is_hrecipe && $count_h2 == 1 && $tag_name == 'p' &&  $count_h3 == 2) {
            $e->setAttribute('class', $class . ' instruction');
        }

        if ($is_hrecipe && strpos($class, 'post__text') !== false &&  $count_h2 == 1) {
            
            $html = innerHTML($e);
            //$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            if (strpos($html, ":") !== false && strpos($html, "<br>") !== false) {
              
                $time = "30";
                foreach ($article->blocks as $b) if ($b->type == 21) {
                    $info = json_decode($b->info);
                    $time = $info->cook_time + $info->prep_time;
                }
              
                $between = str_between_all($html, '</b> ', '.');
                if (isset($between[0])) {
                    $html = str_replace($between[0], "<span class=\"duration\"><span class=\"value-title\" title=\"PT{$time}M\"></span>" . $between[0] . "</span>", $html);
                }
                if (isset($between[1])) {
                    $html = str_replace($between[1], "<span class=\"yield\">" . $between[1] . "</span>", $html);
                }
                
                $html = "<span>{$html}</span>";

                $tpl = new DOMDocument();
                $tpl->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

                $new_e = $doc->createElement($e->nodeName, '');
                $new_e->appendChild($doc->importNode($tpl->getElementsByTagName('span')->item(0), TRUE));
                $new_e->setAttribute('class', $class);
                $e->parentNode->insertBefore($new_e, $e);
                $e->parentNode->removeChild($e);
            }
        }

    }
    return utf8_decode(str_replace(array('<html>','</html>') , '' , $doc->saveHTML($doc->documentElement)));
}

?>
<?php $text = str_replace("\xEF\xBB\xBF",'',$text); ?>
<?php $text = preg_replace( '@<(a)[^>]*?>.*?</\\1>@si', '', $text ); ?>
<?php //$text = str_replace ("/photo_l/foto-{$article->id}-0.jpg", "/photo_b/foto-{$article->id}-0.jpg", $text) ?>
<?php if ($block->info != ''): ?>
<?php echo $text ?>
<?php endif ?>
