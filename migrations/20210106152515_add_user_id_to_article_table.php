<?php

use Phinx\Migration\AbstractMigration;

final class AddUserIdToArticleTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('articles');
        $table->addColumn('user_id', 'integer', ['limit' => 11, 'after' => 'id'])
            ->addColumn('is_reviewed', 'boolean', ['after' => 'category_id'])
            ->removeColumn('author')
            ->addIndex('user_id')
            ->update();
        $this->query('UPDATE `articles` SET user_id = 1');

    }
}
