<?php
require_once dirname(__DIR__) . '/Migration.class.php';

class Message extends Migration
{

    public function create(Migration $migration)
    {
        $migration->table('Message');
        $migration->Int('id',10)->autoincrement('id');
        $migration->String('name',10);
        $migration->String('password',10);

        return $migration;
    }

}




