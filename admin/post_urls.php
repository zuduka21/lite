<?php 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    include "functions.php";
    $max_money = 20 * 100;
    $min_ggl_trust = 7;
    
    //SELECT `id`, `url`, `is_bl_hand`, `is_buy`, `comment`, IF(`p1`>0,`p1`,IF(`p2`>0,`p2`,`p3`))/100 as `p`, `rank`, `rank`/((IF(`p2`>0,`p2`,`p3`))/100) as `r`, `trust_rank`, `domain_rank`, `moz_da`, `ggl_trust`,`link_rank`,`tic`,`seo_percent` FROM `sites_links` WHERE `is_bl`=0 AND `is_buy`=0 AND `is_bl_hand` = 0 AND `rank` > 0 AND (`megaindex_category_data` LIKE "%Cook%" OR `megaindex_category_data` LIKE "%Diet%") ORDER BY `r` DESC

    
    //https://websiteseochecker.com/bulk-check-page-authority/#arearesult
    
    function updateRank () {
        global $mysql;
        
        //$mysql->runQuery("UPDATE `sites_links` SET `rank` = ((`trust_rank`/10)*(`domain_rank`/10)*(`moz_da`/10)*(`ggl_trust`/10)*(`link_rank`/10000)*(`tic`/10)/100)");
        $mysql->runQuery("UPDATE `sites_links` SET `rank` = ((`trust_rank`/100)*(`domain_rank`/100)*(`moz_da`/10)*(`ggl_trust`/10)*(`tic`/10))");
    }

    function updateBL () {
        global $mysql;
        global $max_money;
        global $min_ggl_trust;
        
        //$mysql->runQuery("UPDATE `sites_links` SET `megaindex_category_data` = '' WHERE `megaindex_category_data` = 'Error :: null'");
        $mysql->runQuery("UPDATE `sites_links` SET `is_bl` = 0 WHERE `is_bl_hand` = 0 AND `is_buy` = 0");
        $mysql->runQuery("UPDATE `sites_links` SET `is_bl` = 1 WHERE `ggl_trust` < {$min_ggl_trust}");
        $mysql->runQuery("UPDATE `sites_links` SET `is_bl` = 1 WHERE IF(`p1`>0,`p1`,IF(`p2`>0,`p2`,`p3`)) = 0 OR IF(`p1`>0,`p1`,IF(`p2`>0,`p2`,`p3`)) > {$max_money} OR `is_bl_hand` = 1 OR `is_buy` = 1");
    }


    if (isset($_POST['type']) && $_POST['type'] == 'urls') {
            
        $urls = isset($_POST['urls']) ? $_POST['urls'] : array();
      
        foreach($urls as $k=>$url) {
            $u = $mysql->escapeString($url[0]);
            $p1 = round(100 * ((float) $url[1]));
            $p2 = round(100 * ((float) $url[2]));
            $p3 = round(100 * ((float) $url[3]));
            $id = (int) $url[4];
            $trust = (int) $url[5];
            
            $mysql->runQuery("INSERT IGNORE INTO `sites_links` SET `id` = '{$id}', `url` = '{$u}', `p1` = '{$p1}', `p2` = '{$p2}', `p3` = '{$p3}'");
            $mysql->runQuery("UPDATE `sites_links` SET `id` = '{$id}', `p1` = '{$p1}', `p2` = '{$p2}', `p3` = '{$p3}', `ggl_trust` = '{$trust}' WHERE `url` = '{$u}'");
            
        }
            
        updateRank ();
        updateBL ();
        
        die();
        
    }
    
    if(defined('STDIN') ) {

        /*
        $res = $mysql->getQuery("SELECT `url`, `megaindex_domain_data`  FROM `sites_links` WHERE `megaindex_domain_data` <> ''");
        foreach ($res as $i) {
            $d = json_decode($i->megaindex_domain_data);
            if (isset($d->link_rank)) {
                $mysql->runQuery("UPDATE `sites_links` SET  `link_rank` = '{$d->link_rank}', `tic` = '{$d->tic}', `seo_percent` = '{$d->seo_percent}' WHERE `url` = '{$i->url}'");
                echo "{$i->url}\n";
            }
        }
        */

        updateRank ();
        updateBL ();

        while (true):
        
        $flag = 0;
        
        
        $date = date("U") - 31*24*3600;
        $res = $mysql->getQuery("SELECT `url` FROM `sites_links` WHERE `date_megaindex` < '{$date}' AND `is_bl` = 0 AND `megaindex_category_data` LIKE '%Diets%' ORDER BY `date_megaindex` ASC LIMIT 1");
        
        if ($res && isset($res[0])) {
            $url = $res[0]->url;
            $data = json_decode (file_get_contents("http://api.megaindex.com/backlinks/counters?key=63e688dee1bfc6df958f2979aa6e19b3&domain={$url}"));
            if (isset($data->data)) {
                $date = date("U");
                $mdd = $mysql->escapeString(json_encode($data->data));
                $mysql->runQuery("UPDATE `sites_links` SET `trust_rank` = '{$data->data->trust_rank_log}', `domain_rank` = '{$data->data->domain_rank_log}', `link_rank` = '{$data->data->link_rank}', `tic` = '{$data->data->tic}', `seo_percent` = '{$data->data->seo_percent}', `megaindex_domain_data` = '{$mdd}', `date_megaindex` = '{$date}' WHERE `url` = '{$url}'");
                echo "MegaIndex stat :: {$url}\n";
                updateRank ();

                $flag = 1;
            }
            sleep(1);
        }
        
        
        
        //$res = $mysql->getQuery("SELECT `url` FROM `sites_links` WHERE `megaindex_category_data` = '' AND `is_bl` = 0 ORDER BY `moz_da` DESC LIMIT 1");
        $res = $mysql->getQuery("SELECT `url` FROM `sites_links` WHERE `megaindex_category_data` = '' ORDER BY `moz_da` DESC LIMIT 1");
        
        if ($res && isset($res[0])) {
            $url = $res[0]->url;
            $data = json_decode (file_get_contents("http://api.megaindex.com/visrep/lda_site?key=63e688dee1bfc6df958f2979aa6e19b3&count=5&domain=http://{$url}"));
            echo "MegaIndex category :: {$url}\n";
            if (isset($data->data)) {
                
                $c = $mysql->escapeString(json_encode($data->data));
                $mysql->runQuery("UPDATE `sites_links` SET `megaindex_category_data` = '{$c}' WHERE `url` = '{$url}'");

                $flag = 1;
            } else {
                $c = $mysql->escapeString("Error :: " . json_encode($data));
                $mysql->runQuery("UPDATE `sites_links` SET `megaindex_category_data` = '{$c}' WHERE `url` = '{$url}'");

                $flag = 1;                
            }
            sleep(1);
        }

        $date = date("U") - 31*24*3600;
        $res = $mysql->getQuery("SELECT `url` FROM `sites_links` WHERE `date_moz` < '{$date}' AND `is_bl` = 0 ORDER BY `date_moz` ASC, `domain_rank` DESC LIMIT 1");
        if ($res && isset($res[0])) {
            $url = $res[0]->url;
            $data = explode("\n", file_get_contents("https://websiteseochecker.com/check-history-of-domain-authority/?dmnh={$url}"));
            $da = 0;
            foreach($data as $str) {
                if (strpos($str, "['202") === 0) {
                    $da = 1 * trim(substr($str, 13, 10), " ],\n\r");
                }
            }
            $date = date("U");
            $mysql->runQuery("UPDATE `sites_links` SET `moz_da` = '{$da}', `date_moz` = '{$date}' WHERE `url` = '{$url}'");
            updateRank ();
            
            echo "Moz :: {$url} :: {$da}\n";
            $flag = 1;
            
            sleep(5);
        }

        if ($flag == 0) sleep(30);
        
        endwhile;
    }

