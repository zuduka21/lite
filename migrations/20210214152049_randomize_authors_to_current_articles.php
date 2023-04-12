<?php

use Phinx\Migration\AbstractMigration;

final class RandomizeAuthorsToCurrentArticles extends AbstractMigration
{
    public function change()
    {
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

        $rows = $this->fetchAll('SELECT * FROM articles');

        foreach ($rows as $row){
            $author = $authors[mt_rand(0, count($authors) - 1)];
            $this->execute("SET NAMES UTF8");
            $this->execute("UPDATE articles SET author = '{$author}' WHERE id = {$row['id']}");
            $this->execute("UPDATE articles_memory SET author = '{$author}' WHERE id = {$row['id']}");
        }

    }
}
