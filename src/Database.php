<?php 

namespace App;

use \PDO;

class Database {
    public static function getPdo () : PDO 
    {
        $pdo = new PDO('mysql:dbname=social;host=localhost', 'root', '', [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
       ]);

       return $pdo;
    }
}