<?php 

namespace App;

class Session {
        
    /**
     * isConnected
     *
     * @return bool
     */
    public static function isConnected():bool
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        return !empty($_SESSION['auth']);
    }
    
    /**
     * forcedToConnect to forced the user to connected
     *
     * @return void
     */
    public static function forcedToConnect():void
    {
        if (!Session::isConnected())
        {
            header('Location: /');
            exit();
        }
    }
    
    /**
     * isLiked
     *
     * @return void
     */
    public static function isLiked(): void 
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }
}