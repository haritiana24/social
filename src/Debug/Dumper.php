<?php
namespace App\Debug;


class Dumper{

    
    public static function dd($variable): void
    {
        echo "<pre>";
            var_dump($variable);
        echo "</pre>";

        die();
    }
    
}