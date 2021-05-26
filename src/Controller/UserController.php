<?php

namespace App\Controller;

use App\App;
use App\User;

class UserController{

    
    public static  function getAllUser()
    {
        return  App::getDb()->prepare("SELECT * FROM users WHERE id != :id", ['id' => (int) $_SESSION['auth']], User:: class);
    }
}