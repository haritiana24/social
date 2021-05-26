<?php 

namespace App; 

class App{

    const DB_NAME = "social";
    const DB_USER = "root";
    const DB_PASS = "";
    const DB_HOST = "localhsot";
    
    private  static  $database;
    
    /**
     * getDb
     *
     * @return $database the instance of the PDO
     */
    public static function getDb()
    {
        if(is_null(self::$database))
        {
            self::$database =  new Databases(self::DB_NAME);
        }

        return self::$database;
    }
    
    /**
     * notFound
     *
     * @return void
     */
    public static function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        header("Location: 404.php");
        exit();
    }
}