<?php

namespace Model;

class Model
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');
    }
}