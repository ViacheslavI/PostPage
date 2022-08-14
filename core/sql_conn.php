<?php

namespace core;

use PDO;

class sql_conn
{
    function conn()
    {
        $db = require_once 'conf.php';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        return $pdo = new PDO ($db['host'], $db['user'], $db['password'], $options);
    }
}

