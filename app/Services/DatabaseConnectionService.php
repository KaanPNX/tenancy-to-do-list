<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DatabaseConnectionService
{
    public function setConnection($userId)
    {
        $databaseName = 'user_db_' . $userId;

        Config::set('database.connections.user_db', [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ]);

        \DB::purge('user_db');
        \DB::reconnect('user_db');
    }


    public function createUserDatabase($userId)
    {
        $databaseName = 'user_db_' . $userId;

        \DB::statement("CREATE DATABASE IF NOT EXISTS $databaseName");

        Config::set('database.connections.user_db', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ]);

        \DB::purge('user_db');
        \DB::reconnect('user_db');

        $this->createTablesInNewDatabase();
    }

    private function createTablesInNewDatabase()
    {
        Schema::connection('user_db')->create('todo', function ($table) {
            $table->id();
            $table->timestamps();
            $table->boolean('isFinish');
            $table->string('todo');
        });
    }

}
