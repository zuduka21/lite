<?php

use Phinx\Migration\AbstractMigration;

final class AddIsYandexColumnToArticles extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('articles');
        $table->addColumn('is_yandex', 'integer', ['limit' => 11, 'after' => 'is_for_zen'])
            ->update();
    }

}
