<?php

if (isset($_POST['action']) && $_POST['action'] == 'purge_cache') {

    @file_get_contents("http://admin.lafoy.ru/purge_cache.sh");

}

?>