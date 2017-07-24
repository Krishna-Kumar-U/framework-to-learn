<?php

namespace App\Core\Database;

use PDO;
use PDOException;
use App\Core\Database\DebugQuery;

class Connection
{
    /**
     * Create a new PDO connection.
     *
     * @param array $config
     */
    public static function make($config)
    {
        try {
            return new PDO(
                $config['connection'].';dbname='.$config['name'],
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_STATEMENT_CLASS => ['App\Core\Database\DebugQuery', []],
                ]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
