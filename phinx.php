<?php
require_once(__DIR__."/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    "paths"        => [
        "migrations" => "%%PHINX_CONFIG_DIR%%/migrations",
        "seeds"      => "%%PHINX_CONFIG_DIR%%/migrations/seeds",
    ],
    "environments" => [
        "default_migration_table" => "migrations",
        "default_database"        => "development",
        "production"              => [
            'adapter' => 'mysql',
            "host"    => env('DB_HOSTNAME', 'localhost'),
            "name"    => env('DB_DATABASE'),
            "user"    => env('DB_USERNAME'),
            "pass"    => env('DB_PASSWORD'),
            "port"    => env('DB_PORT', 3306),
            'charset' => env('DB_CHARSET'),
        ],
        "development"             => [
            "adapter" => 'mysql',
            "host"    => env('DB_HOSTNAME', 'localhost'),
            "name"    => env('DB_DATABASE'),
            "user"    => env('DB_USERNAME'),
            "pass"    => env('DB_PASSWORD'),
            "port"    => env('DB_PORT', 3306),
            'charset' => env('DB_CHARSET'),
        ],
        "testing"                 => [
            "adapter" => "mysql",
            "host"    => 'localhost',
            "name"    => 'testing_db',
            "user"    => 'root',
            "pass"    => 'root',
            "port"    => '3306',
            'charset' => 'utf8',
        ],
    ],
];
