<?php

use Phinx\Migration\AbstractMigration;

final class AddUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('role_id', 'integer', ['null' => false, 'limit' => 11])
            ->addColumn('login', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('password', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('firstname', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('lastname', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('date_added', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['login'], ['unique' => true])
            ->create();
        $table->insert(["role_id" => 1, "login" => "admin", "password" => password_hash('lafoy', PASSWORD_BCRYPT), "firstname" => "Maxim", "lastname" => "Lafoy"]);
        $table->saveData();

    }

}
