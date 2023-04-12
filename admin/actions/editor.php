<?php

    $article_src = isset($_POST['src']) ? $_POST['src'] . "\n" : '';

    $article_dst = $article_src;
    
    $article_dst = str_replace("\r", "", $article_dst);
    $article_dst = explode("\n", $article_src);
    
    $type = "";
    
    foreach ($article_dst as $n=>$str) {
        
        $glue = "";
        
        $str = trim($str, "\n");
        $str = trim($str, "\r");
        $str = trim($str, "\t");
        $str = trim($str, " •");
        $str = trim($str);
        
        $str = str_replace("  ", " ", $str);
        $str = str_replace("Serving:", "Servings:", $str);
        $str = str_replace("Тебе понадобится:", "<div class=\"post__title h3\">Тебе понадобится:</div>", $str);
        $str = str_replace("Пошаговый рецепт:", "<div class=\"post__title h3\">Пошаговый рецепт:</div>", $str);
        


        if ($type == "ingredients" && !$list_exists) {
            $str = "<ul>" . $str;
            $list_exists = true;
        }

        if ($type == "directions" && !$list_exists) {
            $str = "<ol>" . $str;
            $list_exists = true;
        }



        
        if ($type == "") {
            for ($i=1; $i<=30; $i++) if (strpos($str, "{$i}.") === 0) $type = "h2";
            $h2_text = trim(substr_replace ($str, "", 0, strlen("{$i}.")));
        }
        if (strpos($str, "ебе понадобится:")) {$type = "ingredients"; $list_exists = false; $li_exists = false;$li_count = 0;}
        if (strpos($str, "ошаговый рецепт:")) {$type = "directions"; $list_exists = false; $li_exists = false;$li_count = 0;}
        if (strpos($str, "оличество:")) $type = "servings";
        if (strpos($str, "ремя приготовления:")) $type = "cooking_time";




        if ($type == "" && $str != "") {
            $str = "<p>" . $str . "</p>";
        }
          
        if ($type == "h2" && $str != "") {
            //$str = "<h2>" . $str . "</h2><figure><img src=\"\" alt=\"{$h2_text}\" title=\"{$h2_text}\" loading=\"lazy\"></figure>";
            $str = "<h2>" . $str . "</h2>";
            $type = "";
        }
        
        if ($type == "cooking_time" && $str != "") {
            $str = str_replace("Время приготовления:", "<b>Время приготовления:</b>", strtolower($str));
            $str = "<p>" . trim($str, ".") . ".<br />";
            $glue = "";
        }
        if ($type == "cooking_time" && $str == "") {

        }
        
        if ($type == "servings" && $str != "") {
            $str = str_replace("Количество:", "<b>Количество:</b>", $str);

            $type = "";
        }

        if ($type == "ingredients" && $list_exists) {
            //for ($i=1; $i<=30; $i++) if (strpos($str, "{$i}.") === 0) $str = trim(substr_replace ($str, "", 0, strlen("{$i}.")));

            if ($str != "" && $str != "<ul>") {
                $str = trim($str, ".");
                if (strpos($str, "<ul>") === 0) {
                    $str = str_replace("<ul>", "", $str);
                    $str = trim($str);
                    $str = "<ul><li>" . $str . "</li>";
                } else {
                    $str = "<li>" . $str . "</li>";                    
                }
                $li_exists = true;
                $li_count ++;
            }
            if ($str == "" && $li_exists) {
                $str = $str . "</ul>";
                $type = "";
            }
            
            if (strpos($str, ":</li>")) { 
                $str = str_replace (":</li>", "</li>", $str);
                $str = str_replace ("<li>", "<li class='noli'>", $str);
            }
        }

        if ($type == "directions" && $list_exists) {
            
            for ($i=1; $i<=30; $i++) if (strpos($str, "{$i}.") === 0) $str = trim(substr_replace ($str, "", 0, strlen("{$i}.")));
            for ($i=1; $i<=30; $i++) if (strpos($str, "<ol>") === 0 && strpos($str, "{$i}.") === 4) $str = trim(substr_replace ($str, "", 4, strlen("{$i}.")));
          
            if ($str != "" && $str != "<ol>") {
                $str = trim($str, ".") . ".";
                if (strpos($str, "<ol>") === 0) {
                    $str = str_replace("<ol>", "", $str);
                    $str = trim($str);
                    $str = "<ol><li>" . $str . "</li>";
                } else {
                    $str = "<li>" . $str . "</li>";                    
                }
                $li_exists = true;
            }
            if ($str == "" && $li_exists) {
                $str = $str . "</ol>";
                $type = "";
            }
        }

        if ($str != "") $article_dst[$n] = $str . $glue;
        
    }
    
    $article_dst = implode("", $article_dst);
    $article_dst = str_replace("<ul></ul>", "", $article_dst);
    
    $article_dst = "<div class=\"step_by_step\">{$article_dst}</div>";
    