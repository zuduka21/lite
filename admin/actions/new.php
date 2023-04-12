<?php

if (isset($_POST['action']) && $_POST['action'] == 'add') {

    $authors = [
        'Яна Иванова',
        'Влада Сахарова',
        'Ирина Бышкина',
        'Елена Сидихина',
        'Оксана Швец',
        'Анна Липовская',
        'Евгения Светлова',
        'Юлия Баскина',
        'Дарья Журавская',
        'Влада Кротенок',
        'Ольга Шемет',
        'Марта Третьяк'
    ];
    $author = $authors[mt_rand(0, count($authors) - 1)];

    $mysql->runQuery("INSERT INTO `articles` SET `name` = 'Новый пост', `author` = '{$author}', `user_id` = '{$_SESSION['user_id']}', `date` = '{$global_now}'");
    redirectTo(getUrl('page=new'));

}

if($U->isAuthor()):
    $collection = $A->getNewArticlesByUser($_SESSION['user_id']);
else:
    $collection = $A->getNewArticles();
endif;
