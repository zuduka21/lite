<?php

if (isset($_GET['user_id'])) {

    $collection = $A->getArticlesByUser($_GET['user_id']);

}

