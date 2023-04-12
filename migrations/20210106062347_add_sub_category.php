<?php

use Phinx\Migration\AbstractMigration;

final class AddSubCategory extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('categories');
        $table->addColumn('is_main', 'boolean', ['after' => 'name'])
            ->addColumn('parent_id', 'integer', ['limit' => 11,'after' => 'is_main'])
            ->addIndex('is_main')
            ->addIndex('parent_id')
            ->update();
        $this->query('UPDATE `categories` SET is_main = 1');
    }
}
